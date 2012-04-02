<div id="content">

<?php   //TO DO, option to choose which schedule and save to database. 
        // EITHER DISPLAY by text all possible sets of courses and a link to display in a time table or
        // display all the time table with a button beside it to save this schedule

        //THIS should be moved to a helper class. helper class help views? maybe dono.
        function get_hour_min($time){
        //Note: should be moved to helper class
        $length = strlen($time);
        $third_last = $length -2;
        $min = substr($time, $third_last, $length);
        $hour= substr($time, 0, $third_last);
        return array("hour" => $hour, "min" =>$min);
      }
?>

  <?php foreach($time_tables as $time_table): ?>
         <?php  $data["time_table"] = $time_table;
                $this->load->view("/scheduleBuilder_views/time_table.php", $data); 
         ?>
         <br/>
         <br/>
  
  <?php endforeach?>


  <?php echo $this->benchmark->memory_usage();  ?>


      <!-- For testing purpose

       <?php
        foreach($possible_sequence as $sequence){
          echo "<hr/><br/>";
          foreach($sequence as $course){
            echo $course["id"]." ".$course["code"].$course["number"].
                 "<br/> ".$course["lecture"]["id"]." Lecture(".$course["lecture"]["section"].") ".$course["lecture"]["start_time"]."-".$course["lecture"]["end_time"].$course["lecture"]["day"]."<br/>";
            if(isset($course["tutorial"])){
              echo $course["tutorial"]["id"]."tutorial(".$course["tutorial"]["section"].") ".$course["tutorial"]["start_time"]."-".$course["tutorial"]["end_time"].$course["tutorial"]["day"]."<br/>";
            }
            if(isset($course["lab"])){
              echo "lab(".$course["lab"]["section"].")";
            }
            echo "<br/>";
          }
        echo "End of One Sequence <br/><br/>";
        echo "<hr/><br/>";
        }
      ?>
     --!>
</div>
