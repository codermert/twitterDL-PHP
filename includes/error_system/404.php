<?php 

$load->page = '404';
$load->title = '404 | ' . $load->config->title;
$load->description = $load->config->description;
$load->content = PHP_LoadPage('404/index',array(
	'HEADER_TOP'=>PHP_LoadPage('template/header'),
	'LANG_404_DESC' => $PHP_Error->_404,
));