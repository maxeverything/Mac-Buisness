<?php
	require('../sql/opendb.php');
	
	function matchEmail($email){
		$query = "SELECT email
				  FROM sellers
				  WHERE email='$email'";
		
		$result = mysql_query($query)or die('Sql Error '.mysql_error());
		
		if(mysql_num_rows($result)>0){
			return true;
			
		}else{
			$query = "SELECT email
				  FROM staffs
				  WHERE email='$email'";
				  
			$result = mysql_query($query)or die('Sql Error '.mysql_error());
			
			if(mysql_num_rows($result)>0){
				return TRUE;
				
			}else{
				$query = "SELECT email
				  FROM members
				  WHERE email='$email'";
				  
				$result = mysql_query($query)or die('Sql Error '.mysql_error());
				
				if(mysql_num_rows($result)>0){
					return true;
				}else{
					return FALSE;
				}
			}
			
		}			
	}
	
?>