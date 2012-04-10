<?php
/*
   Query, insertion and deletion of record related to lecture table
  Authors:  Eric Rideough
            Duc Hoang Michel Pham
            Charles Yang
*/
class Lecture extends CI_Model{

    /**
     * Get selected lecture information from a lecture id.
     * @param   $lecture_id - The lecture ID.
     */
    function get_lecture_info_by_id($lecture_id)
    {
        $this->db->select('lectures.id, section, professor, start_time,
                           end_time,    campus,  room,      day');
        $this->db->join('time_locations',
                        'lectures.time_location_id = time_locations.id',
                        'left');
        $this->db->where('lectures.id', $lecture_id);
        $query = $this->db->get('lectures');
        return $query->row_array();
    }

    function find_by_id($id) {
        if (FALSE === is_int($id)) { // only allow id of type integer
            trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
        }
        $query = $this->db->get_where('lectures', array('id' => $id));
        return $query->row_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

    function find_by_course_id($id) {
        if (FALSE === is_int($id)) { // only allow id of type integer
            trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
        }
        $query = $this->db->get_where('lectures', array('course_id' => $id));
        return $query->result_array(); //row_array returns a single result in a pure array. Better for generating single results.
    }

    function find_by_teacher($name) {
        if (FALSE === is_string($name)) { // only allow id of type integer
            trigger_error('setInteger expected Argument 1 to be Integer', E_USER_WARNING);
        }
        $this->db->from("lectures");
        $this->db->like('professor',$name);
        $query = $this->db->get();
        
        // row_array returns a single result in a pure array. 
        // Better for generating single results.
        return $query->result_array(); 
    }

    function find_by_course_season($course_id,$season){
        $query = $this->db->get_where('lectures', array('course_id' => $course_id, 'season' => $season));
        return $query->result_array();
    }
}
?>