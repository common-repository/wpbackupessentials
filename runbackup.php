<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php

set_time_limit(0);
ini_set('max_execution_time', 0);

$mode = "";

$wp_plugindir = dirname(__FILE__) . "/";

$wp_dir = $wp_plugindir . "../../../";
$wp_directory = $wp_dir;
global $backup_location;
$backup_location = $wp_directory . 'wp-content/wpbe_backups/';


//include_once($wp_dir . "/wp-config.php");
//include_once($wp_plugindir . "functions.php");
global $eol;
$start_time = time();
//print_r($argv);
if($argc > 0) {
	//from shell
	$mode = "shell";
	$eol = "\n";

	$dstname = $argv[1];
}
else {
	//from web
	$mode = "web";
	$eol = "<br />\n";

	
	if($dstname == "") {
		echo "$dstname is empty..." . $eol;
	        $dstname = sanitize_text_field($_GET['dstname']);
	        if($dstname == "") {
		     $dstname = sanitize_text_field($_POST['dstname']);
		     //echo "$dstname set via POST" . $eol;
		}
		else {
			//echo "$dstname set via GET" . $eol;
		}
	}
}

//Initialize bootstrap
require_once($wp_plugindir . "bootstrap.php");

if($dstname != "local-dbandwpfiles" && $dstname != "local-dbonly" && $dstname != "local-wpfilesonly") {
		$dstname="local-dbandwpfiles";
}



function wpbe_dobackup() {
	global $time_string, $eol, $backup_files_cmd, $backup_db_cmd;
	global $destination_backupwpfiles, $destination_backupdb;
	global $email_response;
	global $emailnotifications_enabled, $emailnotifications_fromemail, $emailnotifications_toemail;
	
	$emailnotifications_enabled = trim($emailnotifications_enabled);
	
	if(trim($destination_backupwpfiles == "yes")) {
		//echo $backup_files_cmd;
		echo "[PROCESS] Backing up files...";
		exec($backup_files_cmd);
		//[ <a href='$wp_url/wp-content/plugins/wpbackupessentials/backups/" . $time_string . "_wpfiles.tar.gz'>" . $time_string . "_wpfiles.tar.gz</a> ]
		echo "done " . $eol;
		$email_response .= "WP Files has been backed up as " . $time_string . "_wpfiles.tar.gz" . "\n";
	}
	
	if(trim($destination_backupdb == "yes")) {
		//echo $backup_db_cmd . "<br />";
		echo "[PROCESS] Backing up database...";
		exec($backup_db_cmd);
		//[ <a href='$wp_url/wp-content/plugins/wpbackupessentials/backups/" . $time_string . "_wpdb.tar.gz'>" . $time_string . "_wpdb.tar.gz</a> ]
		echo "done " . $eol;
		echo "[STATUS] Backup process completed" . $eol;
		$email_response .= "WP DB has been backed up as " . $time_string . "_dbfiles.tar.gz" . "\n";
	}
		
	
}

echo $eol;
//echo $mode . ":" . $dstname . $eol;
echo "WPBackup Essentials RUNBACKUP by Dove Technologies. All rights reserved." . $eol;
echo "------------------------------------------------------------------------" . $eol;
set_time_limit(0);
echo "[SETTING] Attempting to set php time limit to infinite (indefinite) to avoid timeout" . $eol;
echo "[SETTING] Backup Location is $backup_location" . $eol;
@mkdir($backup_location);
@file_put_contents($backup_location . ".htaccess", "Options -Indexes");
if($dstname != "") {
	//Basic general code to get a backup going... independent of type of backup
	global $time_string, $eol, $backup_files_cmd, $backup_db_cmd;
	global $destination_backupwpfiles, $destination_backupdb;
	global $email_response;
	global $backup_time;
	global $backup_location;
	
	$backup_time = time();
	$time_string = date("Y-m-d-h-m-s",$backup_time);
	@file_put_contents($wp_plugindir . "latestbackuptimestring.info", $time_string);
	$db_host = DB_HOST;
	$db_name = DB_NAME;
	$db_user = DB_USER;
	$db_password = DB_PASSWORD;
	
	
	$email_response .= "Executing Destination:" . $dstname . "\n";

	if($dstname == "local-dbandwpfiles") {
		$destination_backupwpfiles = "yes";
		$destination_backupdb = "yes";
		$backup_files_cmd = "cd $wp_directory;" . "tar -zcvf " . $backup_location . $time_string . "_wpfiles.tar.gz . --exclude 'wp-content/wpbe_backups/*' >> " . $backup_location . $time_string . "_backuplog.txt";
		$backup_db_cmd = "mysqldump -u'$db_user' -p'$db_password' $db_name > " . $backup_location . $time_string . "_wpdb.sql; cd $backup_location; tar -zcvf " . $backup_location . $time_string . "_wpdb.tar.gz " . $time_string . "_wpdb.sql; rm -rf " . $backup_location . $time_string . "_wpdb.sql >> " . $backup_location . $time_string . "_backuplog.txt ";
		wpbe_dobackup();		
	}
	elseif($dstname == "local-dbonly") {
		$destination_backupwpfiles = "no";
		$destination_backupdb = "yes";
		$backup_files_cmd = "cd $wp_directory;" . "tar -zcvf " . $backup_location . $time_string . "_wpfiles.tar.gz . --exclude 'wp-content/wpbe_backups/*' >> " . $backup_location . $time_string . "_backuplog.txt";
		$backup_db_cmd = "mysqldump -u'$db_user' -p'$db_password' $db_name > " . $backup_location . $time_string . "_wpdb.sql; cd $backup_location; tar -zcvf " . $backup_location . $time_string . "_wpdb.tar.gz " . $time_string . "_wpdb.sql; rm -rf " . $backup_location . $time_string . "_wpdb.sql >> " . $backup_location . $time_string . "_backuplog.txt ";
		wpbe_dobackup();		
	}
	elseif($dstname == "local-wpfilesonly") {
		$destination_backupwpfiles = "yes";
		$destination_backupdb = "no";
		$backup_files_cmd = "cd $wp_directory;" . "tar -zcvf " . $backup_location . $time_string . "_wpfiles.tar.gz . --exclude 'wp-content/wpbe_backups/*' >> " . $backup_location . $time_string . "_backuplog.txt";
		$backup_db_cmd = "mysqldump -u'$db_user' -p'$db_password' $db_name > " . $backup_location . $time_string . "_wpdb.sql; cd $backup_location; tar -zcvf " . $backup_location . $time_string . "_wpdb.tar.gz " . $time_string . "_wpdb.sql; rm -rf " . $backup_location . $time_string . "_wpdb.sql >> " . $backup_location . $time_string . "_backuplog.txt ";
		wpbe_dobackup();		
	}	
		
}

$end_time = time();
$run_time = round(($end_time - $start_time),0);
echo "[TIME ELAPSED] This application took $run_time seconds to execute." . $eol;
echo "[COMPLETE]" . $eol;
?>