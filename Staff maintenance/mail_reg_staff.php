<?php

function sendTo($to,$message){
	$to = 'lengzuo01@gmail.com';
	$subject = "Staff registration";
	$from = "someonelse@example.com";
	$headers = "From:" . $from;
	
	mail($to,$subject,$message,$headers);
}

?>