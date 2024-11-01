<?php

@include("config.php");

global $config;
$config = array();
$config['debug'] = false;

if(!isset($config['debug'])) {
	$config['debug'] = false;
	/* Debug error info code */
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	/* Should remove before releasing */	
}



global $dir;
$dir = dirname ( __FILE__ );

//$config['whmsuperb'] = true;
//$vfdata = @file_get_contents("version.txt");
//$vfdata = trim(str_ireplace("VERSION=","", $vfdata));
$config['version'] = "16.5.28";


if (!isset($script_version)) {
	$script_version = "";
}


$config['style'] = "default.css";


?>