<?php
include '../main/authorization.php';
if(checkStaff($_SESSION['id'])==TRUE){
require_once('../Main/header.php'); 
 
?>	
	
<div class="row">
	<form enctype="multipart/form-data" data-abide class="custom" method="post" action="upload_slideImgs.php" >
	    <fieldset>
        <legend>Slide Show Image</legend>
			<div class="large-12 columns">
	          <label for="SlideShow">Slide Show Image 1<small>required</small></label>
	             <input type="file" id="slideimg1" placeholder="URL of Slide Show Image 1." name="slideimg[]" required>
	        </div>
	        
	        <div class="large-12 columns">
	          <label for="SlideShow">Slide Show Image 2<small>required</small></label>
	             <input type="file" id="slideimg2" placeholder="URL of Slide Show Image 2." name="slideimg[]" required>
	        </div>
	        
	        <div class="large-12 columns">
	          <label for="SlideShow">Slide Show Image 3<small>required</small></label>
	             <input type="file" id="slideimg3" placeholder="URL of Slide Show Image 3." name="slideimg[]" required>
	        </div>
	        
	        <div class="large-12 columns">
	          <label for="SlideShow">Slide Show Image 4<small>required</small></label>
	             <input type="file" id="slideimg4" placeholder="URL of Slide Show Image 4." name="slideimg[]" required>
	        </div>
	     </fieldset>
	     
			
	
	     </div>
	     
	     <div class="large-3 large-centered columns">
                <button type="submit" value="Upload" name="submit_member_reg" class="medium button green">Submit</button>
           </div>
           
           
	</form>
	 	
</div>	
<?php require_once('../Main/footer.php'); 
}?>