<?php
include ('../sql/config.php');
include '../sql/opendb.php';
class product {
	public static function newID($row){
		$newID ="";
		
			for($i=0;$i<strlen($row);$i++){
				if((!is_numeric($row[$i]))|| ($row[$i]==0)){
					$newID .= $row[$i];
				}
				else{
					
					if($row[strlen($row)-1]==9 ){
						$ID_no = (int)substr($row,$i,(strlen($row)-$i));
						$newID = substr($newID,0,$i-1).($ID_no+1);
					}else{
						$ID_no = (int)substr($row,$i,(strlen($row)-$i));
						$newID.= (int)($ID_no)+1;
					}
					break;
				}
		}
		return $newID;
	}
	public static function getDate() {
		$month;
		$year;
		if (date('m') == 1) {
			$month = 12;
			$year = date('Y') - 1;
		} else {
			$month = date('m') - 1;
			$year = date('Y');
		}
		return date("Y-m-d", mktime(0, 0, 0, $month, date('d'), $year));
	}

	public static function getProductColor($in_productID) {
		$productID = mysql_real_escape_string($in_productID);
		$query = mysql_query("Select * from product_color WHERE productID=$productID ") or die('Error, query failed');
		return $query;
	}

	public static function getShipper() {
		$query = mysql_query("Select * from shippers") or die('Error, query failed');
		return $query;
	}

	public static function getCategory() {
		$query = mysql_query("Select categoryID, categoryName from categories") or die('Error, query failed');
		return $query;
	}

	public static function getShop() {
		$query = mysql_query("Select shopID, shopname from shops") or die('Error, query failed');
		return $query;
	}

	public static function setQueryString($strQuery, $typeQuery, $valQuery) {
		if (!empty($strQuery)) {
			$strQuery.='&';
		}
		$strQuery.=$typeQuery.'='.$valQuery;
		return $strQuery;
	}
	
	public static function getItemByShop($shopID)
	{
		$query = mysql_query("Select * from products where shopID='$shopID'") or die('Error, query failed');
		return $query;
	}
	
	public static function getAllItem()
	{
		$query = mysql_query("Select * from products") or die('Error, query failed');
		return $query;
	}
	
	public static function getDiscount($pro_id){
		$id=mysql_real_escape_string($pro_id);
		$query=mysql_query("select pp.discount 
					from promotion_product pp, promotions pro 
					WHERE pp.promotionID=pro.promotionID AND
					NOw() between pro.dateFrom and pro.dateTo AND
					pp.productID='$id'");
		if($row=mysql_fetch_array($query,MYSQL_ASSOC)){
			return $row['discount'];
		}else{
			return 0;
		}
	}
	
	public static function getPerDiscount($pro_id,$in_date){
		$id=mysql_real_escape_string($pro_id);
		$date=mysql_real_escape_string($in_date);
		$query=mysql_query("select pp.discount 
					from promotion_product pp, promotions pro 
					WHERE pp.promotionID=pro.promotionID AND
					'$date' between pro.dateFrom and pro.dateTo AND
					pp.productID='$id'");
		if($row=mysql_fetch_array($query,MYSQL_ASSOC)){
			return $row['discount'];
		}else{
			return 0;
		}
	}
	
	public static function getProduct($in_pro){
		$id=mysql_real_escape_string($in_pro);
		$query=mysql_query("Select * from products where ProductID='$id'");
		$result=mysql_fetch_array($query,MYSQL_ASSOC);
		return $result;
	}
	
	public static function getPromotionTitle($in_pro){
		$id=mysql_real_escape_string($in_pro);
		$query=mysql_query("Select promotiontitle from promotions where promotionID='$id'");
		$result=mysql_fetch_array($query,MYSQL_ASSOC);
		return $result['promotiontitle'];
	}

}
?>