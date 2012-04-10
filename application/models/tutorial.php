<?php
/*
   Query, insertion and deletion of record related to tutorial table
  Authors: Duc Hoang Michel Pham
*/
class Tutorial extends CI_Model{

  	/**
  	 * Return the tutorial information given the tutorial id
  	 * using SQL `JOIN` command.
  	 * @param   $schedule_it - The tutorial id
  	 */
    public function get_tutorial_info_by_id($tutorial_id)
    {
    	$this->db->select('section, start_time, end_time, 
    					   campus,  room,      	day');
    	
    	$this->db->join('time_locations',
    					'tutorials.time_location_id = time_locations.id', 
    					'left');
    	
    	$this->db->where('tutorials.id', $tutorial_id);

    	$query = $this->db->get('tutorials');
    	return $query->row_array();
    }




}
?>