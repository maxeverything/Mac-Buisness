<?php
session_start();
include '../Main/header.php';
include '../sql/opendb.php';
$category=mysql_real_escape_string($_REQUEST['category']);
$query= mysql_query("Select m.* from prefercategory p, members m where p.categoryID='$category' AND p.memberID=m.memberID ")or die(mysql_error());
?>
<div class="small-12 large-12 row">
<h2>Preferring member Detail</h2>
<table class="small-12 large-12">
	<tr>		
	<th class="small-4 large-4">Member Name
	</th>
	<th class="small-4 large-4">Email
	</th>
	<th class="small-4 large-4">Phone
	</th>
	</tr>
<?php
while($row=mysql_fetch_array($query)){
?>
<tr>
	<td><?php echo $row['userName'];?></td>
	<td><?php echo $row['email'];?></td>
	<td><?php echo $row['contact'];?></td>
</tr>
<?php
}
?>
</table>
	
</div>
<?php
include '../main/footer.php';
?>