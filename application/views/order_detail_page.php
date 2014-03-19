<h2>Order Detail</h2>

<style>
	input { display: block;}
	.error {color:red;}
</style>

<?php 
	echo "<p>" . anchor('base/display_order','Back') . "</p>";		
?>	
<?php echo "<p>Order id: " .$id . "</p>" ?>
<?php 
	echo "<table>";
	echo "<tr><th>Product ID</th><th>Name</th><th>Quantity</th></tr>";

	foreach ($products as $product) {
		echo "<tr>";
		echo "<td>" . $product['product_id']. "</td>";
		echo "<td>" . $product['name'] . "</td>";
		echo "<td>" . $product['number'] . "</td>";
		echo "</tr>";
	}
	echo "<table>";
?>
