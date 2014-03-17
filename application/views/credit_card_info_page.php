
<style>
	input { display: block;}
	.error {color:red;}
</style>

<?php 
	echo "<p>" . anchor('base/shopping_cart_main','Back') . "</p>";
	echo form_open_multipart('base/checkout');
		
	echo form_label('Credit Card Number'); 
	echo form_error('ccnumber', '<p class="error"> ','</p>');
	echo form_input('ccnumber',set_value('ccnumber'),"required");

	if(isset($error))
		echo "<p style = \"color:red\">" . $error . "</p>";
			var_dump("1234567890123456");
		
	echo form_label("Expire Date (MM/YY)");
	echo form_error('expiredate', '<p class="error"> ','</p>');
	echo form_input('expiredate',set_value('expiredate'),"required");
		
	echo form_submit('submit', 'Submit');
	echo form_close();
?>	

