<?php

/**
 * PASTA
 *  
 * Functions to query the schedule database
 * 
 * @package		PASTA
 * @author		Charles Yang
 */

class Schedule extends CI_Model {
    function get_all($student_id) {
        return $this->db->get_where('schedules', 
                  array('student_id' => $student_id))->result_array();
    }
}

?>