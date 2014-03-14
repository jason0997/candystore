<h2>Registeration Form</h2>

<style>
	input { display: block;}
	.error {color:red;}	
</style>

<?php 
	echo "<p>" . anchor('login/index','Back') . "</p>";
	
	echo form_open_multipart('register/registerCheck');
		
	echo form_label('First Name'); 
	echo form_error('first', '<p class="error"> ','</p>');
	echo form_input('first',set_value('first'),"required");

	echo form_label('Last Name');
	echo form_error('last', '<p class="error"> ','</p>');
	echo form_input('last',set_value('last'),"required");
	
	echo form_label('Login Name');
	echo form_error('loginName', '<p class="error"> ','</p>');
	echo form_input('loginName',set_value('loginName'),"required");
	
	echo form_label('Password');
	echo form_error('password', '<p class="error"> ','</p>');
	echo form_password('password',set_value('password'),"required");


	echo form_label('Confirm Password');
	echo form_error('confPwd', '<p class="error"> ','</p>');
	echo form_password('confPwd',set_value('confPwd'),"required");

	echo form_label('Email');
	echo form_error('email', '<p class="error"> ','</p>');
	echo form_input('email',set_value('email'),"required");

	echo form_submit('submit', 'Submit');
	echo form_close();
?>	

<script>

</script>

