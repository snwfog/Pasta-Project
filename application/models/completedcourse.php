<?php

/**
 * PASTA
 *
 * Model for query / insert the database for course that an user has
 * already taken previously
 *
 * @package		PASTA
 * @author		Charles Yang
 */

class CompletedCourse extends CI_Model{
    
    function find_by_student_id($student_id) {
      	return $this->db->get_where('completed_courses', 
					array('student_id' => $student_id))->result_array();
    }

    function find_by_id($id) {
      	return $this->db->get_where('completed_courses', 
					array('id' => $id))->result_array();
    }

    function has_taken($student_id, $course_id) {
        return ($this->db->get_where('completed_courses', array(
                    'student_id' => $student_id,
                    'course_id' => $course_id))->num_rows() > 0);
    }

    /**
     * Get current session student total earned credits.
     * @return Student Credit
     */
    public function get_total_credit_earned($student_id) {
        $this->db->select('SUM(credit)');
        $this->db->from('courses');
        $this->db->join('completed_courses', 
            'completed_courses.course_id = courses.id');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get()->result_array();
        
        // if user has no previously completed course
        if ($query[0]['SUM(credit)'] == NULL) return 0;
        
        return $query[0]['SUM(credit)'];
    }

    /**
     * Insert in the `completed_courses` database by student_id
     * @param: 	$student_it - The student id.
     *			$course_id - course_id that
	 *						 this student has taken so far.
	 */
    function insert_by_student_id($student_id, $course_id) {
		// for every course id check if student_id / course_id 
		// combination already exist in the database
		$query_param = array('student_id'	=> $student_id, 
							 'course_id' 	=> $course_id);
        // if not exist
		if (!($this->db->get_where('completed_courses',
				$query_param)->num_rows() > 0))
			$this->db->insert('completed_courses', $query_param);
    }

    /**
     * Remove in the `completed_courses` a row information if the
     * user choose to remove it or has not taken that course
     * @param: 	$student_it - The student id.
     *			$course_id - An array of all the course_id that
	 *						 this student wants to remove.
	 */
    function delete_by_student_id($student_id, $course_id) {
    	$query_param = array('student_id'	=> $student_id, 
						  	 'course_id' 	=> $course_id);
    	// if this combination exists, removes it, else do nothing
    	if ($this->db->get_where('completed_courses', 
    			$query_param)->num_rows() > 0)
    		$this->db->delete('completed_courses', $query_param);
    }
}
?>