 <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<?php
	include '../main/authorization.php';
	if(checkManager($_SESSION['id'])==TRUE){
		
	include '../main/header.php';
	include '../sql/opendb.php';
	
	if(isset($_POST['filter'])){
		
	}
	
	$query = "SELECT COUNT( memberID ) AS  'No of Register', date_format(registerDate,'%M%Y') as month
			  FROM members";
			  
	$where="";
	if(isset($_REQUEST['dateFrom'])&&isset($_REQUEST['dateTo'])&&!empty($_REQUEST['dateFrom'])&&!empty($_REQUEST['dateTo'])){
		$where.=" WHERE registerDate between '".$_REQUEST['dateFrom']."' AND '".$_REQUEST['dateTo']."' ";
	}
	$query.=$where." GROUP BY date_format(registerDate,'%M%Y')
			  ORDER by month";

	$result = mysql_query($query) or die(mysql_error());

	$data = array();
	$year = array();
	if(mysql_num_rows($result)>0){

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
<h2>Customer Registation Report</h2>
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
<div id="report">
<div class="row">

<h3>Number of customer Register</h3>

<table class="bordered">
<thead>
<tr>
<th class="table-sort">Year</th>
<th class="table-sort">No of Register</th>
</tr>
</thead>
<tbody>
<?php $result = mysql_query($query); 
	while($row = mysql_fetch_assoc($result)){
		$data[] =  $row['No of Register'];
		$year[] = "'".$row['month']."'";
?>
	<tr>
		<td><?php echo $row['month']; ?></td>
		<td><?php echo $row['No of Register']; ?></td>		
	</tr>
<?php } ?>
</tbody>
</table>
</div>


<script type='text/javascript'>//<![CDATA[ 
$(function () {
        $('#container').highcharts({
            
            chart: {
            },
            
            title: {
                text: 'Number of Customer Register'
            },
            
            xAxis: {
				title: {
	             text: 'Year'
	                 //align: 'center'
	             },
                categories :['2009',<?php echo join($year,',') ?>] 
            },
          
            yAxis: {
				title: {
	             text: 'No of Customer'
	                 //align: 'center'
	             },
				allowDecimals : false,

            },
            
            tooltip: {
                headerFormat: 'No of customer = {point.y}<br />',
               	valueSuffix: ' peoples',
            },
            
            series: [{ 
				name : 'report ',           
                data: [<?php echo join($data,',') ?>],
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

<div id="container" style="height: 300px"></div>

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
}
?>

  

