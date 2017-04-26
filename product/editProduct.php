<?php
include '../main/authorization.php';
include '../Main/header.php';

if (isset($_SESSION['id']) && ($_SESSION['id'][0] == 'S' || $_SESSION['id'][0] == 'R')) {
} else {
	echo "<script>window.location = '../Home/Homepage.php' </script>";
}
?>


<script type="text/javascript" src="jsColor/jscolor.js"></script>
<script type="text/javascript" src="../js/jquery.wallform.js"></script>
<div class="row">

	<div class="large-12 small-12 columns">
		<?php
		include '../sql/config.php';
			include '../sql/opendb.php';
			include '../Function/currency.php';
			include '../Function/product.php';

			if (isset($_GET['product'])) {
			$pro_id = $_GET['product'];
			}

			$productID = mysql_real_escape_string($pro_id);
				$query_proDetail = "Select p.*, c.categoryName from Products p, Categories c where ProductID=$productID AND p.categoryID= c.categoryID";
				$result_proDetail = mysql_query($query_proDetail) or die('Error, query failed');
				$rowDetail = mysql_fetch_array($result_proDetail, MYSQL_ASSOC);
		?>
		<h1>Edit Product( <?php echo $rowDetail['ProductName']?> )</h1>		
		<div class="large-3 panel columns">
			<a class="right btnEditPicture" id="btnEditPicture" title="Edit" href=" "  data-reveal-id="modalEditPicture" data-reveal-ajax="true">Edit</a>
			<?php	

			$productID = mysql_real_escape_string($pro_id);
			$query_pic = "Select * from product_pic where ProductID=
			$productID ";
			$result = mysql_query($query_pic) or die('Error, query failed2');

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			?>
			<img class='imgSmallItem' src='<?php echo $row['pic_url']; ?>' alt='' title='' style='width:200px;height:auto'/>
			<?php
			}
			?>
		</div>

		<div class="large-6 columns">
			<div class="panel">
				<a class="right btnEditDetail" id="btnEditDetail" title="Edit" href=" "  data-reveal-id="modalEditDetail" data-reveal-ajax="true">Edit</a>
				<?php
				
				?>
				<h2>Detail</h2>
				<label>Product Name:</label>
				<div><p><?php echo $rowDetail['ProductName']; ?></p></div>				
				<label>Price:</label>
				<div><p><?php echo currency::getCurrency($rowDetail["UnitPrice"]); ?> </p>
				</div>
				<label>Weight(gram):</label>
				<div><p><label name="txtWeight" id="txtWeight" ><?php echo $rowDetail['ProductWeight']; ?></label></p></div>				
				<label>Point for Redeem:</label>
				<div><p><?php echo $rowDetail['product_point']; ?></p></div>
				<label>Category:</label>
				<div><p><?php echo $rowDetail['categoryName']; ?></p></div>
				<label>Product Description:</label>
				<div><p><?php echo $rowDetail['description']; ?></p></div>
				
			</div><?php
				if(isset($_SESSION['id']) && $_SESSION['id'][0]=='S'){
				?>		
			<div>
				<div class="section-container auto" data-section>
					<section class="section">
						<h5 class="title"><a href="#panel2">FeedBack</a></h5>
						<div class="content" data-slug="panel2">

							<div class="row">
								<div class="large-12 small-12 columns">
									<form id='frmFeedback'>
										<label>feedback us</label>
										<textarea id="txtfeedback" name="txtfeedback" rows="5"></textarea>
										<textarea id="txtProduct" name="txtProduct" class=" hide" ><?php echo $_GET['product']?></textarea>
										<button id="btnfeedback" name="btnfeedback" type="submit" class="radius button">
											Comment
										</button>
									</form>
								</div>
							</div>
							<div id='contentFeedback'></div>

						</div>
					</section>
				</div>
			</div>
			<?php
			}
			?>
		</div>

		<div class="large-3 panel columns">
			<div class="small-12 large-12 columns" class="order-detail">
				<a class="right btnEditColor" id="btnEditColor" title="Edit" href=" " data-reveal-id="modalEditColor" data-reveal-ajax="true">Edit</a>

				<label>Color</label>

				<?php
				$queryColor = product::getProductColor($pro_id);
				while ($rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC)) {
				?>
				<div class="row">
					<div class="small-6 large-6 columns" style="border-style:solid;
					border-width:2px;  background-color:<?php echo $rowColor['color']; ?>">
						<?php echo $rowColor['color']; ?>
					</div>
					<div class="small-6 large-6 columns" >
						<?php echo $rowColor['qty']; ?>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row">
				<div class="small-6 large-6 columns panel">Total:</div>
				<div class="small-6 large-6 columns panel"> <?php echo $rowDetail['UnitsInStock']; ?> </div>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(e) {
	$('#photoimg').die('click').live('change', function(){			    
				$("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
					
					console.log('v');
					$("#imageloadstatus").show();
					 $("#imageloadbutton").hide();
					 }, 
					success:function(){ 
					console.log('z');
					 $("#imageloadstatus").hide();
					 $("#imageloadbutton").show();
					}, 
					error:function(){ 
							console.log('d');
					 $("#imageloadstatus").hide();
					$("#imageloadbutton").show();
					} }).submit();
					
		
			});	
		$("#preview").on('click','.btnDelete',function(e){
			e.preventDefault();
			$field=$(this).parent().parent().parent();
			var lblImage=$field.children().children('#divImg').children('img').attr('title');
			if (confirm("confirm delete?")) {	
					$.ajax({
						type: "GET",
						url: "hrefImage.php?deleteImageDatabase=",
						data: {imageID:lblImage},
						dataType : 'json',
						success: function(msg) {
						alert(msg);
						// Message Sent - Show the 'Thank You' message and hide the form							
							if(msg.status=="1") {
				            	$field.remove();
							}else{
								alert('Unable to delete');
							}
						}
					});				
			}
			
        });
        
$productID=<?php echo json_encode($_GET['product']); ?>
	;
	$("#contentFeedback").load("../feedback/feedbacklist.php" + window.location.search);
	$('#frmFeedback').submit(function(e) {
		e.preventDefault();
		var str = $(this).serialize();
		$.ajax({
			type : "POST",
			url : "../feedback/hrefFeedback.php?btnfeedback",
			data : str,
			success : function(msg) {
				if (msg == '') {
					$("#contentFeedback").load("../feedback/feedbacklist.php" + window.location.search);
					$('#txtfeedback').val("");
				} else {
					alert('please login to our page first.');
				}
			}
		});
	});
	$("#contentFeedback").on('click', '.btnWarning', function(e) {
		e.preventDefault();
		$email = $(this).attr('dir');
		alert($email);
		$.ajax({
			type : "GET",
			url : "../feedback/mailWarningFeedback.php?sentWarningMail=",
			data : {
				email : $email
			},
			dataType : 'json',
			success : function(msg) {
				if (msg.status == "1") {
					alert('the warning letter sent!');
				} else {
					alert('the email cant be sent!');
				}
			}
		});

	});

	$("#contentFeedback").on('click', '.btnDelete', function(e) {
		e.preventDefault();
		if (confirm("confirm delete?")) {
			$url = $(this).attr("href");
			$.ajax({
				type : "GET",
				url : "../feedback/hrefFeedback.php?btnDeletefeedback=&feedbackid=" + $url,
				dataType : 'json',
				success : function(msg) {
					if (msg.status == "1") {
						$("#contentFeedback").load("../feedback/feedbacklist.php" + window.location.search);
					} else if (msg.status == "2") {
						alert('Only staff can delete the message.');
					} else {
						alert('the message cant be delete!');
					}
				}
			});
		}
	});
	$("#clear").on('click', '.btnDeleteColor', function(e) {
		e.preventDefault();
		$field = $(this).parent().parent().parent();
		var lblColor = $field.children().children('#lblColor').text();
		$colorId = Number($(this).attr("dir"));
		if (confirm("Delete this?")) {
			if ($colorId > 0) {
				$.ajax({
					type : "GET",
					url : "hrefColor.php?btnRemoveColor=&colorid=" + $colorId,
					success : function(msg) {
						// Message Sent - Show the 'Thank You' message and hide the form
						if (msg == '') {
							$field.remove();
						} else {
							alert(msg);
						}
					}
				});
			} else {
				$field.remove();
			}
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
		})
		if (valid == true) {
			var display = '<div class="row">';
			display += '<div class="small-12 large-12 columns rowColor">';
			display += '<div class="small-4 large-4  columns lblColor" id="lblColor" style="background-color:' + color + '">';
			display += color;
			display += '</div>';
			display += '<div class="small-4 large-4  columns" >';
			display += '<input type="number" min="1" name="txtQty" id="txtQty" value="' + qty + '"/>';
			display += '</div>';
			display += '<div class="small-2 large-2  columns">';
			display += '<a id="btnDeleteColor" class="btnDeleteColor" href=" " dir="0">&#215;</a></div></div></div>';
			$('#clear').append(display);
		} else {
			alert('The color already exits');
		}
	});
	$('#btnUpdateColor').click(function(e) {
		$url = "";
		$('.rowColor').each(function() {
			$color = $(this).find('.lblColor').text();
			$qty = $(this).find('input[name^="txtQty"]').val();
			$id = $(this).find('.btnDeleteColor').attr('dir');
			if ($id == 0) {
				$url = 'color=' + $color + '&qty=' + $qty;
				$.ajax({
					type : "POST",
					url : "hrefColor.php?InsertColor=&productId=" + $productID,
					data : $url,
					success : function(msg) {
						if (msg == '') {

						} else {
							alert(msg);
						}
					}
				});
			} else {
				$url = '&color=' + $color + '&qty=' + $qty + '&id=' + $id;
				$.ajax({
					type : "POST",
					url : "hrefColor.php?UpdateColor=",
					data : $url,
					success : function(msg) {
						if (msg == '') {

						} else {
							alert(msg);
						}
					}
				});
			}
		});
		$('#modalEditColor').foundation('reveal', 'close');
		location.reload();
	});
	$('#btnSaveEditPicture').click(function() {
		location.reload();
	});

	$('#frmEditDetail').submit(function(e){
	e.preventDefault();
	var str = $(this).serialize();
	$.ajax({
	type : "POST",
	url : "hrefProduct.php?UpdateProduct=&productid=" + $productID,
	data : str,
	success : function(msg) {
	if (msg == '') {
	alert('Update Successfully.');
	location.reload();
	} else {
	alert(msg);
	}
	}
	});
	})
	});

			</script>

		</div>
		<div class="reveal-modal" id="modalEditColor" >
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
									<input type="number" id="product_Quantity" min="1" value="1" placeholder="1234567" name="product_Quantity" required pattern="^[1-9]\d*$">									
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
							<?php
							$queryColor = product::getProductColor($pro_id);
							while ($rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC)) {
							?>
							
							<div class="row">
							<div class="small-12 large-12 columns rowColor">
							<div class="small-4 large-4  columns lblColor" id="lblColor"  style=" background-color:<?php echo $rowColor['color']; ?>">
							<?php echo $rowColor['color']; ?>
							</div>
							<div class="small-4 large-4  columns" >
								<input type="number" min="1" name="txtQty" id="txtQty" value="<?php echo $rowColor['qty']; ?>"/>
							</div>
							<div class="small-2 large-2  columns">
							<a id="btnDeleteColor" class="btnDeleteColor" href=" " dir="<?php echo $rowColor['id']; ?>">&#215;</a></div>
							</div>
							</div>
							<?php
							}
							?>

						</div>
						<div class="row">
							<div class="large-12 small-centered columns" id="colorNext">
								<button id="btnUpdateColor" name="btnUpdateColor" class="medium button green">
									Done
								</button>
							</div>
						</div>
					</fieldset>
				</div>
		<div id="modalEditDetail" class="reveal-modal">
				<form id="frmEditDetail" class="custom" method="post" data-abide>
					<fieldset>
						<legend>
							Edit Product Detail
						</legend>
						<div class="row">
							<div class="large-12 column">
								<label for="productName">Product Name <small>require</small></label>
								<input type="text" value="<?php echo $rowDetail['ProductName']; ?>" id="productName" placeholder="Product Name" name="productName" required>
							</div>
						</div>
						
						<div class="row">
							<div class="large-12 columns">
								<label for="productDescription">Product Description</label>
								<textarea id="productDescription" placeholder="Example: A Bag" name="productDescription" required><?php echo $rowDetail['description']; ?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="large-6 columns">
								<label for="productPrice">Product Price (RM)<small>require</small></label>
								<input type="text" value="<?php echo $rowDetail['UnitPrice']; ?>" id="productPrice" placeholder="0000.00" name="productPrice" required pattern="^[1-9]\d*(\.\d+)?$">							
							</div>
							
							<div class="large-6 columns">
								<label for="product_point">Redeemable Point<small>Optional</small></label>
								<input type="number" min="0" value="<?php echo $rowDetail['product_point']; ?>" step="100" id="product_point" placeholder="1234567" name="product_point" required>								
							</div>
						</div>

						<div class="row">
							<div class="large-6 columns">
								<label for="ProductWeight">Weight(gram)<small>require</small></label>
								<input type="number" min="0" step="100" id="ProductWeight" value="<?php echo $rowDetail['ProductWeight']; ?>" placeholder="00000" name="ProductWeight" required >
							</div>

							<div class="large-6 columns">
								<label for="CategoryID">Category<small>require</small></label>
								<select id="CategoryID" name="CategoryID" class="medium" required>
									<option>Category</option>
									<?php
									$result_Category=product::getCategory();
									while($row_Category=mysql_fetch_array($result_Category, MYSQL_ASSOC)){
										if($row_Category['categoryName']== $rowDetail['categoryName']){
									?>
									<option selected="selected" value="<?php echo $row_Category['categoryID'] ?>"> <?php echo $row_Category['categoryName'] ?> </option>
									<?php
									}else{
									?>									
									<option value="<?php echo $row_Category['categoryID'] ?>"> <?php echo $row_Category['categoryName'] ?> </option>
									<?php
									}
									}
									?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="large-12 small-centered columns">
								<button type="submit" id="btnSaveEditProduct" name="submitNewAddr" class="medium button green">
									Save
								</button>
								<button type="reset" id="btnClear" name="btnClear" class="medium button green close">
									Reset
								</button>
							</div>
						</div>
					</fieldset>
				</form>
				<a class="close-reveal-modal">&#215;</a>
			</div>
			<div id="modalEditPicture" class="reveal-modal">
          	<fieldset>
            <legend>Product Picture</legend>
            
            <form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php?productid=<?php echo $pro_id; ?>'>
			Upload your image 
			<div id='imageloadstatus' style='display:none'><img src="../images/loader.gif" alt="Uploading...."/></div>
			<div id='imageloadbutton'>
			<input type="file" name="photoimg" id="photoimg" />
			</div>
			</form>
    		<div id="row">
            	<div class="small-12 large-12  columns">
                	<div class="small-4 large-4  columns">
                    	<p>Image</p>
                    </div>
                    <div class="small-2 large-2  columns">
                    	<p>Delete</p>
                        
                    </div>
                </div>
            </div>
            
			<div id='preview'>
				<?php
				$result_pic = mysql_query($query_pic) or die('Error, query failed2');
				while ($row_pic = mysql_fetch_array($result_pic, MYSQL_ASSOC)) {
				?>
				<div class="row">
					<div class="small-12 large-12 columns">
					<div class="small-4 large-4  columns" id="divImg">
					<img id='lblImage' src='<?php echo $row_pic['pic_url']; ?>' title='<?php echo $row_pic['product_picId']; ?>'  class='preview'>
					</div>
					<div class="small-2 large-2  columns">
					<a class="btnDelete" href=" ">&#215;</a></div>
					</div>
					</div>
				<?php
				}
				?>
			</div>
			<div class="row">
				<div class="large-12 small-centered columns">
					<button id="btnSaveEditPicture"  name="btnSaveEditPicture" class="medium button green">
						Done
					</button>
				</div>
			</div>
			
          </fieldset>
         </div>

	</div>
</div>
</div>
<?php include '../Main/footer.php' ?>
