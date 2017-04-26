<?php
session_start();
function checkStaff($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='S'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in as Staff"); 
		    }
		</script>	
		<?php
			return false;
		}
		return TRUE;
	}
} 

function checkSeller($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='R'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in as seller"); 
		    }
		</script>	
		<?php
			return false;
		}
		return TRUE;
	}
} 

function checkMember($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='M'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in as member"); 
		    }
		</script>	
		<?php
			return false;
		}
		return true;
	}
}

function authetication(){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
			return false;
	}else{
		return TRUE;
	}
}

function checkSellerAndStaff($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='S' && $_SESSION['id'][0]!='R'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "You have no permission to enter this page"); 
		    }
		</script>	
		<?php
			return false;
		}
		return TRUE;
	}
} 

function checkManager($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='G'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Only Manager can access this page"); 
		    }
		</script>	
		<?php
			return false;
		}
		return TRUE;
	}
} 

function checkManagerAndStaff($id){
	if(!isset($_SESSION['id'])){
		$_SESSION['id'] = NULL;
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "Please log in"); 
		    }
		</script>	
		<?php
		
	}else{
		if($_SESSION['id'][0]!='S' && $_SESSION['id'][0]!='G'){
		?>
		<script>
		    window.onload = function() {
				window.location.replace("../loginpage/loginpage.php");
				alert( "You have no permission to enter this page"); 
		    }
		</script>	
		<?php
			return false;
		}
		return TRUE;
	}
} 

?>