<?php

class CourseInfo extends CI_Controller {

	public function index()
	{
        $this->load->helper('url');
        $this->config->load('pasta_constants/course_list');
        
        $data = array( 'courseList' => $this->config->item('COURSE_LIST') ); // In case we add more parameters to the view.
        $this->load->view( '/list_courses.php', $data );
	}
}


/* End of file test.php */
/* Location: ./application/controllers/test.php */