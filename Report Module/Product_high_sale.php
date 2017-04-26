 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>


<?php
	include '../main/authorization.php';
	if(checkManager($_SESSION['id'])==TRUE){
		
	include '../main/header.php';
	include '../sql/opendb.php';

$where = "WHERE p.productID = od.productID
			      	AND od.orderID = o.orderID AND DATE_FORMAT(CURDATE(),'%Y')-DATE_FORMAT(o.orderdate,'%Y')<=5 ";
	
if(isset($_POST['filter'])){
	$operator = $_POST['sltOperator'];
	
	$date = date("Y-m-d",strtotime($_POST['filterDate']));// alter date format
	 
	$where .= "and o.orderDate $operator'".$date."' ";
}

	$where .= " GROUP BY p.productName
			  ORDER BY SUM(od.amount) DESC";
	
	
	$query = "SELECT p.productID,p.productName,SUM(od.quantity_order) AS 'Total_Quantity_Sold',
			SUM( od.amount ) AS  'Total_sales',o.orderDate
			  FROM products p, order_det od, orders o
			  $where";
			  
	$result = mysql_query($query) or die(mysql_error());
	
	if(mysql_num_rows($result)<=0){
		$query = "SELECT p.productID,p.productName,SUM(od.quantity_order) AS 'Total_Quantity_Sold',
					SUM( od.amount ) AS  'Total_sales',o.orderDate
				  FROM products p, order_det od, orders o
			  	  WHERE p.productID = od.productID
			      	AND od.orderID = o.orderID AND DATE_FORMAT(CURDATE(),'%Y')-DATE_FORMAT(o.orderdate,'%Y')<=5
				  GROUP BY p.productName
			  	  ORDER BY SUM(od.amount) DESC";
		
		$result = mysql_query($query);
	}
	
	$data = array();
	$proName = array();
	$proID = array();
	
	$count = mysql_num_rows($result);
	
	while($row = mysql_fetch_row($result)){
		$data[] =  $row[3];
		$proID[] = $row[0];
		$proName1[] = $row[1];
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
<br/>
<div class="row">
<h2>Product Ranking Sale Report</h2>

<form action="Product_high_sale.php" method="POST" class="custom">
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
</div>
<div id="report" class="row">
	<h3>Product Highest Sale Report</h3>
	<table class="bordered">
<thead>
<tr>
<th class="table-sort">ProductID</th>
<th class="table-sort">Product Name</th>
<th class="table-sort">Total_Quantity_Sold</th>
<th class="table-sort">Total Sale(RM)</th>
<th class="table-sort">Order Date</th>
</tr>
</thead>
<tbody>
<?php $result = mysql_query($query); 
	while($row = mysql_fetch_assoc($result)){
?>
	<tr>
		<td><?php echo $row['productID']; ?></td>
		<td><?php echo $row['productName']; ?></td>
		<td><?php echo $row['Total_Quantity_Sold']; ?></td>
		<td><?php echo $row['Total_sales']; ?></td>
		<td><?php echo $row['orderDate']; ?></td>
		
	</tr>
<?php } ?>
</tbody>
</table>



<script type='text/javascript'>//<![CDATA[ 
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Product Best Sales'
            },
            subtitle: {
                text: 'CMS enterprise Product'
            },
            xAxis: {
                categories: [<?php echo join($proID,", "); ?>],
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sale (RM)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' RM'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Product ID',
                data: [<?php echo join($data,',') ?>]
            }]
        });
    });
</script>

<br/>
<div class="row">
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

</div>
</div>
<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
<br/>
<?php include '../main/footer.php'; 
}?>

  

