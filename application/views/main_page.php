<style>
.products{border:10px;}
</style>

<?php
	echo 'Hi, ' .  $userInfo['first'] . ' ' . $userInfo['last'] . '!';
	echo form_open('base\logout');
	echo form_submit('submit', 'Log out');
	echo form_close();
	echo form_open('base\shopping_cart_main');
	echo form_submit('submit', 'Shopping Cart');
	echo form_close();
?>	
<hr />

<h3>Candy Inventory</h3>
<?php
		if(isset($exists))
			echo "<p style=\"color: red\">" . $exists . "</p>";
		echo "<table class=\"products\">";
		echo "<tr><th>Name</th> <th>Price</th> <th>Photo</th></tr>";
 		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
			echo "<td>" . anchor("base/add_shopping_cart/$product->id",'Add to shopping cart') . "</td>";				
			echo "</tr>";
		}
		echo "<table>";
?>	