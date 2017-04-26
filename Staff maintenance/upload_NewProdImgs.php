<?php
session_start();
$id = $_SESSION['id'];
$now = date("Y-m-d h:i:s");

require_once('../sql/opendb.php');


if(isset($_POST['submit_prdList'])){
	if(!empty($_POST['product_list'])){
		foreach($_POST['product_list'] as $productID) {
			$query = "INSERT INTO home_newprodimgs (ProductID,editer,editDate)
			  VALUES ('$productID','$id','$now')";
			  			 
			$result=mysql_query($query)or die('sql error '.mysql_error());

		}
	}			
?>
<script>
	window.onload = function() {
 		window.location.replace("../Home/homepage.php");
    	alert(" Upload New Products Picture success :) ");
	}
</script>	
<?php
}


/*
$IMG = isset($_FILES['proimg']) ? $_FILES['proimg'] : array();
$desc = isset($_POST['desc']) ? $_POST['desc'] : array();
if (!empty($IMG) && !empty($desc)) {
    $uploads_dir = '../images/HomePic/NewProdImgs';
    foreach ($IMG["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK && $IMG["size"][$key]<500000) {
            $tmp_name = $IMG["tmp_name"][$key];
            $name = $IMG["name"][$key];
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            $name_array=mysql_real_escape_string($name);
            $value_insert[] = "'" . $name_array . "'";
        }else{
			$errormsg = 'this File '.$IMG["name"][$key].' is more than 500kb. Make sure each of your file size is less than 500kb /'.$IMG["error"][$key];
			
?>
		
<script src="js/script.js"></script>
<script>
	window.onload = function() {
 		window.location.replace("../Staff maintenance/HomeEdit_NewProductImg.php");
    	alert( "<?php echo $errormsg ?>");
	}
</script>	

<?php
		}
    }
	
	for($i=0;$i<3;$i++){
		$description[] = "'$desc[$i]'";
	}
	
    $values_insert = implode(',', $value_insert);
	$description = implode(",",$description);
	
	require_once('../sql/opendb.php');
	
	$query = "INSERT INTO home_newprodimgs (newProduct1,newProduct2,newProduct3,desc1,desc2,desc3,editer,editDate)
			  VALUES (".$values_insert.",".$description.",'$id','$time')";
    $result = mysql_query($query)or die('Upload Image to Database fail, '.mysql_error());
?>
<script src="js/script.js"></script>
<script>
	window.onload = function() {
 		window.location.replace("../Home/homepage.php");
    	alert(" Upload New Products Picture success :) ");
	}
</script>	
<?php
}else{
 echo 'empty array';
}
?>
*/
?>



