<?php
	
	include '../sql/config.php';
	include '../sql/opendb.php';

	class user_profile{
		public static function getMember(){
			if (isset($_SESSION['id'])){
		 		$memberID=mysql_real_escape_string($_SESSION['id']);
				$query_User= mysql_query("Select * From members where memberID='$memberID'")or die('Error, query failed');			
			}
			return mysql_fetch_array($query_User);
		}
		
		public static function getMemberDetail($in_id){
		 	$id=mysql_real_escape_string($in_id);
			if($in_id[0]=="M"){
				$query_User= mysql_query("Select 'Member' as type, userName as name, email, contact, Profile_pic From members where memberID='$id'")or die('Error, query failed');	
			}elseif($in_id[0]=="S"){
				$query_User= mysql_query("Select 'Staff' as type, staffName as name, email, contact, 'profilePic/default.jpg' as Profile_pic From staffs where staffID='$id'")or die('Error, query failed');
			}else{
				$query_User= mysql_query("Select 'Seller' as type, sellerName as name, email, contact, 'profilePic/default.jpg' as Profile_pic From sellers where sellerID='$id'")or die('Error, query failed');
			}				
			return mysql_fetch_array($query_User);
		}
		
		public static function getContact($in_contact){
			return substr_replace($in_contact ,'XXXXXXXX', 3 , strlen($in_contact)-5);
		}
		
		public static function getEmail($in_id){
			$memberID=mysql_real_escape_string($in_id);
			$query_User= mysql_query("Select email From members where memberID='$memberID'")or die('Error, query failed');
			$row=mysql_fetch_array($query_User);
			return $row['email'];
		}
		public static function getGender($in_gender){
			if($in_gender=='M'){
				return 'Male';
			}
			else{
				return 'Female';
			}
		}
		
		public static function getAddress(){
			
			if (isset($_SESSION['id'])){
				$whoseAddress=mysql_real_escape_string($_SESSION['id']);
			}elseif(isset($_SESSION['sellerID'])){
				$whoseAddress=mysql_real_escape_string($_SESSION['sellerID']);
			}else{
				$whoseAddress=mysql_real_escape_string($_SESSION['staffID']);
			}
			$query_addr=mysql_query("Select * from address WHERE whoseAddress='$whoseAddress'") or die ('Error, query failed');		
			return $query_addr;
		}
		
		public static function getSingleAddress($in_addr){
			$addressID=mysql_real_escape_string($in_addr);
			$query=mysql_query("Select * from address where addressID=$addressID")or die ('Error, query failed');
			return mysql_fetch_array($query);
		}
		
		public static function getOrderHistory(){
			if (isset($_SESSION['id'])){
				$memberID=mysql_real_escape_string($_SESSION['id']);
			}
			$query_OrdersHistory=mysql_query("Select o.*, d.total 
			from orders o, ( Select OrderID, sum(amount) as total
							From Order_Det 
							Group by OrderID) d 
			where o.OrderID=d.OrderID AND 
			memberID='$memberID'");
			return $query_OrdersHistory;		
		}
		
		public static function getOrderDetail($in_orderid) {
		//if (!empty($_SESSION['id'])) {
			$OrderID = mysql_real_escape_string($in_orderid);
			$result = mysql_query("select d.*, p.ProductName, p.description, p.UnitPrice, p.ProductWeight,pc.pic_url
			from Order_Det d, products p, product_pic pc
			where pc.productID = p.productID AND d.OrderID='$OrderID' AND 
			d.productID=p.ProductID") or die('Error, ' . mysql_error());
			return $result;
		//}
	}
	}

?>