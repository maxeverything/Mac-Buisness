<?php 
include '../main/authorization.php';
	
include '../Main/header.php'; ?>

  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript">
	
  // Load the Visualization API and the piechart,table package.
  google.load('visualization', '1', {'packages':['corechart','table']});

  function drawItems(num) {
    var jsonPieChartData = $.ajax({
      url: "../Report Module/Product Categories Report/getpiechartdata.php",
      data: "q="+num,
      dataType:"json",
      async: false
    }).responseText;

    var jsonTableData = $.ajax({
      url: "../Report Module/Product Categories Report/gettabledata.php",
      data: "q="+num,
      dataType:"json",
      async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var piechartdata = new google.visualization.DataTable(jsonPieChartData);
    var tabledata = new google.visualization.DataTable(jsonTableData);

    // Instantiate and draw our pie chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(piechartdata, {
      width: 700,
      height: 500,
      chartArea: { left:"5%",top:"5%",width:"90%",height:"90%" }
    });

    // Instantiate and draw our table, passing in some options.
    var table = new google.visualization.Table(document.getElementById('table_div'));
    table.draw(tabledata, {showRowNumber: true, alternatingRowStyle: true});
  }
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
	  <h2>Categories Product Report</h2>
 </div>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<div class="row" style="background-color:#F9F9F9;">
	
  <form>
  <div class="small-3 columns">
	  <select name="users" onchange="drawItems(this.value)">
	 	 <option value="">Select a Product:</option>
	  <?php
	   require_once('../sql/opendb.php');
	    // Create a Query
	    $sql_query = "SELECT categoryID, categoryname FROM categories ORDER BY categoryID";
	    // Execute query
	    $result = mysql_query($sql_query) or die(mysql_error());
	    while ($row = mysql_fetch_array($result)){
	    echo '<option value='. $row['categoryID'] . '>'. $row['categoryname'] . '</option>';
	    }
	    mysql_close($con);
	  ?>
	  </select>
  </div>
  </form>
  <div id="report">
  <div id="chart_div" align="center" class="large-12 columns"></div>
  <div id="table_div" class="large-12 columns"></div>
  </div>
  <div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>
</div>
<br/>
<?php include '../Main/footer.php'; 
?>
