<?php
require_once 'coursecompleted.php';

class parsertest extends CourseCompleted {
	function __construct() {
		parent::__construct();
        
        $this->config->load('pasta_constants/option_courses');
        $this->config->load('pasta_constants/courses_not_available');
	}
        
    function getCoreDetails() {
		/*
		 * Setting up the software engineering courses array with information
         * from the DB, such as title and credits.
		 */
        $coreDetails = array();
		foreach ($this->config->item('SOFT_ENG_COURSES') as $years => $semesters) {
			foreach($semesters as $semester => $course_lists) {
                $dbInfo = $this->_get_course_information($course_lists);
                $coreDetails[$years][$semester] = $dbInfo;
            }
        }
        return $coreDetails;
    }
    
    function getAvailabilityForGroup( &$courseGroup ) {
        /*
         * Look up course availability for optional courses.
         * Set the availability as a boolean to the course array for Fall and Winter.
         */
        
        $COURSES_NOT_AVAILABLE = $this->config->item('COURSES_NOT_AVAILABLE');
        
        foreach ( $courseGroup as $idx => $course ) {
            // If there were no db details, course[0] is code, course[1] is number.
            if ( isset($course['code']) ) {
                $courseCode = $course['code'];
                $courseNumber = $course['number'];
            }
            else {
                $courseCode = $course[0];
                $courseNumber = $course[1];
            }
            
            $course['Fall'] = true;
            if ( in_array( array($courseCode, $courseNumber), $COURSES_NOT_AVAILABLE[2012]['Fall'] ) ) {
                $course['Fall'] = false;
            }
            
            $course['Winter'] = true;
            if ( in_array( array($courseCode, $courseNumber), $COURSES_NOT_AVAILABLE[2012]['Winter'] ) ) {
                $course['Winter'] = false;
            }
            
            // Update the array that was passed by reference.
            $courseGroup[$idx] = $course;
        }
    
    }
    
    function getOptionalCourses() {
        $optionalCourseDetails = array();
        //COURSES_NOT_AVAILABLE
        foreach ( $this->config->item('OPTION_COURSES') as $groupName => $groupCourses ) {
            if ( (array_key_exists(0, $groupCourses)) && (count( $groupCourses[0] ) == 2) ) {
                $dbInfo = $this->_get_course_information($groupCourses);
                
                $this->getAvailabilityForGroup( $dbInfo );
                
                $optionCourseDetails[$groupName] = $dbInfo;
            }
            else {
                // There are subgroups that we must iterate through before the courses.
                $optionCourseDetails[$groupName] = array();
                foreach ( $groupCourses as $subGroup => $subGroupCourses ) {
                    $dbInfo = $this->_get_course_information($subGroupCourses);
                    
                    $this->getAvailabilityForGroup( $dbInfo );
                    
                    $optionCourseDetails[$groupName][$subGroup] = $dbInfo;
                }
            }
        }
        return $optionCourseDetails;
    }
    
	public function index( $view = 'scrape_views/courseCompleted_debug' ) {
		$data['title'] = "Scraper Test";

        $data['soft_eng_courses'] = $this->getCoreDetails();
        
        //$data['option_courses'] = $this->config->item('OPTION_COURSES');
        $data['option_courses'] = $this->getOptionalCourses();

        $this->put($view, $data);
	}

	private function _get_course_information($semester_or_category_list) {
		$information_array = array();

		foreach ($semester_or_category_list as $index => $course) {
            $dbCourseDetails = $this->courses_table->find_by_code_number_array($course);
            if ( ( ! array_key_exists( 'credit', $dbCourseDetails )) || ( is_null($dbCourseDetails['credit']) ) ) {
                $dbCourseDetails['credit'] = 'NOCRED';
                $dbCourseDetails['code'] = $course[0];
                $dbCourseDetails['number'] = $course[1];
            }
            
			$information_array[$index] = $dbCourseDetails;
        }

		return $information_array;
	}

    
}
?>