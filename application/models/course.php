<?php
class Course extends CI_Model{
  //NOTE: ADD TITLE COLUMN FOR COURSE TABLE

    function get_all_courses()
    {
      $this->db->select("id, code, number, credit");
      $query = $this->db->get('course');
      return $query->result_array();

    }
}
?>