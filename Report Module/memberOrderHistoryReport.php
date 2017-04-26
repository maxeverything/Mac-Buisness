<?php

	include '../main/authorization.php';
	if(authetication()==TRUE){
		
	include '../main/header.php';
	include '../sql/opendb.php';
	$query="Select sum(od.amount) AS amount, m.userName, o.orderDate, o.orderID, o.orderDate, sum(od.quantity_order) as qty
		FROM orders o, order_det od, members m
		WHERE m.memberID=o.memberID
		AND o.orderID=od.orderID ";
	$where="";
	if(isset($_REQUEST['dateTo'])&&isset($_REQUEST['dateFrom'])&&!empty($_REQUEST['dateTo'])&&!empty($_REQUEST['dateFrom'])){		
		$where.=" AND o.orderDate between '".$_REQUEST['dateFrom']."' AND '".$_REQUEST['dateTo']."' ";
	}
	if(isset($_REQUEST['MemberName'])&&!empty($_REQUEST['MemberName'])){
		$where.=" AND m.UserName='".$_REQUEST['MemberName']."' ";
	}
	$query.=$where." GROUP BY od.orderID ORDER BY o.orderID ";
	$result=mysql_query($query) or die(mysql_error());
	$total=0;
	$totalQty=0;
	$count=mysql_num_rows($result);
	if($count>0){
?>
<script>
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
		$('#MemberName').autocomplete({
			source:"autocomplete_memberName.php?term="
		});
		
	});
	 function printReport() {
        var prtGrid = document.getElementById('report');
        prtGrid.border = 0;
        var prtwin = window.open('', 'PrintGridViewData', 'left=150, top=150, width=1000, height=1000, tollbar=0, scrollbars=1, status=0, resizable=1');
        prtwin.document.write(prtGrid.outerHTML);
        prtwin.document.close();
        prtwin.focus();
        prtwin.print();
        prtwin.close();
    }
</script>
<div class="row small-12 large-12">
	<h2>Product Return Report</h2>
  <form >
  	
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
  			<button type="submit" name="btnFind" class="medium button green " >Find</button>		
  		</div>
  		<div class="small-12 large-4 columns">
  		</div>
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
			<th class="table-sort large-2 small-2">Member Name</th>
			<th class="table-sort large-2 small-2">Order ID</th>
			<th class="table-sort large-3 small-3">Order Date</th>
			<th class="table-sort large-2 small-2">total Qty</th>
			<th class="table-sort large-3 small-3">Total</th>
			</tr>
			</thead>
			<tbody>

  	<?php
  		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
  			$totalQty+=$row['qty'];
  			$total+=$row['amount'];
  	?>
  			<tr>
  			<td><?php echo $row['userName']; ?></td>
			<td><?php echo $row['orderID']; ?></td>
			<td><?php echo $row['orderDate']; ?></td>
			<td><?php echo $row['qty']; ?></td>			
			<td class="right"><?php echo $row['amount']; ?></td>			
			</tr>
  	<?php  			
  		}
	?>
		<tr>
			<td colspan="3" >
			<h4><label class="right">Total:</label></h4>
			</td>
			<td class="alignright"><h4><?php echo $totalQty; ?></h4></td>
			<td class="right"><h4><?php echo $total; ?></h4></td>
		</tr>
		<tr>
			<td colspan="5">
			<h4><label class="label">Average sales:</label>
				<?php echo round($total/$count,2);?>
			</h4>
			</td>
		</tr>
		</tbody>
		</table>
	<?php
	}else{
	?>
	<script>
	window.onload = function() {
		//window.location.replace("memberOrderHistoryReport.php");
		//alert("No Record Found!");
	}
	</script>
	<?php	
	}
  	?>
  </div>
  <div class="row small-12 large-12">
<button type="submit" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
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
include '../main/footer.php';
}
?>