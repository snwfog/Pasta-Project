<div id="content">
<!-- P.A.S.T.A. main content -->

	<div id="left-content">
		<div id="wrapper">
			<div id="description">
				<p>Hey, welcome to P.A.S.T.A., an online academic course scheduler for Software Engineering students at Concordia. We've created P.A.S.T.A. because we know all good <span class="proud">software engineers</span> have more important algorithms to devise than to plan their course schedules. So if you feel that you <span class="proud">are</span> an <span class="proud">awesome</span> engineer like us, sign up, it's free, and receive your course schedules in just a few easy steps.</p>
				<br />
				<p>Have a great year!</p>

				<p id="pasta-team-signature">- the P.A.S.T.A. team</p>
			</div>


		</div>
	</div>
	<!-- End of left content -->

	<div id="right-content">
		<div id="signup-form">
			<h1>New to P.A.S.T.A? Sign up for free!</h1>
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
	</div><!-- #right-content -->
	
</div><!-- #container -->
