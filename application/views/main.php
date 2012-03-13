<div id="content">
<!-- P.A.S.T.A. main content -->
<h1><?php echo anchor(site_url("/scrape"), "Mike's Scrape"); ?></h1>
<h1><?php echo anchor(site_url("/courseInfo"), "Eric's Scrape"); ?></h1>
<h1><?php echo anchor(site_url("/scrape/testAll"), "Scrape test all courses"); ?>. WARNING: This is takes a while!</h1>
<h1><?php echo anchor(site_url("/scrape/showAllSerializedCourses"), "View all courses as an array"); ?> (fast!). Pro-tip: View -> source.</h1>

<?php 
	echo form_open('signup', array('id' => 'signup')); 
	echo form_label('Student ID:', 'student_id');
	echo form_input('student_id')."<br />";
	
	echo form_label('Password:', 'password');
	echo form_password('password')."<br />";
	
	echo form_label('Confirm Password:', 'password_confirm');
	echo form_password('password_confirm')."<br />";


	echo form_label('First Name:', 'first_name');
	echo form_input('first_name')."<br />";

	echo form_label('Last Name:', 'last_name');
	echo form_input('last_name')."<br />";

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
