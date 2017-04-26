<?php
include '../main/authorization.php';
if(checkMember($_SESSION['id'])==TRUE){
ob_start();
include '../Main/header.php';
	 ?>
<script type="text/javascript" async src="../js/ga.js"></script>
<div class="row">
  <!-- Side Bar -->
  <div class="large-12 small-12 columns">
  	<div class="large-3 columns">
  		<?php
  		include 'personalSideMap.php';
  		?>
  	</div>
  	<div class="large-9 columns">
  		<?php  
	$btnName ='Update';
	 include '../Function/fPersonalInformation.php';
		 
	$row_User=user_profile::getMember();
	$id = $row_User['memberID'];
	$name = $row_User['userName']; 
	$gender=user_profile::getGender($row_User['gender']); 
	$email=$row_User['email']; 
	$hp = $row_User['contact'];
	$point= $row_User['pointAcc']; 
	$regDate = $row_User['registerDate'];
	$profilePic = $row_User['Profile_pic'];
	
	if(isset($_POST['submitMember'])){
		If($_POST['id']){
			$ID = mysql_real_escape_string($_POST['id']);			
			$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
			
			$hp = empty($_POST['phone']) ? die ("ERROR: Enter a hp") : mysql_real_escape_string($_POST['phone']);
			$gender=empty($_POST['gender']) ? die ("ERROR: Select a gender") : mysql_real_escape_string($_POST['gender']);
			$update_query = "UPDATE members SET contact='$hp',userName='$name', gender='$gender'  WHERE memberID='$ID'";
		
			$result = mysql_query($update_query) or die('Error update query '.mysql_error());
			
			header("location:personal_profile.php");
			exit;
		}
	}elseif(isset($_POST['update'])){
	$btnName = 'Submit';
?>
<script type="text/javascript" src="../js/jquery.wallform.js"></script>
<script>	
	$(document).ready(function(e) {		
		//$('#p2,#p3').hide();
		$('#photoimg').die('click').live('change', function()			{ 
			    
				$("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
					$('#preview').text('');
					console.log('v');
					$("#imageloadstatus").show();
					 $("#imageloadbutton").hide();
					 }, 
					success:function(){ 
					console.log('z');
					 $("#imageloadstatus").hide();
					 $("#imageloadbutton").show();
					}, 
					error:function(){ 
							console.log('d');
					 $("#imageloadstatus").hide();
					$("#imageloadbutton").show();
					} }).submit();				
		
			});	
		$("#preview").on('click','#btnDelete',function(e){
			e.preventDefault();
			$btn=$(this);
			$field=$(this).parent().parent().children('#divImg').children('img');	
			$.ajax({
					type: "GET",
					url: "hrefPersonalInformation.php?deleteProfilePic",
					data: {image:$field.attr('src')},
					dataType : 'json',
					success: function(msg) {
						// Message Sent - Show the 'Thank You' message and hide the form							
						if(msg.status == "1") {
							$btn.remove();
				            $field.attr('src','profilePic/default.jpg')
						}else{
							alert('Unable to delete'+msg);
						}
					}
			});
			
        });
		});
		
		
</script>
 	  <h2>Member Update</h2>
      <h4 class="subheader">Click Submit button to update your details</h4>
      
          <fieldset>
            <legend>Member Update Form</legend>
			
			
<form id="imageform" method="post" action='ajaximage.php'>
Upload your image 
<div id='imageloadstatus' style='display:none'><img src="../images/loader.gif" alt="Uploading...."/></div>
<div id='imageloadbutton'>
	<input type="file" name="photoimg" id="photoimg" />
</div>
</form>

<form class="custom" action="personal_profile.php" method="post" data-abide>
    <div id="row">
        <div class="small-12 large-12  columns">
                	<div class="small-4 large-4  columns">
                    	<p>Image</p>
                    </div>
                    <div class="small-2 large-2  columns">
                    	<p>Delete</p>
                        
                    </div>
                </div>
            </div>
            
	<div id='preview'>
    	<div class="row">
			<div class="small-12 large-12 columns">
				<div class="small-4 large-4  columns" id="divImg">
					<img id='lblImage' src="<?php echo $profilePic; ?>" title=''  class='preview'>
				</div>
			<div class="small-2 large-2  columns">
				<?php
				if($profilePic!="profilePic/default.jpg"){
				?>
		<a id="btnDelete" href=" ">Click</a>
		<?php
		}?>
		</div></div></div>
	</div>			
			
			
			
			
			
<div class="row">
                <div class="large-12 column">
                    <label for="name">Member Name</label>
                    <input type="text" id="name" value="<?php echo $name; ?>" name="name" required>
  
                </div> 
</div>

<div class="row">
              <div class="large-12 columns">
                <label for="phone">Contact Phone Number</label>
                <input type="tel" id="phone" value="<?php echo $hp; ?>" name="phone" required>
              </div>
</div>
            

<div class="row">
              <div class="large-12 columns">
                <label for="email">Email</label>
                <label type="email" id="email"><?php echo $email; ?></label>
              </div>
</div>
      
<div class="row">
              <div class="large-12 columns">
                <fieldset>
              <legend>Gender</legend>          
              
              <label for="radio1"><input name="gender" type="radio"  checked="" value="M" class="hidden-field">
              <span class="custom radio checked"></span> Male</label>
              <br/>
              <label for="radio2"><input name="gender" type="radio"  value="F" class="hidden-field">
              <span class="custom radio"></span> Female</label>
              </fieldset>
              </div>
</div>

<div class="row">
              <div class="large-12 columns">
                <label>Current Point</label>
                <p><?php echo $point; ?></p><hr/>                
              </div>
</div>
<div class="row">
              <div class="large-12 columns">
                <label>regDate</label>
                <p><?php echo $regDate ; ?><hr /></p>
              </div>
</div>
      
           
            <div class="row">
              <div class="small-12 small-centered columns">
              	<input type="hidden" value="<?php echo $id; ?>" name="id"/>
                <button type="submit" name="submitMember" class="medium button green"><?php echo $btnName; ?></button>
                
              </div>
            </div>

          </fieldset>
        </form>
	
      </div>
    </div>

<?php
	}else{
	
?>    
  
      <h2>Member Update</h2>
      <h4 class="subheader">Click Update button to update your details</h4>
        


  <form class="custom" action="personal_profile.php" method="post">
          <fieldset>
            <legend>My Account</legend>
<div class="row">
                <div class="large-3 large-centered column">
                    <img src="<?php echo $profilePic; ?>" style="width: 350px;height: 150px;border-color:black;border-style: solid; border-width: 2px;" />
                </div> 
</div>
<br/>
<div class="row">
                <div class="large-12 column">
                    <label>Member Name</label> 
                    	<p><?php echo $name; ?></p><hr />
                </div> 
</div>

<div class="row">
              <div class="large-12 columns">
                <label>Contact Phone Number</label>
                <p>
                	<?php echo user_profile::getContact($hp); ?>
                </p><hr />
              </div>
</div>
            

<div class="row">
              <div class="large-12 columns">
                <label for="email">Email</label>
                <p>
                	<?php echo $email; ?>
                </p><hr />
              </div>
</div>
      

<div class="row">
              <div class="large-12 columns">
                <label>Gender </label>
                <p><?php echo $gender;  ?></p><hr />
              </div>
</div>


<div class="row">
              <div class="large-12 columns">
                <label>Current Point</label></label>
                <p><?php echo $point; ?></p><hr/>                
              </div>
</div>
<div class="row">
              <div class="large-12 columns">
                <label>regDate</label>
                <p><?php echo $regDate;  ?><hr /></p>
              </div>
</div>
    
           
            <div class="row">
              <div class="small-12 small-centered columns">
                <button type="submit" name="update" id="button1" class="medium button green" value="123"><?php echo $btnName; ?></button>
              </div>
            </div>

          </fieldset>
        </form>
    </div>
  </div>
  
<?php }
?>
              
              
    </div>

</div>
</div>
    <!-- Footer -->


  <script src="../js/foundation/foundation.section.js"></script>
  <!-- Other JS plugins can be included here -->
<?php include '../Main/footer.php';
ob_flush();
}
 ?>