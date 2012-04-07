<?php

/**
 * PASTA
 *  
 * Model for query / insert the user login database.
 * THERE ARE CONFLICTS WHEN CONTROLLER NAME IS SAME AS MODEL NAME!!!
 * Code Igniter CANNOT make a difference between them.
 * Potential solution is listed here:
 * " http://stackoverflow.com/questions/9848263/codeigniter-controller-
 * and-model-with-same-name-collison "
 * But for now we are just not going to name them the same, or use an 
 * underscore prefix to ALL model, if needed.
 * 
 * @package		PASTA
 * @author		Charles Yang
 */

class User extends CI_Model {
    function find_by_student_id($student_id) 
    {
      	$this->db->select('id, student_id, first_name, last_name');
        // return unique student
        return $this->db->get_where('logins', 
                    array('student_id' => $student_id))->row_array(); // unique
    }

    function find_by_id($id) 
    {
      	$this->db->select('student_id, first_name, last_name');
        return $this->db->get_where('logins', 
                    array('id' => $id))->row_array(); // unique
    }

    function find_by_login_info($student_id, $salt) 
    {
        $this->db->select('student_id, first_name, last_name');
        return $this->db->get_where('logins', array(
           'student_id' => $student_id,
           'password'   => $salt))->row_array(); // unique
    }

  //   /**
  //    * Insert in the `completed_courses` database by student_id
  //    * @param: 	$student_it - The student id.
  //    *			$course_id - An array of all the course_id that
	 // *						 this student has taken so far.
	 // */
  //   function insert_by_student_id($student_id, $course_id_array) {
		// // for every course id check if student_id / course_id 
		// // combination already exist in the database
		// foreach ($course_id_array as $course_id) {
		// 	$query_param = array('student_id'	=> $student_id, 
		// 						 'course_id' 	=> $course_id);
		// 	// if not exist
		// 	if (!($this->db->get_where('completed_courses',
		// 			$query_param)->num_rows() > 0))
		// 		$this->db->insert('completed_courses', $query_params);
		// }
  //   }

  //   /**
  //    * Remove in the `completed_courses` a row information if the
  //    * user choose to remove it or has not taken that course
  //    * @param: 	$student_it - The student id.
  //    *			$course_id - An array of all the course_id that
	 // *						 this student wants to remove.
	 // */
  //   function delete_by_student_id($student_id, $course_id) {
  //   	$query_param = array('student_id'	=> $student_id, 
		// 				  	 'course_id' 	=> $course_id);
  //   	// if this combination exists, removes it, else do nothing
  //   	if ($this->db->get_where('completed_courses', 
  //   			$query_param)->num_rows() > 0)
  //   		$this->db->delete('completed_courses', $query_param);
  //   }
}

?>