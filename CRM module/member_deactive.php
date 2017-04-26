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
	<h1 class="subheader"><u>Deactive members</u></h1>
</div>
	<div class="large-6 large-centered columns">
    <form class="custom" action="member_deactive.php" method="post" data-abide>
      <label for="username">Enter member name</label> 
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
			  FROM members
			  WHERE userName='$name'";
	
	$result = mysql_query($query) or die(mysql_error());
	
	if(mysql_num_rows($result)>0){
		while($data = mysql_fetch_row($result)){
			$id = $data[0];
			$point = $data[7];
			$email = $data[3];
			$hp = $data[4];
			$regDate = $data[6];
			$status = $data[5];
			$profile = $data[9];
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
    	<form class="custom" method="POST" onsubmit="return confirm('Are you sure you want to deactive this member?');" action='deactive.php'>
        	<fieldset>
            <legend>Member Details</legend>

<div class="row">
		<div class="large-12 columns">
         	<img src="../personal/<?php echo $profile;  ?>" style="width: 80px;height:90px; border: solid black 1.5px"/>
        </div>
        <div class="large-12 column">
            <label for="id">Member ID <small>Display</small></label>
            <input type="text" value="<?php echo $id; ?>" disabled>
            <input type="hidden" value="<?php echo $id; ?>" name="memberID">    
        </div>
        <div class="large-12 columns">
        	<label for="name">Member Name <small>Display</small></label>
         	<input type="text" value="<?php echo $name; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="email">Member email <small>Display</small></label>
         	<input type="text" value="<?php echo $email; ?>" disabled> 
        </div>
        <div class="large-12 columns">
            <label for="ic">Point <small>Display</small></label>
         	<input type="text" value="<?php echo $point; ?>" disabled> 
        </div>
        <div class="large-12 columns">
            <label for="contact">Member Contact <small>Display</small></label>
         	<input type="text" value="<?php echo $hp; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="status">Member Status <small>Display</small></label>
         	<input type="text" value="<?php echo $status; ?>" disabled>
        </div>
        <div class="large-12 columns">
            <label for="regdate">Register Date <small>Display</small></label>
         	<input type="text" value="<?php echo $regDate; ?>" disabled>
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
include '../Main/footer.php' ;
}
?>
