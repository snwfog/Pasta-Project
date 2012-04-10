<?php

/*
   Query, insertion and deletion of record related to Lab table
  Authors: Duc Hoang Michel Pham
*/
class Lab extends CI_Model{
   
    function find_by_tutorial_id($id){
        $query = $this->db->get_where('labs', array('tutorial_id' => $id));
        // row_array returns a single result in a pure array. 
        // Better for generating single results.
        return $query->result_array();
    }


}
?>