<?php
class Course extends CI_Model{
  //NOTE: ADD TITLE COLUMN FOR COURSE TABLE

    function get_all_courses()
    {
      $this->db->select("id, code, number, credit");
      $query = $this->db->get('courses');
      return $query->result_array();

    }

    function find_by_id($id)
    {
      if (FALSE === is_int($id)) { // only allow id of type integer
        trigger_error('setInteger expected Argument 1 to be Integer', 
          E_USER_WARNING);
      }
      $query = $this->db->get_where('courses', array('id' => $id));
      
      // row_array returns a single result in a pure array. 
      // Better for generating single results.
      return $query->row_array(); 
    }

    function find_by_code($code)
    {
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

}
?>