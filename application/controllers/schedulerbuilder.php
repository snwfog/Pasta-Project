<?php

class SchedulerBuilder extends CI_Controller{


	public function listAllCourses()
	{
        $this->load->helper('form');
        $this->load->model('course','course_model');
        $data = array('courseList' => $this->course_model->get_all_courses());
        $this->load->view('listAllCourses.php', $data);
	}

}

?>
