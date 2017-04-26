 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<?php
	include '../main/authorization.php';
		
	include '../main/header.php';
	include '../sql/opendb.php';
	$queryDaily="Select sum(d.amount) as total, o.orderDate 
			From order_det d, orders o, products p, shops s 
			where o.orderID=d.orderID 
			AND p.productID=d.productID
			AND p.shopID=s.shopID ";
	$where="";
	if(isset($_REQUEST['dateFrom'])&&isset($_REQUEST['dateTo'])&&!empty($_REQUEST['dateFrom'])&&!empty($_REQUEST['dateTo'])){
		$where.=" AND o.orderDate between '".$_REQUEST['dateFrom']."' AND '".$_REQUEST['dateTo']."' ";
	}
	if(isset($_SESSION['shopID'])&&!empty($_SESSION['shopID'])){
		$where.="AND s.shopID=".$_SESSION['shopID']." ";
	}
	$queryDaily.=$where." GROUP BY o.orderDate ORDER BY o.orderDate ";
	
	
	$queryMonthly = "SELECT SUM(d.amount) AS total, date_format(o.orderDate,'%m') as Month, date_format(o.orderDate,'%y') as year
			From order_det d, orders o, products p, shops s 
			where o.orderID=d.orderID 
			AND p.productID=d.productID
			AND p.shopID=s.shopID ";
	$queryMonthly.=$where." GROUP BY date_format(o.orderDate,'%m')
			ORDER by Month";
	$resultDaily=mysql_query($queryDaily)or die (mysql_error());
	$resultMonthly = mysql_query($queryMonthly) or die(mysql_error());

	$dataDaily = array();
	$day=array();
	
	$dataMonthly=array();	
	$month = array();
	
	

?>

<link href="css/table.css" type="text/css" rel="stylesheet" />

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
  });
    function printReport() {
        var prtGrid = document.getElementById('rpSellerSale');
        prtGrid.border = 0;
        var prtwin = window.open('', 'PrintGridViewData', 'left=150, top=150, width=1000, height=1000, tollbar=0, scrollbars=1, status=0, resizable=1');
        prtwin.document.write('<link rel="stylesheet" href="../css/foundation.css">'+prtGrid.outerHTML);
        prtwin.document.close();
        prtwin.focus();
        prtwin.print();
        prtwin.close();
    }
</script>
  </script>
<br/>
<?php
if(mysql_num_rows($resultDaily)>0){	
?>
<div class="row">
	<form>
		<div class="small-12 large-4 columns">
  		<label class="label">From</label>
  		<input type="text" id="dateFrom" name="dateFrom" /></div>
  		<div  class="small-12 large-4 columns">
	  	<label class="label">To</label>
  		<input type="text" id="dateTo" name="dateTo" /></div>
  		<div class="large-4 columns"><div class="small-12 large-4 columns"><button type="submit" name="btnFind" class="medium button green " >Filter</button></div></div>
	</form>
</div>
<div id="rpSellerSale">
<div class="row">
<div class="small-6 large-6 columns">
<h2>Daily sales report</h2>

	<table class="bordered">
<thead>
<tr>
<th class="table-sort">Date</th>
<th class="table-sort">Total amount</th>
</tr>
</thead>
<tbody>
<?php
	while($row = mysql_fetch_array($resultDaily,MYSQL_ASSOC)){
		$dataDaily[] = $row['total'];
		$day[]="'".$row['orderDate']."'";
?>
	<tr>
		<td><?php echo $row['orderDate']; ?></td>
		<td><?php echo $row['total']; ?></td>		
	</tr>
<?php } ?>
</tbody>
</table>
</div>
<div class="small-6 large-6 columns">
<h2>Monthly sales report</h2>

	<table class="bordered">
<thead>
<tr>
<th class="table-sort">Month/year</th>
<th class="table-sort">Total amount</th>
</tr>
</thead>
<tbody>
<?php
	while($row = mysql_fetch_array($resultMonthly,MYSQL_ASSOC)){
		$month[]="'".$row['year']."-".$row['Month']."'";	
		$dataMonthly[] = $row['total'];
?>
	<tr>
		<td><?php echo $row['Month']."/".$row['year']; ?></td>
		<td><?php echo $row['total']; ?></td>		
	</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>


<script type='text/javascript'>//<![CDATA[ 
$(function () {	
        $('#containerDaily').highcharts({
            
            chart: {
            },
            
            title: {
                text: 'Shop sales report'
            },
            
            xAxis: {
				title: {
	             text: 'Date'
	                 //align: 'center'
	             },
                categories :['2009',<?php echo join($day,',') ?>] 
            },
          
            yAxis: {
				title: {
	             text: 'sales(RM)'
	                 //align: 'center'
	             },
				allowDecimals : false,

            },
            
            tooltip: {
                headerFormat: 'sales = {point.y}<br />',
               	valueSuffix: ' RM',
            },
            
            series: [{ 
				name : 'report ',
                data: [<?php echo join($dataDaily,',') ?>],
                pointStart: 1
            }]
        });
         $('#containerMonthly').highcharts({
            
            chart: {
            },
            
            title: {
                text: 'Shop sales report'
            },
            
            xAxis: {
				title: {
	             text: 'Month'
	                 //align: 'center'
	             },
                categories :['2009',<?php echo join($month,',') ?>] 
            },
          
            yAxis: {
				title: {
	             text: 'sales(RM)'
	                 //align: 'center'
	             },
				allowDecimals : false,

            },
            
            tooltip: {
                headerFormat: 'sales = {point.y}<br />',
               	valueSuffix: ' RM',
            },
            
            series: [{ 
				name : 'report ',
                data: [<?php echo join($dataMonthly,',') ?>],
                pointStart: 1
            }]
        });
    });
	
//]]>  
</script>

<br/>
<div class="row">
  <script src="http://code.highcharts.com/highcharts.js"></script>

<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="containerDaily" style="height: 300px"></div>
<div id="containerMonthly" style="height: 300px"></div>

</div>
<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
<br/>
<?php include '../main/footer.php';
}else{
	?>
	<script>
		window.onload = function() {
		window.location.replace("sellerSaleReport.php");
		alert("No Record Found!");
		}
	</script>
		<?php
	}
 ?>

  

