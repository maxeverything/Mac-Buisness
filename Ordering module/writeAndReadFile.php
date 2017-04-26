<?php
//get the memberId
//select 1 week transaction
//get the different date
//display the shopping detail based on each date

function writeFile($orderID,$item){
	$file = "..\Ordering module\order_det\\".$orderID.".txt";
	
	// open file
	
	$fh = fopen($file, 'w') or die('Could not open file!');
	
	
	if(fwrite($fh,$item)){
		$_SESSION['fileUrl'] = $file;
	}else{
		die('could not write file!!');
	}

	fclose($fh);
}


function read_File($orderID){
	$file = "..\Ordering module\order_det\\".$orderID.".txt";
	
	$fh = file($file)or die('Could not read file!!!');
	
	$get = '';
	$count=0;
	
	foreach($fh as $a){
		$get .= $a;
		$count++;
	}
	
	$member = explode('<br/>',$get);//had in array
	$grandTotal=array();
	
	$total = 0;
	$qty = '';
	
	
	for($i=0;$i<$count;$i++){
		$field = explode(',',$member[$i]);
		$grandTotal[$i] = $field[3]*$field[4];
		
		//store in detail
		$total += $grandTotal[$i];
		$detail['color_'.($i+1)] = $field[2];
		$detail['qty_'.($i+1)] = $field[3];
		$detail['name_'.($i+1)] = $field[1];
		$detail['price_'.($i+1)] = $field[4];
		$detail['id_'.($i+1)] = preg_replace('/\s+/', '', $field[0]);
		
	}
	$detail['size'] = $count;
	$detail['total'] = $total;
	
	return $detail;
}
?>