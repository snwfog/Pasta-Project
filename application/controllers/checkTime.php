<?php

	//$timeSlots is an array of all the individual time slots in the schedule regardless if its a tutorial or lecture or lab. It is a 3 part array in 2 dimensions. 
	//$timeSlots[0] -> [0] = Tuesday
	//				-> [1] = 0845
	//				-> [2] = 1000
	//$timeSlots[1] -> [0] = Thursday
	//				-> [1] = 0845
	//				-> [2] = 1000
	//The course being added is again a 3 part array in two dimensions (because there may be more than 1 time slot for the course you are adding lecture + lab + tutorial) seperating all it's time slots.
	//$course2[0] -> [0] = Wednesday
	//			  -> [1] = 1745
	//			  -> [2] = 2030
	//$course2[1] -> [0] = Friday
	//			  -> [1] = 1000
	//			  -> [2] = 1200
	
	
	// 0 -> Day, 1 -> Start Time, 2 -> End Time

	function checkTime($timeSlots, $course2) //Takes two two-dimensional arrays, first passed is the courses currently registered, the second is the course being added.
	{
		//Variables. 
		$count = 0; //Outer counter
		$conf = false; //Boolean to be returned for conflict
		
		while($count < sizeof($timeSlots)) //Outer loop traversing $timeSlots array.
		{
			if($conf === true) //if theres a conflict, return now.
				return $conf;
				
			$count2 = 0; //Nested counter
				
			while($count2 < sizeof($course2)) //Inner loop traversing $course2 array
			{
				if($conf === true) //if theres a conflict, return now.
					return $conf;
					
				if($timeSlots[$count][0] === $course2[$count2][0]) //Day is the same
				{
					//If end time AND start time of $course2 are later(bigger) than end time of $timeslots  .. OR .. start time AND end time of $course2 are earlier(smaller) than start time of $timeslots, we're good.
					if(($course2[$count2][1] > $timeSlots[$count][2] && $course2[$count2][2] > $timeSlots[$count][2] ) || ($course2[$count2][1] < $timeSlots[$count][1] && $course2[$count2][2] < $timeSlots[$count][1]))
						$conf = false;//No Conflict.
					else
						$conf = true; //Conflict
				}
				else
				{
					$conf = false; //No Conflict (Different days)
				}
				
				$count2 = $count2 + 1; //Increment nested counter
			}
			
			$count = $count + 1;//Increment outer counter
		}	
		
		return $conf; //Return boolean result of conflict.
	}//End Function.
	
		//TESTING
			//Courses and time slots already registered for.
		//$ab[0][0] = "T";
		//$ab[0][1] = 1000;
		//$ab[0][2] = 1200;
		//$ab[1][0] = "J";
		//$ab[1][1] = 1000;
		//$ab[1][2] = 1200;
		//$ab[2][0] = "M";
		//$ab[2][1] = 1315;
		//$ab[2][2] = 1430;
		
			//Time slots of course to be added
		//$cb[0][0] = "M";
		//$cb[0][1] = 1000;
		//$cb[0][2] = 1200;
		//$cb[1][0] = "J";
		//$cb[1][1] = 1315;
		//$cb[1][2] = 1430;
		//$conflict = checkTime($ab, $cb); //Will return 1 if there is a conflict, nothing (0) if there is no conflict.
		
?>