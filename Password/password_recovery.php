<?php include '../Main/header.php'; 

if(isset($_POST['btnConfirm'])){
		require '../sql/opendb.php';
		$email = mysql_real_escape_string($_POST['inEmail']);
		$role = mysql_real_escape_string($_POST['inRole']);
		
		$ranNum = rand(10000,99999);
		
		include_once '../Function/Salt.php';
		$Obj = new Salt();
		
		$pass = $Obj->setPass($ranNum);
		
		$query = "UPDATE $role
				  SET password='$pass'
				  WHERE email = '$email'";
				  
		$result = mysql_query($query);
		
		if($result==TRUE){
			include 'Email_pass_recovery.php';
			$message = "Your new Password : ".$ranNum."\n Quickly go and update your password after login.http://localhost/km_lz_combined/New%20folder/LoginPage/loginPage.php";
			
			sendTo($email,$message);
			
		}else{
		?>
			<script>
				window.onload = function() {
					window.location.replace("password_recovery.php");
				    alert("<?php echo mysql_error(); ?>");
				}	
			</script>	
		<?php
		}
}

if(!isset($_POST['verifyUser'])){
?>
<div class="row">
	<form class="custom" action="password_recovery.php" method="post" data-abide>
        <div class="large-8 large-centered columns">
            <label for="Username">Enter Email <small>require</small></label>
            <input type="email" id="email" placeholder="Enter email here" name="email" required>    
        </div>
        <div class="row">
            <div class="small-2 small-centered columns">
                <button type="submit" name="verifyUser" class="medium button green">Verify User</button>
            </div>
        </div>
    </form>
<?php 
}else{
	$email = mysql_real_escape_string($_POST['email']);
	require '../sql/opendb.php';
	
	$query = "SELECT sellerID,sellerName
			  FROM sellers s
			  WHERE s.email='$email'";
	
	$query1 = "SELECT staffID,staffName
			  FROM staffs s
			  WHERE s.email='$email'";
	
	$query2 = "SELECT memberID,username
			  FROM members m
			  WHERE m.email='$email'";
	
	$result = mysql_query($query) or die(mysql_error());
	$result1 = mysql_query($query1) or die(mysql_error());
	$result2 = mysql_query($query2) or die(mysql_error());
	
	if(mysql_num_rows($result)>0){
		$table = 'Sellers';
		$actorID = 'SellerID';
		$row = mysql_fetch_row($result);
	}elseif(mysql_num_rows($result1)>0){
		$table = 'Staffs';
		$actorID = 'StaffID';
		$row = mysql_fetch_row($result1);
			
	}elseif(mysql_num_rows($result2)>0){
		$table = 'Members';
		$actorID = 'MemberID';
		$row = mysql_fetch_row($result2);
	}else{
?>
	<script>
		window.onload = function() {
			window.location.replace("password_recovery.php");
		    alert( "Your Email not found . Thank You" );
		}	
	</script>
<?php
	}	
?>
	<form action="password_recovery.php" method="POST">
		
		<div class="row">
			<div class="large-4 large-centered columns">
				<div class="label">Your Email is:</div>
				<input type="text" disabled="" value="<?php echo $email ?>" style="background-color: white">
				<input type="hidden" name="inEmail" value="<?php echo $email ?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="large-4 large-centered columns">
				<div class="label">Your Name is:</div>
				<input type="text"  disabled="" value="<?php echo $row[1] ?>" style="background-color: white">
				<input type="hidden" name="inName" value="<?php echo $row[1] ?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="large-4 large-centered columns">
				<div class="label">Your Role is:</div>
				<input type="text" disabled="" value="<?php echo $table ?>" style="background-color: white">
				<input type="hidden" name="inRole" value="<?php echo $table ?>" />
			</div>
		</div>
	
		<div class="row">
	        <div class="small-2 small-centered columns">
	            <button type="submit" name="btnConfirm" class="medium button green">send Email</button>
	        </div>
	    </div>
		
	</form>
</div>
	
<?php }
include '../Main/footer.php'; ?>
