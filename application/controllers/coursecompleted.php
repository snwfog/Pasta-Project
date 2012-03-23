<?php

/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CourseCompleted extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		// load helper library
		$this->load->helper(array('url', 'form'));

		// load form validation
		$this->load->library('form_validation');

		// load all of the course constants
		$this->config->load('pasta_constants/soft_eng_courses');
	}

	public function index() {

		$data['title'] = "Course Registration Form";
		
		$this->put('courseCompleted', $data);
	}


	// /**
	//  * Basic page display, $content should be the main content page,
	//  * $static_content should hosts things like footer note, or
	//  * page title (header/footer content). - Charles
	//  */
	public function put($content_view, $data) {
		$this->load->view('static/header', $data);
		$this->load->view($content_view, $data);
		$this->load->view('static/footer', $data);
	}
}

?>