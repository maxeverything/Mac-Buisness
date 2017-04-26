<?php
class Currency{
	public static function getCurrency($price){
		return 'RM'.number_format($price,2);
	}
}
?>