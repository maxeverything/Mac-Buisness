
<?php
session_start();

function sendTo($to,$message){
	$to = 'lengzuo01@gmail.com';
	$subject = "Light Enterprise";
	$from = "Light_Enterprise@example.com";
	$headers = "From:" . $from;
	
	mail($to,$subject,$message,$headers);
}


if(!empty($_GET['email1'])){
	$email = $_GET['email1'];
	
	require_once('../Ordering module/writeAndReadFile.php');
	
	$data = read_File($_SESSION['orderID']);
	
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
	sendTo($email,$msg);
	?>
	<script>
            window.onload = function() {
				window.location.replace("../home/homepage.php");
				alert( "Email is send to your main box" ); 
            }
	</script>
	<?php
	}		
?>
