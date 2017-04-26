<?php
include '../sql/opendb.php';
include '../Function/product.php';
include_once '../Function/Salt.php';
if(isset($_REQUEST['RegisterMember'])){
	$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
	$email = empty($_POST['email']) ? die ("ERROR: Enter a email") : mysql_real_escape_string($_POST['email']);
	$password = empty($_POST['password']) ? die ("ERROR: Enter a password") : mysql_real_escape_string($_POST['password']);
	$regDate = date('Y-m-d');
	$Obj = new Salt();
	$pass = $Obj->setPass($password);
	
	$query = "SELECT memberID
			  FROM members
			  ORDER BY memberID DESC
			  LIMIT 1";
	
	$result = mysql_query($query) or die(mysql_error());
		
	$row = mysql_fetch_row($result);
	$memberID = product::newID($row[0]);
	
	$insert = "INSERT INTO members (memberID,email,Username,registerDate,password)
				VALUES ('$memberID','$email','$name','$regDate','$pass')";
	mysql_query($insert);
	if(isset($_REQUEST['category'])){
	for($i=0;$i<count($_REQUEST['category']);$i++){
		$category=mysql_real_escape_string($_REQUEST['category'][$i]);
		mysql_query("insert into prefercategory (memberID, categoryID) values( '$memberID', '$category')")or die(mysql_error());
	}

	}
}
	
?>