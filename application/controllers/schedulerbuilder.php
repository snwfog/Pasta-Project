<?php

class SchedulerBuilder extends CI_Controller{


	public function listAllCourses()
	{
        $this->load->helper('form');
        // course_list is used for now to display all course seletion for user. This will be replaces with actual returned record from course table.
        $this->config->load('pasta_constants/course_list');
        $data = array( 'courseList' => $this->config->item('COURSE_LIST') );
        $this->load->view('listAllCourses.php', $data);
	}

}

?>
