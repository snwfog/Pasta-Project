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
    function get_all_where_student_id_is($student_id) {
        return $this->db->get_where('schedules', 
                  array('student_id' => $student_id))->result_array();
    }

    function get_schedule_by_student_id($student_id) {
        return $this->db->get_where('schedules', 
                  array('student_id' => $student_id))->row_array();
    }

    function get_course_info_from_schedule_id($schedule_id) {
    	// join a few tables together to perform interesting query
    	$this->db->join('schedules', 
    					'scheduled_courses.schedule_id = schedules.id');
    	$this->db->join('courses',
    					'scheduled_courses.course_id = courses.id');
    	$this->db->where('schedule_id', $schedule_id);
    	return $this->db->get('scheduled_courses')->result_array();

    }

    function get_schedule_id($year, $semester, $student_id) {
    	return $this->db->get_where('schedules', array(
					'year' 	   => $year,
    				'season' => $semester,
    				'student_id' => $student_id))->row_array();
    }

    function drop_schedule_by_id($schedule_id) {
    	
    }
}

?>