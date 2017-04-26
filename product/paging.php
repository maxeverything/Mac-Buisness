
<style>
	.imgBtn {
		position: absolute;
		right:0px;
		top:6px;
		width: 50px;
	}
	.panelItem {
		position: relative;
	}
</style>

<?php
include '../sql/config.php';
include '../sql/opendb.php';
include '../Function/currency.php';

// how many rows to show per page
$rowsPerPage = 18;
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
$date = mysql_real_escape_string(product::getDate());

$query = " SELECT p.ProductID, p.ProductName, p.description, p.product_point, p.UnitPrice, c.discount, CASE WHEN (p.Product_date> '$date') THEN '../images/New.gif' ELSE '../images/normal.gif' END AS Status 
		from Products p
		LEFT JOIN (select pp.productID, pp.discount 
					from promotion_product pp, promotions pro 
					WHERE pp.promotionID=pro.promotionID AND
					NOw() between pro.dateFrom and pro.dateTo) AS c
		ON p.productID=c.productID
		WHERE UnitsInStock>0 AND Product_status='ACTIVATE' ";
if (isset($_REQUEST['advanceSearch'])) {
	$queryString = '';
} 

if (isset($_REQUEST['product']) && !empty($_REQUEST['product'])) {
		$queryString = product::setQueryString($queryString, 'product', $_REQUEST['product']);
		$name = mysql_real_escape_string($_REQUEST['product']);
		$query .= " AND ProductName LIKE '%$name%' ";
	}

	if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
		$queryString = product::setQueryString($queryString, 'category', $_REQUEST['category']);
		$category = mysql_real_escape_string($_REQUEST['category']);
		$query .= " AND CategoryID='$category' ";
	}

	if (isset($_REQUEST['shop']) && !empty($_REQUEST['shop'])) {
		$queryString = product::setQueryString($queryString, 'shop', $_REQUEST['shop']);
		$shop = mysql_real_escape_string($_REQUEST['shop']);
		$query .= " AND shopId='$shop' ";
	}

	if (isset($_REQUEST['range']) && (!empty($_REQUEST['range']))) {
		$queryString = product::setQueryString($queryString, 'range', $_REQUEST['range']);
		if ($_REQUEST['range'] == 1) {
			$range = mysql_real_escape_string(50);
			$query .= " AND UnitPrice<='$range' ";
		} elseif ($_REQUEST['range'] == 2) {
			$upperRange = mysql_real_escape_string(100);
			$lowwerRange = mysql_real_escape_string(50);
			$query .= " AND UnitPrice BETWEEN '$lowwerRange' AND '$upperRange' ";
		} else {
			$range = mysql_real_escape_string(100);
			$query .= " AND UnitPrice>'$range' ";
		}

	}
if (isset($_REQUEST['frmSort'])) {
	$orderQuery = '';	
} 
if (isset($_REQUEST['sort']) && isset($_REQUEST['dir']) && !empty($_REQUEST['sort']) && !empty($_REQUEST['dir'])) {		
		$orderQuery = product::setQueryString($orderQuery, 'sort', $_REQUEST['sort']);
		$orderQuery = product::setQueryString($orderQuery, 'dir', $_REQUEST['dir']);
		$sort = mysql_real_escape_string($_REQUEST['sort']);
		$dir = mysql_real_escape_string($_REQUEST['dir']);
		$query .= " order by $sort $dir ";		
}

$result = mysql_query($query . " LIMIT $offset, $rowsPerPage") or die('Error, query failed'.mysql_error());
if(mysql_num_rows($result)>0){
$display = '';

$self = $_SERVER['PHP_SELF'] . '?';

if (!empty($queryString)) {
	$self .= $queryString . '&';
}

if (!empty($orderQuery)) {
	$self .= $orderQuery . '&';
}

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$productID = mysql_real_escape_string($row['ProductID']);
	$query2 = "Select pic_url from product_pic where ProductID=
$productID LIMIT 0,1 ";

	$result2 = mysql_query($query2) or die('Error, query failed2');
	$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
?>
	<div class="large-4 small-6 columns" >
		<a href='OrderProduct.php?product=<?php echo $row['ProductID']; ?>' alt='<?php echo $row['ProductName']; ?>'>
			<div class=" panelItem panel">
				<img src='<?php echo $row2['pic_url']; ?>' class="small-11 large-11" alt='<?php echo $row['ProductName']; ?>' Class='imgItem' style="width: 200px;height:190px;"/>
				<img src='<?php echo $row['Status']; ?>' Class='imgBtn'/>
				<h5> <?php echo $row['ProductName']; ?></h5>
				
				<?php if($row['discount']){
				?>
				<h6 class='subheader'><strike><?php echo Currency::getCurrency($row['UnitPrice']); ?></strike></h6>
				<h5 class='subheader'><?php echo Currency::getCurrency($row['UnitPrice'] * (100 - $row['discount']) / 100); ?>
					<p class="success  radius  label">-<?php echo round($row['discount']); ?>%</p></h5>
				<?php
				}else{
				?>
				<h6 class='subheader'><?php echo Currency::getCurrency($row['UnitPrice']); ?></h6>
				<?php
				}

				if(isset($_SESSION['id']) && $_SESSION['id'][0]=='M'){
				if($row['product_point']>0){
				?>
				<a id="btnRedeem" class="btnRedeem" dir="<?php echo $row['product_point']; ?>" href="../productRedeem/redeemItem.php?product=<?php echo $row['ProductID']; ?>" class="btnRedeem large-12 small-12" role="button" aria-disabled="false">
					<div class="medium button green large-12 small-12">Redeem with (
						<?php
						echo $row['product_point'];
						?> ) point</div>
							</a>
							
						<?php
						}
						if(cart::checkHaveCartItem($row['ProductID'])){
				?>
						<div class="medium button green disabled large-12 small-12">
							<h6 name="lblCart">Already in Cart</h6>
						</div>
					<?php
					}else{
					?>
								<a class='btnAddCart' href='<?php echo $row['ProductID']; ?>'>
							<div class="medium button green large-12 small-12">
								<h6 name="lblCart">Buy Now</h6>
							</div>
						</a>
						<?php
						}
						}
				?>
					
			</div>
		</a>
	</div>

<?php
}
// how many rows we have in database
$result = mysql_query($query) or die('Error, query failed');
$numrows = mysql_num_rows($result);
// how many pages we have when using paging?
$maxPage = ceil($numrows / $rowsPerPage);
// print the link to access each page

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
}else{
?>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {		
		alert('NO product item found');
		window.location.replace("product.php");
	}
	</script>
</script>
<?php
}
// and close the database connection
include '../sql/closedb.php';
?>
<script></script>
