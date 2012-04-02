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
                 <th width=44px> TIME </th>
                 <th width=40px> M </th>
                 <th width=40px> T </th>
                 <th width=40px> W </th>
                 <th width=40px> J </th>
                 <th width=40px> F </th>
                 <th width=40px> Sat </th>
                 <th width=40px> Sun </th>
              <tr>
              <tr >
                <td>
                  <table width=100% border=0 cellpadding="0" cellspacing="0" name=time_column>
                    <?php
                      $total_height = 0;
                      for($i=7; $i<24; $i++){
                        $total_height += 40;
                        echo "<tr height=20px>
                                <td bgcolor = 'DDDDDD'> ".$i.":00 </td>
                             </tr>
                             <tr height=20px>
                                <td> ".$i.":30 </td>
                             </tr>";
                      }?>
                   </table>
                 </td>
               <?php foreach($time_table as $key => $day): ?>
                 <td>
                    <table border=0 cellpadding="0" cellspacing="0" height = <?php echo $total_height?>px name=day_column>
                            <?  $last_end = array("min" => 0, "hour" => 7);
                                foreach($day as $course){
                                $start = get_hour_min($course["start_time"]);
                                $end = get_hour_min($course["end_time"]);
                                $upper_size = ((abs($start["hour"]-$last_end["hour"])*60)+abs($start["min"]-$last_end["min"]))*(4/6);
                                $lower_size = ((abs($start["hour"]-$end["hour"])*60)+abs($start["min"]-$end["min"]))*(4/6);
                                $last_end = $end;
                                echo "<tr height=".$upper_size."px>
                                        <td>
                                        </td>
                                      </tr>
                                      <tr height=".$lower_size."px bgcolor = 'DDDDDD'>
                                        <td >".$start["hour"]."-".$start["min"]." ".$end["hour"]."-".$end["min"]."
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
