<?php
include ('../sql/config.php');
include '../sql/opendb.php';
session_start();
if (isset($_REQUEST['UpdateProduct'])) {
	$productid = mysql_real_escape_string($_REQUEST['productid']);
	$productName = mysql_real_escape_string($_REQUEST['productName']);
	$productDescription = mysql_real_escape_string($_REQUEST['productDescription']);
	$productPrice = mysql_real_escape_string($_REQUEST['productPrice']);
	$product_point = mysql_real_escape_string($_REQUEST['product_point']);
	$ProductWeight = mysql_real_escape_string($_REQUEST['ProductWeight']);
	$CategoryID = mysql_real_escape_string($_REQUEST['CategoryID']);
	mysql_query("Update Products SET ProductName='$productName', description='$productDescription', CategoryID='$CategoryID', UnitPrice='$productPrice', product_point='$product_point', ProductWeight='$ProductWeight' WHERE productID='$productid'") or die(mysql_error());
}

if (isset($_REQUEST['deleteProduct'])) {
	$productid = mysql_real_escape_string($_REQUEST['productid']);
	mysql_query("Update Products SET Product_status='DEACTIVATE' where productID='$productid'") or die(mysql_error());
}

if (isset($_REQUEST['activateProduct'])) {
	$productid = mysql_real_escape_string($_REQUEST['productid']);
	mysql_query("Update Products SET Product_status='ACTIVATE' where productID='$productid'") or die(mysql_error());
}

if (isset($_REQUEST['addNewProduct'])) {
	$productName = mysql_real_escape_string($_REQUEST['productName']);
	$productDescription = mysql_real_escape_string($_REQUEST['productDescription']);
	$productPrice = mysql_real_escape_string($_REQUEST['productPrice']);
	$shopID = mysql_real_escape_string($_SESSION['shopID']);
	$product_point = mysql_real_escape_string($_REQUEST['product_point']);
	$ProductWeight = mysql_real_escape_string($_REQUEST['ProductWeight']);
	$_SESSION['category'] = $_REQUEST['CategoryID'];
	$CategoryID = mysql_real_escape_string($_SESSION['category']);
	mysql_query("INSERT INTO Products (shopId, ProductName, description, CategoryID, UnitPrice, UnitsOnOrder, product_point, ProductWeight, Product_date) VALUES ('$shopID', '$productName', '$productDescription', '$CategoryID', '$productPrice', 0, '$product_point','$ProductWeight', Now())
") or die(mysql_error());
	$productID =mysql_real_escape_string(mysql_insert_id());
	for($i=0;$i<count($_REQUEST['color']);$i++){
		$color=mysql_real_escape_string($_REQUEST['color'][$i]);
		$qty=mysql_real_escape_string($_REQUEST['qty'][$i]);
		mysql_query("insert into product_color (productID, qty, color) values('$productID', '$qty', '$color')")or die('Error');
	}
	for($i=0;$i<count($_REQUEST['image']);$i++){
		$filepath= mysql_real_escape_string($_REQUEST['image'][$i]);
		mysql_query("Insert into product_pic (productID,pic_url) VALUES ('$productID','$filepath')");	
	}
}
?>