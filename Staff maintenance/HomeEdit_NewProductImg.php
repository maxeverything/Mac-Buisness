<?php 
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php';

if(checkStaff($_SESSION['id'])!=TRUE){
?>
<script>
            window.onload = function() {
				window.location.replace("../home/homepage.php");
				alert( "Only staff can access" ); 
            }
        </script>
<?php
}

require('../sql/opendb.php');


$query = "SELECT p.productid,p.productName,p.product_date,pp.pic_url
 		  FROM products p, product_pic pp
		  WHERE date_format(curdate(),'%Y')-date_format(product_date,'%Y')<=1 AND product_status='ACTIVATE' AND p.productID=pp.productID
		  GROUP BY p.productid";
		  
$result = mysql_query($query)or die('SQL error '.mysql_error());

?>
	
<script type="text/javascript" src="../js/my_food_plan_pick_foods.js"></script>
<script type="text/javascript" src="../js/uitablefilter.js"></script>			
<div class="row">

							
<h2>Checked Product to upload to homePage</h2>

<form  method="POST" action="upload_NewprodImgs.php">
<div class="large-4 columns">
 Filter: <input name="filter" id="filter" value="" maxlength="30" size="30" type="text" placeholder="enter name to filter" autofocus=""><br>
 </div>
<div class="large-10 large-centered columns">
<table class="food_planner" width="100%">
	<thead><tr>
	<th>_</th>
		<th colspan="2">ProductID</th>
		<th colspan="2">ProductName</th>
		<th colspan="2">date</th>
		<th colspan='2'>Image</th>
			</tr>
	</thead>
    <tbody><tr style="display: table-row;"></tr>
<?php 
	$i=1;
	while($row = mysql_fetch_row($result)){		
?>
	<tr><td><input name="product_list[]" value="<?php echo $row[0] ?>" type="checkbox"></td>
		<td colspan="2"><?php echo $row[0]; ?></td>
		<td colspan="2"><?php echo $row[1]; ?><input name="<?php echo "food_source_row_$i"; ?>" value="USDA" type="hidden"></td>
		<td colspan="2"><?php echo $row[2]; ?></td>
		<td colspan="2"><img src='../Product/<?php echo $row[3]; ?>' style="width: 30px; height:30px"/></td>
	</tr>
	
<?php
	$i++;
	}
?>
	</tbody>
</table>
</div>
<br><br>
<div class="row">
 <div class="small-3 small-centered columns">
     <button  type="submit" id="submit" name="submit_prdList" class="medium button green">Upload</button>
 </div>
</div>	
</form>          
</div>	

<?php require_once('../Main/footer.php'); 
}?>

