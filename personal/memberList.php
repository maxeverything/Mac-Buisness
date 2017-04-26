<?php
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){

include '../Main/header.php';
include '../sql/opendb.php';

$query = "SELECT * 
		  FROM members
		  WHERE memberStatus!='Freeze'";
		  
$result = mysql_query($query);

?>	
<script type="text/javascript" src="../js/my_food_plan_pick_foods.js"></script>
<script type="text/javascript" src="../js/uitablefilter.js"></script>	
<div class="row">
	<h2>Select Member Profile</h2>
	
	<form  method="POST" action="upload_NewprodImgs.php">
<div class="large-4 columns">
 Filter: <input name="filter" id="filter" value="" maxlength="30" size="30" type="text" placeholder="enter name to filter" autofocus=""><br>
 </div>
<div class="large-10 large-centered columns">
<table class="food_planner" width="100%">
	<thead>
	<tr>
		<th colspan="2">MemberID</th>
		<th colspan="2">UserName</th>
		<th colspan="2">Email</th>
		<th colspan="2">registerdate</th>
		<th colspan='2'>Profile_pic</th>
	</tr>
	</thead>
    <tbody>
	<tr style="display: table-row;">
		<?php
			$i=0;
			while($row = mysql_fetch_assoc($result)){
		?>
	<tr>
		<td colspan="2"><?php echo $row['memberID']; ?></td>
		<td colspan="2"><a href="#"><?php echo $row['userName']; ?><input name="<?php echo "food_source_row_$i"; ?>" value="USDA" type="hidden"></a></td>
		<td colspan="2"><?php echo $row['email']; ?></td>
		<td colspan="2"><?php echo $row['registerDate']; ?></td>
		<td colspan="2"><img src='../Personal/<?php echo $row['Profile_pic']; ?>' style="width: 30px; height:30px"/></td>
	</tr>
	
		<?php
			$i++;
		}
		?>
	</tr>
	</tbody>
</table>
</div>
<br><br>	
</form> 
</div>
<?php include '../Main/footer.php'; 
}?>