<?php
include '../sql/config.php';
include '../sql/opendb.php';

		$name = mysql_real_escape_string($_GET['term']);
		
		$query="SELECT ProductName FROM products WHERE ProductName LIKE '%$name%' ";
		if(isset($_SESSION['shop'])){
			$shop=mysql_real_escape_string($_SESSION['shop']);
			$query.=" AND shopid='$shop' ";
		}
		$query.=" LIMIT 5";
		$result = mysql_query($query)or die('Error');

		$data = array();
		while ($row = mysql_fetch_row($result)) {
			$data[] = array('value' => $row[0]);
		}

		echo json_encode($data);
		flush();
		?>