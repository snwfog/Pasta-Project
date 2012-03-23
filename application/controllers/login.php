<?php 

/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login controller
 * Author: Charles
 */

class Login extends CI_Controller {

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
	}	
	
	public function index() {	
		$data['title'] = 'Login';
		
		// display the main view
		$this->put('login', $data);
	}
	

	public function user_login() {
		// setup login form validation
		$this->form_validation->set_rules(
			'student_id', 
			'Student ID', 
			'required|trim|xss_clean|exact_length[7]|numeric'
		); 

		$this->form_validation->set_rules(
			'password', 
			'Password', 
			'required|trim|xss_clean|required|min_length[6]|alpha_numeric'
		);

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			// from http://www.haughin.com/2008/02/handling-passwords-in-codeigniter/
			$this->db->where('student_id', $this->input->post('student_id'));
			$this->db->where('password', 
				$this->encrypt->sha1($this->input->post('password')));
			// perform mysql query
			$query = $this->db->get('logins');
			if ($query->num_rows() == 1) {
				echo "SUCCESFUL LOGIN";
				// ------------------------------------
				// initialize cookies and sessions here
				// ------------------------------------
			} else {
				echo "FUCK MY LIFE";
			}
		}
	}

	/**
	 * Basic page display, $content should be the main content page,
	 * $static_content should hosts things like footer note, or
	 * page title (header/footer content). - Charles
	 */
	public function put($content_view, $data) {
		$this->load->view('static/header', $data);
		$this->load->view($content_view, $data);
		$this->load->view('static/footer', $data);
	}
}