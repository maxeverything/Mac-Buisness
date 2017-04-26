<?php

function sendTo($to,$message){
	$to = 'lengzuo01@gmail.com';
	$subject = "Test mail";
	$from = "someonelse@example.com";
	$headers = "From:" . $from;
	
	if(mail($to,$subject,$message,$headers)){
?>
<script src="../js/script.js"></script>
<script>
	window.onload = function() {
		window.location.replace("password_recovery.php");
	    alert( "New Password is sent to your Email, Please check your inbox ");
	}	
</script>
<?php
	}else{
?>
<script src="../js/script.js"></script>
<script>
	window.onload = function() {
		window.location.replace("password_recovery.php");
	    alert( "Sent fail, Error" );
	}	
</script>
<?php
	}
}

?>