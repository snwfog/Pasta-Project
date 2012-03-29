<div id="content">
<!-- P.A.S.T.A. main content -->

	<div id="left-content">
		<div id="wrapper">
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
			<div id="description">
				<p>Hey, welcome to P.A.S.T.A. We know its hard and a pain every year to register for new courses and make the schedule. This is why we created P.A.S.T.A. An online academic course scheduler for student that frequent Concordia University. Sign up to get your hassle free schedule generated in 2 simple steps. Have a great year!</p>
				<br />
			</div>
		</div>
	</div>
	<!-- End of left content -->

	<div id="right-content">
		<div id="signup-form">
			<?=form_open('pasta/register', array('id' => 'signup'));?>
			<ul>
				<li><?=form_error('student_id');?></li>	
				echo form_error('student_id');
				// echo form_label('Student ID:', 'student_id');
				echo "<br />";
				echo form_input(array(
						'name' 		  => 'student_id', 
						'maxlength'   => '7', 
						'size' 		  => '7',
						'placeholder' => 'Student ID',
						'value' 	  => set_value('student_id')
					));
				echo "<br />";
			
				echo form_error('password');	
				// echo form_label('Password:', 'password');
				echo "<br />";
				echo form_password(array(
						'name' 		  => 'password',
						'id'		  => 'password',
						'maxlength'	  => '20',
						'placeholder' => 'Password'));
				echo "<br />";
			
				echo form_error('password_confirm');	
				// echo form_label('Confirm Password:', 'password_confirm');
				echo "<br />";

				// define a dummy password field for display
				// echo form_input(array(
				// 		'name' => 'password-dummy',
				// 		'id' => 'password-dummy',
				// 		'maxlength' => '20',
				// 		'placeholder' => 'Password'));
				
				echo form_password(array(
						'name' 		  => 'password_confirm',
						'id'  		  => 'password-confirm',
						'maxlength'	  => '20',
						'placeholder' => 'Repeat Password'));

				echo "<br />";
			
				echo form_error('first_name');
				// echo form_label('First Name:', 'first_name');
				echo "<br />";
				echo form_input(
						array(
								'name' 		  => 'first_name',
								'maxlength'   => '20',
								'placeholder' => 'First Name',
								'value' 	  => set_value('first_name')));
				echo "<br />";
			
				echo form_error('last_name');
				// echo form_label('Last Name:', 'last_name');
				echo "<br />";
				echo form_input(
						array(
								'name' 		  => 'last_name',
								'placeholder' => 'Last Name',
								'maxlength'	  => '20',
								'value' 	  => set_value('last_name')));
				echo "<br />";
			
				// echo form_label('Program:', 'program');
				echo "<br />";
				echo form_dropdown('program', array(
							'soft_eng' => 'Software Engineer', 
							'mech_eng' => 'Mechanical Engineer'))."<br />";
				
				// this sign up button is an HTML link, the function of this link
				// is to submit this current form. The submit function is called
				// with JavaScript in `assets/js/script.js` file
				echo "<br />";
			
				echo form_submit(array(
					'name'  => 'submit',
					'value' => 'Submit',
					'class' => 'button'
				));

				echo form_reset(array(
					'name'  => 'reset',
					'value' => 'Clear',
					'class' => 'button'
				));
			?>
			</form>
		</div>
	</div>
	<!-- End of right content -->
	
</div>
