<div id="content">
	<h1 id="section-title">Hello Charles,</h1>
	<h3 id="section-subtitle">Here is your schedule for
		<?=(($schedules['season'] == '2') ? "Fall" : "Winter")
			 . " - " . $schedules['year'];?></h3>
	<p>Credit <?=$total_credit?></p>
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
		<?php foreach($schedules['course_info'] as $index => $course): ?>
		

					<h3 class="ui-accordion-header"><a href="#">
						<?=$course['code']?>
						<?=$course['number']?>
						<?=$course['title']?>
					</a></h3>
					<div class="ui-accordion-content">CONTENT FOR COURSE</div>

			
		<?php endforeach; ?>
		</div></td></tr>
		<tr><td>
			<a href="#" id="dummy-drop-schedule"><span class="ui-icon ui-icon-trash"></span></a>
		</td></tr>
	</table>
</div>