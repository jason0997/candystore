
<h2>Welcome to Product Management Page</h2>
<?php
		echo "<p>" . anchor('base/admin_main','Back') . "</p>";
		echo "<p>" . anchor('base/logout','Log out') . "</p>";
		echo "<p>" . anchor('base/newForm','Add New') . "</p>";

		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td> <img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
			echo "<td>" . anchor("base/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("base/editForm/$product->id",'Edit') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	
