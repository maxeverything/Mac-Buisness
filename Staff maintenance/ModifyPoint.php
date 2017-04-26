<?php include '../Main/header.php' ;
	
	$file = 'PointFile.txt';
	
	$point = file_get_contents($file)or die('Could not read file!');
	
	?>
<div class="row">
<h2><u>Update Point</u></h2>
	<div class="large-6 columns">
   
        	<div class="panel"><p>Currently the CRM <b>RM <?php echo $point; ?> = 1 point</b>,did you want to modify it ? </p>
            </div>
	</div>
    <div class="large-6 columns">
    	<form class"custom" action="ModifyPoint.php" method="post">
        	 <label for="username">Enter new point</label> 
      <input type="text" id="point" name="NewPoint" placeholder="Fill in new point here" required/>

      		<div class="row">
                  <div class="small-3 small-centered columns">
                    <button type="submit" name="submit" id="button1" class="medium button green" >Update</button>
                  </div>
    	    </div>
        </form>
        
    </div>
</div>

<?php 
if(isset($_POST['submit'])){
		$fh = fopen($file,'w') or die('Could not open File!!');
		
	$NewPoint = empty($_POST['NewPoint']) ? die ("ERROR: Enter a NewPoint") : mysql_real_escape_string($_POST['NewPoint']);

	
		
		if(fwrite($fh,$NewPoint)){
?>
<script>
	window.onload = function() {
	    alert( "Update Point Success" );
		window.location.replace("ModifyPoint.php");
	}	
</script>	
<?php			
		}else{
			die('Fail to update point');
		}
	fclose($fh);
	}
	
	

include '../Main/footer.php';?>