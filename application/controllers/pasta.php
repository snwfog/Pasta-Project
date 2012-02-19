<?php 

/**
 * Script to prevent direct URL access to this file.
 * Should include at every beginning of file.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Pasta main controller
 * Author: Charles
 */
class Pasta extends CI_Controller {
	function Pasta() {
		parent::__construct();	
		
		// Loading helper function
		$this->load->helper(array('url', 'form'));	
	}	
	
	public function index()
	{	
		$data['title'] = 'Welcome to P.A.S.T.A.';
		
		// display the main view
		$this->put('main', $data);
	}
	
	/**
	 * Basic page display, $content should be the main content page,
	 * $static_content should hosts things like footer note, or
	 * page title (header/footer content). - Charles
	 */
	public function put($content, $data) {
		$this->load->view('static/header', $data);
		$this->load->view($content, $data);
		$this->load->view('static/footer', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */