
<?php
include '../main/authorization.php';
if(checkManagerAndStaff($_SESSION['id'])==TRUE){

include '../main/header.php';
require '../sql/openDb.php';

$query = "SELECT *
		  FROM sellers
		  ORDER BY date_format(registerDate,'%Y')";

$query1 = "SELECT count(sellerID) as 'No Register',date_format(registerDate,'%Y') as 'Year'
		   FROM sellers
		   WHERE sellerStatus!='FREEZE'
		   GROUP BY date_format(registerDate,'%Y')
		   ORDER BY date_format(registerDate,'%Y')";

$query2 = "SELECT count(sellerID) as 'No Register'
		   FROM sellers
		   GROUP BY date_format(registerDate,'%Y')
		   ORDER BY date_format(registerDate,'%Y')";
		   
$result = mysql_query($query);
$resultNo = mysql_query($query1);
$result1 = mysql_query($query2);

$subTotal=array();
$total = 0;
while($row1 = mysql_fetch_row($result1)){
	$subTotal[] = $row1[0];
	$total += $row1[0];
}

$subTotal_a=array();
$year = array();
$total_a = 0;

while($row = mysql_fetch_row($resultNo)){
	$subTotal_a[] = $row[0];
	$year[] = $row[1];
	$total_a += $row[0];
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
  
  
<div id="report" class="row">
	<h2>Sellers Report</h2>
<?php if(mysql_num_rows($result)>0){ ?>
<table class="bordered" style="text-align: center">
	<tr>
		<th>Seller ID</th>
		<th>Seller Name</th>
		<th>email</th>
		<th>Contact</th>
		<th>Status</th>
		<th>Register date</th>
		<th>Company Name</th>
	</tr>
		<tbody>
			<?php
				$i=0;
				while($row = mysql_fetch_row($result)){  
					if(date('Y', strtotime($row[5]))!=$year[$i]){
						echo "<tr>
								<td colspan='5'></td>
								<td><b>No of member</b></td>
								<td ><b>$subTotal[$i]</b></td>
							  </tr>
							  
							  <tr>
								<td colspan='5'></td>
								<td><b>Active member</b></td>
								<td ><b>$subTotal_a[$i]</b></td>
							  </tr>";
						$i++;
					}else{
					?>
						<tr>
							<td><?php echo $row[0] ?></td>
							<td><?php echo $row[1] ?></td>
							<td><?php echo $row[3] ?></td>
							<td><?php echo $row[4] ?></td>
							<td><?php echo $row[6] ?></td>
							<td><?php echo $row[5] ?></td>
							<td><?php echo $row[7] ?></td>
						</tr>
					<?php
					}
				}
				echo "<tr>
						<td colspan='5'></td>
						<td><b>No of Seller</b></td>
						<td ><b>$subTotal[$i]</b></td>
					  </tr>
				
					  <tr>
						<td colspan='5'></td>
						<td><b>Active seller</b></td>
						<td ><b>$subTotal_a[$i]</b></td>
					  </tr>";
			?>
			<tr><td colspan='5'></td><td colspan="2"><b>Total of Active Seller: <?php echo $total; ?></b></td></tr>
			<tr><td colspan='5'></td><td colspan="2"><b>Total of Active Seller: <?php echo $total_a; ?></b></td></tr>
		</tbody>
</table>
<?php if($_SESSION['id'][0]=='G'){ ?>
	

<div class="row small-12 large-12">
<button type="submit" name="btnFind" class="medium button green right" onclick="printReport()">Print Report</button>
</div>

<?php } ?>
</div>

<?php 
}
include '../main/footer.php';
} ?>