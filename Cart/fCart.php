<?php
include '../sql/config.php';
include '../sql/opendb.php';
class cart {
	public static function getCartItem() {
		//c.cart_type
		if (!empty($_SESSION['id'])) {
			$OrderID = mysql_real_escape_string(cart::getOrderId());
			$result_cart = mysql_query("select c.OrderID, c.productID, c.Quantity*p.UnitPrice as subTotal, c.Quantity, c.color, p.ProductName, p.description, p.UnitPrice, p.product_point, p.ProductWeight 
			FROM product_cart c,products p 
			where c.OrderID='$OrderID' AND
			p.productID=c.productID") or die('Error, ' . mysql_error());
			return $result_cart;
		}
	}

	public static function getMainPicture($in_proID) {
		$productID = mysql_real_escape_string($in_proID);
		$query_MainPic = "Select pic_url from product_pic where ProductID=
$productID LIMIT 0,1 ";

		$result_MainPic = mysql_query($query_MainPic) or die('Error, ' . mysql_error());
		$row_MainPic = mysql_fetch_array($result_MainPic, MYSQL_ASSOC);
		return $row_MainPic;
	}
	
	public static function checkHaveCartItem($in_proID){
		$productID = mysql_real_escape_string($in_proID);
		$orderID=mysql_real_escape_string(cart::getOrderId());
		$result=mysql_query("Select productID from product_cart where productID='$productID' AND OrderID='$orderID'");
		if(mysql_num_rows($result)>0){
			return TRUE;
		}else{
			return false;
		}
	}
	
	public static function getOrderId(){
		$member=mysql_real_escape_string($_SESSION['id']);
		$query=mysql_query("Select OrderID from orders
			where OrderDate IS NULL AND
			memberID='$member'")or die('ERROR'.mysql_error());
		if(mysql_num_rows($query)>0){
			$row=mysql_fetch_array($query,MYSQL_ASSOC);
			return $row['OrderID'];			
		}else{
			mysql_query("INSERT INTO Orders (memberID) VALUES ('$member')")or die('ERROR'.mysql_error());
			return mysql_insert_id();
		}
	}
	
	public static function getTotalWeight($in_orderID){
		$orderID=mysql_real_escape_string($in_orderID);
		$result=mysql_query("Select c.OrderID, sum(p.ProductWeight*c.Quantity) as totalWeight
			from Products p, product_Cart c
			WHERE c.OrderID='$orderID' AND
			p.productID=c.productID
			GROUP BY c.OrderID")or die(mysql_error());
		if(mysql_num_rows($result)>0){
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
			$weight=$row['totalWeight']/1000;
			if($weight>round($weight)){
				$weight=$weight+1;
			}
			return round($weight);			
		}
	}
	
	public static function getCartOrder($in_orderID){
		$orderID=mysql_real_escape_string($in_orderID);
		$result=mysql_query("Select * from orders where OrderID='$orderID'");
		$row_Orders = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row_Orders;
	}

}


?>