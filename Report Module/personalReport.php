
<?php 
include '../main/authorization.php';

if(checkSeller($_SESSION['id'])==TRUE){
	
include '../Main/header.php';

require '../sql/opendb.php';

$id = $_SESSION['id'];


if(isset($_POST['filter'])){
	$operator = $_POST['sltOperator'];	
	$date = date("Y-m-d",strtotime($_POST['filterDate']));
	$filterDate = "o.orderDate $operator '$date'";
}else{
	$filterDate = 1;
}

if(isset($_SESSION['id']) && $_SESSION['id'][0] == 'R'){
	
	$id = mysql_real_escape_string($_SESSION['id']);
	
	$query = "SELECT p.ProductName,p.shopID,s.sellerID,o.orderID,o.orderDate,p.unitPrice,od.quantity_order,od.amount,sh.shopName
	FROM sellers s, shops sh,orders o,order_det od, products p
	WHERE s.sellerID = sh.sellerID and sh.shopID = p.shopID and p.productID=od.productID and od.orderID = o.orderID and s.sellerID='$id' and $filterDate";
	
	$result = mysql_query($query);
	if(mysql_num_rows($result)<=0){
		$query = "SELECT p.ProductName,p.shopID,s.sellerID,o.orderID,o.orderDate,p.unitPrice,od.quantity_order,od.amount,sh.shopName
		FROM sellers s, shops sh,orders o,order_det od, products p
		WHERE s.sellerID = sh.sellerID and sh.shopID = p.shopID and p.productID=od.productID and od.orderID = o.orderID and s.sellerID='$id' ";
		
		$result = mysql_query($query);
	}
	
	if($result==TRUE){		
?>
<link href="css/table.css" type="text/css" rel="stylesheet" />

<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
   function printReport() {
        var prtGrid = document.getElementById('report');
        prtGrid.border = 0;
        var prtwin = window.open('', 'PrintGridViewData', 'left=150, top=150, width=1000, height=1000, tollbar=0, scrollbars=1, status=0, resizable=1');
        prtwin.document.write('<link rel="stylesheet" href="../css/foundation.css">'+prtGrid.outerHTML);
        prtwin.document.close();
        prtwin.focus();
        prtwin.print();
        prtwin.close();
    }
  </script>
<br/>
<div class="row">
<h2>Personal Shop Sale Report</h2>

<form action="personalReport.php" method="POST">
<div>Filter OrderDate:</div>
	<div class="large-6 columns">
	 <div class="large-8 columns">	
		<input type="text" id="datepicker" name='filterDate' placeholder='Enter Date'/>
	 </div>
	 <div class="large-3 columns">	
		<select name='sltOperator'>
			<option value="=" selected="">=</option>
			<option value=">">></option>
			<option value="<"><</option>
			<option value="<="><=</option>
			<option value=">=">>=</option>
		</select>
	 </div>
	 <div class="large-1 columns">
		<input type="submit" name="filter" value='search'/>
	 </div>
	</div>
	
</form>
<div id="report">
	<table class="bordered">
	    <thead>
		
	    <tr>
	        <th>Shop ID</th>        
	        <th>Shop Name</th>
	        <th>Order ID</th>
			<th>Order Date</th>
			<th>Product Name</th>
			<th>Quantity Order</th>
			<th>UnitsPrice</th>
			<th>Amount</th>
	    </tr>
	    </thead>
	    <tbody>
<?php
		while($row = mysql_fetch_assoc($result)){
			$shopID = $row['shopID'];
			$shopName = $row['shopName'];
			$orderID = $row['orderID'];
			$orderDate = $row['orderDate'];
			$unitPrice = $row['unitPrice'];
			$qtyOrd = $row['quantity_order'];
			$amount = $row['amount'];
			$ProductName = $row['ProductName'];
?>
		<tr>
			<td><?php echo $shopID ?></td>
			<td><?php echo $shopName ?></td>
			<td><?php echo $orderID ?></td>
			<td><?php echo $orderDate ?></td>
			<td><?php echo $ProductName ?></td>
			<td><?php echo $qtyOrd ?></td>
			<td><?php echo $unitPrice ?></td>
			<td><?php echo $amount ?></td>
	    </tr>        
<?php
		}
?>
	
</tbody></table>
</div>
<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>

<?php		
	}else{
?>
<script>
		window.onload = function() {
	 		window.location.replace("../Home/homePage.php");
	    	alert("Error, <?php echo mysql_error(); ?>");
		}
	</script>

<?php
	}
}else{
	header("Location: ../Home/Homepage.php");
}

include '../Main/footer.php';
}
?>

