<h2>Edit Product</h2>

<style>
	input { display: block;}
	.error {color:red;}
</style>

<?php 
	echo "<p>" . anchor('base/product_management','Back') . "</p>";
	
	echo form_open("base/update/$product->id");
	
	echo form_label('Name'); 
	echo form_error('name', '<p class="error"> ','</p>');
	echo form_input('name',$product->name,"required");
	if(isset($existerror) && $existerror = true){
		echo "<p class =\"error\"> Product already exists!</p>";
	}

	echo form_label('Description');
	echo form_error('description', '<p class="error"> ','</p>');
	echo form_input('description',$product->description,"required");
	
	echo form_label('Price');
	echo form_error('price', '<p class="error"> ','</p>');
	echo form_input('price',$product->price,"required");
	
	echo form_submit('submit', 'Save');
	echo form_close();
	echo form_open("base/product_management");
	echo form_submit('submit', 'Give Up');
	echo form_close();

?>	

