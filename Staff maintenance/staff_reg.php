<link rel="stylesheet" href="../css/docs.css"/>
<script type="text/javascript" async src="../js/ga.js"></script>
<?php 
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php' ?>
<div class="row">
      <div class="large-12 columns">
        <h2>Staff Registration</h2>
        <h4 class="subheader">What you still waiting for, join as our member to enjoy fast order.</h4>

<?php if(isset($_POST['submit'])){
	require_once '../sql/opendb.php';
	
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
	
	$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
	$hp = empty($_POST['hp']) ? die ("ERROR: Enter a hp") : mysql_real_escape_string($_POST['hp']);
	$email = empty($_POST['email']) ? die ("ERROR: Enter a email") : mysql_real_escape_string($_POST['email']);
	$ic = empty($_POST['ic']) ? die ("ERROR: Enter a ic") : mysql_real_escape_string($_POST['ic']);
	$password = empty($_POST['password']) ? die ("ERROR: Enter a password") : mysql_real_escape_string($_POST['password']);
	$gender = empty($_POST['gender']) ? die ("ERROR: Select a gender") : mysql_real_escape_string($_POST['gender']);
	
	require_once('../function/checkDuplicateEmail.php');
	
	if(matchEmail($email)==TRUE){
		$msg = 'This email is used by other user, please enter another email';
	?>
	
	<script>
		window.onload = function() {
	 		window.location.replace("staff_reg.php");
	    	alert("Error, <?php echo $msg ?>");
		}
	</script>
	
	<?php	
	
	}else{
	
	include_once '../Function/Salt.php';
	$Obj = new Salt();
	$pass = $Obj->setPass($password);
	
	$selectLast = "SELECT staffID
			       FROM staffs
			       ORDER BY staffID DESC
			       LIMIT 1";
	
	$run = mysql_query($selectLast) or die('Query error '.mysql_error());
	
	$ID = mysql_fetch_row($run);
	
	$staffID = newID($ID[0]);
	$today = date("Y-m-d");
	
	$query = "INSERT INTO staffs(staffID,staffName,staffIC,email,gender,contact,password,createdate) VALUES ('$staffID','$name','$ic','$email','$gender','$hp','$pass','$today')";
	
	$result = mysql_query($query);
	
	if($result==TRUE){
		include 'mail_reg_staff.php';
		$message = "Thank You for register as our staff, to active your account, please click the link below http://localhost/km_lz_combined/New%20folder/Password/verifyNew.php?id=".$staffID;

		sendTo($email,$message);
?>
<script>
	window.onload = function() {
		window.location.replace("staff_reg.php");
	    alert( "Please go your email to active your account, <?php echo $email ?>" );
	}	
</script>
<?php } else{
	?>
		<script>
			window.onload = function() {
			    alert("<?php echo mysql_error() ?>");
				window.location.replace("staff_reg.php");
			}	
		</script>
	<?php	
		}
	 }
	}
	else{
?>
        <form class="custom" data-abide action="staff_reg.php" method="post" data-invalid="">
          <fieldset>
            <legend>Staff Registration Form</legend>

<div class="row">
<div class="large-12 column">
	<label for="Username">Staff Name <small>require</small></label> <input type="text" id="name" placeholder="Name" name="name" required>
                <small class="error" data-error-message="">Username can't have numeric and must be at least 1 letter.</small>
</div>
            <div class="large-12 columns">
                <label for="password">Password <small>required</small></label>
                <input type="password" id="password" placeholder="LittleW0men." name="password" required>
                <small class="error" data-error-message="">Passwords must be at least 8 characters with 1 capital letter, 1 number, and one special character.</small>
              </div>
            </div>

            <div class="row">
              <div class="large-12 columns">
                <label for="phone">Contact Phone Number</label>
                <input type="tel" id="phone" placeholder="017-2085208" name="hp" required>
                <small class="error" data-error-message="">Please enter a properly formatted telephone number.</small>
              </div>
            </div>
            
               <div class="row">
              <div class="large-12 columns">
                <label for="IC">Identity Card Number(IC)</label>
                <input type="text" id="ic" placeholder="1234567-01-1234" name="ic" required>
                <small class="error" data-error-message="">Please enter a properly formatted IC number.</small>
              </div>
            </div>

 <div class="row">
              <div class="large-4 columns">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="foundation@zurb.com" name="email" required>
                <small class="error">Valid email required.</small>
              </div>
             
            <div class="large-8 columns">
   <fieldset>
              <legend>Gender</legend>          
              
              <label for="radio1"><input name="gender" type="radio"  checked="" value="Male" class="hidden-field">
              <span class="custom radio checked"></span> Male</label>
              <br/>
              <label for="radio2"><input name="gender" type="radio"  value="Female" class="hidden-field">
              <span class="custom radio"></span> Female</label>
              </fieldset>
            </div>
          </div>
           
            <div class="row">
              <div class="small-3 small-centered columns">
                <button type="submit" name="submit" class="medium button green">Submit</button>
              </div>
            </div>

          </fieldset>
        </form>

      </div>
    </div>
 
<?php }
include '../Main/footer.php';
} ?>