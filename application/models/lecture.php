<?php
class Lecture extends CI_Model{


    function find_by_id($id)
    {
      if (FALSE === is_int($id)) { // only allow id of type integer
        trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
      }
      $query = $this->db->get_where('lecture', array('id' => $id));
      return $query->row_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

    function find_by_course_id($id)
    {
      if (FALSE === is_int($id)) { // only allow id of type integer
        trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
      }
      $query = $this->db->get_where('lecture', array('course_id' => $id));
      return $query->row_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

    function find_by_teacher($name)
    {
      if (FALSE === is_string($name)) { // only allow id of type integer
        trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
      }
      $this->db->from("lecture");
      $this->db->like('professor',$name);
      $query = $this->db->get();
      return $query->result_array();; //row_array returns a single result in a pure array. Better for generating single results.
    }

}
?>