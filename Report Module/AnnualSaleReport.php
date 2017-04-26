 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<?php
	include '../main/authorization.php';
	if(checkManager($_SESSION['id'])==TRUE){
	
	include '../main/header.php';
	include '../sql/opendb.php';
	
	$where = "Where o.OrderID = od.OrderID And Date_Format(CurDate(), '%Y')-Date_Format(o.OrderDate, '%Y') <= 8 ";
	
	if(isset($_POST['filter'])){	
		$year = mysql_real_escape_string($_POST['filterDate']);
		if($year != 0){
			$operator = $_POST['sltOperator'];
			$where .= "and Date_Format(o.OrderDate, '%Y') $operator '".$year."'";
		}
	}
	
	
	$query = "Select Date_Format(o.OrderDate, '%M') As Months,Date_Format(o.OrderDate, '%Y') As Year,Sum(od.amount) As `Yearly Sales`
			  From orders o,order_det od
			  $where
			  Group By Date_Format(o.OrderDate, '%M'),Date_Format(o.OrderDate, '%Y')
			  ORDER BY Date_Format(o.OrderDate, '%Y')";
	
	$result = mysql_query($query) or die(mysql_error());

	$data = array();
	$year = array();
	$i=1;
	$j=0;
	$count = mysql_num_rows($result);
	
	if($count <= 0){
	   $query = "Select Date_Format(o.OrderDate, '%M') As Months,Date_Format(o.OrderDate, '%Y') As Year,Sum(od.amount) As `Yearly Sales`
			  From orders o,order_det od
			  Where o.OrderID = od.OrderID And Date_Format(CurDate(), '%Y')-Date_Format(o.OrderDate, '%Y') <= 8 
			  Group By Date_Format(o.OrderDate, '%M'),Date_Format(o.OrderDate, '%Y')
			  ORDER BY Date_Format(o.OrderDate, '%Y')";
			  
		$result = mysql_query($query);
	}
	
	while($row = mysql_fetch_row($result)){
		$data[] =  $row[2];
		$year[] = "'".$row[0]."/".$row[1]."'";
	}

?>

<link href="css/table.css" type="text/css" rel="stylesheet" />

<br/>
<div class="row">
<h2>Annual Sale Report</h2>

<form action="annualsaleReport.php" method="POST">
<div>Filter OrderDate:</div>
	<div class="large-6 columns">
	 <div class="large-8 columns">	
		<input type="text" name='filterDate' placeholder='Enter Year OR Enter 0 to view all'/>
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
<th class="table-sort">Month</th>
<th class="table-sort">Year</th>
<th class="table-sort">Yearly Sales</th>
</tr>
</thead>
<tbody>
<?php $result = mysql_query($query); 
	while($row = mysql_fetch_assoc($result)){
?>
	<tr>
		<td><?php echo $row['Months']; ?></td>
		<td><?php echo $row['Year']; ?></td>
		<td><?php echo $row['Yearly Sales']; ?></td>		
	</tr>
<?php } ?>
</tbody>
</table>



<script type='text/javascript'>//<![CDATA[ 
	$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'Annual Sale report'
            },
            xAxis: {
                categories: [<?php echo join($year,',') ?>],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Sale Amount(RM)'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Amount Sale: <b>{point.y:.1f} (RM)</b>',
            },
            series: [{
                name: 'Amount',
                data: [<?php echo join($data,',') ?>],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
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
//]]>  
</script>
<br/>
<div class="row">
<script src="http://code.highcharts.com/highcharts.js"></script>

<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="height: 300px"></div>

</div>
</div>
<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
<br/>
<?php 
include '../main/footer.php'; 
}?>