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
		$data['total_credit'] = $this->completed_courses_table->get_total_credit_earned(3 /* FAKE DATA HERE SHOULD REPLACE WITH session student id */);

		if (!$this->session->userdata('logged_in')) {
			// if is not logged in, redirect user to the login page
			redirect('pasta', 'refresh');
		} else {
			// load the correct data for this particular 
			// user in form of a table
			$data['schedules'] = 
				$this->schedules_table->get_schedule_by_student_id(3 // FAKE DATA HERE SHOULD REPLACE WITH $this->session->userdata('student_id');
				);

			// store all info about courses for this semester
			// hence the '0' extra parameter in the array
			$data['schedules']['course_info'] = 
				$this->schedules_table->get_course_info_from_schedule_id(7);
            print_r($data);

			$this->put('profile', $data);
		}
	}

	function drop_course($schedule_id) {
		// remove from schedules table
		
		// remove from scheduled_courses table
		
		redirect('profile', 'refresh');
	}
}

// End of Profile.php