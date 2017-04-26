<?php
session_start();
include '../sql/config.php';
include '../sql/opendb.php';
include '../Function/Salt.php';
	if(isset($_POST['submitNewPassword'])){		
		$currentPassword=$_REQUEST['currentPassword'];
		$memberID=mysql_real_escape_string($_SESSION['memberID']);
		$result=mysql_query("SELECT password FROM members WHERE memberID = '$memberID'");
		while($log=mysql_fetch_array($result))
		{
			$dbpassword = $log['password' ];
			}
			if(salt::getPass($currentPassword,$dbpassword))
			{
			$newPassword=mysql_real_escape_string(Salt::setPass($_REQUEST['newPassword']));
			mysql_query("Update members set password='$newPassword' where memberID = '$memberID'"
		)or die('Error update query '.mysql_error());
			if(mysql_affected_rows()>0){
?>
<script>
	window.onload = function() {
		window.location.replace("passwordReset.php");
		alert("Your password is update succesfully");
	}
</script><?php
}
}else{
?>
<script>
	window.onload = function() {
		window.location.replace("passwordReset.php");
		alert("Invalid Current Password");
	}
</script>
<?php
}
}


if(isset($_POST['UpdateAddress'])){
$id=mysql_real_escape_string($_REQUEST['addressID']);
$address=mysql_real_escape_string($_REQUEST['txtAddress']);
$city=mysql_real_escape_string($_REQUEST['txtCity']);
$region=mysql_real_escape_string($_REQUEST['txtRegion']);
$postcode=mysql_real_escape_string($_REQUEST['txtPostcode']);
mysql_query("Update address SET Address='$address', City='$city', Region='$region', PostCode='$postcode' WHERE addressID='$id' ");
unset($_SESSION['addressID']);
if(mysql_affected_rows()>0){
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Your address is update succesfully");
	}
</script><?php

}else{
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Address Cannot Be Update");
	}
</script>
<?php
}
}


if(isset($_POST['submitNewAddr'])){
$id=mysql_real_escape_string($_SESSION['id']);
$address=mysql_real_escape_string($_REQUEST['txtAddress']);
$city=mysql_real_escape_string($_REQUEST['txtCity']);
$region=mysql_real_escape_string($_REQUEST['txtRegion']);
$postcode=mysql_real_escape_string($_REQUEST['txtPostcode']);
$result=mysql_query("INSERT INTO address (whoseAddress, Address, City, Region, PostCode) VALUES ('$id' ,'$address', '$city', '$region', '$postcode')");
if($result){
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Your address is added succesfully");
	}
</script><?php

}else{
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Address Cannot Be add");
	}
</script>
<?php
}
}

if(isset($_REQUEST['deleteAddr'])){
$id=mysql_real_escape_string($_REQUEST['addressID']);
$result=mysql_query("Delete FROM address where addressID=$id") or die(mysql_error());
if(mysql_affected_rows()>0){
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Your address is Delete succesfully");
	}
</script><?php

}else{
?>
<script>
	window.onload = function() {
		window.location.replace("Address.php");
		alert("Address Cannot Be delete");
	}
</script>
<?php
}
}

if(isset($_REQUEST['deleteProfilePic'])){
	if(file_exists($_REQUEST['image'])){
		if(unlink($_REQUEST['image'])){
			$id= mysql_real_escape_string($_SESSION['id']);
			mysql_query("UPDATE members 
					 	SET Profile_pic='profilePic/default.jpg'
						WHERE memberID='$id'");
			echo json_encode(array("status" => "1"));
		}else{
			echo json_encode(array("status" => "0"));
		}
	}
}
?>

