<?php

if(isset($_POST['btnDeactive'])){
	include '../sql/opendb.php';
	$deactive_id = empty($_POST['deactive_id']) ? die ("ERROR: No data found") : mysql_real_escape_string($_POST['deactive_id']);
	
	$query = "UPDATE members
			  SET memberStatus = 'Freeze'
			  WHERE memberID='$deactive_id'";
	
	$result = mysql_query($query)or die(mysql_error());
	
	if($result==TRUE){
?>
<script>
            window.onload = function() {
				window.location.replace("../Staff Maintenance/Deactive_member_list.php");
				alert( "Member Delete Success" ); 
            }
        </script>
<?php		
	}
}
?>