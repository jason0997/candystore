
<h2>Welcome to Display Order Page</h2>
<?php
	echo form_open('base/admin_main');
	echo form_submit('submit', 'Back');
	echo form_close();
	echo form_open('base/logout');
	echo form_submit('submit', 'Log out');
	echo form_close();

	echo "<table>";
	echo "<tr><th>Order ID</th><th>Order date</th><th>Order time</th><th>Total</th></tr>";

	foreach ($orders_view_array as $order) {
		$id = $order['order_id'];
		echo "<tr>";
		echo "<td>" . $order['order_id']. "</td>";
		echo "<td>" . $order['order_date'] . "</td>";
		echo "<td>" . $order['order_time'] . "</td>";
		echo "<td>" . $order['total']. "</td>";			
		echo "<td>" . anchor("base/admin_vieworder/$id",'View Details') . "</td>";
		echo "</tr>";
	}
	echo "<table>";


	echo form_open('base/admin_main');
	echo form_submit('submit', 'Back');
	echo form_close();
	echo form_open('base/logout');
	echo form_submit('submit', 'Log out');
	echo form_close();
?>	
