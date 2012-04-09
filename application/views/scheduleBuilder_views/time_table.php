<div id="content">
    <?php
          //THIS should be moved to a helper class. helper class help views? maybe dono.
        function get_hour_min($time)
        {
            //Note: should be moved to helper class
            $length = strlen($time);
            $third_last = $length -2;
            $min = substr($time, $third_last, $length);
            $hour= substr($time, 0, $third_last);
            
            return array("hour" => $hour, "min" =>$min);
        }
    ?>
    <a href="javascript:history.back()">Go back</a>
    <table id="time_table" >
        <tr id="time_table_header">
            <td>TIME</th><td>MONDAY</th><td>TUESDAY</th>
            <td>WEDNESDAY</th><td>THURSDAY</th><td>FRIDAY</th>
        <tr>
        <tr>
            <td>
                <table style="width: 100%" id="time_column">
                    <?php
                        $total_height = 0;
                        for($i=7; $i<24; $i++)
                        {
                            $total_height += 60;
                            $bgcolor=null;
                            echo "<tr style='height: 60px'>
                                    <td>".$i.":00</td>
                                  </tr>";
                        }
                    ?>
                </table>
            </td>
        <?php foreach($time_table as $key => $day): ?>
              <td>
              <table style="width=100%; height=<?=$total_height?>px" id="day_column">
                  <?php 
                      $last_end = array("min" => 0, "hour" => 7);
                      foreach($day as $course)
                      {
                          $start = get_hour_min($course["start_time"]);
                          $end = get_hour_min($course["end_time"]);
                          $upper_size = abs((($start["hour"]*60)+$start["min"])-(($last_end["hour"]*60)+$last_end["min"]));
                          $lower_size = abs((($start["hour"]*60)+$start["min"])-(($end["hour"]*60)+$end["min"]));
                          $last_end = $end;
                          echo "<tr height=".$upper_size."px>
                                    <td></td>
                                </tr>
                                <tr height=".$lower_size."px bgcolor = 'DDDDDD'>
                                    <td>"
                                        .$course["code"]." ".$course["number"]."<br/>"
                                        .$course["type"]."(".$course["section"].")<br/>"
                                        .$start["hour"].":".$start["min"]."-".$end["hour"].":".$end["min"]."<br/>"
                                        ."
                                    </td>
                                </tr>";
                      }
                      
                      echo "<tr height=100%></tr>";


                  ?>
              </table>
           </td>
        <?php endforeach ?>
        </tr>
    </table>
</div>