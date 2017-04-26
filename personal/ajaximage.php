<?php
include ('../sql/config.php');
include ('../sql/opendb.php');
session_start();
$path = "profilePic/";

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
					
					$id= mysql_real_escape_string($_SESSION['id']);
					$selectPic=mysql_query("SELECT Profile_pic 
											from  members
											where memberID='$id'");
					$rowPic=mysql_fetch_array($selectPic);
					if($rowPic['Profile_pic']!='profilePic/default.jpg'){
						if(file_exists($rowPic['Profile_pic'])){
							unlink($rowPic['Profile_pic']);
						}
					}
					$filepath= mysql_real_escape_string($path.$actual_image_name);					 
					$query = "UPDATE members 
					 		   SET Profile_pic='$filepath'
							   WHERE memberID='$id'";
							   
					 mysql_query($query)or die('my sql Error '.mysql_error());

					$display = '<div class="row">';
					$display .= '<div class="small-12 large-12 columns">';
					$display .= '<div class="small-4 large-4  columns" id="divImg">';
					$display .= "<img id='lblImage' src='" . $path . $actual_image_name . "' title=''  class='preview'>";
					$display .= '</div>';
					$display .= '<div class="small-2 large-2  columns">';
					$display .= '<a id="btnDelete" href=" ">Click</a></div></div></div>';
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