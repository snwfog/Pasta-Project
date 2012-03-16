<?php
class Course_model extends CI_Model{
  //NOTE: ADD TITLE COLUMN FOR COURSE TABLE

    function get_all_courses()
    {
      $query = $this->db->get('course');
      foreach ($query->result() as $row)
      {
        echo $row->code;
      }

    }
}
?>