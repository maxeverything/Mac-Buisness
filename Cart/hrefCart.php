<?php
include '../sql/config.php';
include '../sql/opendb.php';
session_start();
if (isset($_REQUEST['addToCart'])) {
	$a;
	if (!empty($_REQUEST['id'])) {
		if (isset($_REQUEST['qty'])) {
			$qty = mysql_real_escape_string($_REQUEST['qty']);
		} else {
			$qty = mysql_real_escape_string(1);
		}

		if (isset($_REQUEST['color'])) {
			$color = mysql_real_escape_string($_REQUEST['color']);
		} else {
			$color = mysql_real_escape_string('');
		}
		$id = mysql_real_escape_string($_REQUEST['id']);
		$product = mysql_real_escape_string($_REQUEST['productID']);
		$result = mysql_query("INSERT INTO product_cart (OrderID,productID,date_in,Quantity,color) VALUES ('$id','$product',now(),'$qty','$color')");
		if ($result) {
			$a = array("status" => "1");
		} else {
			mysql_query("UPDATE product_cart SET Quantity='$qty', color='$color' WHERE OrderID='$id' AND productID='$product'") or die(mysql_error());
			$a = array("status" => "1");
		}
	} else {
		$a = array("status" => "0");
	}
	echo json_encode($a);
}

if (isset($_REQUEST['DeleteCart'])) {
	$OrderID = mysql_real_escape_string($_REQUEST['OrderID']);
	$product = mysql_real_escape_string($_REQUEST['productID']);
	$result = mysql_query("DELETE FROM product_cart WHERE OrderID='$OrderID' AND productID='$product'");
	if ($result > 0) {
		echo json_encode(array("status" => "1"));
	} else {
		echo json_encode(array("status" => "1"));
	}
}
if (isset($_REQUEST['UpdateCart'])) {
	$OrderID = mysql_real_escape_string($_REQUEST['OrderID']);
	for($i=0;$i<count($_REQUEST['qty']);$i++){
		$qty = mysql_real_escape_string($_REQUEST['qty'][$i]);
		$color = mysql_real_escape_string($_REQUEST['color'][$i]);
		$product = mysql_real_escape_string($_REQUEST['productID'][$i]);
		mysql_query("UPDATE product_cart SET Quantity='$qty', color='$color' WHERE OrderID='$OrderID' AND productID='$product'") or die(mysql_error());
	}
}

if(isset($_REQUEST['UpdateOrdersSelectAddr'])){
	$OrderID = mysql_real_escape_string($_REQUEST['OrderID']);
	$ShipperID=mysql_real_escape_string($_REQUEST['ShipperID']);
	$addressID=mysql_real_escape_string($_REQUEST['addressID']);
	$shippingPrice= mysql_real_escape_string($_REQUEST['shippingPrice']);
	mysql_query("UPDATE orders SET addressID='$addressID', ShipperID='$ShipperID', shippingPrice='$shippingPrice' WHERE OrderID='$OrderID'")or die('error'.mysql_error());
}

if(isset($_REQUEST['UpdateOrdersInsertAddr'])){
	$id=mysql_real_escape_string($_SESSION['id']);
	$address=mysql_real_escape_string($_REQUEST['txtAddress']);
	$city=mysql_real_escape_string($_REQUEST['txtCity']);
	$region=mysql_real_escape_string($_REQUEST['txtRegion']);
	$postcode=mysql_real_escape_string($_REQUEST['txtPostcode']);
	$result=mysql_query("INSERT INTO address (whoseAddress, Address, City, Region, PostCode) VALUES ('$id' ,'$address', '$city', '$region', '$postcode')");
	$addressID=mysql_real_escape_string(mysql_insert_id());
	$OrderID = mysql_real_escape_string($_REQUEST['OrderID']);
	$ShipperID=mysql_real_escape_string($_REQUEST['ShipperID']);	
	mysql_query("UPDATE orders SET addressID='$addressID', ShipperID='$ShipperID' WHERE OrderID='$OrderID'");
}
?>