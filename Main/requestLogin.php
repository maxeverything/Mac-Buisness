
<?php
	session_start();
	
	if(!isset($_SESSION['id'])){
		if($_SESSION['id'][0]!='M'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in as member"); 
		    }
		</script>	
		<?php
		}
	}
?>