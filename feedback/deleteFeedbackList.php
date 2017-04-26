<?php
include_once 'fFeedback.php';

if($_GET){
	$pro_id=$_GET['product'];

	$result_feedback=feedback::getFeedback($pro_id);
		while($row_feedback=mysql_fetch_array($result_feedback,MYSQL_ASSOC)){					
?>
    <hr>
    <label><a><?php echo $row_feedback['Name']; ?></a>(<?php echo $row_feedback['feedbackType']?>)</label> <small class="subheader"><?php echo $row_feedback['feedbackDateTime']; ?></small>
    <a class="right btnDelete" title="Delete" onclick="return confirm('Delete this?');" href="../feedback/hrefFeedback.php?btnDeletefeedback=&feedbackid=<?php echo $row_feedback['feedbackID']; ?>">&#215;</a>
    <div class="panel">
    	<p><?php echo $row_feedback['commentDetails']; ?></p>
    </div>
<?php
		}
	}
?>