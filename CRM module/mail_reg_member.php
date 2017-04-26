<?php

function sendTo($to,$message){
	$subject = "Member registration";
	$from = "Light_CMS@example.com";
	$headers = "From:" . $from;
	mail($to,$subject,$message,$headers);
	
}
?>