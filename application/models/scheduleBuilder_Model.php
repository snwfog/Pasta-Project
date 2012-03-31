<?php
class ScheduleBuilder_Model extends CI_Model{
   function filter_courses_by_preference($courses,$time,$longWeekend){
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
                                "SELECT lectures.id, section, professor, season, course_id, time_location_id
                                FROM  courses, lectures, time_locations
                                where courses.id =".$course["id"]."
                                and lectures.course_id = courses.id
                                and lectures.time_location_id = time_locations.id
                                and time_locations.start_time".$constraint." ".$fridayOff
                              )->result_array();
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
        // query all tutorials that belong to a specific lecture and meets the time constraint
        $tutorials = $this->db->query(
                                "SELECT tutorials.id, tutorials.section, lecture_id, tutorials.time_location_id 
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
          //Checking if course even have tutorial before removing. If not, add to filtered array.
          if(!empty($no_tutorial)){
            unset($lectures[$key]);
          }else{
            array_push($filtered_lectures, $lecture);
          }
        }else{
          $tutorials = $this->check_labs($tutorials,$constraint);
          if(empty($tutorials)){
            unset($lectures[$key]);
          }else{
            $lecture["tutorials"] = $tutorials;
            array_push($filtered_lectures, $lecture);
          }
        }

        //If there is no tutorial

    endforeach;
    return $filtered_lectures;
  }


 function check_labs($tutorials,$constraint){
    $filtered_tutorials = array();
    foreach($tutorials as $key=>$tutorial):
        // query all labs that belong to a specific tutorial and meets the time constraint
        $labs = $this->db->query(
                                "SELECT labs.id, labs.section, tutorial_id, labs.time_location_id
                                FROM  time_locations, tutorials, labs
                                where tutorials.id =".$tutorial["id"]."
                                and labs.tutorial_id = tutorials.id
                                and labs.time_location_id = time_locations.id
                                and time_locations.start_time".$constraint
                              )->result_array();

        //Remove tutorials if it has no labs that meet time constraint. Caution: Tutorial may not have labs to begin with.
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

}
?>