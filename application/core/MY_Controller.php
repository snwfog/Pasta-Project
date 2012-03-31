<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PASTA
 *
 * Extends the default CI controller for a few frequently used
 * helping functions.
 *
 * @package		PASTA
 * @author		Charles Yang
 */

class MY_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
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

	/**
	 * Always assum the current session user. Check if user is currently
	 * logged in.
	 * @return boolean [description]
	 */
	public function user_is_logged_in() {
		return $this->session->userdata('logged_in');
	}

	public function session_student_id() {
		return $this->session->userdata('student_id');
	}

	public function session_student_first_name() {
		return $this->session->userdata('first_name');
	}

	public function session_student_last_name() {
		return $this->session->userdata('last_name');
	}

}

// End of MY_Controller