<h1>Candy Store</h1>
<?php 	echo "<p>" . anchor('base/admin_main','Back to candy inventory') . "</p>";?> 
<hr />
<h4>Date:<?php
$this->load->helper('date');
date_default_timezone_set('Canada/Eastern');
$datestring = "%Y/%m/%d - %h:%i %a";
$time = time();
 echo mdate($datestring, $time);?></h4>
<h4>First Name: <?php echo $userInfo['first']?></h4>
<h4>Last Name: <?php echo $userInfo['last'] ?></h4>
<h4>Card Number: <?php echo $encryptCCNumber?></h4>
<hr />
<h3>$<?php echo $totalCost?></h3>
<hr />
<h2>APPROVED</h2>
<h4>Thank you</h4>
<input type="submit" value="Print"  onClick="PrintReceipt();" \>
<script>
function PrintReceipt(){
	window.print();
}
</script>
