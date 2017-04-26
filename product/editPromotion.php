<?php
include '../main/authorization.php';
if(authetication()==TRUE){
include '../Main/header.php';
if (isset($_SESSION['id']) && ($_SESSION['id'][0] == 'S' || $_SESSION['id'][0] == 'R')) {
} else {
	echo "<script>window.location = '../Home/Homepage.php' </script>";
}
?>

<script>
	$(document).ready(function() {
		$("#txtDateFrom").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat : "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#txtDateTo").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#txtDateTo").datepicker({
			defaultDate : "+1w",
			changeMonth : true,
			numberOfMonths : 1,
			dateFormat : "yy-mm-dd",
			onClose : function(selectedDate) {
				$("#txtDateFrom").datepicker("option", "maxDate", selectedDate);
			}
		});
		$('.btnShowItem').click(function(e) {
			$id = $(this).attr('dir');
			window.location.replace('editPromotionList.php?promotion=' + $id);
		});
		$('.btnEditDetail').click(function(e) {
			$promotionid = $(this).attr('dir');
			$("#modalEditPromotionDetail").load("frmEditPromotion.php?promotionid=" + $promotionid);
			$('#modalEditPromotionDetail').foundation('reveal', 'open');
		});

	}); 
</script>
<div class="row">
	<!-- Side Bar -->
	<div class="large-12 small-12 columns">
		<h1>Promotion Maintanance</h1>
		<div id="modalEditPromotionDetail" class="reveal-modal ">

		</div>
		<div class="large-12 columns">
			<?php
			if($_SESSION['id'][0] == 'S'){
			?>
			<form id="frmAddPromotion" class="custom" data-abide action="hrefPromotion.php" method="post" data-invalid="">

				<div class="row">
					<div class="large-12 column">
						<label for="txtPromotionTitle">Promotion Title <small>(require)</small></label>
						<input type="text" id="txtPromotionTitle" placeholder="Promotion Title" name="txtPromotionTitle" required>
					</div>
				</div>

				<div class="row">
					<div class="large-12 columns">
						<label for="txtPromotionDescription">Promotion Description<small>(require)</small></label>
						<textarea id="txtPromotionDescription" placeholder="Example: A Promotion" name="txtPromotionDescription" required></textarea>
					</div>
				</div>

				<div class="row">
					<div class="large-6 columns">
						<label for="txtDateFrom">Start Date<small>(require)</small></label>
						<input type="text" id="txtDateFrom" placeholder="yyyy-mm-dd" name="txtDateFrom" pattern="\d{4}-\d{1,2}-\d{1,2}" required >
					</div>

					<div class="large-6 columns">
						<label for="txtDateTo">End Date<small>(require)</small></label>
						<input type="text" id="txtDateTo" placeholder="yyyy-mm-dd" name="txtDateTo" pattern="\d{4}-\d{1,2}-\d{1,2}"required>
					</div>
				</div>

				<button type="submit" id="btnAddPromotion" name="btnAddPromotion" class="medium button green">
					Add
				</button>
				<button type="reset" id="btnClear" name="btnClear" class="medium button green close">
					Clear
				</button>
			</form>
			<?php
			}
			?>
			<div class="small-12 large-12 columns">
				<div class="row panel" >
					<div class="large-1 small-1 columns">
						ID
					</div>
					<div class="large-6 small-6 columns">
						Description
					</div>
					<div class="large-3 small-3 columns">
						Date
					</div>

					<div class="large-2 small-2 columns">

					</div>
				</div>
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
$query = " SELECT p.*, CASE WHEN (c.totalItem>0) THEN c.totalItem ELSE 0 END AS total
from promotions p
LEFT JOIN (select i.promotionID, count(i.promotionID) as totalItem from promotion_product i GROUP BY i.promotionID) AS c
ON p.promotionID=c.promotionID
ORDER BY dateFrom DESC ";

$result = mysql_query($query . " LIMIT $offset, $rowsPerPage") or die('Error, query failed'.mysql_error());

$display = '';

$self = $_SERVER['PHP_SELF'] . '?';

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				?>
				<div class="row panel" >
					<div class="large-1 small-1 columns">
						<?php echo $row['promotionID']; ?>
					</div>
					<div class="large-6 small-6 columns">
						<label>Title:</label>
						<p>
							<?php echo $row['promotiontitle']; ?>
						</p>
						<label>Discount Items:</label>
						<p>
							<?php echo $row['total']; ?>
						</p>
						<label class="hide-for-small">Description:</label>
						<p class="hide-for-small">
							<?php echo $row['description']; ?>
						</p>
					</div>
					<div class="large-3 small-3 columns">

						<label>From:</label>
						<p class="success  radius  label">
							<?php echo $row['dateFrom']; ?>
						</p>
						<label>To:</label>
						<p class="success  radius  label">
							<?php echo $row['dateTo']; ?>
						</p>
					</div>
					<div class="large-2 small-2 columns">
						<?php
if($_SESSION['id'][0] == 'S'){
						?>
						<button type="button" id="btnEditDetail" name="btnEditDetail"  class="btnEditDetail medium button green" dir="<?php echo $row['promotionID']; ?>">
							Edit Title
						</button>
						<?php
						}
						?>
						<button type="button" id="btnShowItem" name="btnShowItem" class="btnShowItem" dir="<?php echo $row['promotionID']; ?>" class="medium button green close">
							Edit Item
						</button>
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
				</div>
				</div>
				<!-- End Side Bar -->

				<!-- Thumbnails -->

				<!-- End Thumbnails -->

				</div>
				<!-- Footer -->
				<?php include '../Main/footer.php';
				}
				?>
