<?php

require_once 'scrape.php';

/**
  Author Eric Rideough
  *
  */

class PrefetchScraper extends Scrape {
	function __construct() {
		parent::__construct();
        
        $this->load->helper('file');

        $this->cacheLocation = 'data/scraper_cache';
    }

    // Overwrite Scrape.savePageContents to read from local cache.
    function getPageContents ( $session, $course_code, $course_number ) {   
        // Format is YEAR_SEASON_CODE_NUMBER
        // eg: 2011_04_COMP_328
        $cacheFileName = $this->cacheLocation . '/' . '2011' . '_' . $session . '_' . $course_code . '_' . $course_number;
    
        $html = file_get_html( $cacheFileName );
        return $html;
    }

    function savePageContents( $session, $course_code, $course_number ) {                
        $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$session.'&course='.$course_code.'&courno='.$course_number);
        
        $cacheFileName = $this->cacheLocation . '/' . '2011' . '_' . $session . '_' . $course_code . '_' . $course_number;
        write_file( $cacheFileName, $html );
    }
    
    function speedTest() {
        $old_error_handler = set_error_handler( "scrapeTestErrorHandler", E_ALL );

        $ALL_COURSES = $this->getUniqueCourseList();
    
        foreach ( $ALL_COURSES as $courseDetails ) {        
            // With every course we have two possibilites: Fall (2) and Winter(4). Try both of them.
            foreach ( array(2, 4) as $semester ) {
                try {
                    $scrapedCourse = $this->scrape_site( $courseDetails[0], $courseDetails[1], $semester );
                }
                catch ( Exception $e ) {
                    $exceptionsThrown = true;
                    
                    if ( count(strstr( $e->getMessage(), 'No such file or directory' )) > 0 ) {
                        
                    }
                    else {
                        echo "Fail: " . $e->getMessage() . "<br />\n";
                    }
                }
            }
        }
        echo "Pass. <br />";
    }

    function cacheAllCourses() {
        $ALL_COURSES = $this->getUniqueCourseList();
                
        // COURSE_LIST has the format Code, Number.
        foreach ( $ALL_COURSES as $courseDetails ) {        
            // With every course we have two possibilites: Fall (2) and Winter(4). Try both of them.
            foreach ( array(2, 4) as $semester ) {
                    echo "Saving " . $courseDetails[0] . ' ' . $courseDetails[1] . ' ' . $semester . " <br />\n";
                    $this->savePageContents( $semester, $courseDetails[0], $courseDetails[1] );
            }
        }
        echo "All done!";
    }
}

?>