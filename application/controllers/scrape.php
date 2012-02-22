<?php
class Scrape extends CI_Controller {
//	public __constructor() {
//		
//	}
//	
	public function index()
	{
		$this->load->helper(array('url', 'form'));
		
		// setup form validation
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('course_code', 'Course Code', 'required|trim|xss_clean|exact_length[4]|alpha');
		$this->form_validation->set_rules('course_number', 'Course Number', 'required|trim|xss_clean|exact_length[3]|numeric');
		
		// validate form from POST data
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('/scrape_views/form');
		} else {
			// scrape course information
			$this->load->view(
				'/scrape_views/scrape_view', 
				$this->scrape_site(
					strtoupper($this->input->post('course_code')), 
					$this->input->post('course_number'), 
					$this->input->post("session")));
		}
	}
	
	/**
	 * Method to get the course information data
	 */
	private function scrape_site($course_code, $course_number, $session) {
		$CI =& get_instance();

		$CI->load->library('simple_html_dom.php');
		
		// Note that for yrsess 4 is Winter, 2 is Fall, 3 is Fall & Winter, 1 is Summer.
		$html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$session.'&course='.$course_code.'&courno='.$course_number);
		
		$all_rows = $html->find('tr');
			
		//--------------------------------------------------------
		// Course array, containing all course related information
		//--------------------------------------------------------
		$course = array();
	
		// matching the course_id e.g. SOEN 321 in different capture group
		preg_match("/([\w]{4})\s([\d]{3})/", $all_rows[9]->children(1)->plaintext, $course_id);
		$course['code'] = $course_id[1];
		$course['number'] = $course_id[2];
		$course['title'] = $all_rows[9]->children(2)->plaintext;
		
		// matching the course_id e.g. SOEN 321 in different capture group
		preg_match("/[\d]/", $all_rows[9]->children(3)->plaintext, $credit);
		$course['credit'] = $credit[0];
		
		preg_match("/([\w]{4}\s[\d]{3})+/", $all_rows[10]->children(2)->plaintext, $prerequisites);
		$course['prerequisites'] = $prerequisites[0];

		$course['section'] = array(); // assume that there is at least one lecture

		// individual course information starts at table row 13
		for ($i = 13; $i < sizeof($all_rows); $i++) {
			// if row contains a lecture information
			if (preg_match("/Lect/", $all_rows[$i]->children(2)->plaintext)) {
				// create section name
				$section_name = scrape_name($all_rows[$i]->children(2)->plaintext);
				
				// scrape the lecture for this section
				$course['section'][$section_name] = scrape_lecture($all_rows[$i]);
					
			} else if (preg_match("/Tut/", $all_rows[$i]->children(2)->plaintext)) {
			// if row contains a tutorial information
				$tutorial_section = scrape_tutorial_name($all_rows[$i]->children(2)->plaintext, $section_name);
				// create a new section tutorial array to contain the different
				// tutorial sections
				if (!isset($course['section'][$section_name]['tutorial']))
					$course['section'][$section_name]['tutorial'] = array();
				
				// create a new section tutorial section information array
				$course['section'][$section_name]['tutorial'][$tutorial_section] =
					scrape_tutorial($all_rows[$i]);
				
			}
		}
		
		return $course;
	}
		
	//-------------------------------------------------------------
	// Scrape the lecture information providing the row information
	//-------------------------------------------------------------
	private function scrape_lecture($row) {
		$lecture = array();
	
		// set section name
		$lecture['name'] = $section_name;
	
		// set section days
		$lecture['day'] = 
			scrape_day($row->children(3)->plaintext);
		
		// set section times
		$lecture['time'] = 
			scrape_time($row->children(3)->plaintext);
	
		// set section campus
		$lecture['campus'] = 
			scrape_campus($row->children(4)->plaintext);
		
		// set section room
		$lecture['room'] = 
			scrape_room($row->children(4)->plaintext);
		
		// set section professor
		$lecture['professor'] = $row->children(5)->plaintext;
	
		return $lecture;
	}
	
	//-------------------------------------------------------------
	// Scrape the tutorial information providing the row information
	//-------------------------------------------------------------		
	private function scrape_tutorial($row) {
		$tutorial = array();
	
		// set section days
		$tutorial['day'] = 
			scrape_day($row->children(3)->plaintext);
		
		// set section times
		$tutorial['time'] = 
			scrape_time($row->children(3)->plaintext);
	
		// set section campus
		$tutorial['campus'] = 
			scrape_campus($row->children(4)->plaintext);
		
		// set section room
		$tutorial['room'] = 
			scrape_room($row->children(4)->plaintext);
	
		return $tutorial;
	}
	    
	//------------------------
	// Regex helper functions
	//------------------------
	private function scrape_name($str) {
		preg_match("/\b[\w]{1,2}\b/", $str, $name);
		return $name[0];
	}
	
	private function scrape_tutorial_name($str) {
		preg_match("/[^$section_name]\$/", $str, $name);
		return $name[0];
	}
	
	private function scrape_day($str) {
		preg_match_all('/[A-Z]/', $str, $day);
		return $day[0];
	}
	
	private function scrape_time($str) {
		preg_match_all('/[\d]{2}:[\d]{2}/', $str, $time);
		return $time[0];
	}
	
	private function scrape_campus($str) {
		preg_match('/[\w]{3}/', $str, $campus);
		return $campus[0];
	}
	
	private function scrape_room($str) {
		preg_match('/[\w\d]+-[\w\d]+/', $str, $room);
		return $room[0];
	}
	
	//------------------------------
	// End of regex helper functions
	//------------------------------
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */