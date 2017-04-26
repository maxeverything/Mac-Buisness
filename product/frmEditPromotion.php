
<form action="hrefPromotion.php?promotionid=<?php echo $_REQUEST['promotionid'];?>" method="post" data-invalid="">

<?php
include '../sql/config.php';
include '../sql/opendb.php';
$promotionID = mysql_real_escape_string($_REQUEST['promotionid']);
$resultPromotion=mysql_query("Select * from promotions where promotionID='$promotionID'");
$row=mysql_fetch_array($resultPromotion, MYSQL_ASSOC);
?>

<div class="row">
<div class="large-12 column">
<label for="txtPromotionTitle">Promotion Title <small>(require)</small></label>
<input type="text" id="txtPromotionTitle" placeholder="Promotion Title" value="<?php echo $row['promotiontitle'];?>" name="txtPromotionTitle" required>
</div>
</div>

<div class="row">
<div class="large-12 columns">
<label for="txtPromotionDescription">Promotion Description<small>(require)</small></label>
<textarea id="txtPromotionDescription" placeholder="Example: A Promotion" name="txtPromotionDescription" required><?php echo $row['description'];?></textarea>
</div>
</div>


<div class="row">
<div class="large-6 columns">
<label for="txtDateFrom2">Start Date<small>(require)</small></label>
<input type="text" value="<?php echo $row['dateFrom'];?>"  id="txtDateFrom2" name="txtDateFrom" placeholder="yyyy-mm-dd" pattern="\d{4}-\d{1,2}-\d{1,2}" required >
</div>

<div class="large-6 columns">
<label for="txtDateTo2">End Date<small>(require)</small></label>
<input type="text" id="txtDateTo2" name="txtDateTo"  value="<?php echo $row['dateTo'];?>"  placeholder="yyyy-mm-dd" pattern="\d{4}-\d{1,2}-\d{1,2}" required>
</div>
</div>

<button type="submit" id="btnUpdatePromotionDetail" name="btnUpdatePromotionDetail" class="medium button green">
Update
</button>
<button type="reset" id="btnClear" name="btnClear" class="medium button green close">
Clear
</button>
<a class="close-reveal-modal" title="cancel">&#215;</a>
</form>

<script>
	$(document).ready(function() {		
		$("#txtDateFrom2").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat: "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#txtDateTo2").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#txtDateTo2").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat: "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#txtDateFrom2").datepicker("option", "maxDate", selectedDate);
			}
		});
		
	});
</script>