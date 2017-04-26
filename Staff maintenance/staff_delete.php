
<?php 

include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php'; ?>	
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
<script type="text/javascript"> 
		
		jQuery(document).ready(function(){
			$('#name').autocomplete({
					source:"autocomplete_name.php?term="
				});
		});
 
</script> 

<div class="row">
<?php if(!isset($_POST['show'])){ ?>
<div>
	<h1 class="subheader"><u>Delete Staff</u></h1>
</div>
	<div class="large-6 large-centered columns">
    <form class="custom" action="staff_delete.php" method="post" data-abide>
      <label for="username">Enter Staff name</label> 
      <input type="text" id="name" name="name" placeholder="Name list from Databse (autocomplete)" required/>
      
          <div class="row">
                  <div class="small-3 small-centered columns">
                    <button type="submit" name="show" id="button1" class="medium button green" >Show details</button>
                  </div>
          </div>            
    </form>
    </div>
<?php }else {
	require_once('../sql/opendb.php');
	$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
	
	
	$query = "SELECT *  
			  FROM staffs
			  WHERE staffName='$name'";
	
	$result = mysql_query($query) or die(mysql_error());
	
	if(mysql_num_rows($result)>0){
		while($data = mysql_fetch_row($result)){
			$id = $data[0];
			$ic = $data[2];
			$email = $data[3];
			$gender = $data[4];
			$hp = $data[5];
			$status = $data[7];
			$position = $data[6];
		}
	}else{
?>

<script type="text/javascript">
	window.onload = function() {
		alert("No Staff Found");
		window.location.replace("staff_delete.php"); 
      }
</script>
    
<?php
	}

?>
	<div class="large-8 large-centered columns">
    	<form method="POST" onsubmit="return confirm('Are you sure you want to deactive this staff?');" action='deactive.php'>
        	<fieldset>
            <legend>Staff Details</legend>

<div class="row">
        <div class="large-12 column">
            <label for="id">Staff ID <small>Display</small></label>
            <input type="text" value="<?php echo $id; ?>" disabled="">
            <input type="hidden" value="<?php echo $id; ?>" name="staffID">    
        </div>
        <div class="large-12 columns">
        	<label for="name">Staff Name <small>Display</small></label>
         	<input type="text" value="<?php echo $name; ?>" disabled="">
        </div>
        <div class="large-12 columns">
            <label for="email">Staff email <small>Display</small></label>
         	<input type="text" value="<?php echo $email; ?>" disabled=""> 
        </div>
        <div class="large-12 columns">
            <label for="ic">Staff Identities No <small>Display</small></label>
         	<input type="text" value="<?php echo $ic; ?>" disabled=""> 
        </div>
        <div class="large-12 columns">
            <label for="contact">Staff Contact <small>Display</small></label>
         	<input type="text" value="<?php echo $hp; ?>" disabled="">
        </div>
        <div class="large-12 columns">
            <label for="status">Staff Status <small>Display</small></label>
         	<input type="text" value="<?php echo $status; ?>" disabled="">
        </div>
        <div class="large-12 columns">
            <label for="position">Position<small>Display</small></label>
         	<input type="text" value="<?php echo $position; ?>" disabled="">
        </div>
        <div class="large-12 columns">
            <label for="gender">Gender<small>Display</small></label>
         	<input type="text" value="<?php echo $gender; ?>" disabled="">
        </div>
</div>
<div class="row">
 <div class="small-3 small-centered columns">
     <button  type="submit" name="submit_delete" class="medium button green">De-Activate</button> 
 </div>
</div>

          
   		</fieldset>
	</form>
    </div>
</div>
<?php }
include '../Main/footer.php';
}
?>
