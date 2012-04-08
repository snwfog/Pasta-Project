<?php
/*
Author: Duc Hoang Michel Pham
*/
class ScheduleBuilder extends MY_Controller {
    //DATABASE PROBLEMS
    /* Duplicated courses causes alot of prerequisite and associated lecture problems.
    */
  	function __construct() {
  		  parent::__construct();
        $this->load->model('course');
        $this->load->model('scheduleBuilder_Model');
        if (!$this->session->userdata('logged_in')) {
            // if is not logged in, redirect user to the login page
            redirect('pasta', 'refresh');
        }
  	}

    public function index() {
            $data['title'] = "P.A.S.T.A. - Course Registration";
            // load the preference pane by default
            $this->put('course_registration_preference_view', $data);
            //$this->listAllAllowedCourses();
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
            $courses = $this->scheduleBuilder_Model->filter_courses_by_preference($courses, $form_data["time"], $form_data["long_weekend"], $form_data["season"]);
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
            $id = $this->session->userdata['student_id'];
            $form_data = $this->input->post();
            //array( time => , longWeekend, season => , year => )

            $form_data['time'] = $this->input->post('time');
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
            $courses = $this->scheduleBuilder_Model->sort_courses_by_type($courses);
            $data['course_list'] = $courses;
            $data['season'] = $form_data["season"];
            $data['preference'] = $form_data;

            $data['title'] = "P.A.S.T.A. - Course Registration";

            $this->put('course_registration_selection_view', $data);
        }        
    }

    
    public function generate_schedule()
    {
     //TODO CLEAN UP, REDIRECT USER IF NO FORM
     $form_data = $this->input->post();
     $courses = array();
     foreach($form_data["registered_courses"] as $course_id):
        $the_course = $this->course->find_by_id($course_id);
        array_push($courses,$the_course);
     endforeach;
     $courses = $this->scheduleBuilder_Model->filter_courses_by_preference(
                                                                           $courses,$form_data["time"], 
                                                                           $form_data["long_weekend"],
                                                                           $form_data["season"]
                                                                          );
     $possible_sequence = $this->scheduleBuilder_Model->generate_possibility($courses);
     $data = array( "possible_sequence" => $possible_sequence,
                    "season"             => $form_data["season"]);

     $this->put("/scheduleBuilder_views/generated_schedule.php", $data);
    }
    
    public function save_schedule(){
      $this->load->model("schedule");
      $student_id = $this->session->userdata['student_id'];
      $schedule = $this->input->post("courses");
      $season = $this->input->post("season");
      $year = date("Y");

      if($season == 2){
        $year = (date('n') > '9' ? $year+1 : $year);
      }
      $this->schedule->new_and_update_schedule($schedule, $student_id, $season, $year);
      redirect('profile');
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
