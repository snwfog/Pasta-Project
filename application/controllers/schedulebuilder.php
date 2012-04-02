<?php

class ScheduleBuilder extends MY_Controller {

  	function __construct() {
  		  parent::__construct();
        $this->load->model('course');
        $this->load->model('scheduleBuilder_Model');
  	}

    public function index() {
        if (!$this->session->userdata('logged_in')) {
            // if is not logged in, redirect user to the login page
            redirect('pasta', 'refresh');
        } else {
            // load the preference pane by default
            $this->put('register_preferences', NULL);
            //$this->listAllAllowedCourses();
        }
    }

    public function listAllCourses() {
        $this->form_validation->set_rules("time", "Time", "required");

		    if ($this->form_validation->run() == FALSE) {
            $form['url']='schedulebuilder/listAllCourses';
			      $this->load->view('/scheduleBuilder_views/preference', $form);
		    } else {
            $id = 3;//temporary, this should be retrieve from session.
            $form_data = $this->input->post(); //array( time => , longWeekend, season => , year =>
            $courses = $this->course->get_all_courses();
            $courses = $this->scheduleBuilder_Model->filter_courses_by_season($courses, $form_data["season"]);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $form_data["time"], $form_data["longWeekend"], $form_data["season"]);
            $data['courseList'] = $courses;
            $data['season'] = $form_data["season"];
            $data['preference'] = $form_data;
            $this->load->view('/scheduleBuilder_views/listAllCourses.php', $data);
		    }
	  }


    public function listAllAllowedCourses() {
        if (!$this->session->userdata('logged_in')) {
            // if is not logged in, redirect user to the login page
            redirect('pasta', 'refresh');
        } else {
            $id = 3;//temporary, this should be retrieve from session.
            $form_data = $this->input->post(); 
            //array( time => , longWeekend, season => , year => )

            // compute season based on current time
            // before september, can only register for fall
            // after september, can only register for winter
            $form_data['season'] = (date('n') > '9' ? '4' : '2');
            $form_data['long_weekend'] = ($this->input->post('long_weekend') ? 1 : 0);
            $courses = $this->course->get_all_courses_allowed($id);

            //$courses = $this->get_course_detail($courses,$season);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_season($courses, $form_data["season"]);


            $courses = $this->scheduleBuilder_Model->
                filter_courses_by_preference(
                    $courses, 
                    $form_data["time"], 
                    $form_data["long_weekend"], 
                    $form_data['season']
                );
            $data['course_list'] = $courses;
            $data['season'] = $form_data["season"];
            $data['preference'] = $form_data;
            
            $this->put('register_courses', $data);
        }        
    }

    
    public function generate_schedule()
    {
     //TODO CLEAN UP, REDIRECT USER IF NO FORM
     $form_data = $this->input->post();
     $courses = array();
     foreach($form_data["course"] as $course_id):
        $the_course = $this->course->find_by_id($course_id);
        array_push($courses,$the_course);
     endforeach;
     $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $form_data["time"], $form_data["longWeekend"], $form_data["season"]);
     $possible_sequence = $this->scheduleBuilder_Model->generate_possibility($courses);
     $time_tables = $this->categorize_by_day($possible_sequence);
     $time_tables = $this->sort_courses_in_each_day($time_tables);
     $data["possible_sequence"] = $possible_sequence;
     $data["time_tables"] =  $time_tables;
     $this->load->view("/scheduleBuilder_views/generated_schedule.php", $data);
    }


    private function categorize_by_day($possible_sets_of_courses){
      $time_table = array("M" => array(), "T" => array(), "W"=> array(), "J"=> array(), "F" => array(), "S" => array(), "SU" => array());
      $complete_time_table = array();
      foreach($possible_sets_of_courses as $set){
        foreach($set as $course){
            $lecture_days = explode(",", $course["lecture"]["day"]);
            foreach($lecture_days as $day){
              array_push($time_table[$day], $course["lecture"]);
            }
            if( isset($course["tutorial"])){
              $tutorial_days = explode(",", $course["tutorial"]["day"]);
              foreach($tutorial_days as $day){
                array_push($time_table[$day], $course["tutorial"]);
              }
            }
            if( isset($course["lab"])){
              $lab_days = explode(",", $course["lab"]["day"]);
              foreach($lecture_days as $day){
                array_push($time_table[$day], $course["lab"]);
              }
            }
        }
        array_push($complete_time_table, $time_table);
        $time_table = $time_table = array("M" => array(), "T" => array(), "W"=> array(), "J"=> array(), "F" => array(), "S" => array(), "SU" => array());
      }
      return $complete_time_table;
    }

    private function sort_courses_in_each_day($time_table){
      $sorted_time_table = array();
      $completed_time_table = array();
      foreach($time_table as $table_set){
        foreach($table_set as $key=>$day){
          for($i=0; $i<count($day); $i++){
            for($k = $i+1; $k<count($day); $k++){
              if($day[$i]["start_time"] > $day[$k]["start_time"] ){
                $temp = $day[$i];
                $day[$i] = $day[$k];
                $day[$k] = $temp;
                $temp = null;
              }
            }
          }
          $sorted_time_table[$key] = $day;
        }
        array_push($completed_time_table, $sorted_time_table);
      }
      return $completed_time_table;
    }

    public function get_hour_min($time){
      //Note: should be moved to helper class
      $length = strlen($time);
      $third_last = $length -2;
      $min = substr($time, $third_last, $length);
      $hour= substr($time, 0, $third_last);
      return array($min,$hour);
    }

/*
SELECT * FROM  courses, lectures, time_locations, tutorials, labs
where lectures.course_id = courses.id 
and tutorials.lecture_id = lectures.id 
and labs.tutorial_id = tutorials.id 
and lectures.time_location_id = time_locations.id
and tutorials.time_location_id = time_locations.id
and labs.time_location_id = time_locations.id
and time_locations.start_time < 1500



    private function get_course_detail($courses,$season)
    {
      $course_detail = array();
      foreach($courses as $course):
        $id = (int)$course["id"];
        $the_course = $this->course->find_by_id($id);
        $the_course['lectures'] = $this->get_lectures($id,$season);
        array_push($course_detail,$the_course);
      endforeach;
      return $course_detail;
    }






*/
}


// End of ScheduleBuilder.php
