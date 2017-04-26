<?php

require_once('../sql/opendb.php');
$today = date("Y-m-d");

	if(!empty($_POST['check_list'])){
		foreach($_POST['check_list'] as $item) {
			$a = (explode(",",$item));		
			$id = $a[0];
			$type = $a[1];
			
			$a = $id." ";
			if($type=="ORDER"){
				$Update = "UPDATE orders 
			           SET shipmentStatus='completed', ShippedDate='$today'
					   WHERE orderID='$id'";
			}else{
				$Update = "UPDATE redeemables 
			           SET shippingStatus='completed', ShippingDate='$today'
					   WHERE redeemID='$id'";
			}
			$result = mysql_query($Update);
    	}
	}else{
		die('Please check the status Thank You.');
	}

if($result==true){
?>

<script>
    window.onload = function() {
		window.location.replace("updateShipment.php");
		alert( "Shipment Update Success"); 
    }
</script>

<?php
}else{
?>
<script>
    window.onload = function() {
		window.location.replace("updateShipment.php");
		alert( "Error,this Product & order spoiled was sent"); 
    }
</script>
<?php
}

?>