<div id="content">
	<h1 id="section-title">Hello <?=$name;?>,</h1>
	<h3 id="section-subtitle">Here is your schedule for
		<span class="proud">
			<?=(($schedules['season'] == '2') ? "Fall" : "Winter")
				 . " - " . $schedules['year'];?>
		</span>
	</h3>
	<h3 id="section-subtitle">Credits Obtained: <span class="proud"><?=$total_credit?></span></h3>
	<h3 id="section-subtitle">Credits This Semester: <span class="proud"><?=$scheduled_credit?></span></h3>
	<div id="modal-dummy"></div>
	<div id="drop-schedule-confirm-box" class="dialog">
		<h1>
			Are you sure you want to drop this entire semester of course?
		</h1>

		<?=form_open("profile/drop_course/".$schedules['id']);?>
		<?=form_submit(array(
						'name'  => 'drop-schedule-accept',
						'id'	=> 'drop-schedule-accept',
						'value' => 'Accept',
						'class' => 'button'
					));?>
		<?=form_button(array(
						'name'  => 'drop-schedule-cancel',
						'id'	=> 'drop-schedule-cancel',
						'value' => 'false',
						'class' => 'button',
						'content' => 'Cancel'
					));?>

		</form>
	</div>
	<table id="user_schedule_table">
		<tr><td><div id="accordion" class="ui-accordion">
		<?php foreach($scheduled_courses as $index => $course): ?>
			<h3 class="ui-accordion-header"><a href="#">
				<?=$course['code']?>
				<?=$course['number']?>
				<?=$course['title']?>
			</a></h3>
			<div class="ui-accordion-content">
				<table id="lecture-info">
					<tr>
						<td class="proud">Lecture</td>
						<td colspan="5"><?="Section " . $course['lecture']['section'];?></td>
					</tr>
					<tr>
						<td>Professor</td>
						<td colspan="5"><?=$course['lecture']['professor'];?></td>
					</tr>
					<tr>
						<td>Room</td>
						<td colspan="5"><?=$course['lecture']['room'];?></td>
					</tr>
					<tr>
						<td>Time</td>
						<td colspan="5">
							<?php 
								// essentially a bunch of concat with 
								// string manipulation that will display
								// the start to end time from 1235 and 0235
								// to 12:35 - 02:35
								echo substr($course['lecture']['start_time'], 0, 2) . ":" . substr($course['lecture']['start_time'], 2, 2) . " - " . substr($course['lecture']['end_time'], 0, 2) . ":" . substr($course['lecture']['end_time'], 2, 2);
							?>
						</td>
					</tr>
					<tr>
						<td>Day</td>
						<?php
							$week_day = array('M', 'T', 'W', 'J', 'F');
							foreach($week_day as $day)
							{
								echo "<td id=" . (preg_match("/$day/", $course['lecture']['day']) ? "class-day" : "") . " style='text-align: center'>" . $day . "</td>";
							}
						?>
					</tr>
					<tr>
						<td>Campus</td>
						<td colspan="5"><?=$course['lecture']['campus'];?></td>
					</tr>
				</table>
				<div class="detail-schedule-info-divider"></div>
				<?php if (isset($course['tutorial'])): ?>
					<table id="tutorial-info">
						<tr>
							<td class="proud">Tutorial</td>
							<td colspan="5"><?="Section " . $course['tutorial']['section'];?></td>
						</tr>
						<tr>
							<td>Room</td>
							<td colspan="5"><?=$course['lecture']['room'];?></td>
						</tr>
						<tr>
							<td>Time</td>
							<td colspan="5">
								<?php 
									// essentially a bunch of concat with 
									// string manipulation that will display
									// the start to end time from 1235 and 0235
									// to 12:35 - 02:35
									echo substr($course['tutorial']['start_time'], 0, 2) . ":" . substr($course['tutorial']['start_time'], 2, 2) . " - " . substr($course['tutorial']['end_time'], 0, 2) . ":" . substr($course['tutorial']['end_time'], 2, 2);
								?>
							</td>
						</tr>
						<tr>
							<td>Day</td>
							<?php
								$week_day = array('M', 'T', 'W', 'J', 'F');
								foreach($week_day as $day)
								{
									echo "<td id=" . (preg_match("/$day/", $course['tutorial']['day']) ? "class-day" : "") . " style='text-align: center>" . $day . "</td>";
								}
							?>
						</tr>
						<tr>
							<td>Campus</td>
							<td colspan="5"><?=$course['tutorial']['campus'];?></td>
						</tr>
					</table>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div></td></tr>
		<tr><td>
			<a href="#" id="dummy-drop-schedule"><span class="ui-icon ui-icon-trash"></span></a>
		</td></tr>
	</table>
</div>