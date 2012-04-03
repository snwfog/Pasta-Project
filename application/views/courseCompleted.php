<div id="content">
<div id="progress-indicator">
	<ul>
		<li id="stepped-on"><h1 id="bullet">1</h1><h5>Completed Courses</h5></li>
		<li><h1 id="bullet">2</h1><h5>Register Courses</h5></li>
		<li><h1 id="bullet">3</h1><h5>Done</h5></li>
	</ul>
</div>

<h1 id="section-title">Please select the course that you have completed.</h1>

<?php echo form_open('coursecompleted/submit'); ?>

	<table id="course_selection_table">
	<?php foreach($soft_eng_courses as $year => $semesters): ?>
		<tr><td colspan='5'><h1><?="Year " . $year?></h1></td></tr>
		<?php foreach($semesters as $semester => $course_list): ?>
			<tr><td colspan='5'><h2><?=$semester?></h2></td></tr>
			<?php foreach($course_list as $course): ?>
				<tr>
					<td><?php echo $course["id"].(isset($course['code']) ? 
										$course['code'] : "Unknown")?></td>
					<td><?php echo (isset($course['number']) ? 
										$course['number'] : "Unknown")?></td>
					<td><?php echo (isset($course['title']) ? 
										$course['title'] : "Unknown")?></td>
					<td><?php echo (isset($course['credit']) ? 
										$course['credit'] : "Unknown")?></td>
					<td><?php echo form_checkbox(
									'completed_courses[]', 
									(isset($course['id']) ? $course['id'] : "-1"), 
									$course['has_taken']); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>	
	<?php endforeach; ?>
	
	<tr>
		<td colspan="5" style="text-align: right;">
			<?=form_submit(array(
						'name'  => 'submit',
						'id' 	=> 'continue',
						'value' => 'Continue',
						'class' => 'button'
			));?>
		</td>
	</tr>
	</table>
	
	
	
</form>

</div>