<div id="personalSide" class="docs section-container accordion" data-section="accordion" data-options="one_up: false">
  <section class="section" id='sideAccount'>
    <p class="title" ><a href="#">My Account</a></p>
    <div class="content">
      <ul class="side-nav">
        <li><a  href="personal_profile.php">Personal Information</a></li>
        <li><a  href="Address.php">Address</a></li>
      </ul>
    </div>
  </section>
  
  <section class="section " id='sideOrderHistory'>
    <p class="title" ><a href="OrderHistory.php">Order History</a></p>
  </section>
  <section class="section " id="sidePersonalFeedback">
    <p class="title"><a href="PersonalFeedback.php">Feedback</a></p>
  </section>
</div>

<script>
	 	$(document).ready(function(){
	 		$path=(window.location.pathname.split(".")[0]).split("/")[4];
	 		if($path=='personal_profile' || $path=='Address'|| $path=='passwordReset'){
	 			$('#sideAccount').addClass("active");
	 		}else if($path=='OrderHistory'){
	 			$('#sideOrderHistory').addClass("active");
	 		}else if($path=='PersonalFeedback'){
	 			$('#sidePersonalFeedback').addClass("active");
	 		}
	 	});
	 </script>