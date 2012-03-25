<?php

/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CourseCompleted extends CI_Controller {

	function __construct() {
		parent::__construct();
		// load all of the course constants
		$this->config->load('pasta_constants/soft_eng_courses');

		// load the model for doing queries on the courses table
		$this->load->model('Course');
	}

	public function index() {
		// assign constant to an attribute variable
		$soft_eng_courses = $this->config->item('soft_eng_courses');

		$data['title'] = "Course Registration Form";
		
		$data['SOEN'] = $this->Course->find_by_code_number_array(
			$soft_eng_courses["1"]["2"]["2"]);

		$this->put('courseCompleted', $data);
	}

	/**
	 * Private function to query all the courses information from the database
	 * with the "soft_eng_courses" constants file.
	 */

	//private function _query_course_information($course) {
	//	$course_title = 
	//}

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