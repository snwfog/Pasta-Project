<div id="white-div" style="height: 500px">
	<div id="course-preferences-selection" class="dialog">
		<?=form_open("schedulebuilder/listAllAllowedCourses");?>
		<h1>Do you have a time preference?</h1>
		<h1>
			<ul>
				<li><?=form_radio('time', 'day');?> Day</li>
				<li><?=form_radio('time', 'night');?> Evening</li>
				<li><?=form_radio('time', '', TRUE);?> I Don't Care</li>
			</ul>
		</h1>
		<h1>How about a 3 days weekend?</h1>
		<h1><?=form_checkbox('long_weekend', 'true');?> Yes please!</h1>
		
		<?=form_submit(array(
			'name'  => 'course-preferences-accept',
			'id'	=> 'course-preferences-accept',
			'value' => 'Proceed',
			'class' => 'button'
		));?>
		</form>
	</div>
</div>