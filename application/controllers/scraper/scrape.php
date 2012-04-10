<?php

/*
 Author Eric Rideough
 *
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

function createTimeLocQryParams( $details ) {
    /*
     * Get the Date/Time/Location details and add them to the db.
     */
     $dayStr = '';
    foreach ( $details['day'] as $day ) {
        $dayStr .= $day . ',';
    }
    
    // Time's on the page are in standard HH:MM format,
    // however, we want them in the format HHMM so we can store them in an int.
    $startTime = str_replace( ':','', $details['time'][0] );
    $endTime = str_replace( ':','', $details['time'][1] );
    
    $timeLocQryData = array(
        'start_time' => $startTime,
        'end_time' => $endTime,
        'campus' => $details['campus'],
        'room' => $details['room'],
        'day' => $dayStr,
    );
    
    return $timeLocQryData;
}

// From PHP.net's manual for array_unique()
function multi_unique( $array ) {
    foreach ( $array as $k => $na ) {
        $new[$k] = serialize( $na );
    }

    $uniq = array_unique($new);

    foreach($uniq as $k=>$ser) {
        $new1[$k] = unserialize($ser);
    }
    
    return ($new1);
}

class Scrape extends MY_Controller {
	function __construct() {
		parent::__construct();

        $CI =& get_instance();
		$CI->load->library('simple_html_dom.php');
        
        $this->DEBUG = false;
    }

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
    
    public function debug( $courseCode, $courseName, $session ) {
        $this->DEBUG = true;
        $this->load->view( '/scrape_views/scrape_view', $this->scrape_site($courseCode, $courseName, $session) );
    }
    
    public function details( $courseCode, $courseName, $session, $displayFormat = '' ) {
    
        $pageData = $this->scrape_site($courseCode, $courseName, $session);
        
        switch ( $displayFormat ) {
            case 'recursive':
                $view = '/scrape_views/print_r';
                $pageData['courseDetails'] = $pageData;
                break;
            default:
                $view = '/scrape_views/details';
        }
        
        $this->put( $view, $pageData );
    }
    
    /*
     * Call the scraper tester in a special mode to write out the course data as a serialized array.
     * (super slow!)
     */
    public function serializeAll () {
        $this->testAll( true, 'serialize' );
    }
    
    function getUniqueCourseList() {
        $this->config->load('pasta_constants/course_list');
        $this->config->load('pasta_constants/OPTION_COURSES');
        $this->config->load('pasta_constants/soft_eng_courses');

        $ALL_COURSES = $this->config->item('COURSE_LIST');
        
        // Remove the titles from the array,
        // that way when the course list is merged
        // with optional courses and the SOEN schedule,
        // there won't be duplicates since the course arrays
        // are in the same format.
        foreach ( $ALL_COURSES as $idx => $course ) {
            unset($course[2]);
            $ALL_COURSES[$idx] = $course;
        }
        
        // Merge option courses
        // option_courses has a different format from course_list.
        // It is grouped by subjects, such as "Basic Science", "General Electives", etc.
        // There are even sub groups, such as "Technical Electives" => "Computer Games (CG)" => course list.
        foreach ( $this->config->item('OPTION_COURSES') as $groupName => $groupCourses ) {
            // Check the first element in the group course list.
            // If that element is an array containing 2 items, then it is a course.
            // If it isn't, then our groupCourseList has sub-groups that contain course lists.
            if ( (array_key_exists(0, $groupCourses)) && (count( $groupCourses[0] ) == 2) ) {
                $ALL_COURSES = array_merge( $ALL_COURSES, $groupCourses );
            }
            else {
                foreach ( $groupCourses as $subGroup => $subGroupCourses ) {
                    $ALL_COURSES = array_merge( $ALL_COURSES, $subGroupCourses );
                }
            }
        }
        
        /*
         * Merge soft_eng_courses into the course list.
         * Soft eng courses is grouped by year, then semester, then an array of courses.
         */
        foreach ( $this->config->item('SOFT_ENG_COURSES') as $year => $seasons ) {
            foreach ( $seasons as $season => $courseList ) {
                $ALL_COURSES = array_merge( $ALL_COURSES, $courseList );
            }
        }
        
        // Remove duplicates. Some courses are repeated in COURSE_LIST and SOFT_ENG_COURSES
        $ALL_COURSES = multi_unique( $ALL_COURSES );

        return $ALL_COURSES;
    }
    
    /*
     * A debug function that tests all courses to see how well
     * WARNING: This func is VERY slow, since it fetches each course from the Concordia servers 1 at a time.
     * Writes out directly to the browser, and uses deprecated HTML, but that's ok because it's purely for debugging.
     */
    public function testAll( $saveData = false, $saveFormat = 'serialize' ) {
        // Override CI's exception handling, so we can easily output which parameters caused the scraper to fail, and procede to the next call to test.
        $old_error_handler = set_error_handler( "scrapeTestErrorHandler", E_ALL );
                
        if ( $saveData && $saveFormat == 'serialize' ) {
            $allScrapedCourses = array( );
        }
        
        $htmlOut = '';
        
        $ALL_COURSES = $this->getUniqueCourseList();
        
        // COURSE_LIST has the format Code, Number.
        foreach ( $ALL_COURSES as $courseDetails ) {        
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
                    if ( $e->getMessage() == "Undefined offset: 9" || $e->getMessage() == "Undefined offset: 8" ) {
                        $htmlOut .= '<b><font color="gray">Warning</font></b>: Course isn\'t available this semester. Parameters: ' .
                            $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . "<br />\n";   
                    }
                    else {
                        $htmlOut .= '<b><font color="red">ERROR</font></b>: "' . $e->getMessage() . '" Parameters: ' .
                            $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . "<br />\n";
                    }
                }
                
                /*
                 * If no exceptions were thrown, then we passed the test without error.
                 */
                if ( ! $exceptionsThrown ) {
                    $htmlOut .= '<b><font color="green">Pass</font></b>: ' . $courseDetails[0] . ' ' . $courseDetails[1] . ', Semester: ' . $semester . " <br />\n";
                    
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
        
        
        $htmlOut .= "<b>All courses have been tested.</b> <br />\n";
                
        // Serialized data is written out to the client
        if ( $saveData && $saveFormat == 'serialize' ) {
            $this->load->helper('file');

            $serializedCoursed = serialize( $allScrapedCourses );
            write_file('data/SERIALIZED_COURSES.TXT', $serializedCoursed);
            
            $htmlOut .= "<br />\nData saved to SERIALIZED_COURSES.TXT.<br />";
        }
        
        //echo $htmlOut;
        $this->put( 'scrape_views/fullpage', array( 'content' => $htmlOut, 'title' => 'Scraper' ) );
        //$this->put( 'scrape_views/fullpage', array( 'content' => 'UM HELLO WORLD?', 'title' => 'Scraper' ) );
    }
    
    public function testView () {
        $this->put( 'scrape_views/fullpage', array( 'content' => 'HEREIAM', 'title' => 'LOL IT WORKS' ) );
    }
    
    /*
     * Read in the text file of serialized courses, unserialize it, and print it out.
     */
    public function showAllSerializedCourses() {
        $this->load->helper('file');
        
        $s_serializedCourses = read_file('data/SERIALIZED_COURSES.TXT');
        
        $allScrapedCourses = unserialize( $s_serializedCourses );
        
        print_r( $allScrapedCourses );
    }


    // TESTING METHOD
    public function dummy_insert() {
        $this->load->helper('file');
        $all_courses = unserialize(read_file('SERIALIZED_COURSES.TXT'));
        $this->load->model('TimeLocation', 'time_locations_table');

        $this->time_locations_table->insert_time_location($all_courses['FALL']['3']['section']['F']);

        // $this->load->model('Course', 'courses_table');

        // $dummy_course = array(
        //     'code'  => 'DUMM',
        //     'number' => '111',
        // );

        // $this->courses_table->insert_course($dummy_course);
    }
    
    public function save() {
        /*
         * Read the serialized data containing all course information,
         * and save it to the database.
         */
        
        $this->load->helper('file');
        $this->load->database();
        
        $s_serializedCourses = read_file('SERIALIZED_COURSES.TXT');
        
        $allScrapedCourses = unserialize( $s_serializedCourses );

        $COURSE_PRIM_KEYS = array();
        $REQS_INSERTED = array();
        $DUMMY_COURSES = array();
        
        foreach ( $allScrapedCourses as $season => $semesterList ) {
        
            if ( $season == 'FALL' ) {
                $seasonID = 2;
            }
            
            if ( $season == 'WINTER' ) {
                $seasonID = 4;
            }
            
            /*
             * Course contains two iterable items: prerequisite and section.
             * Winter is parsed second. A course can be offered in both Fall and Winter.
             * We don't want duplicate course names, so we should check if it already exists.
             *   We don't need to query the database, we can check the FALL array.
             */
            /*
             * First, iterate through all courses and add them to the DB.
             * We do a second pass over all courses because we need them entered in case
             * they are prerequisites for other courses.
             */
            foreach ( $semesterList as $course ) {
                $newWinterCourse = true;
                if ( $seasonID == 4 ) {
                    //$seasonID = 4; // DO NOTHING. TODO: Check the FALL array for the course.
                    // Check if the course is already in the fall list
                    // and if it is, use that one's primary key.
                    foreach ( $allScrapedCourses['FALL'] as $fallCourse ) {
                        if ( ($course['code'] == $fallCourse['code']) && 
                             ($course['number'] == $fallCourse['number']) ) {
                            // The course is already listed.
                            $newWinterCourse = false;
                            //$coursePrimaryKey = $COURSE_PRIM_KEYS[$course['code']][$course['number']];
                            break; // Stop the foreach on fall courses.
                        }
                    }
                }
                
                if ( $seasonID == 2 || $newWinterCourse ) {
                    $courseQryData = array(
                        'code' => $course['code'],
                        'number' => $course['number'],
                        'title' => $course['title'],
                        'credit' => $course['credit'],
                    );
                    $this->db->insert( 'courses', $courseQryData );
                    
                    $coursePrimaryKey = $this->db->insert_id();
                    // Save the primary key to the associative array 
                    // so it can be re-used during the Winter iteration.
                    $COURSE_PRIM_KEYS[$course['code']][$course['number']] = $coursePrimaryKey; 
                }            
            }
        }        
                
        /*
         * And now go through the courses and add all their details.
         */
        foreach ( $allScrapedCourses as $season => $semesterList ) {         
            foreach ( $semesterList as $course ) {
                
                // Fetch the primary key that was generate from the previous giant loop.
                $coursePrimaryKey = $COURSE_PRIM_KEYS[$course['code']][$course['number']]; 
                
                if ( $season == 'FALL' ) {
                    $seasonID = 2;
                }
            
                if ( $season == 'WINTER' ) {
                    $seasonID = 4;
                }
                
                echo $course['code'] . ' ' . $course['number'] . "<br />\n";
                foreach ( $course['prerequisite'] as $prereqGroup ) {
                    foreach ( $prereqGroup as $prereq ) {
                        /*
                         * Course requirements only needs to be added once.
                         * If the keys are listed in REQS_INSERTED, then we've already done it.
                         */
                        if ( ! ( array_key_exists($course['code'], $REQS_INSERTED) && 
                                 array_key_exists($course['number'], $REQS_INSERTED) ) ) {

                            // TODO: If the course is not in the DB, then create a dummy record in the DB
                            if ( (array_key_exists( $prereq['code'], $COURSE_PRIM_KEYS ) && 
                                  array_key_exists( $prereq['number'], $COURSE_PRIM_KEYS[$prereq['code']])) ||
                                 (array_key_exists( $prereq['code'], $DUMMY_COURSES ) && 
                                 (array_key_exists( $prereq['number'], $DUMMY_COURSES[$prereq['code']])))) {
                                
                                if (array_key_exists( $prereq['code'], $COURSE_PRIM_KEYS ) && 
                                    array_key_exists( $prereq['number'], $COURSE_PRIM_KEYS[$prereq['code']])) {
                                    $prereqId = $COURSE_PRIM_KEYS[$prereq['code']][$prereq['number']];
                                }
                                else {
                                    $prereqId = $DUMMY_COURSES[$prereq['code']][$prereq['number']];
                                }
                                
                                $prereqQryParam = array(
                                    'course_id' => $coursePrimaryKey,
                                    'required_course_id' => $prereqId,
                                );
                                $this->db->insert( 'prerequisites', $prereqQryParam );
                            }
                            
                            $REQS_INSERTED[$course['code']][$course['number']] = true;
                        }
                    }
                }
                
                foreach ( $course['section'] as $courseSection => $sectionDetails ) {
                    /*
                     * Create the lecture record and lecture time-loc.
                     */
                    $timeLocQryData = createTimeLocQryParams( $sectionDetails );

                    $this->db->insert( 'time_locations', $timeLocQryData );
                    
                    $timeLocPrimaryKey = $this->db->insert_id();
                                        
                    $lectureQryData = array(
                        'section' => $courseSection,
                        'professor' => $sectionDetails['professor'],
                        'season' => $seasonID,
                        'course_id' => $coursePrimaryKey,
                        'time_location_id' => $timeLocPrimaryKey,
                    );
                
                    $this->db->insert( 'lectures', $lectureQryData );
                    $lecturePrimaryKey = $this->db->insert_id();
                    /*
                     * End of lecture and lecture time-loc.
                     */
                    
                    if ( array_key_exists( 'tutorial', $sectionDetails ) ) {
                        foreach ( $sectionDetails['tutorial'] as $tutSection => $tutDetails ) {
                            // Create the time location qry parameters for this tut, 
                            // and then insert it into the db.
                            $tutTimeLocQryData = createTimeLocQryParams( $tutDetails );
                            $this->db->insert( 'time_locations', $tutTimeLocQryData );
                            $tutTimeLocPrimaryKey = $this->db->insert_id();
                            
                            // Create tutorial parameters with that time-loc id.
                            $tutQryData = array(
                                'section' => $tutSection,
                                'lecture_id' => $lecturePrimaryKey,
                                'time_location_id' => $tutTimeLocPrimaryKey
                            );
                            $this->db->insert( 'tutorials', $tutQryData );
                            $tutPrimaryKey = $this->db->insert_id();
                            
                            /*
                             * At this point we should check for the existence of a lab key,
                             * and create a time-loc record and lab record similar to tutorials.
                             * However, the scraper didn't return any records with labs...
                             */
                        }
                    }
                }
            }
        }
    }

    function getPageContents( $session, $course_code, $course_number ) {                
        $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$session.'&course='.$course_code.'&courno='.$course_number);
        
        return $html;
    }

	
	/**
	 * Method to get the course information data
	 */
	function scrape_site($course_code, $course_number, $session) {		
		// Note that for yrsess 4 is Winter, 2 is Fall, 3 is Fall & Winter, 1 is Summer.
		$html = $this->getPageContents( $session, $course_code, $course_number );
		
		$all_rows = $html->find('tr');
		        
		//--------------------------------------------------------
		// Course array, containing all course related information
		//--------------------------------------------------------
		$course = array();
		
        $departmentName = $all_rows[7]->plaintext;

        $start_row = 10;
        $basic_details_row = 8;
        
        $departmentNote = '';
        $specialNote = '';
        $prerequisiteText = '';
        
        /*
         * Iterate through all rows, searching for special notes, department notes,
         * and prerequisites. These push down the start row for the course time/location.
         */
        for ( $rowNum = 8; $rowNum < count($all_rows); $rowNum++ ) {
            $rowText = $all_rows[$rowNum]->plaintext;
            if ($this->DEBUG) { echo "Row ".$rowNum.": " . $rowText . "' <br />\n"; }

            /*
             * strpos returns the location of the substring,
             * or false if the substring is not there.
             * Note that 0 evaluates as false.
             * is_int will return true on any integer (ie: a string/array index),
             * but will return false on a boolean false, such as the one returned by strpos.
             */
            if ( is_int( strpos($rowText, 'Department Note (') ) ) {
                $departmentNote = $rowText;
            
                // Department sends the details section down a row.
                $basic_details_row++;
                // All special rows send the start row down.
                $start_row++;
            }
            
            // Special note comes after prerequisites, so it doesn't modify that.
            if ( is_int( strpos($rowText, 'Special Note:') ) ) {
                $specialNote = $rowText;
                // All special rows send the start row down.
                $start_row++;
            }

            if ( is_int( strpos($rowText, 'Prerequisite:') ) ) {
                $prerequisiteText = $rowText;
                // All special rows send the start row down.
                $start_row++;
            }
        }

		$course['prerequisite'] = $this->scrape_prerequisite($prerequisiteText);

        // Contains code and number.
        $basicCourseInfo = $all_rows[$basic_details_row]->children(1)->plaintext;
        if ($this->DEBUG) {echo "COURSE INFO: " . $basicCourseInfo . ".<br />\n"; }
        
        // Extract the code and number into $course_id.
		preg_match("/([\w]{4})\s([\d]{3})/", $basicCourseInfo, $course_id);
		$course['code'] = $course_id[1];
		$course['number'] = $course_id[2];
        
		$course['title'] = $all_rows[$basic_details_row]->children(2)->plaintext;
        if ($this->DEBUG) { echo "TITLE: " . $course['title'] . ".<br />\n"; }
		
		// matching the course_id e.g. SOEN 321 in different capture group
		preg_match("/[\d]/", $all_rows[$basic_details_row]->children(3)->plaintext, $credit);
		$course['credit'] = $credit[0];

        if ($this->DEBUG) {        
            if ( (count($course['prerequisite'] == 0)) && $prerequisiteText == '' ) {
                echo "NO-PREREQS<br />\n";
            }
            else {
                if ( count($course['prerequisite']) == 0 ) {
                    echo "--------------------<br />\n";
                    echo "<b>PREREQUISITES STRING HAS CONTENT, BUT NONE PARSED</b>: <br />\n";
                    echo "Prereq string: '" . $prerequisiteText . "'<br />\n";
                    echo "Scraped prereqs: <br />\n";
                    print_r( $course['prerequisite'] );
                    echo "<br />\n";
                    echo "--------------------<br />\n";
                }
            }
        }

		$course['section'] = array(); // assume that there is at least one lecture                
                
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
        return $str[strlen($str)-1];
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
        $roomParts = explode( ' ', $str );

        if ( count( $roomParts ) >= 2 ) {
            $roomNumber = $roomParts[1];
        }
        else {
            $roomNumber = '';
        }
        
        return $roomNumber; 
	}
	
        //------------------------
	// add courses to the database
	//------------------------
        public function addCoursetoDatabase(){     
            $con = mysql_connect("localhost","root","root");
            if (!$con){
                die('Could not connect: ' . mysql_error());
            }
            mysql_select_db("my_db", $con);

            $course = 'COMP';
            $code = '777';
            $credit = '6';

            mysql_query("INSERT INTO pasta.courses (`id`, `code`, `number`, `credit`)
                VALUES (NULL, '".$course."','".$code."', '".$credit."')");

            mysql_close($con);
            print_r($course.' '.$code." has been added to the table of courses.");
        }
        
        
        public function viewTableCourses(){
            $query = $this->db->query("select * from pasta.courses");

if ($query->num_rows() > 0)
{
   foreach ($query->result() as $row)
   {
      echo $row->id;echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ";
      echo $row->code;echo "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
      echo $row->number;echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ";
      echo $row->credit;echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ";
      echo "<br/>";
   }
}
        }
	
	//------------------------------
	// End of regex helper functions
	//------------------------------
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */
?>