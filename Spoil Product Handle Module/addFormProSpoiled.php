<?php

require_once('../sql/opendb.php');
$today = date("Y-m-d");

if(isset($_POST['btnSubmit'])){
	$proID = $_POST['txtProID'];
	$orderID = $_POST['txtOrderID'];
	$quantity = mysql_real_escape_string($_POST['sltQuantity']);
	$reason = mysql_real_escape_string($_POST['txtReason']);
	
	$query = "INSERT INTO return_handle
			 (productID,orderID,Reason,Quantity,DateSend)
			  VALUES ('$proID','$orderID','$reason','$quantity','$today')";

	$result = mysql_query($query);
	
	if($result==TRUE){
?>		
<script>
    window.onload = function() {
		window.location.replace("Form_spoil.php");
		alert( "Complaint Form send.Thank You"); 
    }
</script>	
<?php		
	}else{
?>
<script>
    window.onload = function() {
		window.location.replace("Form_spoil.php");
		alert( "Complaint Form was sent."); 
    }
</script>	
<?php
	}
}
?>