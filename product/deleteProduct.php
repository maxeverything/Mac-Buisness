<?php
include_once '../sql/config.php';
include_once '../sql/opendb.php';

	if(isset($_REQUEST['deleteProduct']))
	{		
		$id=mysql_real_escape_string($_REQUEST['id']);
		$query1=mysql_query("Upadate Products set product_status='DEACTIVATE'  where id=$id");
	}
?>