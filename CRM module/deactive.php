<?php
			
	if(isset($_POST['submit'])){
			require_once('../sql/opendb.php');
			$mID = empty($_POST['memberID']) ? die ("ERROR: No data found") : mysql_real_escape_string($_POST['memberID']);

			$delete_query = "UPDATE members 
							 SET memberStatus = 'FREEZE'
							 WHERE memberID='$mID'";
		
			$result = mysql_query($delete_query) or die('Error query '.mysql_error());
			
			$query = "SELECT email
					  FROM members
					  WHERE memberID='$mID'";
			
			$result = mysql_query($query)or die('Get email '.mysql_error());
			
			$row = mysql_fetch_row($result);
			
			include 'mail_reg_member.php';
			$message = "Your account have been deactive. Anything please email to us.";

			sendTo($row[0],$message);
		?>
        <script src="../js/script.js"></script>
		<script>
            window.onload = function() {
				window.location.replace("member_deactive.php");
				alert( "member Delete Success" ); 
            }
        </script>
		<?php 
	}
	?>