<?php

session_start();
include '../Main/header.php';

include '../Cart/fCart.php';
?>
<script type="text/javascript">
	$(document).ready(function() {
		var highest = 0;
		var hi = 0;
		
		$(".panelItem").each(function() {
			var h = $(this).height();
			if (h > hi) {
				hi = h;
				highest = h;
			}
		});

		$('.panelItem').height(highest);
		
		function getUrlVars() {
			var vars = [], hash;
			var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for (var i = 0; i < hashes.length; i++) {
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			return vars;
		}
		


		$("#ddlSortBy option").filter(function() {
			//may want to use $.trim in here
			return ($(this).val() == getUrlVars()['sort'] && $(this).attr('dir') == getUrlVars()['dir']);
		}).prop('selected', true);

		$('#ddlSortBy').change(function(e) {
			
			var str = $(this).serialize();
			
			str = str + '&frmSort=&dir=' + $(this).find("option:selected").attr('dir');
			if($(this).val()!=0){
			var allVars;
			if (location.search.length > 0) {
				allVars = getUrlVars();
				if (allVars['product']) {
					str += '&product=' + allVars['product'];
				}

				if (allVars['category']) {
					str += '&category=' + allVars['category'];
				}

				if (allVars['shop']) {
					str += '&shop=' + allVars['shop'];
				}

				if (allVars['range']) {
					str += '&range=' + allVars['range'];
				}
			}

			window.location = "product.php?" + str;
			}
		});

		$('#product').autocomplete({
			source : "productAutocomplete.php?term="
		});
		
		
	});

</script>
<?php
if(isset($_SESSION['id'])){
if($_SESSION['id'][0]=='M'){
?>
<script>
	$(document).ready(function(){
		$id=<?php if($_SESSION['id'][0]=='M'){
			 echo json_encode(cart::getOrderId());
			 }?>;
		$('a.btnAddCart').click(function(e){
			$proid=$(this).attr('href');
			e.preventDefault();
			$.ajax({
				type : "POST",
				url : "../Cart/hrefCart.php?addToCart=",
				data : {productID:$proid, id: $id},
				dataType : 'json',
				success : function(msg) {
					// Message Sent - Show the 'Thank You' message and hide the form
					if (msg.status == "1") {
						window.location= '../Cart/cartList.php';
					} else if(msg.status == "0"){
						alert('Fail');
					}else{
						alert('Error, please login first');
					}
				}
			});			
		});
		$('.btnRedeem').click(function(e){
			e.preventDefault();
			$point=$(this).attr("dir");
			$href=$(this).attr("href");
			$.ajax({
				type : "GET",
				url : "../productRedeem/hrefRedeem.php?checkRedeem=",
				data : {point : $point},
				dataType : 'json',
				success : function(msg) {
					// Message Sent - Show the 'Thank You' message and hide the form
					if (msg.status == "1") {					
						window.location=$href;
					}else if(msg.status == "0") {
						alert('Error, you have not enough point to redeem this product');
					}else{
						alert('Error, please login first');
					}
				}
			});
		});
	});
</script>
<?php
}
}
?>
<div class="row">

	<!-- Side Bar -->

	<div class="large-3 columns">
		<div class="hide-for-small panel">
			<form action="product.php" action="post">
				<h3>Advance Search</h3>
				<label>Product Name</label>
				<div>
					<input type="text" id="product" name="product" placeholder="Product Name" />
				</div>
				<div>
					<label>Category</label>
					<select id="ddlCategory" name="category">
						<option value="">Category</option>
						<?php 
						include '../Function/product.php';
						$result_Category=product::getCategory();

						while($row_Category=mysql_fetch_array($result_Category, MYSQL_ASSOC)){
						?>
						<option value="<?php echo $row_Category['categoryID'] ?>"> <?php echo $row_Category['categoryName'] ?>
						</option>
						<?php
						}
						?>

					</select>
				</div>

				<div>
					<label>Shop</label>
					<select id="ddlShop" name="shop">
						<option value="">Shop</option>
						<?php
						$result_Shop=product::getShop();

						while($row_Shop=mysql_fetch_array($result_Shop, MYSQL_ASSOC)){
						?>
						<option value="<?php echo $row_Shop['shopID'] ?>"> <?php echo $row_Shop['shopname'] ?>
						</option>
						<?php
						}
						?>

					</select>
				</div>

				<div>
					<label>Shop</label>
					<select id="ddlPriceRange" name="range">
						<option value="">Price</option>
						<option value="1">RM1-RM50</option>
						<option value="2">RM51-RM100</option>
						<option value="3">RM100 and above</option>
					</select>
				</div>

				<div class="row">
					<div class="large-12 small-centered columns">
						<button type="submit" id="submitAddNew" name="advanceSearch" class="medium button green">
							Advance Search
						</button>
					</div>
				</div>
			</form>
		</div>

	</div>

	<!-- End Side Bar -->

	<!-- Thumbnails -->
	<div class="large-9 columns">
	<?php
		if(isset($_SESSION['id'])&&$_SESSION['id'][0]=='R'){
			$query = "SELECT shopname
				  	  FROM shops
				 	  WHERE sellerID='".$_SESSION['id']."'";
			
			$result = mysql_query($query);
			
			$row = mysql_fetch_row($result);
			
			echo "<h2>$row[0]</h2>";
		}
		
	?>
		<div class="row">
			<div class="large-6 columns">
				<label>Sort by</label>
				<select id="ddlSortBy" name="sort">
					<option value="0">Sort By</option>
					<option value="Product_date" dir="DESC">Lastest Avariable: ascending</option>
					<option value="Product_date" dir="ASC">Lastest Avariable :descending</option>
					<option value="UnitPrice" dir="ASC">Price :ascending</option>
					<option value="UnitPrice" dir="DESC">Price :descending</option>
					<option value="ProductName" dir="ASC">Name :ascending</option>
					<option value="ProductName" dir="DESC">Name :descending</option>
				</select>
			</div>
		</div>
		<div class="row">
			<?php include 'paging.php'?>

		</div>

		<!-- End Thumbnails -->

		
	</div>
</div>

<!-- Footer -->

<?php include '../Main/footer.php';
?>