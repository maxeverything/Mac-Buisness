<?php
include '../main/authorization.php';
include '../Main/header.php';
if (isset($_SESSION['id']) && ($_SESSION['id'][0] == 'S' || $_SESSION['id'][0] == 'R')) {
} else {
	echo "<script>window.location = '../Home/Homepage.php' </script>";
}

if(isset($_REQUEST['promotion'])){
include '../Function/product.php';
?>

<div class="row">
<!-- Side Bar -->
<div class="large-12 small-12 columns">
	<h1>Promotion( <?php echo product::getPromotionTitle($_REQUEST['promotion']);?>)</h1>
<div class="large-12 small-12 panel">
	
<form id="frmSearchPromotion">
<div class="small-12 large-6 small-centered columns">
	<div id="modalPromotion" class="reveal-modal "></div>
<label>Product Name</label>
<input type="text" id="product" name="product" placeholder="Product Name" />
<div>
<label>Category</label>
<select id="ddlCategory" name="category">
<option value="">Category</option>
<?php

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
<?php
if($_SESSION['id'][0]=='S'){
?>
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
<?php
	}
?>
<button type="button" name="btnSearch" id="btnSearch" class="medium button green" >Search</button>
</div>
</form>
</div>
<style>
	.panelItem {
		position: relative;
	}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$promotionid=<?php echo json_encode($_REQUEST['promotion']); ?>
	;
	$('#btnSearch').click(function(e){
		var str=$('#frmSearchPromotion').serialize();
		window.location="editPromotionList.php?promotion="+$promotionid+"&"+str;
	});
	$('.btnAddPromotion').click(function() {
			$productid = $(this).attr("dir");
			$("#modalPromotion").load("frmPromotionItem.php?productid=" + $productid+'&promotion='+$promotionid );
			$('#modalPromotion').foundation('reveal', 'open');
		});
	$('.btnEditPromotion').click(function() {
			$productid = $(this).attr("dir");
			$("#modalPromotion").load("frmPromotionItem.php?productid=" + $productid+'&promotion='+$promotionid );
			$('#modalPromotion').foundation('reveal', 'open');
		});	
	var highest = 0;
	var hi = 0;
	$id=<?php echo json_encode($_SESSION['id']); ?>;
	$(".panelItem").each(function() {
		var h = $(this).height();
		if (h > hi) {
			hi = h;
			highest = h;
		}
	});

	$('.panelItem').height(highest);
	$('#product').autocomplete({
		source : "productAutocomplete.php?term="
	});
	$('.btnDeletePromotionItem').click(function(e) {
		e.preventDefault();
		$produtcid = $(this).attr('dir');
			if (confirm("confirm delete?")) {
				$.ajax({
					type : "POST",
					url : "hrefPromotion.php?deletePromotionItem=&productid="+$produtcid+'&promotion='+$promotionid,
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
			}
	});
	
	});
</script>

<?php
include '../sql/config.php';
include '../sql/opendb.php';
include '../Function/currency.php';
include '../Cart/fCart.php';
// how many rows to show per page
$rowsPerPage = 20;
$queryString='';
$orderQuery='';
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if (isset($_GET['page'])) {
$pageNum = $_GET['page'];
}
// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
$query = " SELECT p.*, s.shopName from Products p, shops s WHERE p.shopId=s.shopId ";

if($_SESSION['id'][0]=='R'){
$shopID=mysql_real_escape_string($_SESSION['shopID']);
$query.=" AND p.shopId='$shopID' ";
}

if (isset($_REQUEST['promotion']) && !empty($_REQUEST['promotion'])) {
$queryString = product::setQueryString($queryString, 'promotion', $_REQUEST['promotion']);
}

if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
$queryString = product::setQueryString($queryString, 'category', $_REQUEST['category']);
$category = mysql_real_escape_string($_REQUEST['category']);
$query .= " AND p.CategoryID='$category' ";
}

if (isset($_REQUEST['shop']) && !empty($_REQUEST['shop'])) {
$queryString = product::setQueryString($queryString, 'shop', $_REQUEST['shop']);
$shop = mysql_real_escape_string($_REQUEST['shop']);
$query .= " AND p.shopId='$shop' ";
}

if (isset($_REQUEST['product']) && !empty($_REQUEST['product'])) {
$queryString = product::setQueryString($queryString, 'product', $_REQUEST['product']);
$name = mysql_real_escape_string($_REQUEST['product']);
if($_SESSION['id'][0]=='R'){
$query .= " AND ProductName LIKE '%$name%' ";
}else{
$query .= " AND ProductName LIKE '%$name%' ";
}
}

$result = mysql_query($query . " ORDER BY ProductID ASC LIMIT $offset, $rowsPerPage") or die('Error, query failed'.mysql_error());

$display = '';

$self = $_SERVER['PHP_SELF'] . '?';

if (!empty($queryString)) {
$self .= $queryString . '&';
}

// how many rows we have in database

if( mysql_num_rows($result)>0){

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
$productID = mysql_real_escape_string($row['ProductID']);
$query2 = "Select pic_url from product_pic where ProductID=
$productID LIMIT 0,1 ";

$result2 = mysql_query($query2) or die('Error, query failed2');
$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
?>
<div class="large-3 small-6 columns" >

<div class=" panelItem panel" dir="<?php echo $row['ProductID']; ?>">
<?php
$discount=0;
$promotionID=mysql_real_escape_string($_REQUEST['promotion']);
$resultPromotion=mysql_query("select discount from promotion_product where ProductID='$productID' AND promotionID='$promotionID'");
if(mysql_num_rows($resultPromotion)>0){
	$rowPromotion=mysql_fetch_array($resultPromotion, MYSQL_ASSOC);
	$sub=$row['UnitPrice']*(100-$rowPromotion['discount'])/100;
	$discount=$rowPromotion['discount'];
?>
	<a class="right btnDeletePromotionItem" dir="<?php echo $row['ProductID']; ?>" href=" ">&#215;</a>
<?php
}
?>
<img style="height:250px;width:200px" src="<?php echo $row2['pic_url']; ?>" alt="<?php echo $row['ProductName']; ?>"  />

<h5> <?php echo $row['ProductName']; ?></h5>
<div class="row">
	<div class="large-12 small-12 columns">
		<label>Shop: </label>
<p class='subheader'><?php echo $row['shopName']; ?></p>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		Price: 
	</div>	
	<div class="large-6 small-6 columns">
		<label class="lblOriPrice right"><?php echo $row['UnitPrice']; ?></label>
	</div>	
</div>

<?php
if($discount>0){
?>	

<div class="row">
	<div class="large-6 small-6 columns">
		Disc(%):
	</div>	
<div class="large-6 small-6 columns alignright">
		<label class="right"><?php echo $discount; ?>%</label>
	</div>	
</div>
<div class="row">
	<div class="large-6 small-6 columns">
		subTotal:
	</div>	
	<div class="large-6 small-6 columns">
		
 <label class="right"><?php echo number_format($sub, 2); ?></label>
	</div>	
</div>
<div class="row rowEdit">
<div class="large-12 small-12 columns">
<button id="btnEditPromotion" name="btnEditPromotion" type="button" class="radius button btnEditPromotion large-12 small-12" dir="<?php echo $row['ProductID']; ?>">Edit</button>
</div>
</div>
<?php
}else{
?>

<div class="row rowEdit">
<div class="large-12 small-12 columns">
<button id="btnAddPromotion" name="btnAddPromotion" type="button" class="radius button btnAddPromotion large-12 small-12" dir="<?php echo $row['ProductID']; ?>">Add</button>
</div>
</div>
<?php
}
?>




 

</div>

</div>

<?php
}
// how many rows we have in database
$result = mysql_query($query) or die('Error, query failed');
$numrows = mysql_num_rows($result);
$maxPage = ceil($numrows / $rowsPerPage);
$nav = ' ';

if ($maxPage <= 5) {
for ($page = 1; $page <= $maxPage; $page++) {
if ($page == $pageNum) {
$nav .= '<li class="current"><a href="">' . $page . '</a></li> ';
// no need to create a link to current page
} else {
$nav .= " <li><a href=\"$self" . "page=$page\">$page</a></li> ";
}
}
} else {
if ($pageNum <= 3) {
for ($page = 1; $page <= 5; $page++) {
if ($page == $pageNum) {
$nav .= '<li class="current"><a href="">' . $page . '</a></li> ';
// no need to create a link to current page
} else {
$nav .= " <li><a href=\"$self" . "page=$page\">$page</a></li> ";
}
}
} else if ($pageNum < $maxPage - 3) {
for ($page = $pageNum - 2; $page <= $pageNum + 2; $page++) {
if ($page == $pageNum) {
$nav .= '<li class="current"><a href="">' . $page . '</a></li> ';
// no need to create a link to current page
} else {
$nav .= " <li><a href=\"$self" . "page=$page\">$page</a></li> ";
}
}
} else {
for ($page = $maxPage - 4; $page <= $maxPage; $page++) {
if ($page == $pageNum) {
$nav .= '<li class="current"><a href="">' . $page . '</a></li> ';
// no need to create a link to current page
} else {
$nav .= " <li><a href=\"$self" . "page=$page\">$page</a></li> ";
}
}
}
}

if ($pageNum > 1) {
$page = $pageNum - 1;
$prev = "<li class='arrow'><a href=\"$self" . "page=$page\">[Prev]</a> </li>";

$first = " <li class='arrow'><a href=\"$self" . "page=1\">[First]</a></li>";
} else {
$prev = "<li class='arrow unavailable'><a href=\"$self" . "page=$page\">[Prev]</a> </li>";
// we're on page one, don't print previous link
$first = " <li class='arrow unavailable'><a href=\"$self" . "page=1\">[First]</a></li>";
// nor the first page link
}
if ($pageNum < $maxPage) {
$page = $pageNum + 1;
$next = " <li class='arrow'><a href=\"$self" . "page=$page\">[Next]</a> </li>";

$last = " <li class='arrow'><a href=\"$self" . "page=$maxPage\">[Last]</a> </li>";
} else {
$next = " <li class='arrow unavailable'><a href=\"$self" . "page=$page\">[Next]</a> </li>";
// we're on the last page, don't print next link
$last = " <li class='arrow unavailable'><a href=\"$self" . "page=$maxPage\">[Last]</a> </li>";
// nor the last page link
}
// print the navigation link
$displayPage = '
<div class="row">
<div class="large-12 pagination-centered columns"><ul class="pagination">' . $first . $prev . $nav . $next . $last . "</ul></div>
</div>";

echo $displayPage;
// and close the database connection

}else{
echo 'No Item found!';
}

include '../sql/closedb.php';
?>

</div>
<!-- End Side Bar -->

<!-- Thumbnails -->

<!-- End Thumbnails -->

</div>
<!-- Footer -->
<?php 
}else{
	echo "<script>window.location = '../product/editPromotion.php' </script>";
}
include '../Main/footer.php'
?>