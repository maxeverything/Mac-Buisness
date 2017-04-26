<script>
$(document).ready(function() {
    var leftHeight = $('.left').height();
    $('.right').css({'height':leftHeight});
});
</script>
<link href="loginpage.css" type="text/css" rel="stylesheet"/>

<?php include '../Main/header.php';?>
<br/>
<tr><td colspan="17">
<div class="row">
<div class="small-12 small-12 columns">
	<div id="content" class=" small-12 large-6 columns left">
		<form class="custom" action="login.php" method="POST" data-abide>
			<h1>Sign in</h1>
			<?php
			if(isset($_GET['notify']))
			{
				echo '<h2>'.$_GET['notify'].'</h2>';
			}
			?>			
			<div>
				<input type="text" placeholder="Username" required id="user_email" name="user_email" />
			</div>
			<div>
				<input type="password" placeholder="Password" required id="user_pass" name="user_pass"/>
                <a href="../password/password_recovery.php">Forgot your password?</a>
			</div>
			<div>
            
				<input type="submit" name="login" value="Log in" />
          </div>
          </form>      			
	</div><!-- content -->
    
    <div id="content" class=" small-12 large-6 columns right">
		<form action="../CRM module/member_reg.php" method="POST">
			<h1>New Member?</h1>
				<input type="submit" name="register" value="Register" />
		</form>
	</div>
    </div>   
</div>
</td>
</tr>

<?php include '../Main/footer.php' ?>