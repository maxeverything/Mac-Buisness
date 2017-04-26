<?php 
include '../main/authorization.php';
if(checkManagerAndStaff($_SESSION['id'])==TRUE){
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
	<h1 class="subheader"><u>Delete Seller</u></h1>
</div>
	<div class="large-6 large-centered columns">
    <form class="custom" action="seller_delete.php" method="post" data-abide>
      <label for="username">Enter Seller name</label> 
      <input type="text" id="name" name="name" placeholder="Name list from Databse (autocomplete)" required/>
      
          <div class="row">
                  <div class="small-3 small-centered columns">
                    <button type="submit" name="show" id="button1" class="medium button green" >Show details</button>
                  </div>
          </div>            
    </form>
    </div>
<?php }else {
	require_once '../sql/opendb.php';
	$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
	
	
	
	$query = "SELECT *  
			  FROM sellers
			  WHERE sellerName='$name'";
	
	$result = mysql_query($query) or die(mysql_error());
	
	if(mysql_num_rows($result)>0){
		while($data = mysql_fetch_row($result)){
			$id = $data[0];
			$ic = $data[2];
			$email = $data[3];
			$hp = $data[4];
			$regDate = $data[5];
			$status = $data[6];
			$comName = $data[7];
		}
	}else{
?>

<script src="../js/script.js"></script>
	<script>
       window.onload = function() {
			alert( "Seller No Found!!" ); 
			window.location.replace("seller_delete.php");
       }
	</script>
    
<?php
	}

?>
	<div class="large-8 large-centered columns">
    	<form class="custom" method="POST" onsubmit="return confirm('Are you sure you want to deactive this seller?');" action='deactive.php'>
        	<fieldset>
            <legend>Seller Details</legend>

<div class="row">
        <div class="large-12 column">
            <label for="id">Seller ID <small>Display</small></label>
            <input type="text" value="<?php echo $id; ?>" disabled="">
            <input type="hidden" value="<?php echo $id; ?>" name="sellerID">    
        </div>
        <div class="large-12 columns">
        	<label for="name">Seller Name <small>Display</small></label>
         	<input type="text" value="<?php echo $name; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="email">Seller email <small>Display</small></label>
         	<input type="text" value="<?php echo $email; ?>" disabled> 
        </div>
        <div class="large-12 columns">
            <label for="ic">Seller Identities No <small>Display</small></label>
         	<input type="text" value="<?php echo $ic; ?>" disabled> 
        </div>
        <div class="large-12 columns">
            <label for="contact">Seller Contact <small>Display</small></label>
         	<input type="text" value="<?php echo $hp; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="status">Seller Status <small>Display</small></label>
         	<input type="text" value="<?php echo $status; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="regdate">Register Date <small>Display</small></label>
         	<input type="text" value="<?php echo $regDate; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="comName">Company Name<small>Display</small></label>
         	<input type="text" value="<?php echo $comName; ?>" disabled>
        </div>
</div>
<div class="row">
 <div class="small-3 small-centered columns">
     <button type="submit" name="submit" class="medium button green">De-Activate</button>
 </div>
</div> 
   		<fieldset>
	</form>
    </div>
</div>

<?php }
include '../Main/footer.php';
}
?>
