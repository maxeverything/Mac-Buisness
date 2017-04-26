<html>
<body>
<?php
include('../sql/config.php');
include '../sql/opendb.php';
if(isset($_POST['submit']))
{
$color=mysql_real_escape_string($_POST['color']);
$qty=mysql_real_escape_string($_POST['qty']);
$query1=mysql_query("insert into product_color (productID,qty,color) values('2','$qty','$color')");
echo "insert into addd values('','$color','$qty')";
if($query1)
{
header("location:list.php");
}
}
?>
<fieldset style="width:300px;">
<form method="post" action="addColor.php">
Color: <input type="text" name="color"><br>
Qty: <input type="text" name="qty"><br>
<br>
<input type="submit" name="submit">
</form>
</fieldset>
</body>

</html>