<?php
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
include '../Main/header.php';
include '../sql/openDb.php';
if($_SESSION['id'][0] != 'S'){
?>
	<script>
		window.onload = function() {
			window.location.replace("../Home/homepage.php");
			alert( "Authorization Error, only staff can access." ); 
		}
	</script>
<?php
	}
$query = "SELECT memberID,userName,email,contact,pointAcc,profile_pic
		  FROM members
		  WHERE memberStatus!='Freeze'";
		  
$result = mysql_query($query);


?>

<br/>
<div class="row">

<h2>Member List</h2>
		<table class="large-12 columns">
			<tr>
				<th>MemberID</th>
				<th>User Name</th>
				<th>E-mail</th>
				<th>Contact</th>
				<th>Points</th>
				<th>Profile Picture</th>
			</tr>
			
			<?php while($row = mysql_fetch_row($result)){ ?>
			<tr>
				<td style="text-align: center">
				 <a href="../personal/Deactive_member.php?deactive_id=<?php echo $row[0]?>">
					<?php echo $row[0] ;?>
				 </a>
				</td>
				<td style="text-align: center"><?php echo $row[1] ;?></td>
				<td style="text-align: center"><?php echo $row[2] ;?></td>
				<td style="text-align: center"><?php echo $row[3] ;?></td>
				<td style="text-align: center"><?php echo $row[4] ;?></td>
				<td style="text-align: center">
					<?php echo "<img src='../personal/$row[5]' style='width:100px;height:100px;'></img>" ;?></td>
			</tr>
			
			<?php	}	?>
		</table>
						
	
	
</div>
<?php include '../Main/footer.php'; 
}?>
