<style>
	input { display: block;}
	.error {color:red;}
</style>
<h1> Welcome!</h1>
<?php 	
	echo form_open_multipart('login/loginCheck');
		
	echo form_label('Login Name'); 
	echo form_error('loginName');
	echo form_input('loginName',set_value('loginName'),"required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',set_value(),"required");	
	if(isset($error))
		echo '<p class="error">' . $error . '<p>';	
	echo form_submit('submit', 'Login');
	echo form_close();
?>	
<?php 
	echo form_open('login/registerForm');
	echo form_submit('submit', 'Register');
	echo form_close();
?>
