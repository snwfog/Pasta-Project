<?php
class Scrape extends CI_Controller {
	public function index()
	{
		$this->load->helper('url');
		$course_code = trim(strtoupper($this->input->post('course_code')));
		$course_number = trim($this->input->post('course_number'));
        $season = trim($this->input->post("season"));
      
        if ($course_code && $course_number && $season) {
        	// if the course information can be retrieved from the POST data
        	// then scrape the desired information
            $return = $this->data_collection($course_code, $course_number, $season);
			$data['course_lecture'] = $return[0];
			$data['row'] = $return[1];
			// return[2] contains core course information such as the code (ie: SOEN), number (228), prereqs (string; needs to be parsed more), and title (ie: "SYSTEM HARDWARE")
			$data = array_merge( $data, $return[2] );

			$this->load->view('/scrape_views/scrape_view.php',$data);
		}
		else {
			// else there are no information entered into POST, then load the page
			// to display the information form
			$this->search();
		}
	}
	
	/**
	 * Method to load the search form
	 */
	public function search(){
	  	$this->load->helper('form');
	  	$this->load->view('/scrape_views/form.php');
	}
	
	/**
	 * Method to get the course information data
	 */
	private function data_collection($course, $course_number, $season){
		$CI =& get_instance();

		$CI->load->library('simple_html_dom.php');
		
		// Note that for yrsess 4 is Winter, 2 is Fall, 3 is Fall & Winter, 1 is Summer.
		$html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$season.'&course='.$course.'&courno='.$course_number);
		//$html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20113&course='.$course.'&courno='.$course_number.'&campus=&type=U');
		$row = $html->find('td');
		
		$courseDetails = array(
          'name' => $course,
		  'number' => $course_number,
		);

		//scraping information

        // BUG: SOME COURSES IS ALL YEAR LONG ONLY SHOW UP IN OPTION 3: FALL&WINTER. However OPTION 3 will show fall, winter, and fall&winter courses.
		$course_lecture = array();
		for ($i=9; $i<=sizeOf($row)-1; $i++) {
			if(strcasecmp(trim($row[$i]->text()), $course." ".$course_number) === 0){
			    $course_title = $row[$i+1]-> text();
			    $credit = $row[$i+2]-> text();

			    $courseDetails['title'] = $course_title;
			    $courseDetails['credit'] = $credit;
                $courseDetails['prerequisites'] = null;

			}


		    if (strcasecmp(trim($row[$i]->text()), "Prerequisite:") === 0) {
		        $preq = $row[$i+1]-> text();
		        $courseDetails['prerequisites'] = $preq; // TOOD: This should be parsed further into course name and numbers.
		    }
		
			if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)) {
				$lecture_title = trim($row[$i]->text());
				$tutorials = $this->get_tutorials($i+1, $row); // Call function to get lecture of each course
				$time_location = $this->time_location($i, $row);
				$time_location["Teacher"] =  trim($row[$i+3]->text());
				if(empty($tutorials)){
                    $lab = $this -> get_labratory($i+1, $row);
                    if(!empty($lab)){
                        $tutorials_info = array( "Time" => null, "Location" => null, "Labs" => $lab );
                        $tutorials = array( "Null" => $tutorials_info);
                        $time_location["Tutorials"] = $tutorials;
                    }
                }else{
                    $time_location["Tutorials"] =  $tutorials;
                }
				$course_lecture[$lecture_title] = $time_location;
			}
		}
	 	return array($course_lecture, $row, $courseDetails);
    }

	private function get_tutorials($index, $row){
		$tutorial_info = array();
		for ($index; $index<=sizeOf($row)-1; $index++) {
			$text = trim($row[$index]->text());
			$text = preg_replace('/&nbsp;/','',$text);
			if (preg_match("/^Lect\s\w+/", $row[$index]->text(),$matches)) {
				break;
			}
			
			if (preg_match("/Tut\s\w+/",$text)) {
				$labratory_info =  $this->get_labratory($index+3, $row);
				$time_location = $this -> time_location($index,$row);
				$time_location["Labs"] = $labratory_info;
				$tutorial_info[$text] = $time_location;
			}
		}
		return $tutorial_info;
	}

	private function get_labratory($index,$row){
		$labratory_info = array();
		for ($index; $index<=sizeOf($row)-1; $index++) {
			$text = trim($row[$index]->text());
			$text = preg_replace('/&nbsp;/','',$text);
			if (preg_match("/Tut\s\w+/", $row[$index]->text(),$matches) || preg_match("/^Lect\s\w+/", $row[$index]->text(),$matches)) {
				break;
			}
			
			if (preg_match("/Lab\s\w+/",$text)) {
				$labratory_info[$text] = $this -> time_location($index,$row);
			}
		}
		return $labratory_info;
	}
        
	private function time_location($index, $row){
		$time = trim($row[$index+1]->text());
		$location = trim($row[$index+2]->text());
		return array("Time" => $time, "Location" => $location);
	}

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */