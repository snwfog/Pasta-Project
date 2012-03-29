<div id="content">
<!-- P.A.S.T.A. main content -->
<ul>

	<li>
		<h1><?php echo anchor(site_url("/scrape"), "Scrape Course Form"); ?></h1>
	</li>

	<li>
		<h1><?php echo anchor(site_url("/courseInfo"), "Scraped Course List"); ?></h1>
	</li>

	<li>
		<h1><?php echo anchor(
				site_url("/scrape/testAll"), 
				"Test scrape on all courses"); 
			?>. WARNING: This is takes a while!</h1>
	</li>

	<li>
		<h1><?php echo anchor(
				site_url("/scrape/showAllSerializedCourses"), 
				"View all courses as an array"); 
			?> (fast!). Pro-tip: Right Click -> View Source Code (for a formatted array view).</h1>
	</li>


	<li>
		<h1><?php echo anchor(
				site_url("/scrape/addCoursetoDatabase"), 
				"Add Couse"); 
			?> Clicking this link will add a course to the table "Courses".</h1>
	</li>


	<li>
		<h1><?php echo anchor(
				site_url("scrape/viewTableCourses"), 
				"View Table Course"); 
			?> Show table "Courses".</h1>
	</li>

	<li>
		<h1><?=anchor(site_url("coursecompleted"), "User Select Course Completed (With animation and color!");?></h1>
	</li>

	<li>
		<h1><?=anchor(site_url("profile"), "Demo profile page with tables");?></h1>
	</li>

</ul>

<?php 
	echo form_open('pasta/register', array('id' => 'signup')); 
	
	echo form_error('student_id');
	echo form_label('Student ID:', 'student_id');
	echo form_input(
		array(
			'name' => 'student_id', 
			'maxlength' => '7', 
			'size' => '7',
			'value' => set_value('student_id')
		)
	) . "<br />";

	echo form_error('password');	
	echo form_label('Password:', 'password');
	echo form_password('password')."<br />";

	echo form_error('password_confirm');	
	echo form_label('Confirm Password:', 'password_confirm');
	echo form_password('password_confirm')."<br />";

	echo form_error('first_name');
	echo form_label('First Name:', 'first_name');
	echo form_input(
			array(
					'name' => 'first_name',
					'value' => set_value('first_name')))."<br />";

	echo form_error('last_name');
	echo form_label('Last Name:', 'last_name');
	echo form_input(
			array(
					'name' => 'last_name',
					'value' => set_value('last_name')))."<br />";


	echo form_label('Program:', 'program');
	echo form_dropdown('program', array(
				'soft_eng' => 'Software Engineer', 
				'mech_eng' => 'Mechanical Engineer'))."<br />";
				
	echo form_submit('submit', 'Signup');
	echo form_reset('reset', 'Clear');
?>
</form>

<div id="description">
	<p>Hey, welcome to P.A.S.T.A. We know its hard and a pain every year to register for new courses and make the schedule. This is why we created P.A.S.T.A. An online academic course scheduler for student that frequent Concordia University. Sign up to get your hassle free schedule generated in 2 simple steps. Have a great year!</p>
	<br />
	<p>This page is generated dynamically through <code>pasta.php</code> controller file in the controller folder. The page correspond to 3 parts, a header, a footer, and a main content from which you should dynamically update its content by calling the <code>put</code> function from the <code>pasta.php</code> controller. You could further extend this method to have more structure but document it well please.</p>
</div>

</div>
