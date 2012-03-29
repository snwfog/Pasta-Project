<?php
class Course extends CI_Model{
  //NOTE: ADD TITLE COLUMN FOR COURSE TABLE

    function get_all_courses() {
        $this->db->select("id, code, number, credit, 'title");
        $query = $this->db->get('courses');
        return $query->result_array();

    }

    function find_by_id($id) {
        $query = $this->db->get_where('courses', array('id' => $id));
        // row_array returns a single result in a pure array. 
        // Better for generating single results.
        return $query->row_array(); 
    }

    function find_by_code($code) {
      if (FALSE === is_string($code)) {
        trigger_error('setString expected Argument 1 to be String', 
          E_USER_WARNING);
      }
      $query = $this->db->get_where('courses', array('code' => $code));

      // result_array() return multiple result in a pure array.
      return $query->result_array(); 
    }

    function find_by_code_number($code, $number) { 
      $query = $this->db->get_where('courses', 
        array('code' => $code, 'number' => $number));

      // use row_array() because there 
      // is no two record with same code and number.
      return $query->row_array(); 
    }

    // Overload find_by_code_number function taking course code 
    // and number as an array
    function find_by_code_number_array($course) {
      
      // If $course array has "code" and "number" key, search for that
      // Else assume "0" is code and "1" is number.
      if (array_key_exists('code', $course) &&
          array_key_exists('number', $course))
          return $this->find_by_code_number($course['code'], $course['number']);
      else
          return $this->find_by_code_number($course['0'], $course['1']);
    }

    /**
     *
     * @param: course - Course information as array 'code' and 'number'
     * @return: course_id
     */
    function get_course_id($course) {
        $result = $this->find_by_code_number_array($course);
        return (isset($result['id']) ? $result['id'] : FALSE);
    }

    /*------------------------------------------------------*/
    /* Insert course information functions
    /*------------------------------------------------------*/
    function insert_course($course) {
        // Deprecated - They are defaulted in MySQL as NULL -- Charles
        // // initialize course variables
        // $course_variables = array(
        //     'code'    => NULL,
        //     'number'  => NULL,
        //     'title'   => NULL,
        //     'credit'  => NULL
        // );

        // since the course is assumed to be fed as an array, we check if particular
        // array key exists, if not, the value remains null
        foreach ($course as $variable => $value)
            if (array_key_exists($variable, $course)) 
                $course_variables[$variable] = $course[$variable];

        // insert the value into the table
        $this->db->insert('courses', $course_variables);
    }

    function get_all_courses_allowed($student_id)
    {
      $this->load->model("prerequisite","prerequisite_model");
      $this->load->model('CompletedCourse', 'completed_courses');
      $courses = $this->db->get('courses')->result_array();
      $completedCourses = $this->completed_courses->find_by_student_id($student_id);
      $completedCourses = $this->map_course_id($completedCourses);
      foreach($courses as $key=>$course){
        //Retrieve prerequisite for each course
        $prerequisites = $this->prerequisite_model->find_by_course_id((int)$course["id"]);
        foreach($prerequisites as $prerequisite){
            //Loops through the array of prequisites for each course
            if(isset($prerequisite["required_course_id"])){
             //Check against student completed courses. If course does not exist in completedCourses, remove course from courses array.
                if(!in_array($prerequisite["required_course_id"],$completedCourses)){
                  unset($courses[$key]);
                }
            }
        }
      }
      $courses = array_values($courses);// reindex them
      return $courses;

    }

    private function map_course_id($array){
      function return_course_id($record){ // Function within a Function: A hack for array_map callback problem with  models
        return $record["course_id"];
      }
      return $courseCompleted = array_map("return_course_id", $array);
    }


}
?>