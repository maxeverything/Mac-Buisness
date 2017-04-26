<?php
session_start();
include_once 'fFeedback.php';
include_once '../Function/fPersonalInformation.php';
if($_GET){
	$pro_id=$_GET['product'];

	$result_feedback=feedback::getFeedback($pro_id);
		while($row_feedback=mysql_fetch_array($result_feedback,MYSQL_ASSOC)){					
?>
    <hr>
    <div class="row">
    	<div class="small-3 large-3 columns">
    		<img src="../personal/<?php echo $row_feedback['Profile_pic']?>" />
    	</div>
    	<div class="small-9 large-9 columns">
    		<div class="row">
    			<?php
    if(isset($_SESSION['id']) && $_SESSION['id'][0]=='S'){
    ?>
    
    <a class="right btnDelete" title="Delete" href="<?php echo $row_feedback['feedbackID']; ?>">| &#215;</a>
    <a class="right btnWarning" title="Warning User" dir="<?php echo user_profile::getEmail($row_feedback['feedbackBy']); ?>" href=" ">Send Warning latter</a>
    <?php
	}
    ?>
    			 <label><a dir="<?php echo $row_feedback['feedbackBy']; ?>" href=" " class="btnProfileDetail" data-reveal-id="modelProfile" data-reveal-ajax="true""><?php echo $row_feedback['Name']; ?></a>(<?php echo $row_feedback['feedbackType']?>)</label> <small class="subheader"><?php echo $row_feedback['feedbackDateTime']; ?></small>		
    		</div>
    		
    		<div class="row">
    			
    <div class=" small-11 large-11 panel">
    	<p><?php echo $row_feedback['commentDetails']; ?></p>
    </div>
    		</div>
    		
    	</div>
    </div>
   
    
    
<?php
		}
	}
?>
