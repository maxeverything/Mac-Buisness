
<?php 
include '../main/authorization.php';
if(checkSeller($_SESSION['id'])==TRUE){
	include '../Main/header.php'; 
	$btnName = 'Update';
	$id = $_SESSION['id'];
	require_once '../sql/opendb.php';
	
	$query = "SELECT *
			  FROM sellers
			  WHERE sellerID='$id'";
	$result = mysql_query($query) or die('Error in query'.mysql_error());
	
	if($rows = mysql_fetch_row($result)){
		$ID = $rows[0];
		$name = $rows[1];
		$hp = $rows[4];
		$ic = $rows[2];
		$email = $rows[3];
		$regDate = $rows[5];
		$comName = $rows[7];
	}
	
	mysql_free_result($result);
	
?>
<link rel="stylesheet" href="css/docs.css" />

<div class="row">

      <div class="large-6 large-centered columns">
      
<?php if(!isset($_POST['update'])){ ?>    
  
      <h2>Seller Update</h2>
      <h4 class="subheader">Click Update button to update your details</h4>
        


  <form class="custom" action="seller_update.php" method="post">
          <fieldset>
            <legend>Seller Update Form</legend>
            
<div class="row">
                <div class="large-12 column">
                    <label for="SellerID">Seller ID</label> 
                    <input type="text" id="id" value="<?php echo $ID; ?>" name="id" disabled>
  
                </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="Username">Seller Name</label> 
                    <input type="text" id="name" value="<?php echo $name; ?>" name="name" disabled>
  
               </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="comName">Company Name</label> 
                    <input type="text" id="comName" value="<?php echo $comName; ?>" name="comName" disabled>
  
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
                <label for="regdate">Register Date</label>
                <input type="text" id="regDate" value="<?php echo $regDate  ?>" disabled>
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
      
<form class="custom" action="update.php?sellerID=<?php echo $ID; ?>" method="post" data-abide>
          <fieldset>
            <legend>Staff Update Form</legend>

<div class="row">
                <div class="large-12 column">
                    <label for="SellerID">Seller ID</label> 
                    <input type="text" id="id" value="<?php echo $ID; ?>" name="id" disabled>
  
                </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="Username">Seller Name</label> 
                    <input type="text" id="name" placeholder="<?php echo $name; ?>" name="name" required>
  
               </div> 
</div>

<div class="row">
               <div class="large-12 column">
                    <label for="gender">register Date</label> 
                    <input type="text" id="gender" value="<?php echo $regDate; ?>"  disabled>
  
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
                <label for="Position">Company Name</label>
                <input type="text" id="comName" value="<?php echo $comName  ?>" disabled>
              </div>
</div>
           
            <div class="row">
              <div class="small-3 small-centered columns">
                <button type="submit" name="Submitseller" class="medium button green"><?php echo $btnName; ?></button>
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