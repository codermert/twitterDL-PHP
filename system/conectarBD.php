<?php
//Incluyo la configuración

 
require_once ("launcher.php");
 
$load     	= ToObject(array());


$http_header = 'http://';
if (!empty($_SERVER['HTTPS'])) {
    $http_header = 'https://';
}
$load->site_pages = array('home');
$load->actual_link = $http_header . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


//-->	
	$site_url 					= $options_launcher['site_url'];
	$config['theme_url']     	= $site_url . '/themes/default';
	$config['site_url']       	= $site_url;
	$config['name_site']      	= '------';
	$load->config             	= ToObject($config);
//-- Language site
	 
	$lang_file 	= './application/langs/lang.php';
	 
	
	 
	require($lang_file);
	 
	$lang            = ToObject($lang_text);
  
	 