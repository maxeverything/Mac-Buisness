<?php
include '../main/authorization.php';
if(checkSellerAndStaff($_SESSION['id'])==TRUE){
include '../Function/product.php';
$result_Category = product::getCategory();
include '../Main/header.php';

?>
<script type="text/javascript" src="jsColor/jscolor.js"></script>
<script type="text/javascript" src="../js/jquery.wallform.js"></script>
<script>
	$(document).ready(function() {
		$('#btnSaveNewItem').click(function(e) {

			var str = $('#frmAddNew').serialize();

			$('.preview').each(function() {
				str += '&image[]=' + $(this).attr('src');
			});
			$('.lblColor').each(function() {
				str += '&color[]=' + $(this).text();
			});
			$('.txtQty').each(function() {
				str += '&qty[]=' + $(this).val();
			});
			alert(str);
			e.preventDefault();
			if (confirm('Confirm to add?')) {
				$.ajax({
					type : "POST",
					url : "hrefProduct.php?addNewProduct=",
					data :str,
					success : function(msg) {
						if (msg == '') {
							alert('The new item had been add');
							window.location="../CRM module/showPrefMemberList.php?category="+$('#CategoryID').val();
						} else {
							//alert('Unable to add');
							alert(msg);
						}
					}
				});
			}
		});
		$('#photoimg').die('click').live('change', function(e) {
			$("#imageform").ajaxForm({
				target : '#preview',
				beforeSubmit : function() {

					console.log('v');
					$("#imageloadstatus").show();
					$("#imageloadbutton").hide();
				},
				success : function() {
					console.log('z');
					$("#imageloadstatus").hide();
					$("#imageloadbutton").show();
				},
				error : function() {
					console.log('d');
					$("#imageloadstatus").hide();
					$("#imageloadbutton").show();
				}
			}).submit();
		});
		$("#preview").on('click', '#btnDelete', function(e) {
			e.preventDefault();
			if (confirm('Confirm to delete?')) {
				$field = $(this).parent().parent().parent();
				var lblImage = $field.children().children('#divImg').children('img').attr('src');
				$.ajax({
					type : "GET",
					url : "hrefImage.php?deleteNewImage=",
					data : {
						image : lblImage
					},
					success : function(msg) {
						if (msg == '') {
							$field.remove();
						} else {
							alert('Unable to delete');
						}
					}
				});
			}

		});

		$('#frmColor').submit(function(e) {
			e.preventDefault();
			var qty = $('#product_Quantity').val();
			var color = '#' + $('#productColor').val();
			var valid = true;
			$('.lblColor').each(function() {
				if ($(this).text() == color) {
					valid = false;
				}
			});
			if (valid == true) {
				var display = '<div class="row">';
				display += '<div class="small-12 large-12 columns rowColor">';
				display += '<div class="small-4 large-4  columns lblColor" id="lblColor" style="background-color:' + color + '">';
				display += color;
				display += '</div>';
				display += '<div class="small-4 large-4  columns" >';
				display += '<input type="number" min="1" name="txtQty" id="txtQty" class="txtQty" value="' + qty + '"/>';
				display += '</div>';
				display += '<div class="small-2 large-2  columns">';
				display += '<a id="btnDeleteColor" class="btnDeleteColor" href=" " dir="0">&#215;</a></div></div></div>';
				$('#clear').append(display);
			} else {
				alert('The color already exits');
			}
		});

		$("#clear").on('click', '.btnDeleteColor', function(e) {
			e.preventDefault();
			if (confirm('Confirm to delete?')) {
				$(this).parent().parent().parent().remove();
			}
		});

		$("#colorNext").on('click', '#btnAddColor', function() {
			$count = 0;
			$('.lblColor').each(function() {
				$count++;
			});
			// Message Sent - Show the 'Thank You' message and hide the form
			if ($count > 0) {
				$('#p3').show();
				$('#p2').removeClass('active');
				$('#p3').addClass('active');
			} else {
				alert('Please insert a color');
			}
		});

		$('#frmAddNew').submit(function(e) {
			e.preventDefault();
			$('#p2').show();
			$('#p1').removeClass('active');
			$('#p2').addClass('active');
		});
	}); 
</script>
<div class="row">
	<div class="large-12 columns" data-abide action="" method="post" data-invalid="">
		<h1>Add New Product</h1>
		<div class="section-container auto" data-section>
			<section class="section" id="p1">
				<h5 class="title"><a href="#panel1">Product Detail</a></h5>
				<div class="content" data-slug="panel1">
					<fieldset>
						<form id="frmAddNew">

							<legend>
								Add New Product Form
							</legend>

							<div class="row">
								<div class="large-12 column">
									<label for="productName">Product Name <small>(require)</small></label>
									<input type="text" id="productName" placeholder="Product Name" name="productName" required>
								</div>

							</div>

							<div class="row">
								<div class="large-12 columns">
									<label for="productDescription">Product Description<small>(require)</small></label>
									<textarea id="productDescription" placeholder="Example: A Bag" name="productDescription" required></textarea>																											 
									



								</div>
							</div>

							<div class="row">
								<div class="large-12 columns">
									<label for="productPrice">Product Price (RM)<small>(require)</small></label>
									<input type="text" id="productPrice" placeholder="0000.00" name="productPrice" required pattern="^[1-9]\d*(\.\d+)?$">
								</div>
							</div>

							<div class="row">
								<div class="large-12 columns">
									<label for="product_point">Redeemable Point<small>(Optional)<p class="success  radius  label">Set to '0' mean not allow to redeem</p></small></label>
									<input type="number" min="0" step="100" id="product_point" placeholder="1234567" name="product_point">
								</div>
							</div>

							<div class="row">
								<div class="large-6 columns">
									<label for="ProductWeight">Weight(gram)<small>(require)</small></label>
									<input type="number" min="0" step="100" id="ProductWeight" placeholder="00000" name="ProductWeight" required >

								</div>

								<div class="large-6 columns">
									<label for="CategoryID">Category<small>require</small></label>
									<select id="CategoryID" name="CategoryID" class="medium" required>
										<option value="">Category</option>
										<?php

										while($row_Category=mysql_fetch_array($result_Category, MYSQL_ASSOC)){
										?>
										<option value="<?php echo $row_Category['categoryID'] ?>"> <?php echo $row_Category['categoryName'] ?>
										</option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="small-4 small-centered columns">
									<button type="reset" class="medium button green">
										Clear
									</button>
									<button type="submit" id="btnAddNew" name="btnAddNew" class="medium button green">
										Next
									</button>
								</div>
							</div>
						</form>

					</fieldset>
				</div>
			</section>

			<section class="section" id="p2">
				<h5 class="title"><a style=" " href="#panel2">Product Color</a></h5>
				<div class="content" data-slug="panel2">
					<fieldset>
						<legend>
							Product Color
						</legend>
						<form id="frmColor">
							<div class="row" id="DivAddColor">
								<div class="small-12 large-5  columns">
									<label for="productColor">Product Color <small>require</small></label>
									<input class="color" type="text" id="productColor" placeholder="66ff00" name="productColor" required>

								</div>

								<div id="AddColor" class="small-12 large-5  columns">
									<label for="product_Quantity">Quantity<small>require</small></label>
									<input type="number" min="0" id="product_Quantity" placeholder="1234567" name="product_Quantity" required pattern="^[1-9]\d*$">

								</div>
								<div class="small-12 large-2  columns">
									<button id="btnAddColor" name="btnAddColor" class="medium button green">
										Add
									</button>
								</div>
							</div>
						</form>
						<div id="row">
							<div class="small-12 large-12  columns">
								<div class="small-4 large-4  columns">
									<p>
										Color
									</p>
								</div>
								<div class="small-4 large-4  columns">
									<p>
										Qty
									</p>
								</div>
								<div class="small-2 large-2  columns">
									<p>
										Delete
									</p>

								</div>
							</div>
						</div>

						<div id="clear">

						</div>
						<div class="row">
							<div class="large-12 small-centered columns" id="colorNext">
								<button id="btnAddColor" name="btnAddColor" class="medium button green">
									Next
								</button>
							</div>
						</div>
					</fieldset>
				</div>
			</section>

			<section class="section" id="p3">
				<h5 class="title"><a href="#panel2">Product Picture</a></h5>
				<div class="content" data-slug="panel2">
					<fieldset>
						<legend>
							Product Picture
						</legend>
						<form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
							Upload your image
							<div id='imageloadstatus' style='display:none'><img src="../images/loader.gif" alt="Uploading...."/>
							</div>
							<div id='imageloadbutton'>
								<input type="file" name="photoimg" id="photoimg" />
							</div>
						</form>
						<div id="row">
							<div class="small-12 large-12  columns">
								<div class="small-4 large-4  columns">
									<p>
										Image
									</p>
								</div>
								<div class="small-2 large-2  columns">
									<p>
										Delete
									</p>
								</div>
							</div>
						</div>

						<div id='preview'>
						</div>
						<div class="row">
							<div class="large-12 small-centered columns" id="colorNext">
								<button id="btnSaveNewItem" name="btnSaveNewItem" class="medium button green">
									Save
								</button>
							</div>
						</div>
					</fieldset>
				</div>
			</section>
		</div>
	</div>
</div>

<script type="text/javascript">
	//function deleteProductColor(id,color){
	//new Ajax.Request('deleteColor.php', {
	//parameters: $('id'+id+'color'+color).serialize(true),
	//});
	//}
</script>

<?php
include '../Main/footer.php';
}
?>