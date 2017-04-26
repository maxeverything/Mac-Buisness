<?php
include '../sql/config.php';
include '../sql/opendb.php';

		$name = mysql_real_escape_string($_GET['term']);
		
		$query="SELECT userName FROM members WHERE userName LIKE '%$name%' ";
		$query.=" LIMIT 5";
		$result = mysql_query($query)or die('Error');

		$data = array();
		while ($row = mysql_fetch_row($result)) {
			$data[] = array('value' => $row[0]);
		}

		echo json_encode($data);
		flush();
		?>