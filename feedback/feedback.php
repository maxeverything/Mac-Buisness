<?php
session_start();
include '../sql/config.php';
include '../sql/opendb.php';
if (isset($_REQUEST['btnfeedback'])) {
	if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		$productID = mysql_real_escape_string($_REQUEST['txtProduct']);
		$detail = mysql_real_escape_string($_REQUEST['txtfeedback']);
		$feedbackBy = mysql_real_escape_string($_SESSION['id']);
		$query_feedback = mysql_query("Insert into feedback (productID,feedbackBy,feedbackDateTime,commentDetails) VALUES('$productID','$feedbackBy',Now(),'$detail')") or die('Error');
	} else {
		echo 'error';
	}
}

?>