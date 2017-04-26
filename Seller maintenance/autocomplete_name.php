<?php

$term = mysql_real_escape_string($_GET['term']);

require_once '../sql/opendb.php';

$query = "SELECT sellername 
		  FROM sellers
		  WHERE sellerName like '%".$term."%' AND sellerName !='OWN'";

$result = mysql_query($query) or die(mysql_error());

$data = array();
while($row = mysql_fetch_row($result)){
	$data[] =  array('value' => $row[0]);
}

echo json_encode($data);
flush();

