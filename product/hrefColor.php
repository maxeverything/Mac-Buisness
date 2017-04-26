<?php
	include('../sql/config.php');
	include '../sql/opendb.php';
	if(isset($_REQUEST['btnRemoveColor'])){
		$id=mysql_real_escape_string($_REQUEST['colorid']);
		mysql_query("Delete from product_Color where id=$id");
	}
	
	if(isset($_REQUEST['UpdateColor'])){
		$id=mysql_real_escape_string($_REQUEST['id']);
		$qty=mysql_real_escape_string($_REQUEST['qty']);
		mysql_query("Update product_Color SET qty='$qty' WHERE id=$id")or die('Error');
	}
	
	if(isset($_REQUEST['InsertColor'])){
		$color=mysql_real_escape_string($_REQUEST['color']);
		$qty=mysql_real_escape_string($_REQUEST['qty']);
		$productID=mysql_real_escape_string($_REQUEST['productId']);
		mysql_query("insert into product_color (productID, qty, color) values('$productID', '$qty', '$color')")or die('Error');
				
	}
	
?>