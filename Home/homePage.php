<?php 
	session_start();
	include '../Main/header.php';
	require('../sql/config.php');
	require('../sql/opendb.php');
	
	$link = FALSE;
		
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		
		if($_SESSION['id'][0]=='R'){
			$qryQuantity = "SELECT quantity,id
							FROM alertQuantity
							WHERE sellerID='$id'
							ORDER BY id DESC
							LIMIT 1";
			$result = mysql_query($qryQuantity);
			
			if(mysql_num_rows($result)<=0){
				$checkVal = 100;
			}else{
				$row = mysql_fetch_row($result);
				$checkVal = $row[0];
			}
			
			$queryQty = "SELECT p.productID,p.productName,p.unitsInStock,p.unitPrice,pc.pic_url
							FROM products p, shops s, sellers r, product_pic pc
							WHERE p.shopID = s.shopID
							AND r.sellerID = s.sellerID
							AND s.sellerID =  '$id'
							AND pc.productID = p.productID
							AND p.unitsInStock < '$checkVal'";
							
				$result = mysql_query($queryQty);
				$proID = array();
				$proName = array();
				$alertMsg='';
				while($row = mysql_fetch_row($result)){
					$proID[] = $row[0];
					$proName[] = $row[1];
					$proPrice[] = $row[3];
					$proStock[] = $row[2];
					$pic_url[] = $row[4];
					
					$alertMsg .= 'Product ID : '.$row[0].'\n Product Name : '.$row[1].'\n Quantity left only: '.$row[2].' \n--\n';
				}
				
				if(mysql_num_rows($result)>0){
				?>
					<script>
							window.onload = function() {
								 alert("<?php echo $alertMsg; ?>");
							}
					</script>
				<?php	
					$link = TRUE;
				}
		}
	}
	
	$query = "SELECT *
			  FROM Home_slideimg
			  ORDER BY id DESC
			  LIMIT 1";
	
	$result = mysql_query($query)or die("Home slide error ".mysql_error());
	
	while($row = mysql_fetch_assoc($result)){
		$slideImg[0] = $row['slideshowImage1'];
		$slideImg[1] = $row['slideshowImage2'];
		$slideImg[2] = $row['slideshowImage3'];
		$slideImg[3] = $row['slideshowImage4'];
	}
	
	$query = "SELECT productID
			  FROM home_newprodimgs
			  WHERE editDate = (
			    SELECT max(editDate)
			    FROM home_newprodimgs
		       )";
			  
	$result1 = mysql_query($query)or die("new products error ".mysql_error());
	
	$i=0;
	while($row = mysql_fetch_assoc($result1)){
		$prodID[$i] = $row['productID'];
		$i++;
	}
	
	$count = $i;
	
	for($j=0;$j<$count;$j++){
		$query = "SELECT pic_url
		 		  FROM product_pic
				  WHERE productID='".$prodID[$j]."'";
				  
	    $query2 = "SELECT description
				   FROM products
				   WHERE productID='".$prodID[$j]."'";
				  
		$result2 = mysql_query($query)or die(mysql_error());
		$result3 = mysql_query($query2)or die(mysql_error());
		
		$row = mysql_fetch_row($result2);
		$pic_url[$j]=$row[0];
		
		$row = mysql_fetch_row($result3);
		$desc[$j] = $row[0];			
			
	}	

?>
<style>
ul li img{
	height:300px;
}
</style>



    <script src="jsCarousel/jsCarousel-2.0.0.js" type="text/javascript"></script>

    <link href="jsCarousel/jsCarousel-2.0.0.css" rel="stylesheet" type="text/css" />
	<br/>
	<?php if($link==TRUE){ ?>
		<div class="row">
		 		<span class="label">Quicky Update Your Stock</span>
				<table class="small-12 columns" style="border: solid 1px #fe2c31;text-align: center">
				<tr style="border-bottom: solid 1px #fe2c31">
					<th>ProductID</th>
					<th>Product Name</th>
					<th>Units In Stock</th>
					<th>Unit Price</th>
					<th>Picture</th>
				</tr>
				
					<?php for($i=0;$i<sizeof($proID);$i++){ 
						echo "<tr><td><a href=../product/editProduct.php?product=$proID[$i]>$proID[$i]</a></td>
						      <td><a href=../product/editProduct.php?product=$proID[$i]>$proName[$i]</a></td>
							  <td>$proStock[$i]</td>;
							  <td>$proPrice[$i]</td>
							  <td>
								  <a href=../product/editProduct.php?product=$proID[$i]>
								  	<img src='../product/$pic_url[$i]' width='58px' height='50px'/>
								  </a>
							  </td>
							  </tr>";
					 } 
					?>
				
				</table>
			</div>
	<?php 
	} 
	?>
	
  <div class="row" style="border: 1px solid #D9D2A5;height">
<div class="large-12 columns" align="center">
    <ul data-orbit>
    	<?php
    		for($i=0;$i<4;$i++){
    			echo "<li><img src='../images/slideImgs/".$slideImg[$i]."' /></li>";
    		}
    	?>
    </ul>
    <hr />
    </div>
    
  </div>
  <br/>
<!-- Three-up Content Blocks -->
<style>
.smallbox{
	border: solid 1px #999;
	border-radius:5px;
}


#newproduct img{
	border: black solid 1px;
	border-radius: 4px;
}
</style>

<script type="text/javascript">
        $(document).ready(function() {

            $('#carouselv').jsCarousel({ onthumbnailclick: function(src) { }, autoscroll: true, masked: false, itemstodisplay: 3, orientation: 'v' });
            $('#carouselh').jsCarousel({ onthumbnailclick: function(src) { }, autoscroll: false, circular: true, masked: false, itemstodisplay: 5, orientation: 'h' });
            $('#carouselhAuto').jsCarousel({ onthumbnailclick: function(src) {  }, autoscroll: true, masked: true, itemstodisplay: 5, orientation: 'h' });
             $('#carouselPromotion').jsCarousel({ onthumbnailclick: function(src) { }, autoscroll: false, circular: true, masked: false, itemstodisplay: 5, orientation: 'h' });

        });       
        
</script>


<div class="row">
<h2>Recommand Products</h2>
     <div id="carouselh">
	 <?php
	 	for($i=0;$i<$count;$i++){
	?>		 
		<div><!-- Pass $prodID[$i] with queryString-->
				<a href="<?php echo '../product/OrderProduct.php?product='.$prodID[$i]; ?>" >
	            <img  src="../Product/<?php echo $pic_url[$i]; ?>" />
	            <span class="thumbnail-text"><?php echo $desc[$i] ?></span>
			</a>
		</div>
                            
	<?php
		}
    ?>
    </div>
 </div>

<br/>
<?php
	$queryPromotion=mysql_query("Select p.* 
	from products p, promotions pr, promotion_product pp 
	where p.ProductID=pp.ProductID 
	AND pp.PromotionID=pr.PromotionID
	AND pr.PromotionID=(Select promotionID 
						from promotions 
						where Now() between dateFrom AND dateTo)") or die(mysql_error());
	
?>
<div class="row">
<h2>Promotion Product</h2>
</div>
<div class="row smallbox">
    <div id="carouselPromotion">
	 <?php
	 	while($rowPromotion=mysql_fetch_array($queryPromotion,MYSQL_ASSOC)){
	 		$queryPic =mysql_query( "SELECT pic_url
		 		  FROM product_pic
				  WHERE productID='".$rowPromotion['ProductID']."' LIMIT 0,1 ") or die(mysql_error());
			$rowPic= mysql_fetch_array($queryPic);
	?>		 
		<div><!-- Pass $prodID[$i] with queryString-->
				<a href="<?php echo '../product/OrderProduct.php?product='.$rowPromotion['ProductID']; ?>" >
	            <img  src="../Product/<?php echo $rowPic['pic_url']; ?>" />
	            <span class="thumbnail-text"><?php echo $rowPromotion['ProductName'] ?></span>
			</a>
		</div>
                            
	<?php
		}
    ?>
    </div>
</div>
<br/>
<!-- Footer -->
<?php include '../Main/footer.php'; ?>

