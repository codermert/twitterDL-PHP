<?php 
// +------------------------------------------------------------------------+
// | @author shareiv or csode and scode
// | Copyright (c) 2017 shareiv. All rights reserved.
// +------------------------------------------------------------------------+

#-->this code blocks access to system folders

$http_header           = 'http://';
if (!empty($_SERVER['HTTPS'])) {
    $http_header = 'https://';
}
$this_url   = $http_header . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$this_url = str_replace('application', '404', $this_url);
header("Location: $this_url");
exit();
?>
