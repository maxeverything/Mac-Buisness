<?php
include '../main/authorization.php';
if(checkMember($_SESSION['id'])==TRUE){
include '../Main/header.php';
?>
<script>
	$(document).ready(function() {
		$('.btnAdd').click(function() {
			$AddressId = $(this).attr("dir");
			$("#modalUpdateAddr").load("updateAddressForm.php?addressID=" + $AddressId + window.location.search);
			$('#modalUpdateAddr').foundation('reveal', 'open');
		});
	});

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
			<div class="row">
				<div class="large-12 small-12 columns">
					<button data-reveal-id="modalAddNew" data-reveal-ajax="" class="" title="">
						Add Address
					</button>
				</div>
			</div>
			<div id="modalUpdateAddr" class="reveal-modal"></div>
			<div id="modalAddNew" class="reveal-modal">
				<form id="frmAddNew" class="custom" action="hrefPersonalInformation.php" method="post" data-abide>
					<fieldset>
						<legend>
							Add New Address
						</legend>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtAddress">Address<small>(require)</small></label>
								<textarea id="txtAddress" placeholder="Example: 9, jln ABC, tmn ABC" name="txtAddress" required></textarea>													
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtCity">City<small>(require)</small></label>
								<input type="text" id="txtCity" placeholder="Example: Petaling Jaya" name="txtCity" required>

							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtRegion">Region<small>(require)</small></label>
								<input type="text" id="txtRegion" placeholder="Example: Johor" name="txtRegion" required>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtPostcode">Postcode<small>(require)</small></label>
								<input type="text" id="txtPostcode" placeholder="53800" name="txtPostcode" required  pattern="[0-9]{5,12}">
							</div>
						</div>

						<div class="row">
							<div class="large-12 small-centered columns">
								<button type="submit" id="submitNewAddr" name="submitNewAddr" class="medium button green">
									Save
								</button>
								<button type="button" id="btnCancel" name="btnCancel" class="medium button green close-reveal-modal">
									Cancel
								</button>
								<button type="reset" id="btnClear" name="btnClear" class="medium button green close">
									Clear
								</button>
							</div>
						</div>
					</fieldset>
				</form>
				<a class="close-reveal-modal">&#215;</a>
			</div>
			<?php
			include '../Function/fPersonalInformation.php';
			$result_Addr=user_profile::getAddress();
			while($row_Addr=mysql_fetch_array($result_Addr)){
			?>
			<div class="large-4 small-12 columns">
				<div class="panel">
					<strong>Address</strong><a class="right btnDelete" title="Delete" onclick="return confirm('Delete this?');" href="hrefPersonalInformation.php?deleteAddr=&addressID=<?php echo $row_Addr['addressID']; ?>">&#215;</a>
					<hr/>
					<?php echo $row_Addr['Address'] . '<br>
' . $row_Addr['City'] . '<br>' . $row_Addr['Region'] . '<br>' . $row_Addr['PostCode'];
					?>
					<button class="btnAdd" dir="<?php echo $row_Addr['addressID']; ?>">
						Edit Address
					</button>
				</div>
			</div>
			<?php
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
