<?php
include '../sql/config.php';
include '../sql/opendb.php';
class feedback {
	public static function getFeedback($in_productID) {
		$productID = mysql_real_escape_string($in_productID);
		$query = mysql_query("Select f.*,
		CASE WHEN (f.feedbackBy like 'M%') 
		THEN (Select userName 
			from members 
			where memberID=f.feedbackBy) 
		WHEN (f.feedbackBy like 'S%') 
		THEN (Select staffName 
			from staffs 
			where staffID=f.feedbackBy) 
		ELSE (select sellerName 
			from sellers 
			where sellerID=f.feedbackBy) 
		END AS Name, 
		CASE WHEN (f.feedbackBy like 'M%') 
		THEN 'Member' WHEN (f.feedbackBy like 'S%') 
		THEN 'Staff' ELSE 'Seller' 
		END AS feedbackType,
		CASE WHEN (f.feedbackBy like 'M%') 
		THEN (Select Profile_pic
			from members 
			where memberID=f.feedbackBy) 
		WHEN (f.feedbackBy like 'S%') 
		THEN 'profilePic/default.jpg'
		ELSE '/profilePic/default.jpg'
		END AS Profile_pic
		from feedback f
		where productID='$productID' 
		order by feedbackDateTime desc ") or die('Error, query failed'.mysql_error());
		return $query;
	}
	public static function getPersonalFeedback($in_ID) {
		$feedbackArray = array();
		$ID = mysql_real_escape_string($in_ID);
		$query = mysql_query("Select f.ProductID, f.feedbackDateTime, p.ProductName, f.feedbackID from feedback f, Products p where f.feedbackBy='$ID' AND f.ProductID=p.ProductID order by feedbackDateTime ASC ") or die(mysql_error());
		while($row_feedback=mysql_fetch_array($query,MYSQL_ASSOC)){
			$feedbackArray[$row_feedback['ProductID']]=array($row_feedback['feedbackDateTime']=>$row_feedback['ProductName']);
			}
		return $feedbackArray;
	}
}
?>