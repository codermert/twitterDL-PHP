<?php

$PHP_reason_phrases = array(
            //Informational 1xx
            '_100' => "Continue",
            '_101' => "Switching Protocols",

            // Successful 2xx
            '_200' => "OK",
            '_201' => "Created",
            '_202' => "Accepted",
            '_203' => "Non-Authoritative Information",
			'_204' => "No Content",
			'_205' => "Reset Content",
            '_206' => "Partial Content",

            // Redirection 3xx
            '_300' => "Multiple Choices",
            '_301' => "Moved Permanently",
            '_302' => "Found",
            '_303' => "See Other",
            '_304' => "Not Modified",
            '_305' => "Use Proxy",
            '_306' => "(Unused)",
            '_307' => "Temporary Redirect",

            // Client Error 4xx
            '_400' => "Bad Request",
            '_401' => "Unauthorized",
            '_402' => "Payment Required",
            '_403' => "Forbidden",
            '_404' => "Not Found",
            '_405' => "Method Not Allowed",
            '_406' => "Not Acceptable",
            '_407' => "Proxy Authentication Required",
            '_408' => "Request Timeout",
            '_409' => "Conflict",
            '_410' => "Gone",
            '_411' => "Length Required",
            '_412' => "Precondition Failed",
            '_413' => "Request Entity Too Large",
            '_414' => "Request-URI Too Long",
            '_415' => "Unsupported Media Type",
            '_416' => "Requested Range Not Satisfiable",
            '_417' => "Expectation Failed",

            // Server Error 5xx
            '_500' => "Internal Server Error",
            '_501' => "Not Implemented",
            '_502' => "Bad Gateway",
            '_503' => "Service Unavailable",
            '_504' => "Gateway Timeout",
			'_505' => "HTTP Version Not Supported"
        );
		
$PHP_Error   = ToObject($PHP_reason_phrases);		
?>		