<?php

include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php';

require_once('../sql/opendb.php');

$query = "SELECT o.orderid,o.memberid,a.address,a.city,a.region,a.postcode,o.shippedDate,o.orderdate,o.shipmentStatus
		  FROM orders o,address a
		  WHERE o.shipmentStatus='pending' and o.addressID=a.addressID";

$query1 = "SELECT r.redeemID,r.memberid,a.address,a.city,a.region,a.postcode,r.shippingDate,r.reedemdate,r.shippingStatus
		  FROM redeemables r,address a
		  WHERE shippingStatus='pending' and a.addressID=r.addressID";
		  
		  
$result1 = mysql_query($query1)or die('SQL error 12'.mysql_error());
$result = mysql_query($query) or die('SQL error '.mysql_error());

$i=0;

?>
<link type="text/css" rel="stylesheet" href="../css/TableLayout.css"/>
<div class="row">
<br/>

<div class="large-12 large-centered columns">
<h2>Update Shippment Status</h2>
<form class="custom" method="POST" action="Update_shipmentStatus.php">
<table class="bordered">
  <thead>
    <tr>
	 <th>#</th>
      <th>MemberID</th>
	  <th>Address</th>
      <th>ShippedDate</th>
	  <th>order date  </th>
	  <th>Ship Status</th>
	  <th>Type</th>
	  <th>Check</th>
    </tr>
  </thead>
  <tbody>
  
<?php
	while($row = mysql_fetch_row($result)){
		$id[$i] = $row[0];
		$memberid[$i] = $row[1];
		$address[$i] = $row[2];
		$city[$i] = $row[3];
		$region[$i] = $row[4];
		$postcode[$i] = $row[5];
		$shippedDate[$i] = $row[6];
		$orderDate[$i] = $row[7];
		$shipStatus[$i] = $row[8];
		$type = "ORDER"
?>
    <tr>
	  <td><?php echo $row[0]; ?></td>
      <td><?php echo $memberid[$i]; ?></td>
	  <td><?php echo "$address[$i], $city[$i] $postcode[$i] $region[$i]"; ?></td>
      <td><?php echo $shippedDate[$i]; ?></td>
      <td><?php echo $orderDate[$i]; ?></td>
	  <td><?php echo $shipStatus[$i]; ?></td>
	  <td><?php echo $type; ?></td>
	  <td><input type="checkbox" value="<?php echo $row[0].",".$type ; ?>" name="check_list[]"><span class="custom checkbox checked"></span> Shipped</td>
    </tr>
	
<?php
		$i++;
	}
	while($row = mysql_fetch_row($result1)){
		$id[$i] = $row[0];
		$memberid[$i] = $row[1];
		$address[$i] = $row[2];
		$city[$i] = $row[3];
		$region[$i] = $row[4];
		$postcode[$i] = $row[5];
		$shippedDate[$i] = $row[6];
		$redeemDate[$i] = $row[7];
		$shipStatus[$i] = $row[8];
		$type = "REDEEM";
?>
<tr>
	  <td><?php echo $row[0]; ?></td>
      <td><?php echo $memberid[$i]; ?></td>
	  <td><?php echo "$address[$i], $city[$i] $postcode[$i] $region[$i]"; ?></td>
      <td><?php echo $shippedDate[$i]; ?></td>
      <td><?php echo $redeemDate[$i]; ?></td>
	  <td><?php echo $shipStatus[$i]; ?></td>
	  <td><?php echo $type; ?><input type="hidden" name="type[]" value="<?php echo $type; ?>"/></td>
	  <td><input type="checkbox" id="checkbox1" value="<?php echo $row[0].",".$type; ?>" name="check_list[]"><span class="custom checkbox checked"></span> Shipped</td>
</tr>

<?php
		$i++;
	}
?>

  </tbody>
</table>

<div class="row">
 <div class="small-3 push-9 columns">
     <button  type="submit" name="submit_upDateShipStatus" class="medium button green">Update</button>
 </div>
</div>

</form>
</div>
</div>
<br/>
<?php
include '../Main/footer.php';
}
?>