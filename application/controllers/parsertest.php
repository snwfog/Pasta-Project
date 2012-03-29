<?php
require_once 'coursecompleted.php';

class parsertest extends CourseCompleted {
	function __construct() {
		parent::__construct();
	}
    
    public function index() {
        parent::index( 'scrape_views/courseCompleted_debug' );
    }
    
	public function core( $view = 'scrape_views/courseCompleted_debug' ) {
		// assign constant to an attribute variable
		$soft_eng_courses = $this->config->item('SOFT_ENG_COURSES');

		$data['title'] = "Course Registration Form";

		/*
		 * Setting up the software engineering courses array with information
		 */
		foreach ($soft_eng_courses as $years => $semesters) {
			foreach($semesters as $semester => $course_lists) {
                $dbInfo = $this->_get_course_information($course_lists);
                                
				$data['soft_eng_courses'][$years][$semester] = $dbInfo;
            }
        }

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