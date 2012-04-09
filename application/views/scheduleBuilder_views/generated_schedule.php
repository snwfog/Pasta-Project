<div id="content">
  <div id="schedule">
  <?php if(empty($possible_sequence)): ?>
      <div id="no_combination_message">
        <p id="large_sorry"> : (  Sorry !</p>
        <div id="sorry_back">
            <a href="javascript:history.back()">
                <img border="0" src=<?= base_url()."assets/img/red-back-arrow.png" ?> alt="HTML tutorial" width="60" height="60" />
            </a>
            <p id="reason"> P.A.S.T.A could not generate any schedules with the chosen courses. Please select a different combination and try again.</p>
        </div>


      </div>
  <?php else: ?>
    <h1 id="section-title">The following schedules match your preferences.<br/>Please pick one.</h1>
  <?php  endif ?>

  <?php foreach($possible_sequence as $a_set): ?>
      <?php echo form_open("schedulebuilder/save_schedule"); ?>
        <div id="schedule_table">
            <table id="schedule_table">
                <tr id="schedule_table_header">
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
    </form>
        <?php echo form_open("scheduler/time_table"); ?>
          <?= form_hidden($a_set)?>
          <?=form_submit(null,"View Time Table");?>
        </form>
      </div>

  <?php endforeach?>
  </div>

</div>
