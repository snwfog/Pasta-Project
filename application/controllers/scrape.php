<?php

/*
 * A quick and dirty error handler to mass-test the scraper.
 * For simple tests, this is much easier than extending CI's exception handler, which we may do in the future.
 */
function scrapeTestErrorHandler($errorNo, $errorMessage, $errorFile, $errorLine) {
    $exception = new CustomException( $errorMessage, $errorNo );
    
    $exception->setLine($errorLine);
    $exception->setFile($errorFile);
    
    throw $exception; 
    
    return true; // Don't go through the default exception handling.
}

/*
 * And a custom exception handler that currectly reports the line and file.
 * This class was provided by "errd" on the PHP documentation page for set_error_handler().
 */
class CustomException extends Exception { 
    public function setLine( $exceptionLine ) {
        $this->line = $exceptionLine;
    } 
     
    public function setFile( $exceptionFile ) {
        $this->file = $exceptionFile;
    }
}

class Scrape extends CI_Controller {
//	public __constructor() {
//		
//	}
//	
	public function index() {
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
    
    /*
     * Call the scraper tester in a special mode to write out the course data as a serialized array.
     * (super slow!)
     */
    public function serializeAll () {
        $this->testAll( true, 'serialize' );
    }
        
    /*
     * A debug function that tests all courses to see how well
     * WARNING: This func is VERY slow, since it fetches each course from the Concordia servers 1 at a time.
     * Writes out directly to the browser, and uses deprecated HTML, but that's ok because it's purely for debugging.
     */
    public function testAll( $saveData = false, $saveFormat = 'serialize' ) {
        // Override CI's exception handling, so we can easily output which parameters caused the scraper to fail, and procede to the next call to test.
        $old_error_handler = set_error_handler( "scrapeTestErrorHandler", E_ALL );
        
        $this->config->load('pasta_constants/course_list');
        
        if ( $saveData && $saveFormat == 'serialize' ) {
            $allScrapedCourses = array( );
        }
        
        // COURSE_LIST has the format Name, Number, Title.
        foreach ( $this->config->item('COURSE_LIST') as $courseDetails ) {
            // With every course we have two possibilites: Fall (2) and Winter(4). Try both of them.
            foreach ( array(2, 4) as $semester ) {
                $exceptionsThrown = false;
                try {
                    $scrapedCourse = $this->scrape_site( $courseDetails[0], $courseDetails[1], $semester );
                }
                catch ( Exception $e ) {
                    /*
                     * To print the exception use $e->getMessage();
                     * We're not going to do this with this view because it would clog up the test list.
                     * Instead, our view can provide a link to the error-generating page.
                     */
                    $exceptionsThrown = true;
                    // Undefined offset 9 happens when the parser attempts to read course data for a course that isn't available that semester.
                    if ( $e->getMessage() == "Undefined offset: 9" ) {
                        echo '<b><font color="gray">Warning</font></b>: Course isn\'t available this semester. Parameters: ' .
                        $courseDetails[2] . ' (' . $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . ')';
                        echo "<br />\n";   
                    }
                    else {
                        echo '<b><font color="red">ERROR</font></b>: "' . $e->getMessage() . '" Parameters: ' .
                            $courseDetails[2] . ' (' . $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . ')';
                        echo "<br />\n";
                    }
                }
                
                /*
                 * If no exceptions were thrown, then we passed the test without error.
                 */
                if ( ! $exceptionsThrown ) {
                    echo '<b><font color="green">Pass</font></b>: ' . $courseDetails[2] . ' (' . $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . ') <br />' . "\n";
                    
                    // Save the data. This is only called if this method was called through a different save method.
                    if ( $saveData ) {
                        // Later on we'll have a db format, so we can store directly to the DB.
                        if ( $saveFormat == 'serialize' ) {
                            if ( $semester == 2 ) {
                                $allScrapedCourses['FALL'][] = $scrapedCourse;
                            }
                            else {
                                $allScrapedCourses['WINTER'][] = $scrapedCourse;
                            }
                        }
                    }
                }
            }
        }
        echo "<b>All courses have been tested.</b>";
        
        // Serialized data is written out to the client
        if ( $saveData && $saveFormat == 'serialize' ) {
            echo "<br />\n";
            echo "============================= <br />\n";
            echo "Serialized scraped courses: <br />\n";
            echo serialize( $allScrapedCourses ) . "\n";
            echo "============================= <br />\n";
        }
        
    }
    
    /*
     * Read in the text file of serialized courses, unserialize it, and print it out.
     */
    public function showAllSerializedCourses() {
        $this->load->helper('file');
        
        $s_serializedCourses = read_file('SERIALIZED_COURSES.TXT');
        
        $allScrapedCourses = unserialize( $s_serializedCourses );
        
        print_r( $allScrapedCourses );
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
		
		$course['prerequisite'] = 
			$this->scrape_prerequisite($all_rows[10]->children(2)->plaintext);
		
		$course['section'] = array(); // assume that there is at least one lecture
		
		$start_row = 13;
		// individual course information starts at table row 13
		// unless there is not a "Special Note" at row 11, children 1
		if (!preg_match("/Special\sNote/", $all_rows[11]->children(1)->plaintext))
			$start_row = 12;
			
		for ($i = $start_row; $i < sizeof($all_rows)-1; $i++) {
			// if row contains a lecture information, and lecture is not canceled
			if (preg_match("/Lect/", $all_rows[$i]->children(2)->plaintext) &&
				!preg_match("/Canceled/", $all_rows[$i]->children(2)->plaintext)) {
				// create section name
				$section_name = $this->scrape_name($all_rows[$i]->children(2)->plaintext);
			
				// scrape the lecture for this section
				$course['section'][$section_name] = $this->scrape_lecture($all_rows[$i]);
					
			} else if (preg_match("/Tut/", $all_rows[$i]->children(2)->plaintext) &&
				!preg_match("/Canceled/", $all_rows[$i]->children(2)->plaintext)) {
				// if row contains a tutorial information, and tutorial is not canceled
				$tutorial_section = 
					$this->scrape_tutorial_name(
						$all_rows[$i]->children(2)->plaintext, 
						$section_name
					);
					
				// create a new section tutorial array to contain the different
				// tutorial sections
				if (!isset($course['section'][$section_name]['tutorial']))
					$course['section'][$section_name]['tutorial'] = array();
			
				// create a new section tutorial section information array
				$course['section'][$section_name]['tutorial'][$tutorial_section] =
					$this->scrape_tutorial($all_rows[$i]);
				
			}
		}
		
		return $course;
	}
		
	//-------------------------------------------------------------
	// Scrape the lecture information providing the row information
	//-------------------------------------------------------------
	private function scrape_lecture($row) {
		$lecture = array();
	
		$lecture['name'] = 
			$this->scrape_name($row->children(2)->plaintext);;
	
		// set section days
		$lecture['day'] = 
			$this->scrape_day($row->children(3)->plaintext);
	
		// set section times
		$lecture['time'] = 
			$this->scrape_time($row->children(3)->plaintext);
	
		// set section campus
		$lecture['campus'] = 
			$this->scrape_campus($row->children(4)->plaintext);
	
		// set section room
		$lecture['room'] = 
			$this->scrape_room($row->children(4)->plaintext);
	
		// set section professor
		$lecture['professor'] = 
			$row->children(5)->plaintext;
	
		return $lecture;
	}
	
	//--------------------------------------------------------------
	// Scrape the tutorial information providing the row information
	//--------------------------------------------------------------	
	private function scrape_tutorial($row) {
		$tutorial = array();
	
		// set section days
		$tutorial['day'] = 
			$this->scrape_day($row->children(3)->plaintext);
		
		// set section times
		$tutorial['time'] = 
			$this->scrape_time($row->children(3)->plaintext);
	
		// set section campus
		$tutorial['campus'] = 
			$this->scrape_campus($row->children(4)->plaintext);
		
		// set section room
		$tutorial['room'] = 
			$this->scrape_room($row->children(4)->plaintext);
	
		return $tutorial;
	}
	    
	//------------------------
	// Regex helper functions
	//------------------------
	private function scrape_prerequisite($str) {
		$prerequisite = array();
		
		preg_match_all("/(\b[\w]{4}\s[\d]{3}([\sor]+)?)+/", $str, $capture);
	
		$i = 0;
		foreach ($capture[0] as $prerequisite_group) {
			preg_match_all(
				"/(\b[\w]{4})\s([\d]{3})/", 
				$prerequisite_group, 
				$prerequisite_course
			);
			//print_r($prerequisite_course);
			$prerequisite[$i] = array();
			for($j = 0; $j < sizeof($prerequisite_course[1]); $j++) {
				$prerequisite[$i][$j]['code'] = $prerequisite_course[1][$j];
				$prerequisite[$i][$j]['number'] = $prerequisite_course[2][$j];
			}
	
			$i++;
		}
	
		return $prerequisite;
	}
	
	private function scrape_name($str) {
		preg_match("/\b[\w]{1,2}\b/", $str, $name);
		return $name[0];
	}
	
	private function scrape_tutorial_name($str, $section_name) {
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
		preg_match('/[\w\d]+-[\w\d\.]+/', $str, $room);
		return $room[0];
	}
	
	//------------------------------
	// End of regex helper functions
	//------------------------------
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */