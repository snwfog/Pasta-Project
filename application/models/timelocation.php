<?php
class TimeLocation extends CI_Model{
	/**
     * Insert information functions
     * 
     * @param 	$course_slot	
     *		  	a course "slot" (a tutorial or a course) in form of array
     *		  	that might contain potential time location information
     * 
     */
    function insert_time_location($course_slot) {
        // initialize course variables
        $time_location = array(
			'start_time' 	=> NULL,
			'end_time'		=> NULL,
			'campus'		=> NULL,	
        	'room'			=> NULL,
        	'day'			=> NULL,
        );		

        // Format the time from "12:13" to "1223" to keep consistency in the current database
        if (array_key_exists('time', $course_slot)) {
            $time_location['start_time'] = implode(explode(':', $course_slot['time']['0']));
            $time_location['end_time'] = implode(explode(':', $course_slot['time']['1']));
        }

        if (array_key_exists('campus', $course_slot)) {
            $time_location['campus'] = $course_slot['campus'];
        }

        if (array_key_exists('room', $course_slot)) {
            $time_location['room'] = $course_slot['room'];
        }

        // Format the day array into "F,M" ready to insert into database
        if (array_key_exists('day', $course_slot)) {
            $time_location['day'] = implode(',', $course_slot['day']);
        }

        // insert the value into the table
        $this->db->insert('time_locations', $time_location);
    }

}
?>