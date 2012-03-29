<?php
/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PASTA
 *
 * Controller homepage for user that is logged in.
 *
 * @package		PASTA
 * @author		Charles Yang
 */
class Profile extends MY_Controller {

	function __construct() {
		parent::__construct();

		// load model
		$this->load->model('Schedule', 'schedules_table');
		$this->load->model('CompletedCourse', 'completed_courses_table');
		$this->load->model('Course', 'courses_table');
	}
	
	public function index() {

		/**
		 * FAKE DATA HERE
		 * 
		 */
		$this->session->set_userdata('logged_in', TRUE);
		$data['name'] = 'Charles';
		$data['title'] = $data['name'] . "'s Profile";
		$data['total_credit'] = $this->get_session_total_credit(3);

		// end of fake data

		// check if user is logged in
		if (!$this->session->userdata('logged_in')) {
			// if is not logged in, redirect user to the login page
			redirect('login', 'refresh');
		} else {
			// load the correct data for this particular user in form of a table
			$data['schedules'] = 
				$this->schedules_table->get_all(2 // FAKE DATA HERE SHOULD REPLACE WITH $this->session->userdata('student_id');
				);
				
			$this->put('profile', $data);
		}
	}

	/**
	 * Get current session student total course credit taken.
	 * @return [type] [description]
	 */
	public function get_session_total_credit($student_id) {
		$total_credit = 0;
		foreach($this->completed_courses_table->
			find_by_student_id($student_id) as $relation) {
			// query the database for the credit 
			$course = $this->courses_table->find_by_id($relation['course_id']);
			$total_credit += $course['credit'];
		}
		return $total_credit;
	}
}

// End of Profile.php