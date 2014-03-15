<h1>Registration Succeed!</h1>
<?php 
	if($loginName != 'admin')
		echo "<p>" . anchor('base/index','Go to Main Menu') . "</p>";
	else
		echo "<p>" . anchor('base/admin_main','Go to Main Menu') . "</p>";
	
?> 

