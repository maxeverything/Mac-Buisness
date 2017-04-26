<?php 
include '../Main/header.php';
?>
<link rel="stylesheet" href="../css/docs.css">
<script type="text/javascript" async src="../js/ga.js"></script>
<script type="text/javascript">
	window.onload = function() {
		document.getElementById("comfirmPassword").onchange = validatePassword;
	}
	function validatePassword() {
		var passC = document.getElementById("comfirmPassword").value;
		var passN = document.getElementById("newPassword").value;
		if (passN != passC)
			document.getElementById("comfirmPassword").setCustomValidity("Passwords Don't Match");
		else
			document.getElementById("comfirmPassword").setCustomValidity('');
		//empty string means no validation error
	}
</script>

<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<div class="large-3 columns">
			<?php
			include 'personalSideMap.php';
			?>
		</div>
		<div class="large-9 columns">
			<form id="frmPasswordReset" class="custom" data-abide action="hrefPersonalInformation.php" method="post" data-invalid="">

				<label for="currentPassword">Current Password</label>
				<input name="currentPassword" id="currentPassword" type="password" placeholder="Current Password" required>

				<label for="newPassword">New Password</label>
				<input type="password" id="newPassword" placeholder="New Password" name="newPassword" required>

				<label for="comfirmPassword">Comfirm Password</label>
				<input type="password" id="comfirmPassword" placeholder="Comfirm Password" name="comfirmPassword" required>

				<button type="submit" id="submitNewPassword" name="submitNewPassword" class="medium button green">
					Save Change
				</button>
			</form>
		</div>
	</div>
	<!-- End Side Bar -->

	<!-- Thumbnails -->

	<!-- End Thumbnails -->

</div>
<!-- Footer -->
<?php include '../Main/footer.php'
?>