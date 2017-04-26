<?php
session_start();
$id=mysql_real_escape_string($_SESSION['id']);

				$queryPicUrl=mysql_query("select profile_pic from members where memberID='$id'");
				if($PicUrl=mysql_fetch_assoc($queryPicUrl)){
					$query = "UPDATE members 
					 		   SET Profile_pic='default.jpg'
							   WHERE memberID='$id'";
							   
					mysql_query("Delete from product_pic where product_picId='$id'");
					unlink($PicUrl['pic_url']);
				}else{
					return "<h1>$id</h1>";
				}
?>