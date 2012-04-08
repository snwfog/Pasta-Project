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
		$this->load->model('ScheduledCourse', 'scheduled_courses_table');
		$this->load->model('Lecture', 'lectures_table');
		$this->load->model('Tutorial', 'tutorials_table');
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
			// Get current user's schedule
			// i.e. id, student_id, season, year
			$data['schedules'] = 
				$this->schedules_table->
					get_schedule_by_student_id($this->session->userdata('student_id'));

			/**
			 * Retrieve a few interesting information of the current user
			 */
			$data['total_credit'] = $this->completed_courses_table->get_total_credit_earned(
					$this->session->userdata('student_id'));

			$data['scheduled_credit'] = $this->scheduled_courses_table->
				get_total_credit($data['schedules']['id']) != NULL ?
				$this->scheduled_courses_table->
				get_total_credit($data['schedules']['id']) : "0";

			$data['name'] = $this->session->userdata('first_name');
			$data['title'] = $data['name'] . "'s Profile";

			// multiple rows of all the scheduled courses
			$scheduled_courses_list = $this->scheduled_courses_table->get_by_schedule_id($data['schedules']['id']);
			
			//print_r($scheduled_courses);
			// going to store each and every scheduled course
			// information into the `data['scheduled_courses']` variable
			foreach ($scheduled_courses_list as $index => $course) 
			{
				// all course has course information
				$data['scheduled_courses'][$index] = 
					$this->courses_table->find_by_id($course['course_id']);
				// all course has at least a lecture
				$data['scheduled_courses'][$index]['lecture'] =
					$this->lectures_table->get_lecture_info_by_id($course['lecture_id']);

				if ($course['tutorial_id'] != 0)
					$data['scheduled_courses'][$index]['tutorial'] =
						$this->tutorials_table->get_tutorial_info_by_id($course['tutorial_id']);

				// lab is almost inexistant in our record
				// if (isset($course['lab_id']))
				// 
				
				// After this foreach loop, the data in the
				// `$scheduled_courses` variable should be very similar
				// to what we had in the begninning with our scrape
				// script, except here the information are stripped
				// with respect to user preferences and one lecture,
				// tutorial, lab constraint.
			}

			$this->put('pasta_user_profile_view', $data);
		}
	}

	function drop_course($schedule_id) {
		// remove all courses from scheduled_courses table
		$this->scheduled_courses_table->delete_by_schedule_id($schedule_id);

		// remove from schedules table
		$this->schedules_table->delete_by_schedule_id($schedule_id);
		
		
		redirect('profile', 'refresh');
	}
}

// End of Profile.php