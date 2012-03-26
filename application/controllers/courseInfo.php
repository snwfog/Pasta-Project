<?php

/**
  * 
  *
  */

class CourseInfo extends CI_Controller {

  /**
	 * 
	 * 
	 */
	 
	public function index()
	{
        $this->load->helper('url');
        $this->config->load('pasta_constants/course_list');
        
        $data = array( 'courseList' => $this->config->item('COURSE_LIST') ); // In case we add more parameters to the view.
        $this->load->view( '/list_courses', $data );
	}
    
    public function details( $course_code, $course_number ) {
        $this->load->library('scraper');
    
        $return = $this->scraper->data_collection($course_code,$course_number,4);
        $data['course_lecture'] = $return[0];
        $data['row'] = $return[1];
        $data = array_merge( $data, $return[2] );
        //$courseData = $return[2];
          
        $this->load->helper('url');
        $this->load->view('/course_details', $data);
        //$this->load->view('/course_details', $courseData);
    }
}


/* End of file test.php */
/* Location: ./application/controllers/test.php */