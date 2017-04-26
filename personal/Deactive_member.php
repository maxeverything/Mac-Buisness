<?php

if(isset($_GET['deactive_id'])){
	$deactive_id = $_GET['deactive_id'];
}else{
?>
<script>
            window.onload = function() {
				window.location.replace("../home/homepage.php");
				alert( "Error deactive_id" ); 
            }
        </script>
<?php
}

include '../main/header.php';
require_once '../sql/opendb.php';

$query = "SELECT *
		  FROM members
		  WHERE memberID='$deactive_id'";

$result = mysql_query($query);

while($row_User = mysql_fetch_assoc($result)){
	$name = $row_User['userName']; 
	$gender=$row_User['gender']; 
	$email=$row_User['email']; 
	$hp = $row_User['contact'];
	$point= $row_User['pointAcc']; 
	$regDate = $row_User['registerDate'];
	$profilePic = $row_User['Profile_pic'];
}
?>
<div class="row">
	<form action="../personal/deactive.php" method="POST" onsubmit="return confirm('Are you sure you want to deactive this Member?');">
          <fieldset>
            <legend>Member Details</legend>
        <div class="small-3 small-centered columns">
			<?php echo"<img src='../personal/$profilePic' style='width:100px;height:100px;border: black 1px solid'></img>"; ?>
		</div>   
		<div class="row">
		                <div class="large-12 column">
		                    <label for="memberID">member ID</label> 
		                    <input type="text" id="id" value="<?php echo $deactive_id; ?>" name="id" disabled>
		  
		                </div> 
		</div>

		<div class="row">
		               <div class="large-12 column">
		                    <label for="Username">User Name</label> 
		                    <input type="text" id="name" value="<?php echo $name; ?>" name="name" disabled>
		  
		               </div> 
		</div>

		<div class="row">
		               <div class="large-12 column">
		                    <label for="gender">Gender</label> 
		                    <input type="text" id="gender" value="<?php echo $gender; ?>" name="gender" disabled>
		  
		               </div> 
		</div>

		<div class="row">
		              <div class="large-12 columns">
		                <label for="phone">Contact Phone Number</label>
		                <input type="tel" id="phone" value="<?php echo $hp ?>" disabled>
		              </div>
		</div>

		<div class="row">
		              <div class="large-12 columns">
		                <label for="email">Email</label>
		                <input type="email" id="email" value="<?php echo $email ?>" disabled>
		              </div>
		</div>
		      
		<div class="row">
		              <div class="large-12 columns">
		                <label for="RegDate">Register Date</label>
		                <input type="text" id="regdate" value="<?php echo $regDate  ?>" disabled>
		              </div>
		</div>

            <div class="row">
              <div class="small-3 small-centered columns">
                <button type="submit" name="btnDeactive" class="medium button green" >Deactive</button>
				<input type="hidden" name='deactive_id' value="<?php echo $deactive_id; ?>" />
              </div>
            </div>

       </fieldset>
    </form>
</div>

<?php include '../main/footer.php'; ?>