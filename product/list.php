<html>
<body>

<?php
include '../sql/config.php';
include '../sql/opendb.php';
$query1=mysql_query("select id, color, qty from product_color where productID=2");
include 'addColor.php';
if($query1){
echo "<table id='tblColor'><tr><td>Color</td><td>Qty</td><td></td><td></td>";
while($row=mysql_fetch_array($query1))
{
echo "<tr><td>".$row['color']."</td>";
echo "<td>".$row['qty']."</td>";
echo $row['id'];
echo "<td><a href='deleteProduct.php?id=".$row['id']."'>x</a></td><tr>";
}
?>
</ol>
</able>
<?php
}
?>
</body>
<script type="text/javascript">
	function deleteProductColor(id){
		new Ajax.Request("deleteProduct.php?id="+id);
	}
	</script>
</html>