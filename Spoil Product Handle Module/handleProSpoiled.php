<?php

include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../main/header.php';

require_once '../sql/openDb.php';

if(!isset($_SESSION['id'])){
?>
<script>
    window.onload = function() {
		window.location.replace("../LoginPage/loginPage.php");
		alert( "Error,this Login first"); 
    }
</script>
<?php
	require '../main/authorization.php';
	
	if(checkStaff($_SESSION['id'])!=TRUE){
	?>
	<script>
	    window.onload = function() {
			window.location.replace("../LoginPage/loginPage.php");
			alert( "Only Staff can access this page"); 
	    }
	</script>
		}
	<?php		
	}
}

if(isset($_POST['btnUpdate'])){
	$proID = $_POST['txtProID'];
	$orderID = $_POST['txtOrderID'];
	$returnDate = $_POST['txtReturnDate'];
	
	$qryUpdate = "UPDATE return_handle
				  SET returnDate='$returnDate'
				  WHERE orderID='$orderID' and productID='$proID'";
	
	$rltUpdate = mysql_query($qryUpdate)or die('update '.mysql_error());
	
	if($rltUpdate==TRUE){
?>
<script>
    window.onload = function() {
		window.location.replace("../home/homePage.php");
		alert( "Update Success"); 
    }
</script>
<?php		
	}
}

$query = "SELECT r.*,pc.pic_url,p.productName
		  FROM return_handle r,product_pic pc,products p
		  WHERE r.productID=pc.productID and r.returnDate='000-00-00' and p.productID=r.productID";
		  
$result = mysql_query($query)or die(mysql_error());


if(!isset($_POST['submit'])){
?>
<link href="table.css" type="text/css" rel="stylesheet" />

<div class="row">
<h2>Handle Product Spoiled Form</h2>
 <form class="custom" method="POST" action="" data-abide>	
	<div class="large-12 columns">
	<table class="bordered">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Product ID</th>
				<th>Product Name</th>
				<th>Quantity spoiled</th>
				<th>Date Report</th>
				<th>Reason</th>
				<th>Product Pic</th>
				<th>Select Product</th>
				
			</tr>
		</thead>
		<tbody>
			<?php while($row = mysql_fetch_assoc($result)){ ?>
				<tr>
					<td><?php echo $row['orderID'] ?></td>
					<td><?php echo $row['ProductID'] ?></td>
					<td><?php echo $row['productName'] ?></td>
					<td><?php echo $row['quantity'] ?></td>
					<td><?php echo $row['datesend'] ?></td>
					<td><?php echo $row['Reason'] ?></td>
					<td><img src="../product/<?php echo $row['pic_url']; ?>" width="130px" height="150px"/></td>
					<td>
						<input type="radio" name="radProd" value="<?php echo $row['orderID'].",".$row['ProductID']; ?>" required />
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
		<div class="small-2 small-centered columns" ><button type="submit" name="submit">Submit</button></div>
 </form>
</div>
<?php
}else{
	if(isset($_POST['radProd'])){
		$itemID = explode(",",$_POST['radProd']);
		
		$orderID = $itemID[0];
		$proID = $itemID[1];
		
		$query1 = "SELECT r.*,pc.pic_url,p.productName
		  FROM return_handle r,product_pic pc,products p
		  WHERE r.productID=pc.productID and r.orderID='$orderID' and r.productID='$proID' and p.productID=r.productID";
	
	$result1 = mysql_query($query1)or die('Item ID '.mysql_error());
	
	while($row = mysql_fetch_assoc($result1)){
		$pic_url = $row['pic_url'];
		$p_name = $row['productName'];
		$p_quantity = $row['quantity'];
		$reason = $row['Reason'];
		$datesend = $row['datesend'];
	}
?>
<div class="row">
<h2>Select Return Date</h2>
<form action="" method="POST" data-abide>
	  
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
			<input type="text" value="<?php echo $p_quantity?>" disabled=""/>
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Reason:</div>
			<input type="text" value="<?php echo $reason; ?>" disabled="" />
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Date Report</div>
			<input type="text" value="<?php echo $datesend; ?>" disabled=""/>
		</div>	
	</div>
	
	<div class="row">
		<div class="large-6 large-centered columns">
			<div>Select return Date:</div>
			<input type="date" name='txtReturnDate' required>
			</input>
		</div>	
	</div>
	
	<div class="small-2 small-centered columns">
		<button type="submit" name="btnUpdate">Submit Form</button>
	</div>
</form>
</div>
<?php
	}
}
include '../main/footer.php'; 
}?>