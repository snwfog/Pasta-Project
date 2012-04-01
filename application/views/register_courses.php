<div id="content">
<div id="progress-indicator">
	<ul>
		<li><h1 id="bullet">1</h1><h5>Completed Courses</h5></li>
		<li id="stepped-on"><h1 id="bullet">2</h1><h5>Register Courses</h5></li>
		<li><h1 id="bullet">3</h1><h5>Done</h5></li>
	</ul>
</div>

<div id="course-preferences-selection">
	<?=form_open("schedulebuilder/listAllAllowedCourses");?>
	<ul>
		<li><?=form_radio('time', 'day');?> Day</li>
		<li><?=form_radio('time', 'night');?> Evening</li>
		<li><?=form_radio('time', '');?> I Don't Care</li>
	</ul>
	<p><?=form_checkbox('long_weekend', 'true');?> Long Week-End (Friday or Monday off)</p>
	<?=form_submit(array(
						'name'  => 'preferences-accept',
						'id'	=> 'preferences-accept',
						'value' => 'Proceed',
						'class' => 'button'
					));?>
	</form>
</div>

<h1 id="section-title">Here are the courses that meet your preferences</h1>
<h3 id="section-subtitle">You have <span id="registration-counter">5</span> course(s) left</h3>

<?php echo form_open('schedulerbuilder/register_courses'); ?>

	<table id="course-registration-selection-table">
			<?php foreach($course_list as $course): ?>
				<tr>
					<td><?=(isset($course['code']) ? 
								$course['code'] : "Unknown")?></td>
					<td><?=(isset($course['number']) ? 
								$course['number'] : "Unknown")?></td>
					<td><?=(isset($course['title']) ? 
								$course['title'] : "Unknown")?></td>
					<td><?=(isset($course['credit']) ? 
								$course['credit'] : "Unknown")?></td>
					<td><?=form_checkbox(
							'registered_courses[]', 
							(isset($course['id']) ? $course['id'] : "-1")); ?>
					</td>
				</tr>
			<?php endforeach; ?>

	
	<tr>
		<td colspan="5" style="text-align: right;">
			<?=form_submit(array(
						'name'  => 'register',
						'id' 	=> 'continue',
						'value' => 'Register',
						'class' => 'button'
			));?>
		</td>
	</tr>
	</table>
	
	
	
</form>

</div>