<?php	
	class Salt {
    public static function setPass($in_pass) {
      $hash = '';

      $cost = 10;
	  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
	  $salt = sprintf("$2a$%02d$", $cost) . $salt;
	  $hash = crypt($in_pass, $salt);

      return $hash;
    }
	
	public static function getPass($in_pass,$hast_pass) {
      if ( crypt($in_pass, $hast_pass) == $hast_pass ) {
			return true;
		}else{
			return false;
		}
    }
	}
?>