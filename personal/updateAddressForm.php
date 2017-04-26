<?php
session_start();
				include '../Function/fPersonalInformation.php';
				if (isset($_REQUEST['addressID'])) {
				$row_sAddress=user_profile::getSingleAddress($_REQUEST['addressID']);
					
				?>
				<form id="frmUpdateAddr" class="custom" action="hrefPersonalInformation.php?addressID=<?php echo $_REQUEST['addressID'];?>" method="post" data-abide>
					<fieldset>
						<legend>
							Add New Address
						</legend>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtAddress">Address<small>(require)</small></label>
								<textarea id="txtAddress" placeholder="Example: 9, jln ABC, tmn ABC" name="txtAddress" required><?php echo $row_sAddress['Address']; ?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtCity">City<small>(require)</small></label>
								<input type="text" id="txtCity" placeholder="Example: Petaling Jaya" name="txtCity" value="<?php echo $row_sAddress['City']; ?>" required>

							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtRegion">Region<small>(require)</small></label>
								<input type="text" id="txtRegion" placeholder="Example: Johor" name="txtRegion" value="<?php echo $row_sAddress['Region']; ?>" required>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<label for="txtPostcode">Postcode<small>(require)</small></label>
								<input type="text" id="txtPostcode" placeholder="53800" name="txtPostcode" required value="<?php echo $row_sAddress['PostCode']; ?>" pattern="[0-9]{5,12}">
							</div>
						</div>

						<div class="row">
							<div class="large-12 small-centered columns">
								<button type="submit" id="UpdateAddress" name="UpdateAddress" class="medium button green">
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
				<?php
				}
				?>