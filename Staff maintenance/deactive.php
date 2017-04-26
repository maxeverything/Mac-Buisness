<?php
			
	if(isset($_POST['submit_delete'])){
			require_once('../sql/opendb.php');
			$sID = empty($_POST['staffID']) ? die ("ERROR: No data found") : mysql_real_escape_string($_POST['staffID']);
			
			$delete_query = "UPDATE staffs 
							 SET staffStatus = 'FREEZE'
							 WHERE staffID='$sID'";
			
			$result = mysql_query($delete_query) or die('Error query '.mysql_error());
			
			$query = "SELECT email
					  FROM staffs
					  WHERE staffID='$sID'";
			
			$result = mysql_query($query)or die('Get email '.mysql_error());
			
			$row = mysql_fetch_row($result);
			
			include '../CRM module/mail_reg_member.php';
			$message = "Your account have been deactive. Anything please email to us.";

			sendTo($row[0],$message);
		?>
        <script src="../js/script.js"></script>
		<script>
            window.onload = function() {
				window.location.replace("staff_delete.php");
				alert( "Staff Delete Success" ); 
            }
        </script>
		<?php 
	}
	?>