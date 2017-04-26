<?php

	include '../main/authorization.php';
	if(checkManagerAndStaff($_SESSION['id'])==TRUE){
		
	include '../main/header.php';
	include '../sql/opendb.php';
		
	$query="Select m.UserName, s.shopName, p.productName, r.quantity, r.DateSend
		From return_handle r, orders o, members m, products p, shops s 
		where r.OrderID=o.OrderID
		AND o.memberID=m.memberID
		AND r.productID=p.productID
		AND p.shopID=s.shopID ";
	
	$where="";
	if(isset($_REQUEST['dateTo'])&&isset($_REQUEST['dateFrom'])&&!empty($_REQUEST['dateTo'])&&!empty($_REQUEST['dateFrom'])){		
		$where.=" AND r.DateSend between '".$_REQUEST['dateFrom']."' AND '".$_REQUEST['dateTo']."' ";
	}
	if(isset($_REQUEST['shopName'])&&!empty($_REQUEST['shopName'])){
		$where.=" AND s.shopName='".$_REQUEST['SellerName']."' ";
	}
	if(isset($_REQUEST['MemberName'])&&!empty($_REQUEST['MemberName'])){
		$where.=" AND m.UserName='".$_REQUEST['MemberName']."' ";
	}
	
	$query=$query.$where." ORDER BY r.DateSend, s.shopName, m.UserName ";
	$result=mysql_query($query) or die(mysql_error());
	$total=0;
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#dateFrom").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat : "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#dateTo").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#dateTo").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat : "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#dateFrom").datepicker("option", "maxDate", selectedDate);
			}
		});
		$('#shopName').autocomplete({
			source:"autocomplete_ShopName.php?term="
		});
		$('#MemberName').autocomplete({
			source:"autocomplete_memberName.php?term="
		});
		
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
<div class="row" style="background-color:#F9F9F9;">
	<h2>Product Return Report</h2>
  <form action="productReturnReport.php">
  	<div class="small-12 large-12 row panel">
  		<h3>Date</h3>
  		<div class="small-12 large-4 columns">
  		<label class="label">From</label>
  		<input type="text" id="dateFrom" name="dateFrom" /></div>
  		<div  class="small-12 large-4 columns">
	  	<label class="label">To</label>
  		<input type="text" id="dateTo" name="dateTo" /></div>
  		<div class="large-4 columns"></div>
  	</div>
  	<div class="small-12 large-12 row panel">
  		<h3>Search By<small>(Optional)</small></h3>
  		<div class="small-12 large-4 columns">
  		<label class="label">Member Name</label>
  		<input type="text" id="MemberName" name="MemberName" />
  		</div>
  		<div class="small-12 large-4 columns">
  		<label class="label">Shop Name</label>
  		<input type="text" id="shopName" name="shopName" />
  		</div>
  		<div class="small-12 large-4 columns">
  			<button type="submit" name="btnFind" class="medium button green " >Find</button></div>
  	</div>
  	
  </form>
  
  <div id="report" class="large-12 columns panel">
  	<h3>Product Return Report</h3>
  	<?php
  	if(mysql_num_rows($result)>0){
  	?>
  		<table class="bordered large-12 small-12">
			<thead>
			<tr>
			<th class="table-sort large-2 small-2">Date</th>
			<th class="table-sort large-3 small-3">Member Name</th>
			<th class="table-sort large-3 small-3">Product Name</th>
			<th class="table-sort large-3 small-3">Shop Name</th>
			<th class="table-sort large-1 small-1">Quantity</th>
			</tr>
			</thead>
			<tbody>

  	<?php
  		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
  			$total+=$row['quantity'];
  	?>
  			<tr>
  			<td><?php echo $row['DateSend']; ?></td>
			<td><?php echo $row['UserName']; ?></td>
			<td><?php echo $row['productName']; ?></td>
			<td><?php echo $row['shopName']; ?></td>			
			<td class="right"><?php echo $row['quantity']; ?></td>			
			</tr>
  	<?php  			
  		}
	?>
		<tr>
			<td colspan="4" >
			<h4><label class="right">Total Quantity:</label></h4>
			</td>
			<td class="right"><h4><?php echo $total; ?></h4></td>
		</tr>
		</tbody>
		</table>
	<?php
	}else{
	?>
	<script>
	window.onload = function() {
		window.location.replace("productReturnReport.php");
		alert("No Record Found!");
	}
	</script>
	<?php	
	}
  	?>
  </div>
  <div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
<?php
include '../main/footer.php';
}
?>