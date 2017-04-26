<?php

session_start();
	
include '../Main/header.php';
include_once 'fCart.php';
include_once '../Function/product.php';
$result_cart=cart::getCartItem();
?>
<!--
Test Changes-->

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  
<script src="../js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$id=<?php echo json_encode($_SESSION['id']);?>;
		$OrderID=<?php echo cart::getOrderId(); ?>;
		$('input[name^="qty"]').spinner({
			min : 1
		});
		$('input[name^="qty"]').spinner({
			change : function(event, ui) {
				$row=$(this).parent().parent().parent();
				calculateRow($row);
				calculateGrandTotal();
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
			$(this).parent().parent().find('input[name^="qty"]').spinner({
				max : $max
			});
		});
		
		$('.btnDeleteCart').click(function(e){
			e.preventDefault();
			if(confirm('Delete?')){			
			$id=$(this).attr("dir");
			$path=$(this).parent().parent();
			$.ajax({
							type : "POST",
							url : "../Cart/hrefCart.php?DeleteCart=",
							data : {
								productID : $id,
								OrderID: $OrderID
							},
							dataType : 'json',
							success : function(msg) {
								// Message Sent - Show the 'Thank You' message and hide the form
								if (msg.status == "1") {
									$path.remove();
									calculateGrandTotal();
								} else {
									alert('Error, please login first');
								}
							}
			});
			}
		});
		
		calculateGrandTotal();
		$('#btnCheckOut').click(function(e){
			$queryString='';
			$('.dtpColor').each(function(){
				$queryString+='&color[]='+ $('option:selected', this).text();
			});
			$('input[name^="qty"]').each(function(){
				$queryString+='&qty[]='+$(this).val();
			});
			$('label[name^="productID"]').each(function(){
				$queryString+='&productID[]='+$(this).text();
			});
			e.preventDefault();
			$.ajax({
				type : "POST",
				url : "hrefCart.php?UpdateCart=&OrderID="+$OrderID,
				data : $queryString ,
				success : function(msg) {
					if (msg=="") {					
						alert('Updated');
						window.location='orderAddr.php';
					}else{
						alert('Error, your cart cant be upload'+msg);
					}
				}
			});
		});
		
	});
	

	function calculateRow(row) {
		var price = row.find('label[name^="price"]').text();
		var qty = row.find('input[name^="qty"]').val();
		row.find('label[name^="subTotal"]').text((price * qty).toFixed(2));
	}
	

	function calculateGrandTotal() {
		var grandTotal = 0;
		$("table.order-list").find('label[name^="subTotal"]').each(function() {
			grandTotal += +$(this).text();
		});
		$("#grandtotal").text(grandTotal.toFixed(2));
	}
</script>
<br/>
<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<div class="large-12 columns">
			<table class="order-list large-12 columns">
				<thead class="panel">
					<tr>
					<th scope="col" class="large-2 small-2">Items</th>
					<th scope="col" class="large-3 small-3">Description</th>
					<th scope="col" class="large-2 small-1">Color</th>
					<th scope="col" class="large-1 small-2">Qty</th>
					<th scope="col" class="large-2 small-2">Price (RM)</th>
					<th scope="col" class="large-2 small-2">Total (RM)</th></tr>
				</thead>
				<tbody>
				<?php
				
				while($row_cart=mysql_fetch_array($result_cart,MYSQL_ASSOC)){
				?>
				
					<div class="divOrderItem ">
				<tr class="panel">
					<td>
						<label class="hide" name='productID'><?php echo $row_cart['productID']; ?></label>
						<?php
						echo "<a>" . $row_cart['ProductName'] . '</a>';
						$row_pic = cart::getMainPicture($row_cart['productID']);
					?>
					<br/>
					<img width="65px" height="108px" src="../product/<?php echo $row_pic['pic_url']; ?>"/>				
					</td>
					<td class=" text-center large-4 small-4"><?php
					echo $row_cart['description'];
					?></td>
					
					<td >
						<select id="dtpColor" class='dtpColor'>
						<?php
						$queryColor = product::getProductColor($row_cart['productID']);
						while ($rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC)) {
							if ($rowColor['color'] == $row_cart['color']) {
								echo '<option style="background-color:' . $rowColor["color"] . '" value="' . $rowColor["qty"] . '" selected="selected">' . $rowColor['color'] . '</option>';
							} else {
								echo '<option style="background-color:' . $rowColor["color"] . '" value="' . $rowColor["qty"] . '">' . $rowColor['color'] . '</option>';
							}
						}
					?>
				</select>
					</td>					
					<td >
							<input class=" large-12 small-12" id="qty" class="spinner" name="qty" value="<?php echo $row_cart['Quantity']; ?>"/>						
						</td>
						
					<td >
						<label name="price">						
						<?php 
						$discount=product::getDiscount($row_cart['productID']); 						
						echo number_format($row_cart['UnitPrice']*(100-$discount)/100,2); ?>
						</label>
					</td>
					<td>
							<a class="right btnDeleteCart" dir="<?php echo $row_cart['productID']; ?>" title="Delete" href=" ">| &#215;</a>
							<label name="subTotal"><?php echo number_format($row_cart['subTotal']*(100-$discount)/100,2); ?></label>
						
					</td>

				</tr>
				
				
				</div>
				
				<?php
				}
				?>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="5">
							Total:
						</td>
						<td class="text-right panel">
							<h2><label id="grandtotal"></label></h2>
						</td>
					</tr>
				</tfoot>
			</table>
			<button id="btnCheckOut" name="btnCheckOut" class="btnCheckOut right" role="button" aria-disabled="false">
					<span class="ui-button-text">Make payment</span>
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
