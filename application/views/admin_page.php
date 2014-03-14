
<h2>Welcome to Admin Page!</h2>
<?php 
//Product management
//Display order
//Delete all info
	echo form_open('base/product_management');
	echo form_submit('submit', 'Product Management');
	echo form_close();

	echo form_open('base/display_order');
	echo form_submit('submit', 'Display Order');
	echo form_close();
	
?>
<form method="post" name="Form1">
<input type="submit" value="Delete all info"  onClick="ConfirmDelete();" \>
<input type="hidden" name="Delete" value=""\>
</form>
<?php 
	echo form_open('base/logout');
	echo form_submit('submit', 'Log Out');
	echo form_close();

?>
<script>
function ConfirmDelete(){
	if(confirm(	"Do you really want to delete all user and order information?")){
			document.Form1.Delete.value = 'true';
	}
}
</script>
