<?php

class ScheduleBuilder extends CI_Controller{


	public function listAllCourses()
	{
        $this->load->helper('form');
        $this->load->model('course', 'course_model');
        $data = array('courseList' => $this->course_model->get_all_courses());
        $this->load->view('listAllCourses.php', $data);
	}

    public function list_all_allowed_courses()
    {
      //1. Get student id from session, query the student record for completed courses or from global variable.
      //2. Retrieve all courses id with its pre-requisite.
      //3. Check each courses pre-requisites against student completed courses. If not met, remove course from array.
      //4. Function returns an array of courses that student meets the requirement.
    }


    
    public function generate_schedule(/*array of course id*/)
    {
     $course_data = $this->get_course_detail();
     //use $course_data to call another function that build an array of all possible course combination
     //load view to display combination of courses
    }


    private function get_course_detail(/*$courses*/)
    {
      $i=0;
      $this->load->model('course', 'course_model');
      $courses = array(2,4,5,8,9); //TEMPORARY: dummy entry of courses id.
      foreach($courses as $course):
        $course_detail[$i] = $this->course_model->find_by_id($course);
        $course_detail[$i]["lecture"]= $this->get_lecture($course);
        $i++;
      endforeach;
      print_r($course_detail);
    }

    private function get_lecture($course_id)
    {
      $this->load->model('lecture', 'lecture_model');
      return $lectures = $this->lecture_model->find_by_course_id($course_id);
      //foreach($lectures as $lecture):
          //$lecture["tutorials"] = $this->get_tutorials($lecture["id"]);
      //endforeach;
    }

    private function get_tutorial($lecture_id)
    {
    }



}

?>
