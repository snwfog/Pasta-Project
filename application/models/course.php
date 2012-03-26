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
        trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
      }
      $query = $this->db->get_where('courses', array('id' => $id));
      return $query->row_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

    function find_by_code($code)
    {
      if (FALSE === is_string($code)) {
        trigger_error('setString expected Argument 1 to be String', E_USER_WARNING);
      }
      $query = $this->db->get_where('courses', array('code' => $code));
      return $query->result_array(); //result_array() return multiple result in a pure array.
    }

    function find_by_code_number($code, $number)
    { 
      if (FALSE === is_string($code)) {
        trigger_error('setString expected Argument 1 to be String', E_USER_WARNING);
      }
      if (FALSE === is_int($number)) {
        trigger_error('setString expected Argument 2 to be Integer', E_USER_WARNING);
      }
      $query = $this->db->get_where('courses', array('code' => $code, 'number' => $number));
      return $query->row_array(); // used row_array() because there is no two record with same code and number.
    }
    

}
?>