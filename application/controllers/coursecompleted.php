`<?php
/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PASTA
 *
 * Controller for registration of courses that have been already taken.
 *
 * @package		PASTA
 * @author		Charles Yang
 */
class CourseCompleted extends MY_Controller {

	function __construct() {
		parent::__construct();
		// load all of the course constants
		$this->config->load('pasta_constants/soft_eng_courses');

		// load the model for doing queries on the courses table
		$this->load->model('Course', 'courses_table');

		// load the model for doing queries on the completed courses table
		$this->load->model('CompletedCourse', 'completed_courses_table');
	}

	public function index() {

		if (!$this->session->userdata('logged_in')) {
			// if is not logged in, redirect user to the login page
			redirect('pasta', 'refresh');
		} else {
			// assign constant to an attribute variable
			$soft_eng_courses = $this->config->item('SOFT_ENG_COURSES');

			$data['title'] = "P.A.S.T.A. - Course Completed";

			/*
			 * Setting up the software engineering courses array with information
			 */
			foreach ($soft_eng_courses as $years => $semesters) {
				foreach($semesters as $semester => $course_lists) {
					$data['soft_eng_courses'][$years][$semester] = 
						$this->_get_course_information($course_lists);
	            }
	        }

			$this->put('course_completed_selection_view', $data);
		}
	}

	/**
	 * Get array of course information from an array of course list
	 * input as an array.
	 * @param: semseter_or_category_list
	 *		   Semester is an array of courses taken in one semester.
	 * 		   Category list is optional courses list, and electives.
	 */
	private function _get_course_information($semester_or_category_list) {
		$information_array = array();

		foreach ($semester_or_category_list as $index => $course) {
			$information_array[$index] =
				$this->courses_table->find_by_code_number_array($course);
			// query the database check if this course is already taken
			// if taken then we need to put a checked box to indicate
			// that this course is already present in the database
			$information_array[$index]["has_taken"] = 
				$this->completed_courses_table->has_taken(
					$this->session->userdata('student_id'),
					$this->courses_table->get_course_id($course));
		}
		
		return $information_array;
	}

	/**
	 * Store the core courses that this student has taken in 
	 * completed courses table
	 */
	public function submit() {
		$updated_completed = $this->input->post('completed_courses');

		// database completed courses
		$database_completed = $this->completed_courses_table->find_by_student_id($this->session->userdata('student_id'));

		// if student has taken courses, then update the database
		// for this student, else do nothing and move onto next step
		if ($database_completed != NULL) 
		{
			foreach ($database_completed as $database_relations => $value)
			{
				$this->completed_courses_table->delete_by_student_id(
					$this->session->userdata('student_id'),
					$value['course_id']);
			}
		}


		// insert new values
		if ($updated_completed != NULL)
		{
			foreach ($updated_completed as $database_relations => $value) 
			{
				$this->completed_courses_table->insert_by_student_id(
					$this->session->userdata('student_id'),
					$value);
			}
		}
		
		// redirect user to course registration
		redirect('schedulebuilder', 'location');
	}
}

// End of CourseCompleted.php