<?php

if(isset($_REQUEST['sentMail'])){
	$to = 'lengzuo01@gmail.com';
	$subject = "Contact Us: product ID ".$_REQUEST['product'];
	$from = $_REQUEST['email'];
	$headers = "From:" . $from;
	$message="Name: ".$_REQUEST['name']."\n";
	$message.="What Up?\n".$_REQUEST['contact'];
	if(mail($to,$subject,$message,$headers)==true){
		echo json_encode(array("status" => "1"));
	}else{
		echo json_encode(array("status" => "0"));
	}
}

?>