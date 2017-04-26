<?php
include '../main/authorization.php';
if(checkMember($_SESSION['id'])==TRUE){
include '../Main/header.php';
?>
<script type="text/javascript" async src="../js/ga.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<div class="large-3 columns">
			<?php
			include 'personalSideMap.php';
			?>
		</div>
		<div class="large-9 columns">
			
			<?php
			include '../feedback/fFeedback.php';
			$resultPersonalFeedback = feedback::getPersonalFeedback($_SESSION['id']);
			foreach ($resultPersonalFeedback as $product => $value) {
				foreach ($value as $time => $name) {
					?>
					<div class="row">
				<div class="large-12 small-12 columns panel">				
					<p>You have commented on <a href="../product/OrderProduct.php?product=<?php echo $product; ?>"><?php echo $name; ?></a> at <small><?php echo $time; ?></small></p>
				</div>
			</div>
					
					<?php
					}
					}
			?>
		</div>
	</div>
	<!-- End Side Bar -->

	<!-- Thumbnails -->

	<!-- End Thumbnails -->

</div>
<!-- Footer -->
<?php include '../Main/footer.php';
}
?>
