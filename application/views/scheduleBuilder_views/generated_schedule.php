<html>
<head>
<title>This is your Possible Schedule</title>
</head>
<body>

<?php
    function get_hour_min($time){
      //Note: should be moved to helper class
      $length = strlen($time);
      $third_last = $length -2;
      $min = substr($time, $third_last, $length);
      $hour= substr($time, 0, $third_last);
      return array("hour" => $hour, "min" =>$min);
    }
?>
<?php //print_r($time_tables);
    foreach($time_tables as $time_table): ?>
      <table border=1px name=time_table cellpadding="0" cellspacing="0">
              <tr>
                 <td width=44px> <strong>TIME</strong> </th>
                 <td width=40px> <strong>M</strong> </th>
                 <td width=40px> <strong>T</strong>  </th>
                 <td width=40px> <strong>W</strong>  </th>
                 <td width=40px> <strong>J</strong>  </th>
                 <td width=40px> <strong>F</strong>  </th>
                 <td width=40px> <strong>Sat</strong>  </th>
                 <td width=40px> <strong>Sun</strong>  </th>
              <tr>
              <tr >
                <td>
                  <table width=100% border=0 cellpadding="0" cellspacing="0" name=time_column>
                    <?php
                      $total_height = 0;
                      for($i=7; $i<24; $i++){
                        $total_height += 60;
                        $bgcolor=null;
                        if(($i%2)==0){
                          $bgcolor = "bgcolor = 'DDDDDD'";
                        }
                        echo "<tr height=60px>
                                <td ".$bgcolor."> ".$i.":00 </td>
                             </tr>";
                      }?>
                   </table>
                 </td>
               <?php foreach($time_table as $key => $day): ?>
                 <td>
                    <table border=0 cellpadding="0" cellspacing="0" height = <?php echo $total_height?>px name=day_column>
                            <?  $last_end = array("min" => 0, "hour" => 7);
                                $once = 15;
                                foreach($day as $course){
                                $start = get_hour_min($course["start_time"]);
                                $end = get_hour_min($course["end_time"]);
                                $upper_size = abs((($start["hour"]*60)+$start["min"])-(($last_end["hour"]*60)+$last_end["min"]));
                                $lower_size = abs((($start["hour"]*60)+$start["min"])-(($end["hour"]*60)+$end["min"]));
                                $last_end = $end;
                                echo "<tr height=".$upper_size."px>
                                        <td>
                                        </td>
                                      </tr>
                                      <tr height=".$lower_size."px bgcolor = 'DDDDDD'>
                                        <td >
                                             ".$course["code"]." ".$course["number"]."<br/>"
                                              .$course["type"]."(".$course["section"].")<br/>"
                                              .$start["hour"].":".$start["min"]."-".$end["hour"].":".$end["min"]."<br/>"
                                              ."
                                        </td>
                                      </tr>";
                               }
                               echo "<tr height=100%>
                                     </tr>";


                            ?>
                    </table>
                 </td>
               <?php endforeach ?>
              </tr>
       </table>

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
</body>
</html>
