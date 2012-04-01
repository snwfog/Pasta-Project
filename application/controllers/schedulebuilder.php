<?php

class ScheduleBuilder extends MY_Controller {

  	function __construct() {
  		  parent::__construct();
        $this->load->model('course');
        $this->load->model('scheduleBuilder_Model');
  	}

    public function index() {
        $this->listAllAllowedCourses();
    }

    public function listAllCourses() {
        $this->form_validation->set_rules("time", "Time", "required");

		    if($this->form_validation->run() == FALSE) {
            $form['url']='schedulebuilder/listAllCourses';
			      $this->load->view('/scheduleBuilder_views/preference', $form);
		    } else {
            $id = 3;//temporary, this should be retrieve from session.
            $form_data = $this->input->post(); //array( time => , longWeekend, season => , year =>
            $courses = $this->course->get_all_courses();
            //$courses = $this->get_course_detail($courses,$season);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_season($courses, $form_data["season"]);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $form_data["time"], $form_data["longWeekend"], $form_data["season"]);
            $data['courseList'] = $courses;
            $data['season'] = $form_data["season"];
            $data['preference'] = $form_data;
            $this->load->view('/scheduleBuilder_views/listAllCourses.php', $data);
		    }
	  }


    public function listAllAllowedCourses() {
        $this->form_validation->set_rules("time", "Time", "required");

		    if($this->form_validation->run() == FALSE) {
            $form['url']='schedulebuilder/listAllAllowedCourses';
			      $this->load->view('/scheduleBuilder_views/preference', $form);
		    } else {
            $id = 3;//temporary, this should be retrieve from session.
            $form_data = $this->input->post(); //array( time => , longWeekend, season => , year =>
            $courses = $this->course->get_all_courses_allowed($id);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_season($courses, $form_data["season"]);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $form_data["time"], $form_data["longWeekend"], $form_data["season"]);
            $data['courseList'] = $courses;
            $data['season'] = $form_data["season"];
            $data['preference'] = $form_data;
            $this->load->view('/scheduleBuilder_views/listAllCourses.php', $data);
		        //$this->put('register_courses', $data);
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
     $data["possible_sequence"] = $possible_sequence;
     $this->load->view("/scheduleBuilder_views/generated_schedule.php", $data);
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
