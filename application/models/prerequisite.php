<?php
class Prerequisite extends CI_Model{
  
    function find_by_course_id($id)
    {
      $query = $this->db->select("required_course_id")->get_where('prerequisites', array('course_id' => $id));
      return $query->result_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

// Unfinished - Charles
	// /**
 //     * Insert information functions
 //     * 
 //     * @param 	$prerequisite
 //     *          The course prerequisite array.
 //     *          
 //     */
 //    function insert_time_location($prerequisite) {
 //        foreach ()

 //        // insert the value into the table
 //        $this->db->insert('time_locations', $time_location);
 //    }

}
?>