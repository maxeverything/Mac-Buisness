<?php
include '../main/authorization.php';
include '../Main/header.php';
include_once '../Cart/fCart.php';
?>
<script>
	$(document).ready(function(){
		//$('input[name^="group1"]')
		$add=$('#frmAddNew');
		$select=$('#divSelectAddr');
		$('#rdbSelectAddr').click(function(){
			$select.show();
			$add.hide();
		});
		$('#rdbAddNew').click(function(){
			$select.hide();
			$add.show();
			
		});
		$('input[name^="qty"]').spinner({
			min : 1
		});
		$('input[name^="qty"]').spinner({
			change : function(event, ui) {
				$qty=$(this).val();
				$price=$('#price').text();
				$('#subTotal').text($price*$qty);
				$('#total').text($price*$qty);
			}
		});
		
		$('input[name^="qty"]').each(function() {
			$max = $(this).parent().parent().parent().parent().find('#dtpColor').val();
			$(this).spinner({
				max : $max
			});
		});


		$('.dtpColor').each(function(){
			$(this).css("background-color", $('option:selected', this).css('backgroundColor'));
		});
		
		$('.dtpColor').change(function() {			
			$(this).css("background-color", $('option:selected', this).css('backgroundColor'));
			$max = $(this).val();
			$(this).parent().parent().parent().find('input[name^="qty"]').spinner({
				max : $max
			});
		});
		$("#btnRedeem").click( function(e) {
			e.preventDefault();
			$color=$('#dtpColor option:selected').text();
			
			$productID=<?php echo $_REQUEST['product'];?>;
			$redeemQuantity=$('#qty').val();
			$point=$('#total').text();
			$shipperID=$('#dtpShipper :selected').attr("title");
			if($shipperID==null){
				alert('Please select a shipper');
			}else{
			if($('#rdbSelectAddr').is(':checked')){
				$addressID=$("input[name^='groupAddr']:checked").attr("dir");
				
				alert("hrefRedeem.php?UpdateRedeemSelectAddr=&ShipperID="+$shipperID+"&addressID="+$addressID+"&color="+ $color +"&point="+$point+"&reedeemQuantity="+$redeemQuantity+"&productID="+$productID);
				$.ajax({
				type : "GET",
				url : "hrefRedeem.php?UpdateRedeemSelectAddr=&ShipperID="+$shipperID+"&addressID="+$addressID + "&point="+ $point +"&redeemQuantity="+ $redeemQuantity +"&productID="+ $productID + "&color="+ $color,
				dataType : 'json',
				success : function(msg) {
					if (msg.status == "1") {
						alert('Successful redeem');
						window.location="../Home/HomePage.php"
					}else if(msg.status == "0") {
						alert('Error, you have not enough point to redeem this product');
					}else{
						alert('Error, please login first');
					}
				}
				});

			}else{
				alert('a');				
				var str = $('#frmAddNew').serialize();
				$.ajax({
				type : "GET",
				url : "hrefCart.php?UpdateOrdersInsertAddr=&ShipperID="+$shipperID+"&point="+ $point +"&redeemQuantity="+ $redeemQuantity +"&productID="+ $productID + "&color="+ $color, 
				data : str ,
				dataType : 'json',
				success : function(msg) {
					if (msg.status == "1") {					
						alert('Successful redeem');
					}else if(msg.status == "0") {
						alert('Error, you have not enough point to redeem this product');
					}else{
						alert('Error, please login first');
					}
				}
				});
			}
			}
			
		});
	});
	
	function calculateGrandTotal() {
		
		var grandTotal = 0;
		grandTotal=Number($("#shipping").text())+Number($('#subTotal').text());
		$("#grandtotal").text(grandTotal.toFixed(2));
	}
</script>
<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<div>
			<fieldset>
			<legend>
			<input type="radio" name="group1" id="rdbSelectAddr" checked >Select Address</input>
			</legend>
			<div id="divSelectAddr">
			<?php
			include '../Function/fPersonalInformation.php';
			
			include_once '../Function/product.php';
			$result_Addr=user_profile::getAddress();
			$row_Addr=mysql_fetch_array($result_Addr);
			?>
			<div class="large-4 small-12 columns">
				<div class="panel">
					<strong>
			<input type="radio" name="groupAddr" checked="checked" class="groupAddr" dir="<?php echo $row_Addr['addressID']; ?>" />
			Address
					</strong>
					<hr/>
					<?php echo $row_Addr['Address'] . '<br>
' . $row_Addr['City'] . '<br>' . $row_Addr['Region'] . '<br>' . $row_Addr['PostCode'];
					?>
				</div>
			</div>
			<?php

			while($row_Addr=mysql_fetch_array($result_Addr)){
			?>
			<div class="large-4 small-12 columns">
				<div class="panel">
					<strong>
						<input type="radio" name="groupAddr" class="groupAddr"  dir="<?php echo $row_Addr['addressID']; ?>" />
						Address
					</strong>
					<hr/>
					<?php echo $row_Addr['Address'] . '<br>
' . $row_Addr['City'] . '<br>' . $row_Addr['Region'] . '<br>' . $row_Addr['PostCode'];
					?>
				</div>
			</div>
			<?php
			}
			?>
			</div>
		</fieldset>
		<fieldset>
			<legend>
			<input type="radio" name="group1" id="rdbAddNew" >Add New Address</input>
			</legend>
			<form id="frmAddNew" class="custom hide" data-abide>
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
								<button type="reset" id="btnClear" name="btnClear" class="medium button green close">
									Clear
								</button>
							</div>
						</div>
						</form>
					</fieldset>
		
				
			
	</div>
	<div class="large-12 columns">
		<h4>You Have <?php echo $spe;?> point in your account</h4>
	</div>
	<div>
		<table class="order-list large-12 columns">
				<thead class="panel">
					<tr>
					<th >Items</th>
					<th >Description</th>
					<th>Color</th>
					<th >Qty</th>
					<th >Unit (point)</th>
					<th>Total (point)</th></tr>
				</thead>
				<?php
				
				
				$rowRedeem=product::getProduct($_REQUEST['product']);
				$total=0;
				?>
				<tbody>
					<div class="divOrderItem ">
				<tr class="panel">
					<td class="large-2 small-2">
						<label class="hide" name='productID'><?php echo $_REQUEST['product']; ?></label>
						<?php
						echo "<a>" . $rowRedeem['ProductName'] . '</a>';
						$row_pic = cart::getMainPicture($_REQUEST['product']);
					?>
					<br/>
					<img width="65px" height="108px" src="../product/<?php echo $row_pic['pic_url']; ?>"/>				
					</td>
					<td class="large-3 small-3"><?php
					echo $rowRedeem['description'];
					?></td>
					
					<td class="large-1 small-1">
						<select id="dtpColor" class='dtpColor'>
						<?php
						$queryColor = product::getProductColor($_REQUEST['product']);
						$rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC);
						echo '<option style="background-color:' . $rowColor["color"] . '" value="' . $rowColor["qty"] . '" selected="selected">' . $rowColor['color'] . '</option>';
						while ($rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC)) {							
								echo '<option style="background-color:' . $rowColor["color"] . '" value="' . $rowColor["qty"] . '">' . $rowColor['color'] . '</option>';							
						}
					?>
				</select>
					</td>					
					<td class="large-2 small-2">
							<input class=" large-12 small-12" id="qty" class="spinner" name="qty" value="1"/>						
						</td>
						
					<td class="large-2 small-2">
						<label name="price" id="price">						
						<?php 
											
						echo $rowRedeem['product_point']; ?>
						</label>
					</td>
					<td class="text-center large-2 small-2">
							<label name="subTotal" id="subTotal"><?php echo $rowRedeem['product_point']; ?></label>
						
					</td>

				</tr>
				
				
				</div>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="5">
							Ship By:<select id="dtpShipper" required class='dtpShipper  large-4 small-8'>
								<option value="0">--Select Shipper--</option>
						<?php
						$queryShipper = product::getShipper();
						while ($rowShipper = mysql_fetch_array($queryShipper, MYSQL_ASSOC)) {
						?>
								<option  value="<?php echo $rowShipper["shipperID"]; ?>" title="<?php echo $rowShipper["shipperID"]; ?>"><?php echo $rowShipper['companyName'] . '(free)'; ?></option>
							<?php
							}
					?></select>Total Point:
						</td>
						<td class="text-right panel">
							<h2><label id="total"><?php echo $rowRedeem['product_point']; ?></label></h2>
						</td>
					</tr>					
				</tfoot>
			</table>
			
			<button id="btnRedeem" name="btnRedeem" class="btnRedeem right" role="button" aria-disabled="false">
					<span class="ui-button-text">Make Redeem</span>
			</button>
	</div>
	
	</div>
	<!-- End Side Bar -->

	<!-- Thumbnails -->

	<!-- End Thumbnails -->

</div>
<!-- Footer -->
<?php include '../Main/footer.php'
?>
