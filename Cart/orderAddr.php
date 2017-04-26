<?php
include '../main/authorization.php';

if(authetication()==TRUE){
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
		$weight=Number($('#totalWeight').text());
		$('#dtpShipper').change(function() {
			$shipFee = $(this).val();
			$('#shipping').text(($weight*$shipFee).toFixed(2));
			calculateGrandTotal();
		});
		
		$OrderID=<?php echo cart::getOrderId();?>;
		$('#btnSaveOrderAddr').click(function(e){
			e.preventDefault();
			$shipperID=$('#dtpShipper :selected').attr("title");
			if($shipperID==null){
				alert('Please select a shipper');
			}else{
				$shipPrice=$('#shipping').text();
			if($('#rdbSelectAddr').is(':checked')){
				$addressID=$("input[name^='groupAddr']:checked").attr("dir");
				
				$.ajax({
				type : "POST",
				url : "hrefCart.php?UpdateOrdersSelectAddr=&ShipperID="+$shipperID+"&addressID="+$addressID+"&OrderID="+$OrderID+"&shippingPrice="+$shipPrice,
				success : function(msg) {
					if (msg=="") {
						alert('Updated');
						window.location='../Ordering module/orderdetails.php';
					}else{
						alert('Error, your cart cant be upload'+msg);
					}
				}
				});

			}else{				
				var str = $('#frmAddNew').serialize();
				 $.ajax({
				type : "POST",
				url : "hrefCart.php?UpdateOrdersInsertAddr=&ShipperID="+$shipperID+"&OrderID="+$OrderID+"&shippingPrice="+$shipPrice,
				data : str ,
				success : function(msg) {
					if (msg=="") {
						alert('Updated');
						window.location='../Ordering module/orderdetails.php';
					}else{
						alert('Error, your cart cant be upload'+msg);
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
	<div class="large-12 columns" >
		<div>
			<fieldset>
			<legend>
			<input type="radio" name="group1" id="rdbSelectAddr" checked >Select Address</input>
			</legend>
			<div id="divSelectAddr" >
			<?php
			include '../Function/fPersonalInformation.php';
			
			include_once '../Function/product.php';
			$result_Addr=user_profile::getAddress();
			$row_Orders=cart::getCartOrder(cart::getOrderId());
			if($row_Orders['addressID']==NULL){
				$row_Addr=mysql_fetch_array($result_Addr);
			?>
			<div class="large-4 columns">
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
			}

			while($row_Addr=mysql_fetch_array($result_Addr)){
			?>
			<div class="large-4 columns">
				<div class="panel">
					<strong>
						<?php
						if($row_Addr['addressID']==$row_Orders['addressID']){
						?>
						<input type="radio" name="groupAddr" checked="checked" class="groupAddr" dir="<?php echo $row_Addr['addressID']; ?>" />
						<?php
						}else{
						?>
						<input type="radio" name="groupAddr" class="groupAddr"  dir="<?php echo $row_Addr['addressID']; ?>" />
						<?php
							}
						?>
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
	<div style="background-color: white">
		<table class="order-list large-12 columns">
				<thead class="panel">
					<tr>
					<th width="20%">Items</th>
					<th width="25">Description</th>
					<th width="10%">Color</th>
					<th width="10%">Weight(Gram)</th>
					<th width="10%">Quantity</th>
					<th width="10%">Price (RM)</th>
					<th width="15%">Total (RM)</th></tr>
				</thead>
				<?php
				
				
				$result_cart=cart::getCartItem();
				$total=0;
				while($row_cart=mysql_fetch_array($result_cart,MYSQL_ASSOC)){
					$discount=product::getDiscount($row_cart['productID']); 
					$total=$total+$row_cart['subTotal']*(100-$discount)/100;
				?>
				<tbody>
					<div class="divOrderItem ">
				<tr class="panel">
					<td class="large-2 small-2">						
						<?php
						echo "<a>" . $row_cart['ProductName'] . '</a>';
						$row_pic = cart::getMainPicture($row_cart['productID']);
					?>
					<br/>
					<img width="65px" height="108px" src="../product/<?php echo $row_pic['pic_url']; ?>"/>				
					</td>
					<td class="large-2 "><?php
						echo $row_cart['description'];?>
						
					</td>
					
					<td class="large-2 ">
						<?php echo "<div style='width:20px;height:20px;background-color:".$row_cart['color']."'></div>"; ?>
					</td>
					
					<td class="large-1 ">	
						<label class=" large-12 small-12" id="weight" name="weight"><?php echo $row_cart['ProductWeight']; ?> </label>						
					</td>
									
					<td class="large-1 ">	
						<label class=" large-12 small-12" id="qty" name="qty"><?php echo $row_cart['Quantity']; ?></label>						
					</td>
						
					<td class="large-2 ">
						<label name="price">						
						<?php
							echo number_format($row_cart['UnitPrice'] * (100 - $discount) / 100, 2);
 ?>
						</label>
					</td>
					<td class="large-3 ">
							<label name="subTotal"><?php echo number_format($row_cart['subTotal'] * (100 - $discount) / 100, 2); ?></label>
						
					</td>

				</tr>
				
				
				</div>
				
				<?php
				}
				?>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="6">
							Sub-total:
						</td>
						<td class="text-right panel">
							<h2><label id="subTotal"><?php echo number_format($total, 2); ?></label></h2>
						</td>
					</tr>
					<tr>
						<td class="text-right" colspan="6">
						Weight:
							<label id="totalWeight">
							
							<?php echo $weight = cart::getTotalWeight(cart::getOrderId());?>
							</label>
							Ship By:<select id="dtpShipper" required class='dtpShipper right large-4 small-8'>
								<option value="0">--Select Shipper--</option>
						<?php
						$queryShipper = product::getShipper();
						$shipFee=0;
						while ($rowShipper = mysql_fetch_array($queryShipper, MYSQL_ASSOC)) {
							
							if($rowShipper['shipperID']==$row_Orders['ShipperID']) {
								$shipFee=$rowShipper['shipPrice'];
							?>
								<option value="<?php echo $rowShipper['shipPrice'] ?>" title="<?php echo $rowShipper["shipperID"]; ?>" selected="selected"><?php echo $rowShipper['companyName'] . '(' . $rowShipper['shipPrice'] . '/kg)'; ?></option>
							<?php
							} else {
							?>
								<option  value="<?php echo $rowShipper['shipPrice'] ?>" title="<?php echo $rowShipper["shipperID"]; ?>"><?php echo $rowShipper['companyName'] . '(' . $rowShipper['shipPrice'] . '/kg)'; ?></option>
							<?php
							}
							}
					?>
				</select>
						</td>
						<td class="text-right panel">
							<h2><label id="shipping"><?php echo number_format($weight * $shipFee, 2); ?></label></h2>
						</td>
					</tr>
					<tr>
						<td class="text-right" colspan="6">
							Total:
						</td>
						<td class="text-right panel">
							<h2><label id="grandtotal"><?php echo number_format($total + $weight * $shipFee, 2); ?></label></h2>
						</td>
					</tr>
				</tfoot>
			</table>
			
			<button id="btnSaveOrderAddr" name="btnSaveOrderAddr" class="btnSaveOrderAddr right" role="button" aria-disabled="false">
					<span class="ui-button-text">Save Address</span>
			</button>
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
