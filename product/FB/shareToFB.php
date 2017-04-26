<?php
include_once("config.php");
$proID = $_SESSION['pro_id'];
if (isset($_GET['pic_url'])) {
	$pic_url = $_GET['pic_url'];
}else{
	header("Location: ../../product/OrderProduct.php?product=$proID");
}

//destroy facebook session if user clicks reset
if(isset($_GET["reset"]) && $_GET["reset"]==1)
{
	$facebook->destroySession();
	header("Location: ".$homeurl);
}

if(!$fbuser)
{
		$fbuser = null;
		$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
		echo '<a href="'.$loginUrl.'"><img src="images/facebook-login.png"></a>'; 
		//header("Location : '$loginUrl'");
		
}else{
	$file = 'C:\xampp\htdocs\km_lz_combined\New folder\product';
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Post Photos to User Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="fbpagewrapper">
<div id="fbpageform" class="pageform">
<form action="process.php" method="post" enctype="multipart/form-data" name="form" id="form">
<h1>Post Photos to User Profile</h1>
<p> The image will be posted on your profile wall! <a href="?reset=1">Reset User Session</a>.</p>
<label>Image
<span class="small">This image will post to your Facebook wall</span>
</label>
<img src="<?php echo '../'.$pic_url; ?>" style="width:180px;height: 140px;border: black solid 3px;margin-left: 13px;" />
<br/>
<input type="hidden" name="pictureFile" id="pictureFile"  value="<?php echo $file.'/'.$pic_url ?>" />

<label>Message
<span class="small">Write something to post!</span>
</label>
<textarea name="message"></textarea>
<button type="submit" class="button" id="submit_button">Post Picture</button>
</form>
</div>
</div>

</body>
</html>
<?php
}
?>

 
		

