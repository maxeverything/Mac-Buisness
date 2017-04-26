<?php
	session_start();
	if(!isset($_SESSION['color']) && empty($_SESSION['color'])){
		$_SESSION['color'] = array();
		}
	if(!isset($_SESSION['pro_pic']) && empty($_SESSION['pro_pic'])){
		$_SESSION['pro_pic'] = array();
		}
	include('../sql/config.php');
	include '../sql/opendb.php';
	
	class Color{
		public $color;
		public $color_qty;
		
		
		public function __construct($color,$color_qty){
			$this->color=$color;
			$this->color_qty=$color_qty;
		}
	}
	
	
	if(isset($_REQUEST['f'])) {		
		$functionName=$_REQUEST['f'];
		if(isset($_REQUEST['productColor'])){
			$col=$_REQUEST['productColor'];
		}
		
		if(isset($_REQUEST['product_Quantity'])){
			$qty=$_REQUEST['product_Quantity'];
		}
		
		switch ($functionName){
			case 1 ://add Color
				$valid=true;
				
				if(count($_SESSION['color'])>0){					
					for($i=0;$i< count($_SESSION['color']);$i++){
						if($_SESSION['color'][$i]->color == $col){
							$valid=false;
						}
					}
				}
						
				if($valid==true){
						array_push($_SESSION['color'],new Color($col,$qty));
						return 'ok';
					}
					else{
						return print_r($_SESSION['color']);
					}
					//	print_r($_SESSION['color']);	
								
				break;
			case 2://Save Product to database
				$productName=mysql_real_escape_string($_REQUEST['productName']);				
				$productDescription=mysql_real_escape_string($_REQUEST['productDescription']);
				$productPrice=mysql_real_escape_string($_REQUEST['productPrice']);
				$shopID=mysql_real_escape_string($_SESSION['shopID']);
				$product_point=mysql_real_escape_string($_REQUEST['product_point']);
				$ProductWeight=mysql_real_escape_string($_REQUEST['ProductWeight']);
				$_SESSION['category']=$_REQUEST['CategoryID'];
				$CategoryID=mysql_real_escape_string($_SESSION['category']);
				mysql_query("INSERT INTO Products (shopId, ProductName, description, CategoryID, UnitPrice, UnitsOnOrder, product_point, ProductWeight, Product_date) VALUES ('$shopID', '$productName', '$productDescription', '$CategoryID', '$productPrice', 0, '$product_point','$ProductWeight', Now())
") or die(mysql_error());
				$_SESSION['productID']=mysql_insert_id();
				break;
			case 3://remove color
				for($i=0;$i< count($_SESSION['color']);$i++){
					if($_SESSION['color'][$i]->color==$col){
						unset($_SESSION['color'][$i]);
						$_SESSION['color'] = array_values($_SESSION['color']);
					}
				}
				break;
			case 4://
				print_r($_SESSION['color']);
				break;
			case 5://clear color
				unset($_SESSION['color']);
				break;
			case 6://insert color to database
				$productID=mysql_real_escape_string($_SESSION['productID']);
				if(count($_SESSION['color'])>0){
				foreach($_SESSION['color'] as $row){
					$color=mysql_real_escape_string($row->color);
					$qty=mysql_real_escape_string($row->color_qty);					
					mysql_query("insert into product_color (productID, qty, color) values('$productID', '$qty', '$color')")or die('Error');
				}
				unset($_SESSION['color']);
				}else{
					return 'At least 1 color be add';
				}
				break;
			case 7:				
				$id=mysql_real_escape_string($_REQUEST['imageID']);
				$queryPicUrl=mysql_query("select pic_url from product_pic where product_picId='$id'");
				if($PicUrl=mysql_fetch_assoc($queryPicUrl)){
					mysql_query("Delete from product_pic where product_picId='$id'");
					unlink($PicUrl['pic_url']);
				}else{
					return 'Unable to delete';
				}
				break;
				
			}
			
			
		}
		//print_r($_SESSION['color']);
	
?>