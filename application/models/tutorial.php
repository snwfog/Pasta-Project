<?php
class Tutorial extends CI_Model{
   
    function find_by_lecture_id($id){
        $query = $this->db->get_where('tutorials', array('lecture_id' => $id));
        // row_array returns a single result in a pure array. 
        // Better for generating single results.
        return $query->result_array();
    }


}
?>