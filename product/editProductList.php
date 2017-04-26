<?php 
include '../main/authorization.php';

include '../Main/header.php';
if (isset($_SESSION['id']) && ($_SESSION['id'][0] == 'S' || $_SESSION['id'][0] == 'R')) {
} else {
	echo "<script>window.location = '../Home/Homepage.php' </script>";
}
?>

<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<div class="large-12 small-12 panel">
			<form action="editProductList.php">
			<div class="small-12 large-6 small-centered columns">
			<label>Product Name</label>
			<input type="text" id="product" name="product" placeholder="Product Name" />
			<button type="submit" name="btnSearch" id="btnSearch" class="medium button green" >Search</button>
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
		var highest = 0;
		var hi = 0;
		$id=<?php echo json_encode($_SESSION['id']);?>;
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
		$('.btnDeleteProduct').click(function(e){
			e.preventDefault();
			$produtcid=$(this).attr('dir');
			$product=$(this);
			if($product.text()=='REACTIVE'){				
				if (confirm("Reactive this product?")) {			
				$.ajax({
					type: "POST",
					url: "hrefProduct.php?activateProduct=&productid="+$produtcid,
					success: function(msg) {
						// Message Sent - Show the 'Thank You' message and hide the form							
						if(msg=='') {
				           $product.text('×');
						}else{
							alert('Unable to delete'+msg);
						}
					}
			});
			}
			}else{
				
				if (confirm("confirm delete?")) {			
				$.ajax({
					type: "POST",
					url: "hrefProduct.php?deleteProduct=&productid="+$produtcid,
					success: function(msg) {
						// Message Sent - Show the 'Thank You' message and hide the form							
						if(msg=='') {
				           $product.text('REACTIVE');
						}else{
							alert('Unable to delete'+msg);
						}
					}
			});
			}
			}
		});
	});
</script>
	
<?php
include '../Function/product.php';
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
$query = " SELECT * from Products ";

if($_SESSION['id'][0]=='R'){
	$shopID=mysql_real_escape_string($_SESSION['shopID']);
	$query.="WHERE shopID='$shopID' ";
}

if (isset($_REQUEST['product']) && !empty($_REQUEST['product'])) {
		$queryString = product::setQueryString($queryString, 'product', $_REQUEST['product']);
		$name = mysql_real_escape_string($_REQUEST['product']);
		if($_SESSION['id'][0]=='R'){
			$query .= " AND ProductName LIKE '%$name%' ";
		}else{
			$query .= " WHERE ProductName LIKE '%$name%' ";
		}		
	}


$result = mysql_query($query . " LIMIT $offset, $rowsPerPage") or die('Error, query failed'.mysql_error());

$display = '';

$self = $_SERVER['PHP_SELF'] . '?';

if (!empty($queryString)) {
	$self .= $queryString . '&';
}


while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$productID = mysql_real_escape_string($row['ProductID']);
	$query2 = "Select pic_url from product_pic where ProductID=
$productID LIMIT 0,1 ";

	$result2 = mysql_query($query2) or die('Error, query failed2');
	$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
?>
	<div class="large-3 small-6 columns" >
		
			<div class=" panelItem panel">
				<?php
				if($row['Product_status']=="ACTIVATE"){
				?>
				<a class="right btnDeleteProduct" dir="<?php echo $row['ProductID']; ?>" href=" ">&#215;</a>
				<?php	
				}else{
				?>
				<a class="right btnDeleteProduct" dir="<?php echo $row['ProductID']; ?>" href=" ">REACTIVE</a>
				<?php	
				}
				?>
				<a target="_blank" href='editProduct.php?product=<?php echo $row['ProductID']; ?>' alt='<?php echo $row['ProductName']; ?>'>
				<img src='<?php echo $row2['pic_url']; ?>' class="small-12 large-12" alt='<?php echo $row['ProductName']; ?>' Class='imgItem' style="width: 200px;height:190px"/>
				</a>
				<h5> <?php echo $row['ProductName']; ?></h5>
				<p class='subheader'><?php echo $row['description']; ?></p>
				
					
			</div>
		
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
// and close the database connection
include '../sql/closedb.php';
?>

	</div>
	<!-- End Side Bar -->

	<!-- Thumbnails -->

	<!-- End Thumbnails -->

</div>
<!-- Footer -->
<?php include '../Main/footer.php'
?>