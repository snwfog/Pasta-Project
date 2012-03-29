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


    public function listAllAllowedCourses($season = null)
    {
		if ($season == null) {
			$this->load->view('/scheduleBuilder_views/season');
		} else {
            $id = 3;//temporary, retrieve from session.
            $courses = $this->course->get_all_courses_allowed($id);
            $courses = $this->filter_courses_by_season($courses, $season);
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
        settype($course, 'integer');
        $the_course = $this->course->find_by_id($course);
        $the_course['lectures'] = $this->get_lecture($course,$season);
        array_push($course_detail,$the_course);
      endforeach;
      print_r($course_detail);
    }

    private function get_lecture($course_id,$season)
    {
      $this->load->model('lecture', 'lecture_model');
      return $lectures = $this->lecture_model->find_by_course_season($course_id, $season);
      //foreach($lectures as $lecture):
          //$lecture["tutorials"] = $this->get_tutorials($lecture["id"]);
      //endforeach;
    }

    private function get_tutorial($lecture_id)
    {
    }

    private function filter_courses_by_season($courses, $season)
    {
      foreach($courses as $key=>$course):
        $this->load->model('lecture', 'lecture_model');
        $lecture = $this->get_lecture($course['id'],$season);
        if(empty($lecture)){
            unset($courses[$key]);
        }
      endforeach;

      return array_values($courses);
    }



}


// End of ScheduleBuilder.php
