
<h2>Welcome to Display Order Page</h2>
<?php
	echo form_open('base\admin_main');
	echo form_submit('submit', 'Back');
	echo form_close();
	echo form_open('base\logout');
	echo form_submit('submit', 'Log out');
	echo form_close();
?>	
