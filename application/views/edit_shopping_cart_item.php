<h2>Edit Product</h2>

<style>
	input { display: block;}
	.error {color:red;}
</style>


<?php 
	echo "<p>" . anchor('base/shopping_cart_main','Back') . "</p>";
	?>
<?php echo "<p>Name: " .$product->name . "</p>" ?>
<?php echo "<p>Description: " .$product->description . "</p>" ?>
<?php echo "<p>Price: " .$product->price . "</p>" ?>
<?php echo "<td> <img src='" . base_url() . "images/product/" . $product->photo_url . "' width='400px' /></td>"; ?>
<hr />
<?php
	echo form_open("base/update_item_shopping_cart/$product->id");
	
	echo form_label('Order Amount');
	echo form_error('number', '<p class="error"> ','</p>');
	echo form_input('number',$number,"required");
	
	echo form_submit('submit', 'Save');
	echo form_close();
	echo form_open("base/product_management");
	echo form_submit('submit', 'Give Up');
	echo form_close();
?>	

