<?php
session_start();
include '../main/header.php';


if(isset($_POST['btnSubmit'])){
	$num = $_POST['txtVal'];
	include '../sql/openDb.php';
	
	$query = "INSERT INTO alertQuantity
			  (sellerID,quantity)
			  VALUES
			  ('".$_SESSION['id']."','$num')";
	
	$result = mysql_query($query)or die(mysql_error());
	
	if($result==TRUE){
	?>
		<script>
				window.onload = function() {
					 alert("Update Alert for unitsInStock Success \n Alert Only if UnitsInStock is less than <?php echo $num; ?>.");
					 window.location.replace("../home/homepage.php");
				}
		</script>
	<?php
	}else{
	?>
		<script>
				window.onload = function() {
					 alert("Error Occurs. Update Fail");
					 window.location.replace("adjustAlertQuantity.php");
				}
		</script>
	<?php
	}
}
?>
<div class="row">
	<h2>Change Alert for Units In Stock</h2>
	<div class="large-6 large-centered columns">
		<form action="adjustAlertQuantity.php" method="POST" data-abide>
			<div>Enter Value for Alert if UnitsInStock is less than<small>Default is 100</small></div>
			<div><input type="text" name='txtVal' required pattern="\d*" placeholder="Value must be Integer"></div>
			<div class="row">
				<div class="small-4 small-centered columns">
					<button type="submit" name='btnSubmit'>Submit</button>
				</div>
			</div>
			
		</form>
	</div>
</div>
<?php include '../main/footer.php';
?>