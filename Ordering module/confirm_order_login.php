<?php include '../Main/header.php' ?>
<div class="row">
    <div class="large-6 columns">
        <div class="panel">
            <form class="custom">
                <div class="row collapse">
                              <label>Email : </label>
                              <div class="small-10 columns">
                              	<input type="text" placeholder="Email" name="email">
                              </div>
                              <div class="small-2 columns">
                                <span class="postfix">.com</span>
                              </div>
               </div>
                              
               <div class="large-12 columms">
                            <label>Password :</label>
                            <input type="password" placeholder="Password" name="pass">
               </div>            
              
              <div style="padding-top:20px;"> <center>
                    <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Login</span></button>
                  </center>
              </div>     
            </form>
      </div>
    </div>
    <div class="large-6 columns">
    	<div class="panel">
            <div class="large-8 large-centered columns">
                <label>Register as New Member ?</label><br/>
                <a href=""><img src="../images/join_member_banner.jpg"></a>
            </div>
            <br/>
            <br/>
            <hr>
             <div class="panel" style="background-color:#FFF">
             	<div class="large-8 large-centered columns">
             <label>Join Us On Facebook</label>
             <a href=""><img src="../images/facebook_login_button.png" ></a><br/>
             	</div>
               <center><small>We will never post on your behalf or share any information without your permission.</small></center>
             </div>
        </div>
        <hr>
    </div>
</div>
<?php include '../Main/footer.php' ?>
