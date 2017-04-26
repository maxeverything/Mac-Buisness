<?php
include '../sql/config.php';
include '../sql/opendb.php';
class ship{
	public static function getShipperName($in_shipID){
		$shipID=mysql_real_escape_string($in_shipID);
		$result=mysql_query("Select companyName from shippers WHERE shipperID='$shipID'");
		$row=mysql_fetch_array($result);
		return $row['companyName'];
	}
}
?>