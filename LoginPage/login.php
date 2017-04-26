<?php
include '../Function/Salt.php';

if(isset($_POST['login']))
{
	require '../sql/opendb.php';
	
	$email = mysql_real_escape_string($_POST['user_email']);
	$password = mysql_real_escape_string($_POST['user_pass']);
	
	if($email && $password)
	{
		$queryMember = "SELECT userName, memberID, password 
						FROM members 
						WHERE email = '$email' AND memberStatus!='Freeze'";
		
		$queryStaff = "SELECT StaffName, staffID, password 
						FROM staffs 
						WHERE email = '$email' AND staffStatus!='Freeze'";
						
		$querySeller = "SELECT sellerName, sellerID, password 
						FROM sellers 
						WHERE email = '$email' AND sellerStatus!='Freeze'";
						
		$login = mysql_query($queryMember)or die(mysql_error());
		if(mysql_num_rows($login)>0){
			$id = 'memberID';
			$name = 'userName';
		}else{
			$login = mysql_query($queryStaff)or die(mysql_error());
			if(mysql_num_rows($login)>0){
				$id = 'staffID';
				$name = 'StaffName';
			}else{
				$login = mysql_query($querySeller)or die(mysql_error());
				if(mysql_num_rows($login)>0){
					$id = 'sellerID';
					$name = 'sellerName';
				}
			}
		}
		
		while($log=mysql_fetch_array($login))
		{
			$dbpassword = $log['password'];
			$username = $log[$name];
			$id = $log[$id];
		}
		
		if(salt::getPass($password,$dbpassword))
		{
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['id'] = $id;
			if($_SESSION['id'][0] == 'R'){
				$query  = "SELECT shopID
						   FROM shops
						   WHERE sellerID='".$_SESSION['id']."'";
				$result = mysql_query($query);
				
				if($result==TRUE){
					$row = mysql_fetch_row($result);
					$_SESSION['shopID'] = $row[0];
					
				}
			}else{
				$_SESSION['shopID'] = 0;
			}
			
			header("location:../Home/homePage.php");
		}
		else
		{
			header("location:loginPage.php?notify=Incorrect Username or Password.");
		}
	}
	else
	{
		header("location:loginPage.php?notify=All fields are required.");
	}
}
?>