
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload and Post to Facebook user wall using PHP</title><script type="text/javascript" src="http://www.saaraan.com/wp-content/themes/san/js/jquery-1.9.0.min.js"></script><link href="style.css" rel="stylesheet" type="text/css" /><link href="http://www.saaraan.com/wp-content/themes/san/css/layout.css" rel="stylesheet" type="text/css" />

<style>
.nonav{
border-right:none!important;min-width:0;
}
</style>
 <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-651636-11']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

</head>
<body>
<!-- BuySellAds Ad Code -->
<script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>
<!-- End BuySellAds Ad Code -->

<div class="demo-header-bar">
<div class="onepcssgrid-1100">
    <div class="onerow">
        <div class="col12">
            <div class="header-texts">
            <!-- navigation -->
			<nav class="demo-nav clearfix"> 
            
<ul id="menu-top-navigation" class="nav">
<li>
<span class="logo">
<a href="http://www.saaraan.com/"><img src="http://www.saaraan.com/wp-content/themes/san/images/logo.png" title="Saaraan Homepage" border="0"></a></span>
</li>
<li>
<a href="http://www.saaraan.com/2012/02/post-picture-to-facebook-user-wall-php" title="Visit Tutorial Page">Visit Tutorial</a></li>
<li style="float:right;margin-top:10px;">
    <!-- AddThis Follow BEGIN -->
    <div style="width:80px;">
    <div class="addthis_toolbox addthis_16x16_style addthis_default_style">
    <a class="addthis_button_twitter_follow nonav" addthis:userid="saaraan"></a>
    <a class="addthis_button_google_follow nonav" addthis:userid="114294210195147580398"></a>
    <a class="addthis_button_facebook_follow nonav" addthis:userid="saarraan"></a>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=saaraan"></script>
	</div>
    <!-- AddThis Follow END -->
</li>
</ul>     
<div style="clear:both"></div><a href="http://www.saaraan.com" id="pull">Saaraan.com</a>  
</nav>
<!-- end navigation -->
</div>
</div>
</div>
</div>
<div style="clear:both"></div>
</div>


<div class="onepcssgrid-1100">
<div class="onerow content-wrap">
<div class="col8 main-content">
        <!-- ad -->
        <div class="main-item demo-top-ad">
			<script type="text/javascript">
            google_ad_client = "ca-pub-0052126645916042";
            google_ad_slot = "4332477367";
            google_ad_width = 468;
            google_ad_height = 60;
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>
        <!-- ad end -->
<div class="fbpagewrapper">
<div id="fbpageform" class="pageform">
<form action="process.php" method="post" enctype="multipart/form-data" name="form" id="form">
<h1>Post Photos to User Profile</h1>
<p> The image will be posted on your profile wall! <a href="?reset=1">Reset User Session</a>.</p>
<label>Pages
<span class="small">Select a Page</span>
</label>
<input type="file" name="pictureFile" id="pictureFile">
<label>Message
<span class="small">Write something to post!</span>
</label>
<textarea name="message"></textarea>
<button type="submit" class="button" id="submit_button">Post Picture</button>
<div class="spacer"></div>
</form>
</div>
</div>

<!-- ad -->
<div class="main-item demo-bottom-ad" align="center">
<script type="text/javascript">
google_ad_client = "ca-pub-0052126645916042";
google_ad_slot = "4332477367";
google_ad_width = 468;
google_ad_height = 60;
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<!-- ad end -->
</div>
 
<div class="col4 sidebar last">
    <div class="sidebar-pad demo-sidebar">  
        
       <!-- BuySellAds Zone Code -->
        <div id="bsap_1289305" class="bsarocks bsap_3246a2e15c6824a11558262db4409e23"></div>
        <!-- End BuySellAds Zone Code -->

    </div>

</div>
</div>
</div>


</body>
</html>