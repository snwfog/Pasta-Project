<?php

/**
 * PASTA
 *
 * Model for query / insert the database for courses that are
 * already scheduled for the user
 *
 * @package		PASTA
 * @author		Charles Yang
 */

class ScheduledCourse extends CI_Model
{
	function get_by_schedule_id($schedule_id)
	{
		$this->db->where('schedule_id', $schedule_id);
		$query = $this->db->get('scheduled_courses');
		return $query->result_array();
	}

	/**
	 * Return the total credit of all scheduled courses of a schedule
	 * @return total credit (int)
	 */
	function get_total_credit($schedule_id) 
	{
		$this->db->select("SUM(courses.credit)");
		$this->db->join('courses', 
						'scheduled_courses.course_id = courses.id',
						'left');
		$this->db->where('schedule_id', $schedule_id);
		$query = $this->db->get('scheduled_courses');
		$sum_credit = $query->row_array();
		return $sum_credit['SUM(courses.credit)'];
	}

	function delete_by_schedule_id($schedule_id) 
	{
		$this->db->where('schedule_id', $schedule_id);
		$this->db->delete('scheduled_courses');
	}
}
  

// END ScheduledCourse class

/* End of file scheduledcourse.php */
/* Location: application/model/scheduledcourse.php */
