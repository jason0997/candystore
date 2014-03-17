<style>
.products{border:10px;}
</style>

<?php
	echo form_open('base/logout');
	echo form_submit('submit', 'Log out');
	echo form_close();
?>	
<hr />

<h3>Confirm Checkout</h3>
<?php
		if(isset($exists))
			echo "<p style=\"color: red\">" . $exists . "</p>";
		echo "<table class=\"products\" border=\"1\" >";
		echo "<tr><th>Name</th> <th>Price</th> <th>Number</th></tr>";

		foreach ($products as $item) {
				$product = $item[0];
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td>"	. $item[1] . "</td>";				
			echo "</tr>";
		}
		echo "<table>";
		echo "<hr />";
		echo "<h4> Total Cost: " . $totalCost . "</h4>";
		$status = "confirm";
		echo form_open("base/confirm_checkout/$status");
		echo form_submit('submit', 'Confirm');
		echo form_close();

		echo form_open('base/shopping_cart_main');
		echo form_submit('submit', 'Back to shopping cart');
		echo form_close();
?>	