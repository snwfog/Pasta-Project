<?php
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
class CourseCompleted extends CI_Controller {

	function __construct() {
		parent::__construct();
		// load all of the course constants
		$this->config->load('pasta_constants/soft_eng_courses');

		// load the model for doing queries on the courses table
		$this->load->model('Course', 'courses_table');
	}

	public function index() {
		// assign constant to an attribute variable
		$soft_eng_courses = $this->config->item('SOFT_ENG_COURSES');

		$data['title'] = "Course Registration Form";

		/*
		 * Setting up the software engineering courses array with information
		 */
		foreach ($soft_eng_courses as $years => $semesters)
			foreach($semesters as $semester => $course_lists)
				$data['soft_eng_courses'][$years][$semester] = 
					$this->_get_course_information($course_lists);

		$this->put('courseCompleted', $data);
	}

	/**
	 * Get array of course information from an array of course list
	 * input as an array.
	 */
	private function _get_course_information($semester_or_category_list) {
		$information_array = array();

		foreach ($semester_or_category_list as $index => $course)
			$information_array[$index] =
				$this->courses_table->find_by_code_number_array($course);

		return $information_array;
	}

	/**
	 * Store the core courses that this student has taken in 
	 * completed courses table
	 */
	public function submit() {
		print_r($this->input->post('completed_courses'));
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

?>