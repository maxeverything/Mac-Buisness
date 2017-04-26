<?php
session_start();
$id = $_SESSION['id'];
$time = date("Y-m-d");

$IMG = isset($_FILES['slideimg']) ? $_FILES['slideimg'] : array();
if (!empty($IMG)) {
	$size='';
    $uploads_dir = '../images/SlideImgs';
    foreach ($IMG["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK && $IMG["size"][$key]<500000) {
            $tmp_name = $IMG["tmp_name"][$key];
            $name = $IMG["name"][$key];
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            $name_array=mysql_real_escape_string($name);
            $value_insert[] = "('" . $name_array . "')";
			$a='succcess';
        }
		else{
			$errormsg = 'this File '.$IMG["name"][$key].' is more than 500kb. Make sure each of your file size is less than 500kb /'.$IMG["error"][$key];
			
?>
			
<script src="js/script.js"></script>
<script>
	window.onload = function() {
 		window.location.replace("../Staff maintenance/HomeEdit_SlideImage.php");
    	alert( "<?php echo $errormsg ?>");
	}
</script>	

<?php
		}
    }
	
    $values_insert = implode(',', $value_insert);
	
	require_once('../sql/opendb.php');
	
	$query = "INSERT INTO home_slideimg (slideshowImage1,slideshowImage2,slideshowImage3,slideshowImage4,editer,editDate)
			  VALUES (".$values_insert.",'$id','$time')";
    $result = mysql_query($query)or die('Upload Image to Database fail, '.mysql_error());
?>
<script src="js/script.js"></script>
<script>
	window.onload = function() {
 		window.location.replace("../Home/homepage.php");
    	alert(" Upload Slide Picture success :) ");
	}
</script>
<?php
}else{
 echo 'empty array';
}
?>