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
		if ( ! $this->session->userdata('logged_in')) {
			// if is not logged in, redirect user to the login page
			redirect('pasta', 'refresh');
		} else if ($this->schedules_table->get_schedule_by_student_id(
			$this->session->userdata('student_id')) == NULL) {
			// if we cannot find any schedule for this user
			// then auto direct him to the course selection page
			redirect('coursecompleted', 'location');
		} else {
			// fill in session information	
			$data['name'] = $this->session->userdata('first_name');
			$data['title'] = $data['name'] . "'s Profile";
			$data['total_credit'] = $this->completed_courses_table->get_total_credit_earned(
					$this->session->userdata('student_id'));


			// load the correct data for this particular 
			// user in form of a table
			$data['schedules'] = 
				$this->schedules_table->
					get_schedule_by_student_id($this->session->userdata('student_id'));

			// get schedule id
			$user_schedule = $this->schedules_table->get_schedule_by_student_id(
				$this->session->userdata('student_id'));
			$data['schedules']['course_info'] = 
				$this->schedules_table->get_course_info_from_schedule_id($user_schedule['id']);

			$this->put('pasta_user_profile_view', $data);
		}
	}

	function drop_course($schedule_id) {
		// remove from schedules table
		
		// remove from scheduled_courses table
		
		redirect('profile', 'refresh');
	}
}

// End of Profile.php