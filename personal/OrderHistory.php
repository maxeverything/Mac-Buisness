<?php
include '../main/authorization.php';
if(authetication()==TRUE){
	include '../Main/header.php';
?>
  

<script>
	$(document).ready(function() {
		$('.btnShowDetail').click(function() {
			$OrderId = $(this).attr("dir");
			$("#modalOrderDetail").load("frmOrderHistoryDetail.php?orderID=" + $OrderId );
		});
	});
	 function printReport() {
        var prtGrid = document.getElementById('modalOrderDetail');
        prtGrid.border = 0;
        var prtwin = window.open('', 'PrintGridViewData', 'left=150, top=150, width=1000, height=1000, tollbar=0, scrollbars=1, status=0, resizable=1');
        prtwin.document.write(prtGrid.outerHTML);
        prtwin.document.close();
        prtwin.focus();
        prtwin.print();
        prtwin.close();
    }     

</script>
<br/>
<div class="row">
  <!-- Side Bar -->
  <div class="large-12 small-12 columns">
  	<div id="modalOrderDetail" class="reveal-modal">

  	</div>
  	<div class="large-3 columns">
  		<?php
  		include 'personalSideMap.php';
  		?>
	</div>
	<div class="large-9 columns">
  		<table class="small-12 columns">
  					<tr>
    					<th scope="col">Order Detail</th>
    					<th scope="col">Order Date</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Amount (RM)</th>
                    </tr>
					<?php
						include '../Function/fPersonalInformation.php';
						$result_history=user_profile::getOrderHistory();
						while($row_history=mysql_fetch_array($result_history,MYSQL_ASSOC)){
                    ?>
                    <tr>    
                    	<td><?php
							echo "<a href=' ' dir=".$row_history['OrderID'].' " data-reveal-id="modalOrderDetail" class="btnShowDetail data-reveal-ajax="true"">Show</a>';	
                        ?>
                        </td>
                        <td class="text-center"><?php
							echo $row_history['OrderDate'];	
                        ?>
                        </td>
                        <td class="text-center">
                        <?php
                        	if($row_history['shipmentStatus']=='sent'){
                        		echo $row_history['shipmentStatus'].' At ('.$row_history['ShippedDate'].')';
                        	}else{
                        		echo 'will be sent at '.$row_history['RequiredDate'];
                        	}
							
                        ?>
                        </td>
                        <td class="text-center"><?php
							echo $row_history['total'];	
                        ?>
                        </td>
                    
                    </tr>
                    <?php
						}
					?>
					</table>
	</div>
</div>
    <!-- End Side Bar -->

    <!-- Thumbnails -->

    <!-- End Thumbnails -->

</div>
    <!-- Footer -->
<?php include '../Main/footer.php';
} ?>
