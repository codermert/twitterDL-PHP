<?php
/*
Script for: twitter.com
Author: Zhareiv
Update date: 24-07-2020
Copyright (c) 2020 Videoit. All rights reserved.
*/
error_reporting(0);
ini_set('display_errors', 1);
include "twitter_functions.php";
use Abraham\TwitterOAuth\TwitterOAuth;
// API Connection Parameters.
$consumer_key = "ZCY2bbZBsTCRjIwcREUIdpJIZ";
$consumer_secret_key = "Q2cNeCKYcWXB6LPNVgCCCkXVVP2ex4LfB3nAuHrhqKoRpHXIKF";

// My tokens created by using Twitter Applications page create my tokens.
$access_token = "3124224490-YI13UIPpxn105lECNj2FN506cjlC13hDmZkLJfW";
$access_token_secret = "9pHRKD4Ee5i9tyd1GqDthXZQ7XreYIFKARKg3e876EKMh";

// Connection and getting permisions from API Connection parameters.
$data_class = new TwitterOAuth($consumer_key, $consumer_secret_key, $access_token, $access_token_secret);

	function Data_Host_Function($url){
		global $data_class;
		$data = array();
		$content 			= $data_class->get("account/verify_credentials");
		$tweet_id 			= getVid($url); 
		$tweet 				= getTweetInfo($data_class,$tweet_id);
		//Get Tweet Video URL
		$Data_video_twitter = getTweetVideo($tweet);
		$i = 0;
		foreach($Data_video_twitter as $indice => $data_video){
			$data['video'][$i] = [
									[
										'url' 			=> $data_video['url'],
										'format' 		=> 'mp4',
										'quality' 		=> quality_video($data_video['url']).'p',
										'size' 			=> (PHP_file_size_curl($data_video['url'])==NULL)? '/': PHP_file_size_curl($data_video['url'])
									],  
								];	
			$i++; 
		}
		return [
			'title'				=> getTweetText($tweet),
			'thumbnail'			=> getTweetImage($tweet),
			'source'			=> 'twitter',
			'video'				=> true,
			'data'				=> $data,
		];
	} 
	
	function getVid($requestUrl){
        $urlPath 	= parse_url($requestUrl, PHP_URL_PATH);
        $vid 		= pathinfo($urlPath, PATHINFO_BASENAME);
        return $vid;
    }
	
	function quality_video($data){
		preg_match("/(180x320|240x240|320x180|320x400|320x568|320x628|324x270|360x638|460x576|480x480|576x478|608x1080|640x360|720x720|1280x720)/", $data, $match);
		
		switch ($match[1]) {
			//-- here are created the new chats
			case '1280x720':
				$quality = '1280x720';
			break;
			case '720x720':
				$quality = '720';
			break;
			case '640x360':
				$quality = '640';
			break;
			case '608x1080':
				$quality = '608';
			break;
			case '576x478':
				$quality = '576';
			break;
			case '480x480':
				$quality = '480';
			break;
			case '460x576':
				$quality = '460';
			break;
			case '360x638':
				$quality = '360';
			break;
			case '324x270':
				$quality = '324';
			break;
			case '320x628':
				$quality = '320';
			break;
			case '320x568':
				$quality = '320';
			break;
			case '320x400':
				$quality = '320';
			break;
			case '320x180':
				$quality = '320';
			break;
			case '240x240':
				$quality = '240';
			break;
			case '180x320':
				$quality = '180';
			break;
			default: 
				$quality = '?';
			break;
		}
		
		return $quality;
	}
?>