<form >

<?php
include '../sql/config.php';
include '../sql/opendb.php';
$productID = mysql_real_escape_string($_REQUEST['productid']);
$resultProduct=mysql_query("Select * from products where ProductID='$productID'");
$row=mysql_fetch_array($resultProduct, MYSQL_ASSOC);
$promotionID=mysql_real_escape_string($_REQUEST['promotion']);
$resultPromotion=mysql_query("select discount from promotion_product where ProductID='$productID' AND promotionID='$promotionID'");
if(mysql_num_rows($resultPromotion)>0){
	$rowPromotion=mysql_fetch_array($resultPromotion, MYSQL_ASSOC);
	$sub=$row['UnitPrice']*(100-$rowPromotion['discount'])/100;
	$discount=$rowPromotion['discount'];
?>
<div class="row">
	<div class="large-6 small-6 columns">
		Price: 
	</div>	
	<div class="large-6 small-6 columns">
		<label class="lblOriPrice right"><?php echo $row['UnitPrice']; ?></label>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		Disc(%):
	</div>	
<div class="large-6 small-6 columns alignright">
		<input type="number" min="0" value="<?php echo $discount; ?>" class="txtDiscountRate" name="txtDiscountRate" id="txtDiscountRate" class=" "/>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		subTotal:
	</div>	
	<div class="large-6 small-6 columns">
		
 <label class="lblsubTotal right"><?php echo number_format($sub, 2); ?></label>
	</div>	
</div>
<div class="row rowEdit">
<div class="large-12 small-12 columns">
<button id="btnUpdatePromotion" name="btnUpdatePromotion" type="button" class="radius button btnUpdatePromotion large-12 small-12" dir="<?php echo $row['ProductID']; ?>">Update</button>
</div>
<div class="large-12 small-12 columns">
<button id="btnRemovePromotion" name="btnRemovePromotion" type="button" class="radius button btnRemovePromotion large-12 small-12" dir="<?php echo $row['ProductID']; ?>">
Remove
</button>
</div>
</div>
<?php
}else{
?>
<div class="row">
	<div class="large-6 small-6 columns">
		Price: 
	</div>	
	<div class="large-6 small-6 columns">
		<label class="lblOriPrice right"><?php echo $row['UnitPrice']; ?></label>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		Disc(%):
	</div>	
<div class="large-6 small-6 columns alignright">
		<input type="number" min="0" value="0" class="txtDiscountRate" name="txtDiscountRate" id="txtDiscountRate" class=" "/>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		subTotal:
	</div>	
	<div class="large-6 small-6 columns">
		
 <label class="lblsubTotal right"><?php echo $row['UnitPrice']; ?></label>
	</div>	
</div>
<div class="row rowEdit">
<div class="large-12 small-12 columns">
<button id="btnSavePromotion" name="btnSavePromotion" type="button" class="radius button btnSavePromotion large-12 small-12" dir="<?php echo $row['ProductID']; ?>">Add</button>
</div>
</div>
<?php
}
?>
<a class="close-reveal-modal" title="cancel">&#215;</a>
</form>
<script>
	$(document).ready(function() {
		$promotionid=<?php echo json_encode($_REQUEST['promotion']); ?>;
		$productid=<?php echo json_encode($_REQUEST['productid']); ?>;
		$('.txtDiscountRate').change(function() {
			$discount = $(this).val();
			$this = $(this).parent().parent().parent();
			$oriPrice = $this.find('.lblOriPrice').text();
			$this.find('.lblsubTotal').text(($oriPrice * (100 - $discount) / 100).toFixed(2));
		});
		$('#btnSavePromotion').click(function(e) {
			e.preventDefault();
			$discount = $(this).parent().parent().parent().find('#txtDiscountRate').val();
			$.ajax({
			 type : "POST",
			 url : "hrefPromotion.php?addPromotionItem=&promotion="+$promotionid+'&productid='+$productid+'&txtDiscountRate='+$discount,
			 success : function(msg) {			 	
			 // Message Sent - Show the 'Thank You' message and hide the form
			 if (msg == '') {
			 	alert('Successfully add');
			 	location.reload();
			 } else {
			 alert(msg);
			 }
			 }
			 });
		});
		
		$('#btnRemovePromotion').click(function(e) {
			e.preventDefault();
			$.ajax({
			 type : "POST",
			 url : "hrefPromotion.php?deletePromotionItem=&promotion="+$promotionid+'&productid='+$productid,
			 dataType : 'json',				
					success : function(msg) {
						// Message Sent - Show the 'Thank You' message and hide the form
						if (msg.status == '1') {
							alert('Remove successfully');
							location.reload();
						} else {
							//alert('Unable to remove');
							alert(msg);
						}
					}
			 });
		});
		
		$('#btnUpdatePromotion').click(function(e) {
			e.preventDefault();
			$discount = $(this).parent().parent().parent().find('#txtDiscountRate').val();
			$.ajax({
			 type : "POST",
			 url : "hrefPromotion.php?updatePromotionItem=&promotion="+$promotionid+'&productid='+$productid+'&txtDiscountRate='+$discount,
			 success : function(msg) {			 	
			 // Message Sent - Show the 'Thank You' message and hide the form
			 if (msg == '') {
			 	alert('Successfully update');
			 	location.reload();
			 } else {
			 alert(msg);
			 }
			 }
			 });
		});
	}); 
</script>