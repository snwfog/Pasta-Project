<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    /**
     * This is just a temp copy, to display details. This library will become obsolete
     * when we scrape all course data and save it to a database.
     */

class Scraper {
	
	function data_collection($course, $course_number, $season){
		$CI = &get_instance();
		
		$CI->load->library('simple_html_dom.php');
		// ENGR 201, COMP 348, COMP 346, SOEN 341
		// Note that for yrsess 20114 is Winter, 20112 is Fall, 20113 is Fall AND Winter.
		// $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20114&course='.$course.'&courno='.$course_number.'&campus=&type=U');
		// $html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20113&course='.$course.'&courno='.$course_number.'&campus=&type=U');
		
		// Removed campus and type query string since they are not relevant to
		// the scraping. Campus query can be set to U (for undergraduate) or G (for
		// graduate). While campus can be set to SGW or LOY - Charles
		$html = file_get_html('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=20113&course='.$course.'&courno='.$course_number);
		$row = $html->find('td');
		
		// scraping information
		$course_lecture = array();
		for($i=9; $i<=sizeOf($row)-1; $i++){
			if (strcasecmp(trim($row[$i]->text()), $course." ".$course_number) === 0) {
				$course_title = $row[$i+1]->text();
				$credit = $row[$i+2]->text();
				echo "Course Title:".$course_title."<br>Credit:".$credit;
			}
			if (preg_match("/^Lect\s\w+/", $row[$i]->text(),$matches)) {
				$lecture_title = trim($row[$i]->text());
				$tutorials = $this->get_tutorials($i+1, $row); // Call function to get lecture of each course
				$time_location = $this->time_location($i, $row);
				$time_location["Teacher"] =  trim($row[$i+3]->text());
				$time_location["Tutorials"] =  $tutorials;
				
				$course_lecture[$lecture_title] = $time_location;
				//print_r($course_lecture);
			}
		}
		return array($course_lecture, $row);
	}
	
	
	function get_tutorials($index, $row){
		$tutorial_info = array();
		for($index; $index<=sizeOf($row)-1; $index++) {
			$text = trim($row[$index]->text());
			$text = preg_replace('/&nbsp;/','',$text);
			if(preg_match("/^Lect\s\w+/", $row[$index]->text(),$matches)) {
				break;
			}
			if(preg_match("/Tut\s\w+/",$text)) {
				$labratory_info = $this->get_labratory($index+3, $row);
				$time_location = $this->time_location($index,$row);
				$time_location["Labs"] = $labratory_info;
				$tutorial_info[$text] = $time_location;
			}
		}
		//print_r($tutorial_info);
		return $tutorial_info;
	}
	
	function get_labratory($index,$row){
		$labratory_info = array();
		for($index; $index<=sizeOf($row)-1; $index++){
			$text = trim($row[$index]->text());
			$text = preg_replace('/&nbsp;/','',$text);
			if(preg_match("/Tut\s\w+/", $row[$index]->text(),$matches)) {
				break;
			}
			if(preg_match("/Lab\s\w+/",$text)) {
				$labratory_info[$text] = $this->time_location($index,$row);
			}
		}
		return $labratory_info;
	}
		
	function time_location($index, $row){
		$time = trim($row[$index+1]->text());
		$location = trim($row[$index+2]->text());
		return array("Time" => $time, "Location" => $location);
	}
}
?>