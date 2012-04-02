<?php 

/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login controller
 * 
 * Author: Charles
 */

class Login extends MY_Controller {

	/**
	 * Information regarding the database password type:
	 * http://stackoverflow.com/questions/
	 * 247304/mysql-what-data-type-to-use-for-hashed-password-field-and-what-length
	 */
	function __construct() {
		parent::__construct();	
		
		// load helper library
		$this->load->helper(array('url', 'form'));	
		
		// load form validation
		$this->load->library('form_validation');

		// load the login model
		$this->load->model('User', 'logins_table');
	}	
	
	public function index() {
		$data['title'] = 'Login';
		
		// check if the user is already logged in
		if ($this->session->userdata('logged_in')) {
			// if user is already logged in, do an immediate redirect
			redirect('profile', 'refresh');
		} else {
			// display the main view
			$this->put('pasta', $data);
		}
	}
	
	public function logout() {
		// unassign logged_in boolean
		$this->session->set_userdata('logged_in', FALSE);
		// redirect to pasta main
		redirect('pasta', 'refresh');
	}

	public function user_login() {
		// setup login form validation
		$this->form_validation->set_rules(
			'login_student_id', 
			'Login Student ID', 
			'required|trim|xss_clean|exact_length[7]|numeric'
		); 

		$this->form_validation->set_rules(
			'login_password', 
			'Login Password', 
			'required|trim|xss_clean|required|min_length[6]|alpha_numeric'
		);

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			// from http://www.haughin.com/2008/02/handling-passwords-in-codeigniter/
			if ($this->logins_table->find_by_login_info(
					$this->input->post('student_id'),
					$this->encrypt->sha1($this->input->post('password')))) {

				// ------------------------------------
				// initialize sessions
				// ------------------------------------

				$user_data = $this->logins_table->find_by_student_id(
					$this->input->post('student_id'));

				$this->session->set_userdata(array(
					'student_id' => $user_data['student_id'],
					'first_name' => $user_data['first_name'],
					'last_name'  => $user_data['last_name'],
					'logged_in'  => true
				));

				// redirect to user profile page
				redirect('profile', 'redirect');
			} else {
				echo "Sorry, we could not find you in our records. "
				 	 . ", should you "
				 	 . anchor(site_url('pasta'), 'register first')
					 . "?";
			}
		}
	}
}

// End of Login.php