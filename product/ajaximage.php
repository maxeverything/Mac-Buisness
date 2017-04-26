<?php
include ('../sql/config.php');
include ('../sql/opendb.php');
$path = "images/";

$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
	$name = $_FILES['photoimg']['name'];
	$size = $_FILES['photoimg']['size'];
	$temp = explode(".", $_FILES["photoimg"]["name"]);
	$extension = end($temp);
	if (strlen($name)) {
		if (!is_dir($path)) {
			mkdir($path);
		}
		if (in_array($extension, $valid_formats)) {
			if ($size < (1024 * 1024)) {
				$actual_image_name = time() . substr(str_replace(" ", "_", 'Img'), 5) . "." . $extension;
				$tmp = $_FILES['photoimg']['tmp_name'];
				if (move_uploaded_file($tmp, $path . $actual_image_name)) {
					if(isset($_REQUEST['productid'])){
						$productID= mysql_real_escape_string($_REQUEST['productid']);		
						$filepath= mysql_real_escape_string($path.$actual_image_name);
					 	mysql_query("Insert into product_pic (productID,pic_url) VALUES ('$productID','$filepath')");				
					}					 

					$display = '<div class="row">';
					$display .= '<div class="small-12 large-12 columns">';
					$display .= '<div class="small-4 large-4 columns" id="divImg">';
					if(isset($_REQUEST['productid'])){
						$display .= "<img id='lblImage' src='" . $path . $actual_image_name . "' title='".mysql_insert_id()."'  class='preview'>";
					}else{
						$display .= "<img id='lblImage' src='" . $path . $actual_image_name . "' title=''  class='preview'>";
					}
					$display .= '</div>';
					$display .= '<div class="small-2 large-2  columns">';
					$display .= '<a id="btnDelete" class="btnDelete" href=" ">&#215;</a></div></div></div>';
					echo $display;
				} else
					echo "Fail upload folder with read access.";
			} else
				echo "Image file size max 1 MB";
		} else
			echo "Invalid file format..";
	} else
		echo "Please select image..!";

	exit ;
}
?>