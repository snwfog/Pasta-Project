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
				<p>Hey, welcome to P.A.S.T.A., an online academic courses scheduler. If you are a Software Engineering student at Concordia, then we've created P.A.S.T.A. just for you because we know all good software engineers respect the DRY principle and that you've got more important algorithms to devise out than figuring your schedule every semester. So if you are an awesome engineer like us, feel free to sign up, and begin to save braincells and build your software engineer course sequences just in a few steps.</p>
				<br />
				<p>Have a great year!</p>

				<p id="pasta-team-signature">- the P.A.S.T.A. team</p>
			</div>
		</div>
	</div>
	<!-- End of left content -->

	<div id="right-content">
		<div id="signup-form">
			<h1>A new collegue?</h1>
			<?=form_open('pasta/register', array('id' => 'signup'),
				array('program' => 'soft_eng'));?>
			<ul>
				<li><?=form_error('student_id');?></li>	
				<li>
					<?=form_input(array(
						'name' 		  => 'student_id', 
						'maxlength'   => '7', 
						'size' 		  => '8',
						'placeholder' => 'Student ID',
						'value' 	  => set_value('student_id')
					));?>
					<?=form_submit(array(
						'name'  => 'submit',
						'id'	=> 'register',
						'value' => 'Register',
						'class' => 'button'
					));?></li>
			
				<li><?=form_error('password');?></li>
				<li><?=form_password(array(
						'name' 		  => 'password',
						'id'		  => 'password',
						'maxlength'	  => '20',
						'placeholder' => ''));?>

					<!-- dummy password form -->
					<?=form_input(array(
						'name' 		  => 'password_dummy',
						'class'		  => 'placeholder dummy',
						'value' 	  => 'Password',
						'maxlength'   => '20',
						'placeholder' => ''));?></li>
			
				<li><?=form_error('password_confirm');?></li>	
				<li><?=form_password(array(
						'name' 		  => 'password_confirm',
						'id'  		  => 'password-confirm',
						'maxlength'	  => '20',
						'placeholder' => ''));?>
						<!-- dummy password confirmation form -->
					<?=form_input(array(
						'name' 		  => 'password_confirm_dummy',
						'class'		  => 'placeholder dummy',
						'value' 	  => 'Confirm Password',
						'maxlength'   => '20',
						'placeholder' => ''));?></li>

				<li><?=form_error('first_name');?></li>
				<li><?=form_input(array(
						'name' 		  => 'first_name',
						'maxlength'   => '20',
						'placeholder' => 'First Name',
						'value' 	  => set_value('first_name')));?></li>

				<li><?=form_error('last_name');?></li>
				
				<li><?=form_input(array(
						'name' 		  => 'last_name',
						'placeholder' => 'Last Name',
						'maxlength'	  => '20',
						'value' 	  => set_value('last_name')));?></li>
			</form>
		</div>

		<div id="login-form">
			<h1>Already registered?</h1>
			<?=form_open('pasta/user_login', array('id' => 'login'));?>
			<ul>
				<li><?=form_error('login_student_id');?></li>
				<li>
					<?=form_input(array(
						'name' 		  => 'login_student_id', 
						'maxlength'   => '7', 
						'size' 		  => '8',
						'placeholder' => 'Student ID',
						'value' 	  => set_value('student_id')
					));?>
					<?=form_submit(array(
						'name'  => 'submit',
						'id' 	=> 'login',
						'value' => 'Login',
						'class' => 'button'
					));?></li>
			
				<li><?=form_error('login_password');?></li>
				<li><?=form_password(array(
						'name' 		  => 'login_password',
						'id'		  => 'password',
						'maxlength'	  => '20',
						'placeholder' => ''));?>

					<!-- dummy password form -->
					<?=form_input(array(
						'name' 		  => 'password_dummy',
						'class'		  => 'placeholder dummy',
						'value' 	  => 'Password',
						'maxlength'   => '20',
						'placeholder' => ''));?></li>
			</form>
		</div>
	</div>
	<!-- End of right content -->
	
</div>
