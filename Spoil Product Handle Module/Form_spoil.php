<?php	
include '../main/authorization.php';
if(checkMember($_SESSION['id'])==TRUE){
include '../main/header.php';

require_once '../sql/openDb.php';
$id = $_SESSION['id'];

$query = "SELECT od.orderID,p.productName,od.quantity_order,p.unitPrice,o.orderDate,od.productID
		  FROM order_det od, orders o,products p
		  WHERE od.orderID=o.orderID and od.productId = p.productID and o.memberID='$id' and o.shipmentStatus!='pending'";
		  
$result = mysql_query($query)or die(mysql_error());

if(!isset($_POST['btnGet'])){
?>
<link href="table.css" type="text/css" rel="stylesheet" />

<div class="row">
<h2>Spoil Product Register</h2>
 <form class="custom" method="POST" action="" data-abide>	
	<div class="large-12 columns">
	<table class="bordered">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>orderDate</th>
				<th>Select</th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = mysql_fetch_row($result)){ ?>
				<tr>
					<td><?php echo $row[0] ?></td>
					<td><?php echo $row[1] ?></td>
					<td><?php echo $row[2] ?></td>
					<td><?php echo $row[3] ?></td>
					<td><?php echo $row[4] ?></td>
					<td>
						<input type="radio" name="itemId" value="<?php echo $row[0].",".$row[5] ?>" required>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
		<div class="small-2 small-centered columns" ><button type="submit" name="btnGet">Submit</button></div>
 </form>
</div>
<?php 	}else{	 

	$itemid = explode(",",$_POST['itemId']);;
	
	$orderID = $itemid[0];
	$proID = $itemid[1];
	
	$query1 = "SELECT pc.pic_url,p.productName,od.quantity_order,p.unitPrice,o.orderdate
			  FROM product_pic pc,orders o,order_det od,products p
			  WHERE  pc.productID='$proID' and p.productID=od.productID and o.orderID=od.orderID and od.orderID='$orderID'";
	
	$result1 = mysql_query($query1)or die('Item ID '.mysql_error());
	
	while($row = mysql_fetch_assoc($result1)){
		$pic_url = $row['pic_url'];
		$p_name = $row['productName'];
		$p_quantity = $row['quantity_order'];
		$p_price = $row['unitPrice'];
		$orderdate = $row['orderdate'];
	}
?>
<div class="row">
<h2></h2>
<form action="addFormProSpoiled.php" method="POST" data-abide>
	  
	<div class="row">
	  	<div class="small-2 small-centered columns">
			<img src="../product/<?php echo $pic_url ?>" width="150px" height="150px" style="border: black 1px solid">
		</div>
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Product Name:</div>
			<input type="text" value="<?php echo $p_name?>" disabled=""/>
			<input type="hidden" value="<?php echo $proID?>" name="txtProID"/>
			<input type="hidden" value="<?php echo $orderID?>" name="txtOrderID"/>	
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<label>select quantity spoiled</label>
			<select name='sltQuantity' required="">
				<?php
					for($i=1;$i<=$p_quantity;$i++){
						echo "<option value='$i'>$i</option>";
					}
				?>
			</select>
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>UnitPrice:</div>
			<input type="text" value="<?php echo $p_price?>" disabled=""/>
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Order date:</div>
			<input type="text" value="<?php echo $orderdate; ?>" disabled=""/>
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Reason:</div>
			<input type="text" name='txtReason' placeholder="How is the Spoiled?" required>
			</input>
		</div>	
	</div>
	
	<div class="small-2 small-centered columns">
		<button type="submit" name="btnSubmit">Submit Form</button>
	</div>
</form>
</div>
<?php
}
include '../main/footer.php';
}?>
