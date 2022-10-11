<?php
require_once ("launcher.php");
//--
    function PHP_DatesCrypt($action, $string) {
		global $options_launcher;
		$output 			= false;
		$encrypt_method 	= "AES-256-CBC";
		$secret_key 		= $options_launcher['crypt_secret_key'];
		$secret_iv 			= $options_launcher['crypt_password'];
		// hash
		$key 				= hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
//--
	function PHP_Crypt_code($in, $to_num = false, $pad_up = false, $pass_key = null) {
		return $in;
	}
//--
	function PHP_fetchToken($form = 'mailer'){
        $token  =   sha1(uniqid(microtime(), true));
        $_SESSION['token'][$form]   =   $token; 
        // Just return it, don't echo and return
        return $token;
    }
//--
	function PHP_matchToken($form){
        if(!isset($_POST['token'][$form]))
            return false;
        // I would clear the token after matched
        if($_POST['token'][$form] === $_SESSION['token'][$form]) {
            $_SESSION['token'][$form]   =   NULL;
            return true;
        }
        // I would return false by default, not true
        return false;
    }	
?>