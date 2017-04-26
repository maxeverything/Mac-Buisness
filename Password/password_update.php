<link rel="stylesheet" type="text/css" href="../css/docs.css" />
<?php 

include '../main/authorization.php';

if(authetication()==TRUE){
	
include '../Main/header.php'; 

$id=$_SESSION['id']; 

?>
<?php if(!isset($_POST['update_pass'])){ ?>
<br/>

<div class="row">
	<div class="large-8 large-centered columns">
    	<form class="custom" action="password_update.php" method="post">
            <div class="row">
              <div class="large-12 columns">
               <div class="row collapse">
                  <span class="attached-label style">Old Password</span>
                  <input type="text" class="attached-input" placeholder="Old Passoword" name="old_pass" required>
   			   </div>
              </div>
            </div>
            
             <div class="row">
              <div class="large-12 columns">
               <div class="row collapse">
                  <div class="label">New Password</div>
                  <input type="password" class="attached-input" placeholder="New Password" name="new_pass" required>
   			   </div>
              </div>
            </div>
            
            <div class="row">
              <div class="small-3 small-centered columns">
                  <button type="submit" name="update_pass" id="button1" class="medium button green" >Confirm</button>
   			   </div>
              </div>

        </form>
    </div>
</div>
<?php }else {
		require '../sql/opendb.php';
	
		$oldPass = $_POST['old_pass'];
		
		if($id[0] == 'R'){
			$actor = 'sellers';
			$idField = 'sellerID';
		}elseif($id[0] == 'M'){
			$actor = 'members';
			$idField = 'memberID';
		}else{
			$actor = 'staffs';
			$idField = 'staffID';
		}
		
		
			
		$sltQuery = "SELECT password
					 FROM $actor
					 WHERE $idField='$id'";
					 
		$result = mysql_query($sltQuery) or die('Select Query '.mysql_error());
	
		include '../Function/Salt.php';
		
		$Obj = new Salt();
		
		$row = mysql_fetch_row($result);
		
		if($Obj->getPass($oldPass,$row[0])==true){
			$newPass = $Obj->setPass($_POST['new_pass']);
			
			$updatePass="UPDATE $actor SET password='$newPass'
						 WHERE $idField='$id'";
			
			mysql_query($updatePass);
			?>
            <script src="js/script.js"></script>
			<script>
                window.onload = function() {
                    window.location.replace("password_update.php");
                    alert( "password Update Success" );
                }	
            </script>
            
<?php
		}else{
?>
            
<script src="js/script.js"></script>
<script>
	window.onload = function() {
		window.location.replace("password_update.php");
	    alert( "Old password doesnt match!! Update Password not success" );
	}	
</script>

<?php
		}	
}

include '../Main/footer.php'; 
}
?>