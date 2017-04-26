<?php 
include '../main/authorization.php';
if(checkMember($_SESSION['id'])==TRUE){
	
include '../Main/header.php'; ?>

<style>
table { 
color: #333;
font-family: Helvetica, Arial, sans-serif;
width:100%;
border-spacing: 0;
border:solid 2px #404040 ; 
}

td, th { 
border: 1px solid transparent; /* No more visible border */
transition: all 0.3s;  /* Simple transition for hover effect */
}

th {
background: #B8B8B8 ;  /* Darken header a bit */
font-weight: bold;
}

td {
background: #FAFAFA;
text-align: center;
}

/* Cells in even rows (2,4,6...) are one color */ 
tr:nth-child(even) td { background: #D8D8D8   ; }   

/* Cells in odd rows (1,3,5...) are another (excludes header cells)  */ 
tr:nth-child(odd) td { background: #ffffff; }  

tr td:hover { background: #666; color: #FFF; } /* Hover cell effect! */
</style>

	<script type="text/javascript" src="../js/jquery-latest.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.pager.js"></script>
	<script type="text/javascript">
	$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
			.tablesorterPager({container: $("#pager")});
	});
	
	</script>


<div class="row content" style="height: 530px">
	<h2>View History Report</h2>
	<div class="row">
	<div class="large-6 large-centered columns">	
		<?php
			$conn = mysql_connect('localhost','root','')or die("Connection error");
			mysql_select_db('cms_1');
			
			//this id from session
			$id = $_SESSION['id'];
			
			$qry = "SELECT p.productName,od.quantity_order,p.unitPrice,o.orderDate
					FROM orders o,order_det od,products p
					WHERE o.memberID='$id' AND od.orderID=o.orderID AND p.productID=od.productID";
					
			$result = mysql_query($qry)or die('Query Error '.mysql_error());
			
			if(mysql_num_rows($result)>0){
		?>
<br/>
		
		<table cellspacing="1" class="tablesorter">
			
			<thead>
				<tr style="border-bottom:solid 2px #404040 ;">
					<th style="text-align: center">Product Name</th>
					<th style="text-align: center">Quantity</th>
					<th style="text-align: center">Price</th>
					<th style="text-align: center">Date Purchase</th>
				</tr>
			</thead>
			<tbody>				
		<?php
				while($row = mysql_fetch_row($result)){
						$productName = $row[0];
						$qty_order = $row[1];
						$unitPrice = $row[2];
						$orderDate = $row[3];
						
						echo "<tr><td>".$productName."</td>";
						echo "<td>".$qty_order."</td>";
						echo "<td>".$unitPrice."</td>";
						echo "<td>".$orderDate."</td></tr>";
				}
		
			
		}else{
			
			echo "<h1>No history View</h1>";
		}
			
		?>
		
		</tbody>
		</table>
		</div>
		</div>
		
		<div id="pager" class="large-6 push-3 columns" style="width: 500px;padding-top:20px;margin-left:3em;" align="center">
			<form>
				<div class="large-12 columns">
					<div class="large-2 columns">
						<img src="../images/first.png" class="first"/>
						<img src="../images/prev.png" class="prev"/>
					</div>
					<div class="large-4 columns">
						<input type="text" class="pagedisplay" style="height:20px;width:8em;" />
					</div>
					<div class="large-2 columns">
					<img src="../images/next.png" class="next"/>
						<img src="../images/last.png" class="last"/>
					</div>
					<div class="large-4 columns">
						<select class="pagesize" name="pagesize">
								<option selected="selected" value="10">10</option>
								<option value="15">15</option>
						</select>
					</div>	
				</div>			
			</form>
		</div>
		
		
		
		<script>
		$('select[name="pagesize"]').change(function(){
			var $result = $("#pager");
			var height1 = $('.pagesize').val();
			
			if(height1==15){
				var crtHeight = 45*(height1);
			}else{
				var crtHeight = 53*(height1);
			}
			$(".content").height(crtHeight);
		});
		</script>
</div>
	
<?php include '../Main/footer.php'; 
}?>

