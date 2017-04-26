<link rel="stylesheet" href="../css/docs.css"/>
<script type="text/javascript" async src="../js/ga.js"></script>
<?php include '../Main/header.php' ?>

<div class="row">
<div class="large-12 columns">

<?php if(isset($_POST['submit_member_reg'])) { 
	require_once '../sql/opendb.php';
	
	$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
	$email = empty($_POST['email']) ? die ("ERROR: Enter a email") : mysql_real_escape_string($_POST['email']);
	$password = empty($_POST['password']) ? die ("ERROR: Enter a password") : mysql_real_escape_string($_POST['password']);
	$regDate = date('Y-m-d');
	
	function newID($row){
		$newID ="";
		
			for($i=0;$i<strlen($row);$i++){
				if((!is_numeric($row[$i]))|| ($row[$i]==0)){
					$newID .= $row[$i];
				}
				else{
					
					if($row[strlen($row)-1]==9 ){
						$ID_no = (int)substr($row,$i,(strlen($row)-$i));
						$newID = substr($newID,0,$i-1).($ID_no+1);
					}else{
						$ID_no = (int)substr($row,$i,(strlen($row)-$i));
						$newID.= (int)($ID_no)+1;
					}
					break;
				}
		}
		return $newID;
	}
	
	include_once '../Function/Salt.php';
	$Obj = new Salt();
	$pass = $Obj->setPass($password);
	
	require_once('../function/checkDuplicateEmail.php');
	
	if(matchEmail($email)==TRUE){
		$msg = 'This email is used by other user, please enter another email';
	?>
	<script>
		window.onload = function() {
	 		window.location.replace("member_reg.php");
	    	alert("<?php echo $msg ?>");
		}
	</script>
<?php	
	}else{	
	
	$query = "SELECT memberID
			  FROM members
			  ORDER BY memberID DESC
			  LIMIT 1";
	
	$result = mysql_query($query) or die(mysql_error());
		
	$row = mysql_fetch_row($result);
	
	$memberID = newID($row[0]);
		
	$insert = "INSERT INTO members (memberID,email,Username,registerDate,password)
				VALUES ('$memberID','$email','$name','$regDate','$pass')";
	
	$result = mysql_query($insert);
	
	if($result==TRUE){
		include 'mail_reg_member.php';
		$message = "Thank You for register as our member, to active your account, please click the link below http://localhost/km_lz_combined/New%20folder/Password/verifyNew.php?id=".$memberID;
		
		sendTo($email,$message);
	
?>
<script>
	window.onload = function() {
 		window.location.replace("member_reg.php");
    	alert( "Please go your email to active your account, <?php echo $email ?>");
	}
</script>		
<?php }else{
	?>
		<script>
			window.onload = function() {
			    alert("<?php echo mysql_error() ?>");
				window.location.replace("member_reg.php");
			}	
		</script>
	<?php	
		}
	}
}else{ ?> 

  <form class="custom" data-abide action="member_reg.php" method="post" data-invalid="">
          <fieldset>
            <legend>Member Registration Form</legend>

<div class="row">
	<div class="large-12 column">
	<div class="row">
              <div class="large-12 columns">
                <label for="email">User name</label>
                <input type="text" id="name" placeholder="user name" name="name" required>
                <small class="error">Valid name required.</small>
              </div>
     </div>    
	 
	<div class="row">
              <div class="large-12 columns">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="youremail@mail.com" name="email" required>
                <small class="error">Valid email required.</small>
              </div>
     </div>        
    <div class="row">
              <div class="large-12 columns">
                <label for="password">Password <small>required</small></label>
                <input type="password" id="password" placeholder="Fill in Password" name="password" required>
                <small class="error" data-error-message="">Passwords must be at least 8 characters with 1 capital letter, 1 number, and one special character.</small>
              </div>
            </div>

              <div class="large-3 large-centered columns">
                <button type="submit" name="submit_member_reg" class="medium button green">Submit</button>
              </div>
		</div>
	</div>
          </fieldset>
        </form>
</div>
</div>
 <?php }
 	include '../Main/footer.php';
 ?>
      
 