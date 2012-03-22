<?

	//$timeSlots is an array of all the individual time slots in the schedule regardless if its a tutorial or lecture or lab. It is a 3 part array in 2 dimensions. 
	//$timeSlots[0] -> [0] = Tuesday
	//				-> [1] = 0845
	//				-> [2] = 1000
	//$timeSlots[1] -> [0] = Thursday
	//				-> [1] = 0845
	//				-> [2] = 1000
	//The course being added is again a 3 part array in two dimensions seperating all it's time slots.
	//$course2[0] -> [0] = Wednesday
	//			  -> [1] = 1745
	//			  -> [2] = 2030
	
	// 0 -> Day, 1 -> Start Time, 2 -> End Time
	public function checkTime($timeSlots, $course2)
	{
		$conflict = false;
		$count = 0; 
		while($count <= sizeof($timeSlots)) 
		{
			if($timeSlots[$count[0]] === $course2[0])
			{
				if($course2[1] > $timeSlots[$count[2]] && $course2[2] < $timeSlots[$count[1]])
					$conflict = false;
				else
					$conflict = true;
			}
			else
				$conflict = false;
			$count = $count + 1;
		}	
		
?>