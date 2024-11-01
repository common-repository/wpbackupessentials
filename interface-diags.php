<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<html>
<head>

</head>
<body>

<?php


$eol = "<br />\n";
?>

<h2>Diagnostics</h2>
<?php
$dir = dirname(__FILE__);
$wp_directory = get_home_path();
$backup_location = $wp_directory . '/wp-content/wpbe_backups/';

if (is_writable($backup_location)) {
	echo "[OK] WPBackupEssentials Plugin directory is writable by PHP" . $eol;
}
else {
	echo "[FATAL] WPBackupEssentials Plugin directory is not writable. Licensing will fail to register properly and backups will not be able to be saved. You must fix this for this plugin to function properly" . $eol;
}

if (is_dir($backup_location)) {
	echo "[OK] WPBackupEssentials Backups directory exists" . $eol;
}
else {
	echo "[WARNING] WPBackupEssentials Backup Directory does not exist. Please try to execute a Live Backup to see whether it can create a 'backups' directory in the plugin folder" . $eol;
}

unset($output);
exec("mysqldump --version", $output);
$found_mysqldump = false;
foreach ($output as $line) {
	//echo $line . $eol;
	if(stripos($line, "mysqldump") === FALSE) {

	}
	else {
		$found_mysqldump = true;
	}
}

if($found_mysqldump) {
	echo "[OK] MYSQLDUMP was executed successfully." . $eol;
}
else {
	echo "[FATAL] MYSQLDUMP could not be executed. This application is required to generate database backups. Please contact your hosting company to enable." . $eol;
}

unset($output);
exec("tar --version", $output);
$found_tar = false;
foreach ($output as $line) {
	//echo $line . $eol;
	if(stripos($line, "tar") === FALSE) {
		
	}
	else {
		$found_tar = true;
	}
}

if($found_tar) {
	echo "[OK] TAR was executed successfully." . $eol;
}
else {
	echo "[FATAL] TAR could not be executed. This application is required to generate database backups. Please contact your hosting company to enable." . $eol;
}

unset($output);
exec("ps", $output);
$found_ps = false;
foreach ($output as $line) {
	//echo $line . $eol;
	if(stripos($line, "PID") === FALSE) {

	}
	else {
		$found_ps = true;
	}
}

if($found_ps) {
	echo "[OK] PS was executed successfully." . $eol;
}
else {
	echo "[WARNING] PS could not be executed. This application is required to show jobs currently running" . $eol;
}

?>
<br />
Please note that if any FATAL errors occur, you will need to fix the problem before WPBackupEssentials can run properly.
</body>
</html>