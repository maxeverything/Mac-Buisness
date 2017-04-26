<?php 
//will be use session orderID i cincai put give orderID=1, because u do the order product before add to cart, so u generate the orderID yah 
include '../main/authorization.php';

if(authetication()==TRUE){
	
if(!isset($_POST['checkOut'])){	
	include_once '../Function/product.php';
	include_once '../Main/header.php'; 
	include_once '../Cart/fCart.php';
	$id = $_SESSION['id'];

	include_once '../sql/opendb.php';

	//get Product_cart of this member
	$getProductCart = "SELECT pc.*
					   FROM product_cart pc,orders o
					   WHERE o.memberID='$id' AND o.orderID=pc.orderID AND
					         o.orderID=(
							 	SELECT orderID
								FROM orders
								WHERE memberID='$id'
								ORDER BY orderID DESC
								LIMIT 1
							 )";

	$result = mysql_query($getProductCart);

	$detail =array(array());

	$row=0;
	$countItem = mysql_num_rows($result);
	
	$_SESSION['noItem'] = $countItem;
	
	if(mysql_num_rows($result)>0){
		
			while($rows = mysql_fetch_row($result)){			
				$orderID = $rows[0];
				$detail[$row]['productID']=$rows[1];
				$detail[$row]['date_in']=$rows[2];
				$detail[$row]['qty']=$rows[3];
				$detail[$row]['color']=$rows[4];
				
				$row++;
			}
	}

	$grandTotal= array();
	$total=0;

	for($i=0;$i<$row;$i++){
		// get products detail
		$query = "SELECT productName,unitPrice,ProductWeight
				  FROM products
				  WHERE productID='".$detail[$i]['productID']."'";
				  
		$result = mysql_query($query);
		while($rows = mysql_fetch_row($result)){	
			$prodName[$i] = $rows[0];
			$discount=product::getDiscount($detail[$i]['productID']);
			$weight[$i] = $rows[2];
			$price[$i] = number_format($rows[1]*(100-$discount)/100,2);
			$grandTotal[$i] = $price[$i]*$detail[$i]['qty'];
			$total += $grandTotal[$i];
		}
		
		//get img url, i had edit the url in database, where this testing productid are 2 and 8
		$qryImg = "SELECT pic_url
				   FROM product_pic
				   WHERE productID='".$detail[$i]['productID']."'";
				   
		$result = mysql_query($qryImg);
		
		while($rows = mysql_fetch_row($result)){
			$picurl[$i]=$rows[0];
		}
	}
	$ordID=mysql_real_escape_string(cart::getOrderId());
	$getShippingPrice=mysql_query("Select shippingPrice From orders where OrderID='$ordID'");
	if($rowShip=mysql_fetch_row($getShippingPrice)){
		$shipFee=$rowShip[0];
	}

	$TotalPrice = $shipFee+$total;

	$qryUser = "SELECT userName,email
			   FROM members
			   WHERE memberID='$id'";
			   
	$result = mysql_query($qryUser);

	while($row = mysql_fetch_row($result)){
		$userName = $row[0];
		$email = $row[1];
	}

	$query = "SELECT a.address, a.city, a.postcode, a.region
			FROM address a
			WHERE a.addressID = ( 
			SELECT addressID
			FROM orders
			WHERE orderID = '$orderID' )";

	$result = mysql_query($query);

	while($row = mysql_fetch_row($result)){
		$address = $row[0];
		$city = $row[1];
		$postcode = $row[2];
		$region = $row[3];
	}
	$_SESSION['orderID']=$orderID; // Here is the orderID
	
	//Write into txt
	$orderDet = '';
	
	for($i=0;$i<$countItem;$i++){
		//write in for store in file
		$orderDet .= $detail[$i]['productID'].",".$prodName[$i].",".$detail[$row]['color'].",".$detail[$i]['qty'].",".$price[$i]."<br/>\n";
		
		
		//$querystring .= "quantity_".($i+1)."=".$detail[$i]['qty']."&";
	}
	
	require_once('../Ordering module/writeAndReadFile.php');
	
	writeFile($orderID,$orderDet);
	
?>

<style>
	table .product{
		border-collapse: separate;
		border-spacing: 2px;
		border-color: gray;
	}

</style>

<div class="row">
	<h3>Order Details Summary</h3>
	<div class="large-12 columns">
		
    	<table class="large-12 large-centered columns">
  <thead>
    <tr>
      <th width="39%">Item(s)</th>
      <th width="38%">Delivery Time</th>
      <th width="8%">Quantity</th>
      <th style="text-align:center" width="15%">Item Price</th>
    </tr>
  </thead>
  <tbody>  
<?php for($i=0;$i<$countItem;$i++){ ?>
    <tr> 
      <td>
            <table width="100%" height="10px" class="product">
            <tr>
            	<td rowspan="4">
                	<img width="98px" src="../product/<?php echo $picurl[$i]; ?>"/>
                </td>
                <td>
                	<table width="100%">
	                	<tr>
	                       <td>Name</td>
	                       <td style="text-align:center"> <?php echo "<b>" . $prodName[$i]. "</b>"; ?>
	                       	</td>
	                    </tr>
						
						<tr>
	                       <td>Name</td>
	                       <td style="text-align:center"> <?php echo "<b>" . $weight[$i]. "</b>"; ?>
	                       	</td>
	                    </tr>
						
	                	<tr>
	                       <td>Color</td>
	                       <td align="middle" style="text-align:center"> <?php echo "<div style='background-color:" . $detail[$i]['color'] . ";width:20px;height:20px'></div>"; ?>
	                       	</td>
						</tr>
						<tr>
							<td>Price</td>
							<td style="text-align:center"><?php echo number_format((float)$price[$i],2); ?></td>
						</tr>
					</table>
				</td>
			</tr>

			</table>
</td>
<td><label>3 Business Days (4 Days For East Malaysia)</label></td>
<td style="border-right: solid 1px silver"><?php echo $detail[$i]['qty']; ?></td>
<td style="text-align: center;"><?php echo "RM ".$grandTotal[$i]; ?></td> 
</tr>

<?php } ?>
	<tr>
		<td colspan="2">
		<div>
			<tr>
				<td colspan="3" style="text-align:right">Shipping Price :</td>
				<td style="text-align:center"><?php echo "<h5>RM ".$shipFee."</h5>"; ?></td>
			</tr>
			
			<tr>
				<td colspan="3" style="text-align:right">Sub Total :</td>
				<td style="text-align:center"><?php echo "<h5>RM ".number_format((float)$total,2)."</h5>"; ?></td>
			</tr>
			
			<tr>
				<td >
				<h3><u>Ship to Address</u></h3>
				<label>Address : <b><?php echo $address; ?></b></label>
				<label>City : <b><?php echo $city; ?></b></label>
				<label>Region : <b><?php echo $region; ?></b></label>
				<label>PostCode :<b> <?php echo $postcode; ?></b></label>
				</td>
				<td colspan="2" style="text-align:right">Grand Total  :</td>
				<td style="text-align:center"><?php echo "<h5>RM " .number_format((float)$TotalPrice,2) . "</h5>"; ?></td>
			</tr>
		</div>
		</td>
	</tr>

</tbody>
<tfoot>
<tr><br/>
<td colspan="4">

<!-- Pass detail to paypal -->

<div class="small-3 push-9 columns">
<form class="custom paypal" method="post" <?php echo "action='orderdetails.php?NoOfItem=$countItem"; ?> id="paypal_form" target="_blank"'>
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="lc" value="MY" />
<input type="hidden" name="currency_code" value="MYR" />
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
<input type="hidden" name="item_name" value="Purchase date : <?php echo date('Y-m-d'); ?>" />
<input type="hidden" name="last_name" value="<?php echo $userName; ?>"  />
<input type="hidden" name="payer_email" value="<?php echo $email; ?>"  />
<input type="hidden" name="amount" value="<?php echo number_format((float)($TotalPrice-$shipFee),2); ?>" />
<input type='hidden' name='item_number' value='<?php echo $_SESSION['orderID']; ?>'/>
<input type='hidden' name='shipping' value='<?php echo $shipFee; ?>'/>


<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" name="checkOut" role="button" aria-disabled="false">
<span class="ui-button-text">Check Out</span>
</button>
</form>
</div>

</td>
</tr>
</tfoot>
</table>

</div>
</div>
<?php
include '../Main/footer.php';
}else{
$countItem = $_GET['NoOfItem'];

// PayPal settings
$paypal_email = 'lengzuo01@gmail.com';
$return_url = 'http://localhost/km_lz_combined/New%20folder/Ordering%20module/payment-successful.php';
$cancel_url = 'http://example.com/payment-cancelled.htm';
$notify_url = 'http://example.com/paypal/payments.php';

// Include Functions
include("functions.php");

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
	$querystring='';
// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";	
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	// ONE ITEM ONLY
	
	//Multiple item format
	$querystring .= "item_name=".urlencode(date('Y-m-d'))."&";
	//$querystring .= "amount=".urlencode($totalPrice)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	//die($querystring);
	// Redirect to paypal IPN
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();
}

}
}
?>

