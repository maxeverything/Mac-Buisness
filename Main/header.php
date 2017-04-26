
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>CMS</title>

  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/foundation.css">
  <link href="../css/jquery-ui-1.10.3.custom.css" type="text/css" rel="stylesheet">
  <link href="../css/jquery-ui-1.10.3.custom.min.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="../css/zoom.css" type="text/css" />
 
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/zepto.js"></script>
  <script src="../js/modernizr.js"></script>
 <script src="../js/jquery-1.8.3.js"></script> 
  <script src="../js/jquery-ui-1.10.3.custom.js"></script>
  <script src="../js/min.js"></script>
<style>
body{
	background: #f0f0f0 url(../images/htmlbg.jpg) repeat; width:100%;
}
.promote_img img{
	height:300px;
}

.top{
	height:230px
}
.sign img{
	height:50px;
	width:130px;
}
</style>
</head>
<body>
<div class="row" style="background: #f8f8f8;border: 1px solid #eee;">
  <div class="row">
    <div class="small-4 columns top">
    	<img src="../images/lightCMS_logo.jpg" style="padding-left:10px;padding-top:10px;height:220px;width: 350px;"  />
    </div>
    <div class="small-8 columns sign" style="padding-top:30px;" >
    	<div class="small-10 push-4 columns">
<?php

	$conn = mysql_connect('localhost','root','') or die ('Error connecting to mysql');
	mysql_select_db('cms_2');
	
	if(!isset($_SESSION['id'])){
?>
        	<ul class="button-group radius">
              <li><a href="../LoginPage/loginPage.php" class="button secondary">Sign In</a></li>
              <li><a href="../CRM module/member_reg.php" class="button secondary">Sign Up</a></li>
        	</ul>
			
<?php
	}else{
		$id = $_SESSION['id'];
		
		if($_SESSION['id'][0]=='R'){
			$actor = "Seller";
			$spec = "Company Name";
			$selectQry = "SELECT sellerName,email,companyName
						  FROM sellers
						  WHERE sellerID='$id'";
			
		}
		if($_SESSION['id'][0]=='S'){
			$actor = "Staff";
			$spec = "Position";
			$selectQry = "SELECT staffName,email,position
						  FROM staffs
						  WHERE staffID='$id'";
		}
		if($_SESSION['id'][0]=='M'){
			$actor = "Member";
			$spec = "Point";
			$selectQry = "SELECT userName,email,pointAcc, profile_pic
						  FROM members
						  WHERE memberID='$id'";
		}
		
		
		if($_SESSION['id'][0]=='G'){
			$actor = "Manager";
			$spec = "Position";
			$selectQry = "SELECT staffName,email, position
						  FROM staffs
						  WHERE staffID='$id'";
		}
		
		
		$result = mysql_query($selectQry)or die(mysql_error());
		
		if($actor == 'Member'){
			while($row = mysql_fetch_row($result)){
				$name = $row[0];
				$email = $row[1];
				$spe = $row[2];
				$profile = $row[3];
			}		
		}else{
			while($row = mysql_fetch_row($result)){
				$name = $row[0];
				$email = $row[1];
				$spe = $row[2];
			}	
		}
		
if(isset($_SESSION['id']) && $_SESSION['id'][0]=='M'){
	
	$query = "SELECT count(productID)
			  FROM product_cart
			  WHERE orderID=(
			  	SELECT orderID
				FROM orders
				WHERE memberID='".$_SESSION['id']."'
				ORDER BY orderID DESC
				LIMIT 1
				)";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result)>0){
		while($row = mysql_fetch_row($result)){
			$itemCart = $row[0];
		}
	}else{
		$itemCart = 0;
	}
	
?>
<style>
	.notification{
		border-radius:100%;
		width:25px;height:25px;
		background-color: #c1c0d3;
		border:1px black solid;
		position: absolute;
		right:-5px;
		top:-5px;
		text-align:center;
	}
</style>
<div class="small-2 push-5 columns" style="top:100px">
<div class="notification"><?php echo $itemCart ?></div>
	<a href="../Cart/cartList.php"><img src="../images/cart.jpg" style="height: 80px;"/></a>
</div>


<img src="../personal/<?php echo $profile;  ?>" style="width: 80px;height:90px; border: solid black 1.5px"/>
<?php }
?>
<a href="#" data-dropdown="drop3" class="button alert round dropdown"><?php echo "Welcome : {$name}"; ?></a><br>
    <ul id="drop3" data-dropdown-content class="f-dropdown">
      <li><label>ID :</label><?php echo $_SESSION['id']; ?></li>
      <li><label>Email :</label><?php echo $email; ?></li>
      <li><label><?php echo $spec." :"; ?></label><?php echo $spe; ?></li>
   </ul>
 <br/>
<div class="small-3 columns">
	<span class="success label" style="border-radius:5px">
    	<div class="radius secondary label">Role : </div>
    	<h3 style="color:#FFF">
			<?php echo "$actor" ?>
        </h3>
    </span>
</div>

<form method="post" action="../Main/destroySession.php">
		<button name="logout" class="tiny button secondary">Logout</button>
</form>

<?php
}
	
?>
        </div>

    </div>
	
</div>
 	<div class="row">
    <div class="large-12 columns">

          <nav class="top-bar">
            <ul class="title-area">
              <!-- Title Area -->
              <li class="name">
                <h1>
                  <a href="../Home/homePage.php">
                    Welcome to Light Enterprise
                  </a>
                </h1>
              </li>
			 
            </ul>
         
            <section class="top-bar-section">
              <!-- Right Nav Section -->
              <ul class="right">
<?php
	if(isset($_SESSION['id']) && $_SESSION['id'][0]=='R'){
		
		$profilePage = "../Seller maintenance/seller_update.php";
		
		$query = "SELECT shopID
				  FROM shops
				  WHERE sellerID='".$_SESSION['id']."'";
				  
		$result = mysql_query($query);
		
		$row = mysql_fetch_row($result);
?>
 				    <li class="has-dropdown">
                      <a href="#" class="">Shops</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><?php echo "<a href='../product/product.php?shop=$row[0]'>My Shops</a>"; ?></li>
                        <li><a href="../Report Module/personalReport.php">Shop transaction report</a></li>
                      </ul>
                    </li>
					
                    
                    <li class="has-dropdown">
                      <a href="#" class="">Products</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><a href="../product/editPromotion.php">Promotion Maintenance</a></li>
						<li><a href="../product/AddProduct.php">Add new Product</a></li>
                        <li><a href="../product/editProductList.php">Update/Deactive Product</a></li>
                      </ul>
                    </li>
					
					 		
<?php
	}
	if(isset($_SESSION['id']) && $_SESSION['id'][0]=='S'){
		$profilePage = "../Staff maintenance/staff_update.php";
?>
				 <li class="has-dropdown">
                    <a href="#" class="">Editer</a>
                    <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                      <li><a href="../Staff maintenance/HomeEdit_SlideImage.php">Home Slide Picture</a></li>
                      <li><a href="../Staff maintenance/HomeEdit_NewProductImg.php">Home Products Picture</a></li>
					  <li><a href="../Report Module/memberOrderHistoryReport.php">Member Order History Report</a></li>
                    </ul>
                 </li>
				 
				 
				 <li class="has-dropdown">
				 	
     			 <a href="#">Maintenance</a>
        		  <ul class="dropdown">
                    <li class="has-dropdown">
                      <a href="#" class="">Member</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><a href="../Staff maintenance/deactive_member_list.php">Deactive Member</a></li>
						<li><a href="../Report Module/member_report.php">View Member Report</a></li>
                      </ul>
                    </li>
                    
                    <li class="has-dropdown">
                      <a href="#" class="">Products</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><a href="../product/editProductList.php">Update/Deactive Product</a></li>
                      </ul>
                    </li>
					
					<li class="has-dropdown">
                      <a href="#" class="">Sellers</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><a href="../Seller maintenance/seller_reg.php">Add new Seller</a></li>
                        <li><a href="../Seller maintenance/seller_delete.php">Delete Seller</a></li>
					    <li><a href="../Report Module/seller_report.php">View Seller Report</a></li>
                      </ul>
                    </li>

                     <li><a href="../product/editPromotion.php">Promotion Maintenance</a></li>				
					 <li><a href="../Spoil product handle module/handleProSpoiled.php">Spoiled Complaint</a></li>
                     <li><a href="../shipping module/updateShipment.php">Update Shipping</a></li>
                  </ul>
                 </li>
<?php	
	}
	
	if(isset($_SESSION['id']) && $_SESSION['id'][0]=='G'){
	?>
					<li class="has-dropdown">
                      <a href="#" class="">Sellers</a>
                      <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
                        <li><a href="../Seller maintenance/seller_reg.php">Add new Seller</a></li>
                        <li><a href="../Seller maintenance/seller_delete.php">Delete Seller</a></li>
                      </ul>
                    </li>
					
					<li class="has-dropdown">
						<a href='#' class=''>Report</a>
						<ul class="dropdown"><li class="title back js-generated"><h5><a href="#">« Back</a></h5></li>
	                        <li><a href="../Report Module/AnnualSaleReport.php">Annual Sale Report</a></li>
	                        <li><a href="../Report Module/Grib_CustOrder.php">Grib CustOrder Report</a></li>
	                        <li><a href="../Report Module/productReturnReport.php">Product Returnable Report</a></li>
	                        <li><a href="../Report Module/NoOfCustomerReg.php">Customer Registration Report</a></li>
	                        <li><a href="../Report Module/p_cat_report.php">Category Report</a></li>
	                        <li><a href="../Report Module/Product_high_sale.php">Product best sale Report</a></li>
	                        <li><a href="../Report Module/member_report.php">Member Report</a></li>
	                        <li><a href="../Report Module/seller_report.php">Seller Report</a></li>
	                        <li><a href="../Report Module/staff_report.php">Staff Report</a></li>
							<li><a href="../Report Module/memberOrderHistoryReport.php">Member Order History Report</a></li>
                      </ul>
					</li>
	<?php
	}
	if(isset($_SESSION['id']) && $_SESSION['id'][0]=='M'){
		$profilePage = "../personal/personal_profile.php";
		?>
			<li>
	            <a href='../Spoil product handle module/Form_spoil.php'>Report Spoiled Product</a>
	        </li>
	
		<?php
	}
	
	if(isset($_SESSION['id']) && $_SESSION['id'][0]!='G'){
?>
		<li class="has-dropdown">
            <a href="#">My Setting</a>
            <ul class="dropdown">
                <li><a href="<?php echo $profilePage ?>">My Profile</a></li>
                <li><a href="../Password/password_update.php">Change Password</a></li>
				
				<?php
					if($_SESSION['id'][0]=='M'){
						echo "<li><a href='../personal/OrderHistory.php'>Puchase History</a></li>";
					}
					
					if($_SESSION['id'][0]=='R'){
						echo "<li><a href='../Seller maintenance/adjustAlertQuantity.php'>Update Alert for UnitInStock</a></li>";
					}
				?>
            </ul>
        </li>
		
<?php
	}
?>
	<!-- lists that will be appear for customer -->   		
                
                <li class="has-dropdown">
                  <a href="#">Categories</a>
                   <ul class="dropdown">
                    <li><label>Category List </label></li>
<?php
	$connect = mysql_connect('localhost','root','') or die('Database not found!');
	mysql_select_db('cms_2');
	
	$getCategories = "SELECT categoryName, categoryID
					  FROM categories";
					  
	$getShop = "SELECT shopName, shopId
				FROM shops
				WHERE shopID";
				
	$result = mysql_query($getCategories)or die(mysql_error());
	
	while($row = mysql_fetch_row($result)){
		echo "<li><a href='../product/product.php?category=$row[1]'>$row[0]</a></li>";
	}
	
	$result = mysql_query($getShop)or die(mysql_error());
	
	$count = mysql_num_rows($result);
?>                    
                  </ul>
                </li>

                 <li class="has-dropdown">
                  <a href="#">Shop Name</a>
                  <ul class="dropdown">
                  <li><label>Shop Name List</label></li>
                    <?php 
						while($row = mysql_fetch_row($result)){
							echo "<li><a href='../product/product.php?shop=$row[1]'>$row[0]</a></li>";
						}
						mysql_close($connect);
					?>
                  </ul>
                </li>
                
                <li>
                  <a href="../product/product.php">Products Page</a>
				</li>
            
          
              </ul>
            </section>
          </nav>
          
  <script src="../js/zepto.js"></script>
  <script src="../js/modernizr.js"></script>
        </div>
  </div>
</div>