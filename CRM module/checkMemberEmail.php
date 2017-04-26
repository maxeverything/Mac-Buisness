<?php
	require('../sql/opendb.php');
	
	function matchEmail($email){
		$query = "SELECT email
				  FROM members
				  WHERE email='$email'";
		
		$result = mysql_query($query)or die('Sql Error '.mysql_error());
		
		if(mysql_num_rows($result)>0){
			return true;
		}else{
			return false;
		}			
	}
?>