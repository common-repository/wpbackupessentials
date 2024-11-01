<?php

function wpbe_cleanCommands($str) {
	$str = str_ireplace(";", "", $str);
	$str = str_ireplace("rm -rf", "", $str);
	$str = str_ireplace("rm -f", "", $str);
	$str = str_ireplace("ls -l", "", $str);
	$str = str_ireplace("ls -a", "", $str);
	$str = str_ireplace("ls -la", "", $str);
	return $str;
}

function wpbe_cleanText($str) {
	$str = strip_tags($str);
	$str = trim($str);
	return $str;
}

?>
