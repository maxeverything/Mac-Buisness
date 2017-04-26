
<?php
	include '../main/authorization.php';
	if(checkManager($_SESSION['id'])==TRUE){
		
	include '../main/header.php';
	include '../sql/opendb.php';
	
	
		
	$where = "WHERE m.memberID = o.memberID and o.OrderID = od.OrderID and p.ProductID = od.ProductID ";
	
	
	if(isset($_POST['btnFilter'])){
		$name = mysql_real_escape_string($_POST['txtName']);
		$date = date("Y-m-d",strtotime($_POST['txtDate']));// alter date format	
		
		if($date=='1970-01-01'){
			$date = null;
		}
			if($date != null){
				$operator = $_POST['sltOperator'];
				$where .= "AND o.orderDate $operator '".$date."' ";
			}
				
			if(isset($_POST['chkName'])){
				$where .= "AND m.userName = '".$name."' ";
			}		
	}
	
	$query = "SELECT m.userName,o.OrderID,p.ProductName,od.quantity_order,od.amount,o.OrderDate
			  FROM orders o,members m,order_det od,products p
			  $where
			  ORDER BY m.userName";
	
	
	$query1 = "SELECT m.userName,sum(od.amount)
			   FROM orders o,members m,order_det od,products p
			   $where
			   GROUP BY m.userName
			   ORDER BY m.userName";
	$total=0;
	$subTotal=array();
	$name = array();
	
	$result = mysql_query($query)or die(mysql_error());
	$resultAmt = mysql_query($query1)or die(mysql_error());	
	
	if(mysql_num_rows($result)<=0){
		$query = "SELECT m.userName,o.OrderID,p.ProductName,od.quantity_order,od.amount,o.OrderDate
			  FROM orders o,members m,order_det od,products p
			  WHERE m.memberID = o.memberID and o.OrderID = od.OrderID and p.ProductID = od.ProductID 
			  ORDER BY m.userName";
		
		$query1 ="SELECT m.userName,sum(od.amount)
			   	  FROM orders o,members m,order_det od,products p
			  	  WHERE m.memberID = o.memberID and o.OrderID = od.OrderID and p.ProductID = od.ProductID 
			   	  GROUP BY m.userName
			  	  ORDER BY m.userName";
				  
		$result = mysql_query($query);
		$resultAmt = mysql_query($query1);
	}	
	
	while($row = mysql_fetch_row($resultAmt)){
		$subTotal[] = $row[1];
		$name[] = $row[0];
		$total +=$row[1];
	}

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
  
<div class="row">
<form action="Grib_CustOrder.php" method="POST">
<div><strong>Filter By:</strong></div>
 <div class="row">
	<div class="large-6 columns">
		 <div>Order Date</div>
	 <div class="large-8 columns">	
		<input type="text" id="datepicker" name='txtDate' placeholder='Select Date'/>
	 </div>
	 <div class="large-4 columns">	
		<select name='sltOperator'>
			<option value="=" selected="">=</option>
			<option value=">">></option>
			<option value="<"><</option>
			<option value="<="><=</option>
			<option value=">=">>=</option>
		</select>
	 </div>
	</div>
 </div>
 
 <div class="row">
	<div class="large-6 columns">
		 <div>User Name</div>
	 <div class="large-8 columns">	
		<input type="text" name='txtName' placeholder='Enter UserName'/>
	 </div>
		<input type="checkbox" name="chkName"/> With Name
	</div>
 </div>
 
<div class="large-6 columns">
 			<button type="submit" name="btnFilter" class="medium button green" >Filter</button>
 </div>
</form>
</div>
<div id="report" class="row">
	<h2>Customer Sale Report</h2>
<?php if(mysql_num_rows($result)>0){ ?>
<table class="bordered" style="text-align: center">
	<tr>
		<th>User Name</th>
		<th>Order ID</th>
		<th>Product Name</th>
		<th>Quantity Order</th>
		<th>Order Date</th>
		<th>Amount (RM)</th>
	</tr>
		<tbody>
			<?php
				$i=0;
				while($row = mysql_fetch_row($result)){  
					if($row[0]!=$name[$i]){
						echo "<tr>
								<td colspan='4'></td>
								<td><b>Sub Total</b></td>
								<td ><b>$subTotal[$i]</b></td>
							  </tr>";
						$i++;
					}else{
					?>
						<tr>
							<td><?php echo $row[0] ?></td>
							<td><?php echo $row[1] ?></td>
							<td><?php echo $row[2] ?></td>
							<td><?php echo $row[3] ?></td>
							<td><?php echo $row[5] ?></td>
							<td><?php echo $row[4] ?></td>
						</tr>
					<?php
					}
				}
				echo "<tr>
						<td colspan='4'></td>
						<td><b>Sub Total</b></td>
						<td ><b>$subTotal[$i]</b></td>
					  </tr>";
			?>
			<tr><td colspan='5'></td><td><b>Total : <?php echo $total; ?></b></td></tr>
		</tbody>
</table>
<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
<?php }else{
	echo "<h2><strong>No data Found</strong></h2>";	
}

include '../main/footer.php'; 
}?>

