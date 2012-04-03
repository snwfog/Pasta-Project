<?php
class ScheduleBuilder_Model extends CI_Model{
   function filter_courses_by_preference($courses,$time,$longWeekend, $season){
      $constraint ="< 2400";
      $fridayOff = null;

      if($time == "day"){
         $constraint ="< 1745";
      }elseif($time== "night"){
         $constraint ="> 1200";
      }
      if($longWeekend){
        $fridayOff = "and NOT FIND_IN_SET('F', day)";
      }

      $filtered_courses = array();
      foreach($courses as $key=>$course):
        $lectures = $this->db->query(
                                "SELECT lectures.id, section, professor, season, course_id, time_location_id, start_time, end_time, day
                                FROM  courses, lectures, time_locations
                                where courses.id =".$course["id"]."
                                and lectures.course_id = courses.id
                                and lectures.season=".$season." 
                                and lectures.time_location_id = time_locations.id
                                and time_locations.start_time".$constraint." ".$fridayOff
                              )->result_array();
        //if lecture is empty remove course from list.
        if(empty($lectures)){
          unset($courses[$key]);
        }else{
          $lectures = $this->check_tutorials($lectures,$constraint);
          if(empty($lectures)){
            unset($courses[$key]);
          }else{
            $course["lectures"]= $lectures;
            array_push($filtered_courses, $course);
          }
        }
      endforeach;
    return array_values($filtered_courses);

  }
  
  function check_tutorials($lectures,$constraint){
    $filtered_lectures = array();
    foreach($lectures as $key=>$lecture):
        // query all tutorials that belong to a specific lecture and if it meets the time constraint
        $tutorials = $this->db->query(
                                "SELECT tutorials.id, tutorials.section, lecture_id, tutorials.time_location_id, start_time, end_time, day
                                FROM  lectures, time_locations, tutorials
                                where lectures.id =".$lecture["id"]."
                                and tutorials.lecture_id = lectures.id
                                and tutorials.time_location_id = time_locations.id
                                and time_locations.start_time".$constraint
                              )->result_array();
        //Remove lecture if it has no tutorial that meet time constraint. Caution: Lecture may not have tutorial to begin with.
        // If have lectures that meet constraint, check the labs if it meet the constraints
        if(empty($tutorials)){
          $no_tutorial = $this->db->query("select * from tutorials
                                                where tutorials.lecture_id =".$lecture["id"])->result_array();
          //Checking if lecture even have any tutorial before removing lecture from list. If not, add to filtered array.
          if(!empty($no_tutorial)){
            unset($lectures[$key]);
          }else{
            array_push($filtered_lectures, $lecture);
          }
        }else{
          //If have tutorials and meet constraint, check labs time.
          $tutorials = $this->check_labs($tutorials,$constraint);
          if(empty($tutorials)){
            unset($lectures[$key]);
          }else{
            $lecture["tutorials"] = $tutorials;
            array_push($filtered_lectures, $lecture);
          }
        }
    endforeach;
    return $filtered_lectures;
  }


 function check_labs($tutorials,$constraint){
    $filtered_tutorials = array();
    foreach($tutorials as $key=>$tutorial):
        // query all labs that belong to a specific tutorial and meets the time constraint
        $labs = $this->db->query(
                                "SELECT labs.id, labs.section, tutorial_id, labs.time_location_id, start_time, end_time, day
                                FROM  time_locations, tutorials, labs
                                where tutorials.id =".$tutorial["id"]."
                                and labs.tutorial_id = tutorials.id
                                and labs.time_location_id = time_locations.id
                                and time_locations.start_time".$constraint
                              )->result_array();

        //Remove tutorial if it has no labs that meet time constraint. Caution: Tutorial may not have labs to begin with.
        if(empty($labs)){
          $no_labs = $this->db->query("select * from labs
                                                where labs.tutorial_id =".$tutorial["id"])->result_array();
          //Checking if course even have tutorial before removing.
          if(!empty($no_labs)){
            unset($tutorials[$key]);
          }else{
            array_push($filtered_tutorials, $tutorial);
          }
        }else{
          $tutorial["labs"] = $labs;
          array_push($filtered_tutorials, $tutorial);
        }
    endforeach;
    return $filtered_tutorials;
  }



    function branching($courses){
      //create all possible combination of course + lecture + tutorial(if have) + labs(if have) while respecting which course/lecture/tutorial they belong to.
      $course = array();
      foreach( $courses["lectures"] as $lecture){
        if(isset($lecture["tutorials"])){
            foreach($lecture["tutorials"] as $tutorial){
              if(isset($tutorial["labs"])){
                foreach($tutorial["labs"] as $lab){
                 unset($tutorial["labs"]);
                 $courses["lab"] = $lab;
                 unset($lecture["tutorials"]);
                 $courses["tutorial"] = $tutorial;
                 unset($courses["lectures"]);
                 $courses["lecture"] = $lecture;
                 array_push($course, $courses);
                }
              }else{
                 unset($lecture["tutorials"]);
                 $courses["tutorial"] = $tutorial;
                 unset($courses["lectures"]);
                 $courses["lecture"] = $lecture;
                 array_push($course, $courses);
              }
            }
        }else{
             unset($courses["lectures"]);
             $courses["lecture"] = $lecture;
             array_push($course, $courses);
        }
      }
    return $course;
    }

    function generate_possibility($courses){
       //This method is dependent on filter_courses_by_preference because that method structures the array of courses for this method.
       // The structure is  = array ( ..... lectures => array ( ...... tutorials =>  array( ....... labs => .....)))
       // where ....  is other keys => values
       // Preparing the data into a easier structure to work with for me
       // Method Constraints: This method doesn't put into account that it might compare to lecture/tutorials/labs that are from different season. -
       //                     In other words, for this method to work properly, the lectures should be from the same season.
       $branched_course = array();

       for($i=0; $i<count($courses); $i++){
         $branched_course[$i] = $this->scheduleBuilder_Model->branching($courses[$i]);
       };

       //First step compare two course to set up the sets of course array
       $possible_sequence = array();
       if(isset($branched_course[1])){
         foreach($branched_course[0] as $course_1){
           foreach($branched_course[1] as $course_2){
             $conflict = false;
             $conflict=$this->compare_time($course_1, $course_2);
             if(!$conflict){
                array_push($possible_sequence, array($course_1,$course_2));
             }
           }
         }
       }else{
         foreach($branched_course[0] as $course){
            array_push($possible_sequence, array( 0 => $course));
         }
       }
       /*Each set of courses in $possible_sequence is compared against each the branch of a course in $branched_courses array.
       $branched_courses: each index of this array contain an array of all possible combination of a lecture, tutorials and labs for a Course
       $possible_sequence: is an array of sets of courses that doesn't conflict.*/
       $final_possibilities = array();
       if(isset($branched_course[2])){
         for($i=2; $i<count($branched_course); $i++){
           foreach($branched_course[$i] as $new_course){
             foreach($possible_sequence as $key=>$sequence){
               foreach($sequence as $base_course){
                  $conflict = $this->compare_time($base_course, $new_course);
                  //If new course conflict with any of the courses in the set. Remove the set and exit loop.
                  if($conflict){
                      unset($possible_sequence[$key]);
                      break;
                  }
               }
               //If new course does not conflict with any course in the set. A new set is created consisting of the old set + new course
               if(!$conflict){
                  array_push($sequence, $new_course);
                  array_push($final_possibilities, $sequence); // store the new set of courses that doesn't conflict.
               }
             }
           }
           //After checking the new course against each set of course. If final possibility array contain sets of courses
           // then old sets of courses in possible_sequence is replaced by new set of courses in final_possibilities.
           // final_posssibilities is emptied for next iteration of a new course.
           if(!empty($final_possibilities)){
                $possible_sequence = $final_possibilities;
                $final_possibilities = array();
           }
         }
       }

       return $possible_sequence;
     }

    function compare_time($course_A, $course_B){
      //Return true if there is a conflict else it return false.
      $A = array();
      $A["lecture"] = $course_A["lecture"];
      if(isset($course_A["tutorial"])){
        $A["tutorial"] = $course_A["tutorial"];
      }
      if(isset($course_A["lab"])){
        $A["lab"] = $course_A["lab"];
      }

      $B = array();
      $B["lecture"] = $course_B["lecture"];
      if(isset($course_B["tutorial"])){
        $B["tutorial"] = $course_B["tutorial"];
      }
      if(isset($course_B["lab"])){
        $B["lab"] = $course_B["lab"];
      }

      foreach($A as $a){
        foreach($B as $b){
          $a_days = explode(",",$a["day"]);
          $b_days = explode(",",$b["day"]);
          $same_days = array_intersect($a_days,$b_days);
          if(!empty($same_days)){
            if ($b["start_time"] > $a["start_time"]
                && $b["start_time"] < $a["end_time"]){
                return true;
            }elseif($b["start_time"] < $a["start_time"]
                    && $b["end_time"] > $a["start_time"]){
                return true;
            }elseif($b["start_time"] == $a["start_time"]){
                return true;
            }
          }
        }
      }
      return false;
    }

    function filter_courses_by_season($courses, $season){
      foreach($courses as $key=>$course):
        $lecture = $this->db->query("  SELECT * FROM `courses`
                                       JOIN lectures
                                       where courses.id = ".$course["id"]."
                                       and lectures.course_id = courses.id
                                       and lectures.season = ".$season);
        if(empty($lecture)){
            unset($courses[$key]);
        }
      endforeach;

      return array_values($courses);
    }

}
?>