<?php
include '../sql/config.php';
include '../sql/opendb.php';
include '../Function/product.php';
include '../Function/fPersonalInformation.php';
include '../shipping/fShipping.php';
?>
<a class="close-reveal-modal">&#215;</a>
<div id="divInvoice"><?php
	$orderID = mysql_real_escape_string($_REQUEST['orderID']);
	$resultDate = mysql_query("Select * from orders WHERE OrderID='$orderID'");
	$rowOrder = mysql_fetch_array($resultDate);
	$orderDate = $rowOrder['OrderDate'];
	?>
	<div class="large-12 small-12 columns">
<table >
<tr>
<td class="large-2 small-2">
<label class="label large-12 small-12">Order Date:</label>
</td>
<td class="large-4 small-4">
<p>
<?php echo $rowOrder['OrderDate']; ?>
</p>
</td>
<td class="large-2 small-2">
<label class="label large-12 small-12">Received point:</label>
</td>
<td class="large-4 small-4">
<p>
<?php echo $rowOrder['points_get']; ?>
</p>
</td>
</tr>
<tr>
<td class="large-2 small-2">
<label class="label large-12 small-12">Shipper By:</label>
</td>
<td class="large-4 small-4">
<p>
<?php echo ship::getShipperName($rowOrder['ShipperID']); ?>
</p>
</td>
<td class="large-2 small-2">
<label class="label large-12 small-12">Required arrived date:</label>
</td>
<td class="large-4 small-4">
<p>
<?php echo $rowOrder['RequiredDate']; ?>
</p>
</td>
</tr>
<tr>
<td class="large-2 small-2">
<label class="label large-12 small-12">Shipping Address:</label>
</td>
<td colspan="3">
<p>
<?php 
$rowAddr=user_profile::getSingleAddress($rowOrder['addressID']);
echo $rowAddr['Address'].','.$rowAddr['PostCode'].', '.$rowAddr['City'].$rowAddr['Region'].'.'; ?>
</p>
</td>
</tr>
</table>
</div>
	<div class="large-12 small-12 columns">
	<table class="large-12 small-12 columns">
		<thead class="panel">
				<th scope="col" colspan="2" class="large-5 small-5">Item</th>
				<th scope="col" class="large-2 small-2">Color</th>
				<th scope="col" class="large-2 small-2">Unit Price</th>
				<th scope="col" class="large-1 small-1">Quantity</th>
				<th scope="col" class="large-2 small-2">Total Price</th>
		</thead>
		<tbody>
			
			
			<?php
			$total=0;
			$queryOrderDetail = user_profile::getOrderDetail($_REQUEST['orderID']);
			while($row_OrderDetail=mysql_fetch_array($queryOrderDetail,MYSQL_ASSOC)){
				$total=$total+$row_OrderDetail['amount'];
			?>

			<tr class="panel">
				<td>
					<img src="../product/<?php echo $row_OrderDetail['pic_url']; ?>" width="80px" height="80px"></img>
				</td>
				<td>
						<p>
					<?php echo $row_OrderDetail['ProductName']; ?>
						</p>								
				<td>						
					<div class="small-6 large-6 columns" style="border-style:solid;
					border-width:2px;  background-color:<?php echo $row_OrderDetail['color']; ?>">
					<p > </p>
					</div>
				</td>
					
				<td>
					<?php
					$discount = product::getPerDiscount($row_OrderDetail['ProductID'], $orderDate);
					echo number_format($row_OrderDetail['UnitPrice'] * (100 - $discount) / 100, 2);
				?>
				
				</td>
				<td><?php echo "<b>" . $row_OrderDetail['quantity_order'] . "</b>"; ?></td>
				<td class="text-right">
				<?php echo $row_OrderDetail['amount']; ?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
		<tfoot>
			
			<tr>
			<td colspan="5" class="text-right">
				Total:
			</td>
			<td class="text-right panel">
				<?php echo $total; ?>
			</td>
			</tr>
		</tfoot>

	</table>
	</div>
	<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print receipt</button>
</div>