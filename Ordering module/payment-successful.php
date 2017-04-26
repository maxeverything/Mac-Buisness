
<?php 
	
	include '../main/authorization.php';
	include '../Main/header.php';
	require_once('../Ordering module/writeAndReadFile.php');
	require_once '../sql/openDb.php';
	
	$data = read_File($_SESSION['orderID']);
	$query = "SELECT email
			  FROM members
			  WHERE memberID=(
				  SELECT memberID
				  FROM orders
				  WHERE orderID='".$_SESSION['orderID']."'
			  )";
			  
	$result = mysql_query($query);
	
	$getEmail = mysql_fetch_row($result);
	
	$email = $getEmail[0];
	
	$count = $data['size'];
	$msg = "Date : ".date('Y-m-d');
	
	for($i=0;$i<$count;$i++){
		$proID[$i] = $data['id_'.($i+1)];
		$proName[$i] = $data['name_'.($i+1)];
		$proQty[$i] = $data['qty_'.($i+1)];
		$price[$i] = $data['price_'.($i+1)];
		$color[$i] = $data['color_'.($i+1)];
		
		$msg .= "\r\nProductID".$proID[$i] 
			   ."\r\nProduct Name: ".$proName[$i]
			   ."\r\nQuantity: ".$proQty[$i]
			   ."\r\nPrice : ".$price[$i]
			   ."\r\n-----------------------------------\r\n";
	}		
	
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}
	
	// assign posted variables to local variables
	$data['item_name']			= $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['custom'] 			= $_POST['custom'];
		
	// read the post from PayPal system and add 'cmd'	
	for($i=0;$i<$count;$i++){
		$query = "INSERT INTO order_det (orderID,productID,quantity_order,color,amount)
				  VALUES ('".$_SESSION['orderID']."','".$proID[$i]."','".$proQty[$i]."','".$color[$i]."','".($proQty[$i]*$price[$i])."')";
				  
		$result = mysql_query($query)or die("order Detail : ".mysql_error());
	}
	
	$today = date('Y-m-d');
	$require = strtotime("+8 day", strtotime($today));
	$shipped = strtotime("+4 day", strtotime($today));
	
	$pointGet = (int)($data['payment_amount']/10);
	
	$query1 = "UPDATE orders
			   SET txnID='".$data['txn_id']."',
			  	  OrderDate = '".$today."',
				  RequiredDate = '".date('Y-m-d', $require)."',
				  ShippedDate = '".date('Y-m-d', $shipped)."',
				  points_get = '".$pointGet."'
			   WHERE orderID='".$_SESSION['orderID']."'";
	$result=mysql_query($query1)or die('Error again '.mysql_error());
	
	
	if($result==TRUE){	
	/*
	
	for($i=0;$i<$count;$i++){
		$qryDelete = "DELETE FROM product_cart
				      WHERE productID='$proID[$i]'";
		$rstDeleteCart = mysql_query($qryDelete);
	}*/
	
?>
<div class="row">

<h1>Thank You</h1>
<p>Your payment was successful. Thank you.</p>
<p>Go your mail box to check your order details</p>
<span class="round alert label">Redirect to homepage after 1 SECONDS</span>

</div>
<br/>

<!--<meta http-equiv="refresh" content="1; URL=Email.php?email1=<?php echo $email; ?>&msg=<?php echo $msg;?>">-->
<meta http-equiv="refresh" content="1; URL=Email.php?email1=<?php echo $email; ?>">
<?php	

}
include '../Main/footer.php';
?>
