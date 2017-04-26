
<?php 
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php'; 
	$btnName = 'Update';

	require_once '../sql/opendb.php';
	
	$id = $_SESSION['id'];
	
	$query = "SELECT * 
			  FROM staffs
			  WHERE staffID='$id'";
			  
	$result = mysql_query($query) or die('Error in query'.mysql_error());
	
	if($rows = mysql_fetch_row($result)){
		$ID = $rows[0];
		$name = $rows[1];
		$hp = $rows[5];
		$ic = $rows[2];
		$email = $rows[3];
		$pos = $rows[6];
		$sex = $rows[4];
	}
	if($sex=='M'){
		$gender = "Male";
	}else{
		$gender = "Female";	
	}
	
	mysql_free_result($result);
	
?>
<link rel="stylesheet" href="css/docs.css" />

<div class="row">

      <div class="large-6 large-centered columns">
      
<?php if(!isset($_POST['update'])){ ?>    
  
      <h2>Staff Update</h2>
      <h4 class="subheader">Click Update button to update your details</h4>
        


  <form class="custom" action="staff_update.php" method="post">
          <fieldset>
            <legend>Staff Update Form</legend>
            
<div class="row">
                <div class="large-12 column">
                    <label for="staffID">Staff ID</label> 
                    <input type="text" id="id" value="<?php echo $ID; ?>" name="id" disabled>
  
                </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="Username">Staff Name</label> 
                    <input type="text" id="name" value="<?php echo $name; ?>" name="name" disabled>
  
               </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="gender">Staff Gender</label> 
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
                <label for="IC">Identity Card Number(IC)</label>
                <input type="text" id="ic" value="<?php echo $ic ?>" disabled>
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
                <label for="Position">Position</label>
                <input type="text" id="position" value="<?php echo $pos  ?>" disabled>
              </div>
</div>

    
           
            <div class="row">
              <div class="small-3 small-centered columns">
                <button type="submit" name="update" id="button1" class="medium button green" ><?php echo $btnName; ?></button>
              </div>
            </div>

          </fieldset>
        </form>
   </div>
 </div>
<?php }else{
$btnName = 'Submit';
?>
 	  <h2>Staff Update</h2>
      <h4 class="subheader">Click Submit button to update your details</h4>
      
<form class="custom" action="update.php?staffID=<?php echo $ID; ?>" method="post" data-abide>
          <fieldset>
            <legend>Staff Update Form</legend>

<div class="row">
                <div class="large-12 column">
                    <label for="staffID">Staff ID</label> 
                    <input type="text" id="id" value="<?php echo $ID; ?>" name="id" disabled>
  
                </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="Username">Staff Name</label> 
                    <input type="text" id="name" placeholder="<?php echo $name; ?>" name="name" required>
  
               </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="gender">Staff Gender</label> 
                    <input type="text" id="gender" value="<?php echo $gender; ?>"  disabled>
  
               </div> 
</div>

<div class="row">
              <div class="large-12 columns">
                <label for="phone">Contact Phone Number</label>
                <input type="tel" id="phone" placeholder="<?php echo $hp ?>" name="hp" required>
              </div>
</div>
            
<div class="row">
              <div class="large-12 columns">
                <label for="IC">Identity Card Number(IC)</label>
                <input type="text" id="ic" value="<?php echo $ic ?>" disabled>
              </div>
</div>

<div class="row">
              <div class="large-12 columns">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="<?php echo $email ?>" name="email" required>
              </div>
</div>
      
<div class="row">
              <div class="large-12 columns">
                <label for="Position">Position</label>
                <input type="text" id="position" value="<?php echo $pos  ?>" disabled>
              </div>
</div>
           
            <div class="row">
              <div class="small-3 small-centered columns">
                <button type="submit" name="submitStaff" class="medium button green"><?php echo $btnName; ?></button>
              </div>
            </div>

          </fieldset>
        </form>
	
      </div>
    </div>

<?php 
	}
	include '../Main/footer.php';
	}
 ?>