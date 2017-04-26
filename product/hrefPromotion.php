<?php
include '../sql/config.php';
include '../sql/opendb.php';
if(isset($_REQUEST['btnAddPromotion'])){
	$title=mysql_real_escape_string($_REQUEST['txtPromotionTitle']);
	$description=mysql_real_escape_string($_REQUEST['txtPromotionDescription']);
	$dateFrom=mysql_real_escape_string($_REQUEST['txtDateFrom']);
	$dateTo=mysql_real_escape_string($_REQUEST['txtDateTo']);
	$result=mysql_query("Insert into promotions (promotiontitle, dateFrom, dateTo, description, timeCreate) Values ('$title',STR_TO_DATE('$dateFrom', '%Y-%m-%d'),STR_TO_DATE('$dateTo', '%Y-%m-%d'),'$description',Now())")or die(mysql_error());
	if($result){

?>
<script>
	window.onload = function() {
		window.location.replace("editPromotion.php");
		alert("Promotion was added succesfully");
	}
</script>
<?php
}else{
?>
<script>
	window.onload = function() {
		window.location.replace("editPromotion.php");
		alert("The promotion cannot be add");
	}
</script>
<?php
}
}

if(isset($_REQUEST['btnUpdatePromotionDetail'])){
$title=mysql_real_escape_string($_REQUEST['txtPromotionTitle']);
$description=mysql_real_escape_string($_REQUEST['txtPromotionDescription']);
$dateFrom=mysql_real_escape_string($_REQUEST['txtDateFrom']);
$dateTo=mysql_real_escape_string($_REQUEST['txtDateTo']);
$promotionID=mysql_real_escape_string($_REQUEST['promotionid']);
$result=mysql_query("Update promotions set promotiontitle='$title', dateFrom=STR_TO_DATE('$dateFrom', '%Y-%m-%d'), dateTo=STR_TO_DATE('$dateTo', '%Y-%m-%d'), description='$description' WHERE promotionID='$promotionID'")or die(mysql_error());
if($result){
?>
<script>
	window.onload = function() {
		window.location.replace("editPromotion.php");
		alert("Promotion was update succesfully");
	}
</script>
<?php
}else{
?>
<script>
	window.onload = function() {
		window.location.replace("editPromotion.php");
		alert("The promotion cannot be update");
	}
</script>
<?php
}
}

if(isset($_REQUEST['addPromotionItem'])){
$productID = mysql_real_escape_string($_REQUEST['productid']);
$promotionID=mysql_real_escape_string($_REQUEST['promotion']);
$discount=mysql_real_escape_string($_REQUEST['txtDiscountRate']);
$resultPromotion=mysql_query("Insert into promotion_product (promotionID, ProductID, discount) Values ('$promotionID', '$productID', '$discount')")or die(mysql_error());
}

if(isset($_REQUEST['updatePromotionItem'])){
$productID = mysql_real_escape_string($_REQUEST['productid']);
$promotionID=mysql_real_escape_string($_REQUEST['promotion']);
$discount=mysql_real_escape_string($_REQUEST['txtDiscountRate']);
$resultPromotion=mysql_query("Update promotion_product set discount='$discount' where ProductID='$productID' AND promotionID='$promotionID'")or die(mysql_error());
}

if(isset($_REQUEST['deletePromotionItem'])){
$productID = mysql_real_escape_string($_REQUEST['productid']);
$promotionID=mysql_real_escape_string($_REQUEST['promotion']);
$resultPromotion=mysql_query("Delete from promotion_product where promotionID='$promotionID' AND ProductID='$productID'")or die(mysql_error());
if($resultPromotion>0){
echo json_encode(array("status" => "1"));
}else{
echo json_encode(array("status" => "0"));
}
}
?>