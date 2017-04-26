<?php
include '../Sql/opendb.php';
if (isset($_REQUEST['deleteNewImage'])) {
	if(file_exists($_REQUEST['image'])){
		unlink($_REQUEST['image']);
	}
}

if (isset($_REQUEST['deleteImageDatabase'])) {
	$id = mysql_real_escape_string($_REQUEST['imageID']);
	$queryPicUrl = mysql_query("select pic_url from product_pic where product_picId='$id'")or die(mysql_error());
	if ($queryPicUrl){
		$PicUrl=mysql_fetch_array($queryPicUrl, MYSQL_ASSOC);
		mysql_query("Delete from product_pic where product_picId='$id'");
		if(file_exists($PicUrl['pic_url'])){
			unlink($PicUrl['pic_url']);
		}
		echo json_encode(array("status" => "1"));		
	} else {
		echo json_encode(array("status" => "0"));
	}	
}
?>