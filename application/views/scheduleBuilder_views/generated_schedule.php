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
  <div id="schedule">
  <?php
    if(empty($possible_sequence)){
      echo "I'm very sorry, SO SORRY, There isn't any combination possible for those chosen courses";
    }
  ?>

  <?php foreach($possible_sequence as $a_set): ?>
      <?php echo form_open("scheduleBuilder/save_schedule"); ?>
        <div id="schedule_table">
            <table id="schedule_table">
                <tr>
                    <th>Course</th>
                    <th>Lecture </th>
                    <th>Tutorial </th>
                    <th>Lab </th>
                </tr>
                <?php foreach($a_set as $course): ?>
                    <tr>
                		<td><?php   echo (isset($course['code']) ? $course['code'] : "Unknown");
                                    echo (isset($course['number']) ? " ".$course['number'] : "Unknown");
                              ?>
                        </td>
    
                		<td><?php echo (isset($course['lecture']) ? "Section: ".$course['lecture']['section']."<br/>".
                                                                    $course['lecture']['day']."<br/>".
                                                                    $course['lecture']['start_time']."-".
                                                                    $course['lecture']['end_time'] 
                                                                    : "-")?>
                        </td>
    
                		<td><?php echo (isset($course['tutorial'])? "Section: ".$course['tutorial']['section']."<br/>".
                                                                    $course['tutorial']['day']."<br/>".
                                                                    $course['tutorial']['start_time']."-".
                                                                    $course['tutorial']['end_time'] 
                                                                    : "-")?>
                        </td>
    
                		<td><?php echo (isset($course['lab'])     ? "Section: ".$course['lab']['section']."<br/>".
                                                                    $course['lab']['day']."<br/>".
                                                                    $course['lab']['start_time']."-".
                                                                    $course['lab']['end_time']
                                                                    : "-")?>
                        </td>
            		</tr>
        
                    <input type  = "hidden"
                           name  = "courses[<?php echo $course['id'] ?>][lecture_id]"
                           value = <?php echo isset($course['lecture'])? $course['lecture']['id'] : NULL ?> />
                    <input type  = "hidden"
                           name  = "courses[<?php echo $course['id'] ?>][tutorial_id]"
                           value = <?php echo isset($course['tutorial'])? $course['tutorial']['id'] : NULL ?> />
                    <input type  = "hidden"
                           name  = "courses[<?php echo $course['id'] ?>][lab_id]"
                           value = <?php echo isset($course['lab'])? $course['lab']['id'] : NULL ?> />
        
               <?php endforeach ?>
            </table>
            <br/>
            <br/>
        </div>
        <div id="schedule_table_button">
          <input class="button" type = "hidden" name="season" value = <?php echo $season;?> />
          <?=form_submit(null,"Save This Schedule");?>
        </div>
      </form>
  <?php endforeach?>
  </div>

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
      


         <?php  $data["time_table"] = $time_table;
                $this->load->view("/scheduleBuilder_views/time_table.php", $data);
         ?>
     --!>
</div>
