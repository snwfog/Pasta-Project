<?php
class CompletedCourse extends CI_Model{
  //NOTE: ADD TITLE COLUMN FOR COURSE TABLE


    function find_by_student_id($id)
    {
      if (FALSE === is_int($id)) { // only allow id of type integer
        trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
      }
      $query = $this->db->select("course_id")->from('completed_courses')->where('student_id', $id)->get();
      return $query->result_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

}
?>