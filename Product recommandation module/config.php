<?php
include_once("inc/facebook.php"); //include facebook SDK
######### edit details ##########
$appId = '435498849892371'; //Facebook App ID
$appSecret = '54739f980c7e6dde5af54320debcbb43'; // Facebook App Secret
$return_url = 'http://localhost/km_lz_combined/FB/process.php';  //return url (url to script)
$homeurl = 'http://localhost/km_lz_combined/CMS/product/FB/shareToFB.php';  //return to home
$fbPermissions = 'publish_stream,user_photos';  //Required facebook permissions
##################################

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret,
  'fileUpload' => true,
  'cookie' => true

));
$fbuser = $facebook->getUser();
?>