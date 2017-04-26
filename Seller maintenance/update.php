<?php
	require_once '../sql/opendb.php';
	
	$sID = $_GET['sellerID'];
			
	if(isset($_POST['Submitseller'])){
		if($sID != null){
			$name = empty($_POST['name']) ? die ("ERROR: Enter a name") : mysql_real_escape_string($_POST['name']);
			$email = empty($_POST['email'])? die ("ERROR: Enter a email") : mysql_real_escape_string($_POST['email']);;
			$hp = empty($_POST['hp']) ? die ("ERROR: Enter a hp") : mysql_real_escape_string($_POST['hp']);

			$update_query = "UPDATE sellers SET contact='$hp',email='$email',sellerName='$name' WHERE sellerID='$sID'";
		
			$result = mysql_query($update_query) or die('Error update query '.mysql_error());
			
		}
		?>
        <script src="../js/script.js"></script>
		<script>
            window.onload = function() {
				window.location.replace("seller_update.php");
				alert( "Seller Update Success" ); 
            }
        </script>
		<?php 
	} 
	?>