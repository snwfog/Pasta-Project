<?php

class ScheduleBuilder extends MY_Controller{

	function __construct() {
		parent::__construct();
        $this->load->model('course');
		$this->load->helper(array('form', 'url'));
	}

    public function index(){
    $this->listAllAllowedCourses();
    }

	public function listAllCourses($season)
	{
        $courses = $this->course->get_all_courses();
        $courses = $this->filter_courses_by_season($courses, $season);
        $data = array(
                        'courseList' => $this->course->get_all_courses(), 
                        'season' => $season
                        );
        $this->load->view('/scheduleBuilder_views/listAllCourses.php', $data);
	}


    public function listAllAllowedCourses()
    {
        $this->load->model('scheduleBuilder_Model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules("season", "Season", "required");

		if($this->form_validation->run() == FALSE){
			$this->load->view('/scheduleBuilder_views/season');
		} else {
            $id = 3;//temporary, retrieve from session.
            $season = $this->input->post("season");
            $time = $this->input->post("time");
            $longWeekend = $this->input->post("longweekend");
            $courses = $this->course->get_all_courses_allowed($id);
            //$courses = $this->get_course_detail($courses,$season);
            $courses = $this->filter_courses_by_season($courses, $season);
            $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $time, $longWeekend);
            $data['courseList'] = $courses;
            $data['season'] = $season;
            $this->load->view('/scheduleBuilder_views/listAllCourses.php', $data);
		}
    }

    
    public function generate_schedule($season)
    {
     $courses = $this->input->post("course");
     $course_data = $this->get_course_detail($courses,$season);
     //use $course_data to call another function that build an array of all possible course combination
     //load view to display combination of courses
    }


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

    private function get_lectures($course_id,$season)
    { 
      $lecture_detail = array();
      $this->load->model('lecture', 'lecture_model');
      $lectures = $this->lecture_model->find_by_course_season($course_id, $season);
      foreach($lectures as $lecture):
          $lecture["tutorials"] = $this->get_tutorials($lecture["id"]);
          array_push($lecture_detail, $lecture);
      endforeach;
      return $lecture_detail;
    }

    private function get_tutorials($lecture_id)
    {
      $tutorial_detail = array();
      $this->load->model('tutorial', 'tutorial_model');
      $tutorials = $this->tutorial_model->find_by_lecture_id($lecture_id);
      foreach($tutorials as $tutorial):
          $tutorial["labs"] = $this->get_labs($tutorial["id"]);
          array_push($tutorial_detail, $tutorial);
      endforeach;
      return $tutorial_detail;
    }
    
    private function get_labs($tutorial_id){
      $this->load->model('lab', 'lab_model');
      $labs = $this->lab_model->find_by_tutorial_id($tutorial_id);
      return $labs;
    }

    private function filter_courses_by_season($courses, $season)
    {
      foreach($courses as $key=>$course):
        $this->load->model('lecture', 'lecture_model');
        $lecture = $this->get_lectures($course['id'],$season);
        if(empty($lecture)){
            unset($courses[$key]);
        }
      endforeach;

      return array_values($courses);
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
*/
}


// End of ScheduleBuilder.php
