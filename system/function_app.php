<?php
require_once('conectarBD.php');
require('core/reason_phrases.php');
 
//-- 
	function PHP_LoadPage($page_url = '', $data = array(), $set_lang = true) {
		global $load, $lang_text, $lang, $lang_admin, $config, $add_action, $CODE,$text_media, $text_media_two, $text_media ,$options_launcher;
		$page         = './themes/default/layout/' . $page_url . '.php';
		if (!file_exists($page)) {
			return false;
		}
		$page_content = '';
		ob_start();
		require($page);
		$page_content = ob_get_contents();
		ob_end_clean();
	    if ($set_lang == true) {
			$page_content = preg_replace_callback("/{{LANG (.*?)}}/", function($m) use ($lang_text) {
				return (isset($lang_text[$m[1]])) ? $lang_text[$m[1]] : '';
			}, $page_content);
		}
 
		if (!empty($data) && is_array($data)) {
			foreach ($data as $key => $replace) {
					$object_to_replace = "{{" . $key . "}}";
					$page_content      = str_replace($object_to_replace, $replace, $page_content);
			}
		}
		#-->
		$page_content = preg_replace("/{{LINK (.*?)}}/", PHP_Link("$1"), $page_content);
		$page_content = preg_replace_callback("/{{CONFIG (.*?)}}/", function($m) use ($config) {
			return (isset($config[$m[1]])) ? $config[$m[1]] : '';
		}, $page_content);
		return $page_content;
	}
//-- 
	function PHP_Link($string) {
		global $site_url;
		return $site_url . '/' . $string;
	}
//--
	function PHP_Slug($string, $video_id) {
		global $load;
		if ($load->config->seo_link != 'on') {
			return $video_id;
		}
		$slug = url_slug($string, array(
			'delimiter' => '-',
			'limit' => 100,
			'lowercase' => true,
			'replacements' => array(
				'/\b(an)\b/i' => 'a',
				'/\b(example)\b/i' => 'Test'
			)
		));
		return $slug . '_' . $video_id . '.html';
	} 
//--
	function ToArray($obj) {
		if (is_object($obj))
			$obj = (array) $obj;
		if (is_array($obj)) {
			$new = array();
			foreach ($obj as $key => $val) {
				$new[$key] = ToArray($val);
			}
		} else {
			$new = $obj;
		}
		return $new;
	}
//-- 
	function PHP_SYSTEM_url_get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}	
//-- 	
	function ToObject($array) {
		$object = new stdClass();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$value = ToObject($value);
			}
			if (isset($value)) {
				$object->$key = $value;
			}
		}
		return $object;
	}
//--	
	 
	// This function is to prevent special characters
	function PHP_Secure($string, $censored_words = 1) {
		global $con,$config;
		$string = trim($string);
		$string = htmlspecialchars($string, ENT_QUOTES,'UTF-8');
		$string = str_replace('\r\n', " <br>", $string);
		$string = str_replace('\n\r', " <br>", $string);
		$string = str_replace('\r', " <br>", $string);
		$string = str_replace('\n', " <br>", $string);
		$string = str_replace('&amp;#', '&#', $string);
		$string = stripslashes($string);
		return $string;
	}
	
	 
//-- 
	function PHP_Data_file_size($bytes){
		switch ($bytes) {
			case $bytes < 1024:
				$size = $bytes . " B";
				break;
			case $bytes < 1048576:
				$size = round($bytes / 1024, 2) . " KB";
				break;
			case $bytes < 1073741824:
				$size = round($bytes / 1048576, 2) . " MB";
				break;
			case $bytes < 1099511627776:
				$size = round($bytes / 1073741824, 2) . " GB";
				break;
		}
		if (!empty($size)) {
			return $size;
		} else {
			return "";
		}
	}
//-- 
	function PHP_file_size($url){
		$headers = get_headers($url, 1);
		if (is_array($headers) && count($headers) > 0) {
			$size = $headers['Content-Length'];
			if (is_array($size)) {
				foreach ($size as $value) {
					if ($value != 0) {
						$size = $value;
						break;
					}
				}
			} 
			return $size;
		} else {
			return "unknown";
		}
	}
//--
	function PHP_file_size_curl($url){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_REFERER, '');
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240");
		$header = curl_exec($curl);
		return (int)curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($curl);
	}
//--
	function time_data($time){
		return gmdate(($time > 3600 ? "H:i:s" : "i:s"), $time);
	}
//-- 
	function PHP_Format_video($Format){
		$url = PHP_Secure($Format);
		//-- with this function is to know the format of the video
		preg_match("/.(3gp|3GP|mp4|MP4|flv|FLV|m4a|M4A|avi|AVI|webm|WebM|wmv|WMV|mov|MOV|h264|H264|mkc|MKV|3gpp|3GPP|mpegps|MPEGPS|mpeg4|MPEG4|gifv|GIFV|jpg|JPG|jpeg|JPEG|png|PNG|icon|ICON|gif|GIF|mp3|MP3|m3u8|M3U8)/", $url, $check);
		if ($check[1] == 'H264'&&'h264'){
			$Formats = 'mp4';
		}else if($check[0] == null){
			$Formats = 'mp4';
		}else if($check[0] == 'M4A'&&'m4a'){
			$Formats = 'mp3';			
		}else{	
			$Formats = $check[1];
		}
		return strtoupper($Formats);
	}
//-- https://stackoverflow.com/a/9826656/9855444
    function PHP_string_between($string, $start, $end){
        $string = " " . $string;
        $ini = strpos($string, $start);
        $eni = strpos($string, $end);
        if ($ini == 0 || $eni == 0) return "";
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }	
//--	
	function br2nl($st) {
		$breaks = array("<br />","<br>","<br/>");  
		return str_ireplace($breaks, "\r\n", $st);
	}
//--
	function PHP_str_replace_text($text, $src) {
		$tags 	= array("/", "|", "+", "-", "*", " ", "%", "#", "!", "(", ")", "'", "&", ":", ".", "{", "}", "$", "?", "¿", "20");	
		$data 	= str_replace($tags, $src, $text);
		return $data;
	}
//--
	function return_json($array){
		header('Content-Type: application/json');
		echo json_encode($array);
		die();
	}
//--
	function username_post_id($url){
		$username = explode('.', str_ireplace("www.", "", parse_url($url, PHP_URL_HOST)))[0];  
        return $username; 
    }	
//-- 
	function PHP_Video_Data($data = array(), $message_error = array()){
		global $con, $lang, $CODE, $config, $_COOKIE, $options_launcher, $data_class;
		error_reporting(E_ERROR | E_PARSE | error_reporting()); // Make sure to show any critical error while loading the plugin.
		$content 		= array();
		$data_url 		= PHP_Secure($data['Url_video_media']);
		$share_url 		= ($data['Active_share']) ? true : false;
		$save_url		= PHP_Secure($data['Get_share']);
		
		if(1 == 0){
			$status 		= 400;
			$message 		= $message_error['false_data_db'];
		}else{
			if ($data_url == NULL){
                $status 	= 400;
				$message 	= $message_error['false_url_empty'];
            }else{    
					//-->
						 
							 
							include("plugins/functions.php"); 
							$Data_content = Data_Host_Function($data_url);
							if (empty($Data_content['data']['video'][0][0]['url'] or $Data_content['data']['audio'][0][0]['url'] or $Data_content['data']['list'][0][0]['url'])){
							# Report_link	
								$status 	= 400;
								$message 	= $message_error['false_video'];
							}else{
								 
								$content['L_TITLE'] 					= (!empty($Data_content['title']))?$Data_content['title']:'';
								$content['L_TIME'] 						= (!empty($Data_content['time']))?$Data_content['time']:'';
								$content['L_THUMBNAIL']					= (!empty($Data_content['thumbnail']))?$Data_content['thumbnail']:'';
								$content['L_SOURCE']					= (!empty($Data_content['source']))?$Data_content['source']:'';
								$content['L_DATA_VIDEO'] 				= $Data_content['data']['video'];
								$content['L_DATA_AUDIO'] 				= (!empty($Data_content['data']['audio']))?$Data_content['data']['audio']:'';
								$content['L_DATA_LIST'] 				= (!empty($Data_content['data']['list']))?$Data_content['data']['list']:'';
								$content['L_DIRECT_DOWNLOAD'] 			= (!empty($Data_content['direct_download']))?$Data_content['direct_download']:'';
								$content['L_VIDEO'] 					= (!empty($Data_content['video']))?1:'';
								$content['L_AUDIO'] 					= (!empty($Data_content['audio']))?1:'';
								$content['L_LIST'] 						= (!empty($Data_content['list']))?1:'';
								$content['L_URL'] 						= '';
								
								$status 	= 200;
								$message 	= $message_error['true_data'];
							}
						 
            } 
		} 
		$content['STATUS'] 			= $status;
		$content['ERROR_MESSAGE'] 	= $message;
		return $content; 
	}
//--
 
	function PHP_GetKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false) {
		$charset = '';
		if ($uselower) {
			$charset .= "abcdefghijklmnopqrstuvwxyz";
		}
		if ($useupper) {
			$charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}
		if ($usenumbers) {
			$charset .= "123456789";
		}
		if ($usespecial) {
			$charset .= "~@#$%^*()_+-={}|][";
		}
		if ($minlength > $maxlength) {
			$length = mt_rand($maxlength, $minlength);
		} else {
			$length = mt_rand($minlength, $maxlength);
		}
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $charset[(mt_rand(0, strlen($charset) - 1))];
		}
		return $key;
	}
//--
	function File_Delete_datas(){
		
		return true;	
	}	
//--
	function File_download_host($data = array()){
		 
		$status = 200;
	  				
		return $status;			
	}	
//--
	function prettyPrint($json){
		$result 			= '';
		$level 				= 0;
		$in_quotes 			= false;
		$in_escape 			= false;
		$ends_line_level 	= NULL;
		$json_length 		= strlen($json);

		for( $i = 0; $i < $json_length; $i++ ) {
			$char 			= $json[$i];
			$new_line_level = NULL;
			$post 			= "";
			
			if( $ends_line_level !== NULL ) {
				$new_line_level 	= $ends_line_level;
				$ends_line_level 	= NULL;
			}
			
			if ($in_escape){
				$in_escape = false;
			} else if($char === '"') {
				$in_quotes = !$in_quotes;
			} else if(!$in_quotes) {
				switch($char){
					case '}': case ']':
						$level--;
						$ends_line_level 	= NULL;
						$new_line_level 	= $level;
						break;
					case '{': case '[':
						$level++;
					case ',':
						$ends_line_level 	= $level;
						break;
					case ':':
						$post 				= " ";
						break;
					case " ": case "\t": case "\n": case "\r":
						$char = "";
						$ends_line_level 	= $new_line_level;
						$new_line_level 	= NULL;
						break;
				}
			} else if ( $char === '\\' ) {
				$in_escape = true;
			}
			if( $new_line_level !== NULL ) {
				$result .= "\n".str_repeat( "\t", $new_line_level );
			}
			$result .= $char.$post;
		}

		return $result;
	}
//-->
	function list_file_host(){
		$data 		= array();
		$list 		= '';
		$localdir 	= 'download_file';
		if ($dh = opendir($localdir)) {
			$i = 1;
			while (($file = readdir($dh)) !== FALSE) {
				
				if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4'
					||pathinfo($file, PATHINFO_EXTENSION) === 'MP4'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'avi'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'AVI'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'wmv'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'WMV'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'mkv'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'MKV'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'mov'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'MOV'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'mp3'
					|| pathinfo($file, PATHINFO_EXTENSION) === 'MP3'
				){

					if($i <= 100){

						if (preg_match_all('#time_[^{]*{([^}]*)}#', $file, $resultado)) {
							$mp = $resultado[1];   //que sólo tome lo capturado por el primer grupo
						} else {
							$mp = [];
						}
						
						if(!$mp == null){
							foreach ($mp as $time) {
								if ($time <= time()) {
									$data['files'][$i] = [
															[
																'file' 		=> $file,
																'key' 		=> $i,
																'time' 		=> $time,
															],  
														];
								} 
							} 
						} 
					}					
					$i++;
				}
			}
		  closedir($dh);
		}
     
		return [
			'data'				=> $data,
		];
    }
 
	function list_file_host_delete(){
		$list_file_host = list_file_host();
		if(!empty($list_file_host['data']['files'][1][0]['file'])){
			foreach ($list_file_host['data']['files'] as $data) {
				if ($data[0]['time'] < time()) {
					$file_video = './download_file/' .$data[0]['file'];
					if (file_exists($file_video)) {
						unlink($file_video);
					} 
				} 
			}    
		}
		return true;
	}

	//--> list_file_host_delete();	
?>