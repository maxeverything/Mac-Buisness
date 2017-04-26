<?php
include '../Main/header.php';

	$id = empty($_GET['id'])?die('ID error'):mysql_real_escape_string($_GET['id']);
	require_once '../sql/openDb.php';
	
	$qryMember = "SELECT memberID
				  FROM members
				  WHERE memberID='$id'";
	
	$qryStaff = "SELECT staffID
				  FROM staffs
				  WHERE staffID='$id'";
	
	$qrySeller = "SELECT sellerID
				  FROM sellers
				  WHERE sellerID='$id'";
				  
	$result=mysql_query($qryMember);
	
	if(mysql_num_rows($result)>0){
		while($row=mysql_fetch_row($result)){
			$found=true;
			$table='Member';
			break;
		}
	}else{
		$result=mysql_query($qryStaff);
		if(mysql_num_rows($result)>0){
			while($row=mysql_fetch_row($result)){
				$found=true;
				$table='Staff';
				break;
			}
		}else{
			$result=mysql_query($qrySeller);
			if(mysql_num_rows($result)>0){
				while($row = mysql_fetch_row($result)){
					$found=true;
					$table='Seller';
					break;
				}
			}
		}
	}

	if($found==TRUE){
		$qryUpdate = "UPDATE ".$table."s 
					  SET ".$table."Status='Active'
					  WHERE ".$table."ID='$id'";
		
				  
		$result = mysql_query($qryUpdate)or die('Error encounter '.mysql_error());
?>
<script src="js/script.js"></script>
<script>
	window.onload = function() {
		window.location.replace("../LoginPage/Loginpage.php");
	    alert( "Your account have been ACTIVE. Thank You" );
	}	
</script>
<?php		
	}else{
		echo "<p>You are not registered, Please go back to <a href='http://localhost/CMS/Home/homePage.php'>home page</a><p>";
	}
	
include "../Main/footer.php";
?>

