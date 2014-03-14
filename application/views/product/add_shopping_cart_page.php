<h2>Edit Product</h2>

<style>
	input { display: block;}
	.error {color:red;}
	.orderNumber {width:30px;}
</style>

<?php 	
	echo "<p> Name: " . $product->name . "</p>";
	echo "<p> Description: " . $product->description . "</p>";
	echo "<p> Price: " . $product->price . "</p>";
	echo form_open("base/confirm_adding/$product->id");
	echo form_label("Order Number");
	echo form_error('orderNumber', '<p class="error"> ','</p>');
	$property_type = array('class' => 'orderNumber','name' =>'orderNumber','id' =>'orderNumber', 'required'=>'required', 'type'=>'text');
	echo form_input($property_type); 
	echo form_submit('submit', 'Add');
	echo form_close();

	echo form_open("base/index");
	echo form_submit('submit', 'Give Up');
	echo form_close();
	echo "<img src='" . base_url() . "images/product/" . $product->photo_url . "' width='400px' />";



?>	

