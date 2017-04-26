<?php

if(isset($_REQUEST['sentWarningMail'])){
	$to = $_REQUEST['email'];
	$subject = "Wraning Letter";
	$from = "someonelse@example.com";
	$headers = "From:" . $from;
	$message="You have Reseive an Warning Latter from CMS website(www.cms.com), because you have typing rude word ";
	if(mail($to,$subject,$message,$headers)==true){
		echo json_encode(array("status" => "1"));
	}else{
		echo json_encode(array("status" => "0"));
	}
}

?>