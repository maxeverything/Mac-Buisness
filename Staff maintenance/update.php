<?php
	require_once '../sql/opendb.php';
	
	$sID = $_GET['staffID'];
			
	if(isset($_POST['submitStaff'])){
		if($sID != null){
			$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
			$email = empty($_POST['email'])? die ("ERROR: Enter a email") : mysql_real_escape_string($_POST['email']);;
			$hp = empty($_POST['hp']) ? die ("ERROR: Enter a hp") : mysql_real_escape_string($_POST['hp']);

			$update_query = "UPDATE staffs SET contact='$hp',email='$email',staffName='$name' WHERE staffID='$sID'";
		
			$result = mysql_query($update_query);
			
			if($result ==TRUE){
				
		}
		?>
        <script src="js/script.js"></script>
		<script>
            window.onload = function() {
				window.location.replace("staff_update.php");
				alert( "Staff Update Success" ); 
            }
        </script>
		<?php 
		}else{
		?>
		<script>
            window.onload = function() {
				window.location.replace("staff_update.php");
				alert( "UserName is used by other" ); 
            }
        </script>
			
		<?php
		}
	} 
	?>