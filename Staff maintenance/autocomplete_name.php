<?php

require_once('../sql/opendb.php');

$query = "SELECT staffName 
		  FROM staffs
		  WHERE staffName like '%".$term."%'";

$result = mysql_query($query) or die(mysql_error());

$data = array();
while($row = mysql_fetch_row($result)){
	$data[] =  array('value' => $row[0]);
}

echo json_encode($data);
flush();
?>
