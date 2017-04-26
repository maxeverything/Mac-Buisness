<?php
include_once '../sql/config.php';
include_once '../sql/opendb.php';
session_start();

if (isset($_REQUEST['checkRedeem'])) {
	if (!empty($_SESSION['id'])) {
		$memberID = mysql_real_escape_string($_SESSION['id']);
		$point = mysql_real_escape_string($_REQUEST['point']);
		$result = mysql_query("select pointAcc-$point AS remainPoint From members where memberID='$memberID'");
		$row_point = mysql_fetch_row($result, MYSQL_ASSOC);
		if ($row_point['remainPoint'] >= 0) {
			$a = array("status" => "1");
		} else {
			$a = array("status" => "0");
		}
	} else {
		$a = array("status" => "2");
	}
	echo json_encode($a);
}

if (isset($_REQUEST['UpdateRedeemSelectAddr'])) {
	if (!empty($_SESSION['id'])) {
		$memberID = mysql_real_escape_string($_SESSION['id']);
		$point = mysql_real_escape_string($_REQUEST['point']);
		$result = mysql_query("select pointAcc-$point AS remainPoint From members where memberID='$memberID'");
		$row_point = mysql_fetch_row($result, MYSQL_ASSOC);
		if ($row_point['remainPoint'] >= 0) {
			$color=mysql_real_escape_string($_REQUEST['color']);
			$memberID = mysql_real_escape_string($_SESSION['id']);
			$productID = mysql_real_escape_string($_REQUEST['productID']);
			$redeemQuantity = mysql_real_escape_string($_REQUEST['redeemQuantity']);
			$PointUse = mysql_real_escape_string($_REQUEST['point']);
			$ShipperID = mysql_real_escape_string($_REQUEST['ShipperID']);
			$addressID = mysql_real_escape_string($_REQUEST['addressID']);
			mysql_query("Insert INTO redeemables (memberID, productID, color, reedemDate, redeemQuantity,PointUse, ShipperID, addressID ) VALUES ('$memberID', '$productID', '$color', Now() , '$redeemQuantity' ,'$PointUse', '$ShipperID', '$addressID')") or die('error' . mysql_error());
			$a = array("status" => "1");
		} else {
			$a = array("status" => "0");
		}
	} else {
		$a = array("status" => "2");
	}
	echo json_encode($a);

}

if (isset($_REQUEST['UpdateRedeemInsertAddr'])) {
	if (!empty($_SESSION['id'])) {
		$memberID = mysql_real_escape_string($_SESSION['id']);
		$point = mysql_real_escape_string($_REQUEST['point']);
		$result = mysql_query("select pointAcc-$point AS remainPoint From members where memberID='$memberID'");
		$row_point = mysql_fetch_row($result, MYSQL_ASSOC);
		if ($row_point['remainPoint'] >= 0) {
			
			$id = mysql_real_escape_string($_SESSION['id']);
			$address = mysql_real_escape_string($_REQUEST['txtAddress']);
			$city = mysql_real_escape_string($_REQUEST['txtCity']);
			$region = mysql_real_escape_string($_REQUEST['txtRegion']);
			$postcode = mysql_real_escape_string($_REQUEST['txtPostcode']);
			$result = mysql_query("INSERT INTO address (whoseAddress, Address, City, Region, PostCode) VALUES ('$id' ,'$address', '$city', '$region', '$postcode')");
			$addressID = mysql_real_escape_string(mysql_insert_id());
			$color=mysql_real_escape_string($_REQUEST['color']);
			$memberID = mysql_real_escape_string($_SESSION['id']);
			$productID = mysql_real_escape_string($_REQUEST['productID']);
			$redeemQuantity = mysql_real_escape_string($_REQUEST['redeemQuantity']);
			$PointUse = mysql_real_escape_string($_REQUEST['point']);
			$ShipperID = mysql_real_escape_string($_REQUEST['ShipperID']);
			mysql_query("Insert INTO redeemables (memberID, productID, color, reedemDate, redeemQuantity,PointUse, ShipperID, addressID ) VALUES ('$memberID', '$productID', '$color', Now() , '$redeemQuantity' ,'$PointUse', '$ShipperID', '$addressID')") or die('error' . mysql_error());
			$a = array("status" => "1");
		} else {
			$a = array("status" => "0");
		}
	} else {
		$a = array("status" => "2");
	}
	echo json_encode($a);

}
?>