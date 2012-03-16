<div id="content">
	<div id="form">
		<?php 
			echo form_open('login/user_login', array('id' => 'login'));

			echo form_error('student_id'); 
			echo form_label('Student ID:', 'student_id');
			echo form_input('student_id')."<br />";
			
			echo form_error('password');
			echo form_label('Password:', 'password');
			echo form_password('password')."<br />";
			
			echo form_submit('submit', 'Login');
			echo form_reset('reset', 'Clear');
		?>
		</form>
	
	</div>
</div>