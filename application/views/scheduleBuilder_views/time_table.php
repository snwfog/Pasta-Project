<table id="time_table" >
        <tr id="time_table_header">
           <td id="time_header"> <small>Time</small> </th>
           <td id="day_header"> <small>Monday</small> </th>
           <td id="day_header"> <small>Tuesday</small>  </th>
           <td id="day_header"> <small>Wednesday</small>  </th>
           <td id="day_header"> <small>Thursday</small>  </th>
           <td id="day_header"> <small>FUNDAY</small>  </th>
           <td id="day_header"> <small>Saturday</small>  </th>
           <td id="day_header"> <small>BORINGDAY</small>  </th>
        <tr>
        <tr >
          <td>
            <table width=100% id="time_column">
              <?php
                $total_height = 0;
                for($i=7; $i<24; $i++){
                  $total_height += 60;
                  $bgcolor=null;
                  if(($i%2)==0){
                    $bgcolor = "bgcolor = 'DDDDDD'";
                  }
                  echo "<tr height=60px>
                          <td ".$bgcolor."> <small>".$i.":00 </small></td>
                       </tr>";
                }?>
             </table>
           </td>
         <?php foreach($time_table as $key => $day): ?>
           <td>
              <table width = 100% height = <?php echo $total_height?>px id="day_column">
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