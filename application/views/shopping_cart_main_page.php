
<h2>Shopping Cart</h2>
<?php
		echo "<p>" . anchor('base/index','Back') . "</p>";
		echo "<p>" . anchor('base/logout','Log out') . "</p>";
		echo "<hr />";
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td> <img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	
