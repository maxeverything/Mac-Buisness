<?php 
session_start();

include '../Main/header.php'
?>

<script type="text/javascript" src="../js/zoom_min.js"></script>
<script type="text/javascript" src="../js/zoomPic.js" ></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		$('#multizoom1').addimagezoom({
			zoomrange : [3, 3],
			magnifiersize : [600, 200],
			cursorshade : true,
			imagevertcenter : true,
			disablewheel : true
		});
	}); 
</script>

<br/>
<div class="row">

	<div class="large-12 small-12 columns">
		<div class="large-3 panel columns">
			<?php

			include '../sql/config.php';
			include '../sql/opendb.php';
			include '../Function/currency.php';
			include '../Function/product.php';
			include '../Cart/fCart.php';
			if (isset($_GET['product'])) {
				$_SESSION['pro_id'] = $_GET['product'];
				$pro_id = $_SESSION['pro_id'];
			}

			$productID = mysql_real_escape_string($pro_id);
			$query_pic = "Select * from product_pic where ProductID=
$productID ";

			$result = mysql_query($query_pic) or die('Error, query failed2');
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$pic_url = $row['pic_url'];
			$display = "<img id='multizoom1' src='{$row['pic_url']}' style='width:200px;height:auto'/>
<div class='row multizoom1 thumbs'>
<p>" . "<a href='{$row['pic_url']}' data-large='{$row['pic_url']}' data-title='' data-dims='200, auto'>
<img class='imgSmallItem' src='{$row['pic_url']}' alt='' title='' style='width:auto;height:45px'/></a>";

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$display .= "<a href='{$row['pic_url']}' data-large='{$row['pic_url']}' data-title='' data-dims='200, auto'>
<img class='imgSmallItem' src='{$row['pic_url']}' alt='' title='' style='width:auto;height:45px'/></a>";
			}
			$display .= '</p></div>';
			echo $display;
			?>
		</div>

		<div class="large-6 columns">
			<div id="modelProfile" class="reveal-modal"> </div>
			<?php
			$productID = mysql_real_escape_string($pro_id);
			$query_proDetail = "Select * from Products where ProductID=$productID ";
			$result_proDetail = mysql_query($query_proDetail) or die('Error, query failed');

			$rowDetail = mysql_fetch_array($result_proDetail, MYSQL_ASSOC);

			$display_detail = '<div class="panel">' . '<h2>Detail</h2>' . '<label>Product Name:</label>' . "<div><p>{$rowDetail['ProductName']}</p></div>" . '<label>Unit In Stock:</label>' . "<div><p>{$rowDetail['UnitsInStock']}</p></div>" . '<label>Price:</label>' . '<div><p>' . currency::getCurrency($rowDetail["UnitPrice"]) . '</p>' . '</div>' . '<label>Weight:</label>' . '<div><p><label name="txtWeight" id="txtWeight" >'.$rowDetail['ProductWeight'].' Gram</label></p></div>' . '</div>' . '<div class="panel">' . '<label>Product Description:</label>' . "<div><p>{$rowDetail['description']}</p></div>
</div>";
			echo $display_detail;
			?>
			<div>
				<div class="section-container auto" data-section>
					<section class="section">
						<h5 class="title"><a href="#panel1">Contact Us</a></h5>
						<div class="content" data-slug="panel1">
							<form id="frmContactUs" dir="<?php echo $_REQUEST['product'];?>">
								<div class="row collapse">
									<div class="large-2 columns">
										<label class="inline">Your Name</label>
									</div>
									<div class="large-10 columns">
										<input type="text" id="name" name="name" placeholder="Jane Smith" required="required"/>
									</div>
								</div>
								<div class="row collapse">
									<div class="large-2 columns">
										<label class="inline"> Your Email</label>
									</div>
									<div class="large-10 columns">
										<input type="text" id="email" name="email"  placeholder="jane@smithco.com" required="required"/>
									</div>
								</div>
								<label>What's up?</label>
								<textarea rows="4" name="contact" id="contact" required="required"></textarea>
								<button type="submit" class="radius button">
									Submit
								</button>
							</form>
						</div>
					</section>
					<section class="section">
						<h5 class="title"><a href="#panel2">FeedBack</a></h5>
						<div class="content" data-slug="panel2">

							<div class="row">
								<div class="large-12 small-12 columns">
									<form id='frmFeedback'>
										<label>feedback us</label>
										<textarea id="txtfeedback" name="txtfeedback" rows="5" required="required"></textarea>
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
		</div>

		<div class="large-3 panel columns">
			<div class="small-12 large-12" class="order-detail">

				<label>Color</label>

				<?php
				$queryColor = product::getProductColor($pro_id);
				$rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC);
				$qty = $rowColor['qty'];
				echo '
				<select  id="dtpColor" style="background-color:' . $rowColor["color"] . '">
					';
				echo '<option value="' . $rowColor['qty'] . '" style="background-color:' . $rowColor["color"] . '">' . $rowColor['color'] . '</option>';
				while ($rowColor = mysql_fetch_array($queryColor, MYSQL_ASSOC)) {
					echo '<option value="' . $rowColor['qty'] . '" style="background-color:' . $rowColor["color"] . '">' . $rowColor['color'] . '</option>';
				}
				echo '
				</select>';
				?>

			</div>
			<div>

				<label>Quantity</label>
				<div class="row">
					<div class="small-12 columns">
						<input type="number" min="1" max="<?php echo $qty; ?>" name="txtQty" id="txtQty" value="1"/>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(e) {
					claculateSub();
					$('#dtpColor').change(function() {
						$max = $(this).val();
						$txtQty = $(this).parent().parent().find('input[name^="txtQty"]').attr({
							max : $max
						});
						$('#dtpColor').css("background-color", $('option:selected', this).css('backgroundColor'));
					});
					$("#contentFeedback").load("../feedback/feedbacklist.php" + window.location.search);
					$('#frmFeedback').submit(function(e) {
						e.preventDefault();
						var str = $(this).serialize();
						$.ajax({
							type : "POST",
							url : "../feedback/hrefFeedback.php?btnfeedback=",
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
					$('#txtQty').change(function() {
						claculateSub();
					});

					$("#contentFeedback").on('click', '.btnProfileDetail', function(e) {
						e.preventDefault();
						$id = $(this).attr("dir");
						$("#modelProfile").load("../personal/frmProfile.php?id=" + $id);
					});

					$('#frmContactUs').submit(function(e) {						
						e.preventDefault();
						$proid=$(this).attr("dir");
						var str = $(this).serialize();
						$.ajax({
							type : "POST",
							url : "../product/mailContactUs.php?sentMail=&product="+$proid,
							data : str,
							dataType : 'json',
							success : function(msg) {
								if (msg.status == "1") {
									alert('Your email sent!');
									$('#contact').val('');
									$('#name').val('');
									$('#email').val('');
								} else {
									alert('the email cant be sent!');
								}
							}
						});
					});
				});
				function claculateSub() {
					$unit = Number($('#unitPrice').text());
					$qty = $('#txtQty').val();
					$('#lblqty').text($qty);
					$('#subtotal').text(($unit * $qty).toFixed(2));
				}
			</script>
			<?php
			if(isset($_SESSION['id'])){
				if($_SESSION['id'][0]=='M'){
			?>
			<script>
								$(document).ready(function(){
					$orderId=<?php echo json_encode(cart::getOrderId()); ?>
						;

						$('#frmOrderDetail').submit(function(e) {
							$id = $('#btnBuyNow').attr('dir');
							$qty = $('#txtQty').val();
							$color = $('#dtpColor option:selected').text();
							e.preventDefault();
							$.ajax({
								type : "POST",
								url : "../Cart/hrefCart.php?addToCart=",
								data : {
									productID : $id,
									qty : $qty,
									id : $orderId,
									color : $color
								},
								xhrFields : {
									withCredentials : true
								},
								dataType : 'json',
								success : function(msg) {
									// Message Sent - Show the 'Thank You' message and hide the form
									if (msg.status == "1") {
										window.location = '../Cart/cartList.php';
									} else {
										alert('Error, please login first');
									}
								}
							});
						});

						});
			</script>
			<?php
			}
			if($_SESSION['id'][0]=="S"){
			?>
			<script>
				$(document).ready(function() {
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
				});
			</script>
			<?php
			}
			}
			?>
			
			

			<form id="frmOrderDetail" action="" method="post">
				<table class="large-12 panel columns">
					<thead>
						<tr>
							<th>Summary</th>
							<th colspan="2" align="center">Price</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="40"><img src="../images/currency-dollar.png" width="40px"></td>
							<td>Original</td>
							<td><label name="oriPrice" id="oriPrice" class="right"><?php echo $rowDetail['UnitPrice']; ?></label></td>
						</tr>
						<tr>
							<td width="40"><img src="../images/currency-dollar.png" width="40px"></td>
							<td>We Sell</td>
							<td><label name="unitPrice" id="unitPrice" class="right"><?php $discount = product::getDiscount($_REQUEST['product']);
								echo number_format($rowDetail['UnitPrice'] * (100 - $discount) / 100, 2);
 ?></label></td>
						</tr>
						<tr>
							<th>Quantity: </th>
							<th colspan="2"><label name="lblqty" id="lblqty" class="right"></label></th>
						</tr>
						<tr>
							<th>Sub Total: </th>
							<th> RM </th>
							<th><label name="subtotal" id="subtotal" class="right"></label></th>
						</tr>
					</tbody>

				</table>
				<?php
				if(isset($_SESSION['id'])){
				if($_SESSION['id'][0]=='M'){
				?>
				<center>
					<button id="btnBuyNow" name="btnBuyNow" type="submit" class="radius button" dir="<?php echo $_REQUEST['product']; ?>">
						Buy Now
					</button>
		
					<?php
					 echo "<a href='../Product/FB/shareToFB.php?pic_url=".$pic_url."'>
									<img src='FB/images/shareFB.jpg'/>
						  </a>"; 
					?>
				</center>
				
				<?php
				}
				}else{
				?>
				<a class='btnAddCart' href='../LoginPage/loginPage.php'>
							<div class="medium button green large-12 small-12">
								<h6 name="lblCart">login to buy this item</h6>
							</div>
						</a>
				
				<?php
				}
				?>
			</form>

		</div>

	</div>
</div>
</div>
<?php include '../Main/footer.php' ?>
