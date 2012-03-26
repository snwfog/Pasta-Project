<div id="content">

<p>Please select the course that you have completed.</p>

<?php echo form_open('coursecompleted/submit'); ?>

	<table id="course_selection_table">
	<?php foreach($soft_eng_courses as $year => $semesters): ?>
		<tr><td colspan='5'><h1><?=$year?></h1></td></tr>
		<?php foreach($semesters as $semester => $course_list): ?>
			<tr><td colspan='5'><h2><?=$semester?></h2></td></tr>
			<?php foreach($course_list as $course): ?>
				<tr>
					<td><?php echo (isset($course['code']) ? 
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
									FALSE); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>	
	<?php endforeach; ?>
	
	<tr>
		<td colspan="4" style="text-align: right">
			<?=form_reset('reset', 'Clear');?>
		</td>
		<td><?=form_submit('submit', 'Continue');?></td>
	</tr>
	</table>
	
	
	
</form>

</div>