<?php
include '../Function/fPersonalInformation.php';
$row_User=user_profile::getMemberDetail($_REQUEST['id']);	
?>
         <fieldset>
            <legend><?php echo $row_User['name'];?>(<?php  echo $row_User['type'];?>)</legend>
            <div class="row">
            	<div class="large-4 small-4 columns">
                    <img src="../personal/<?php echo $row_User['Profile_pic']; ?>" style="width: 75px;height: 100px;border-color:black;border-style: solid; border-width: 2px;" />
  
            	</div>
            	<div class="large-8 small-8 columns">
            		<div class="large-12 row">
            			 <label>Name</label> 
                    	<p><?php echo $row_User['name']; ?></p><hr />
            		</div>
            		<div class="large-12 row">
            			<label>Contact Phone Number</label>
                <p>
                	<?php echo user_profile::getContact($row_User['contact']); ?>
                </p><hr />
            		</div>
            	</div>
            </div>

</fieldset>
<a class="close-reveal-modal">&#215;</a>