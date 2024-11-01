<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php

	$wp_directory = get_home_path();
	$wp_url = get_home_url();
	$backup_location = $wp_directory . 'wp-content/wpbe_backups/';
	$backup_location_url = $wp_url . '/wp-content/wpbe_backups/';
	$plugin_dir_url = plugin_dir_url(__FILE__);
	if(isset($_POST['submit'])) {
		check_admin_referer( 'backupfiles' );
		$submit = sanitize_text_field($_POST['submit']);
		if($submit == "Delete") {
			$files = sanitize_text_field($_POST['filenames']);
			foreach ($files as $file) {
				@unlink($backup_location . $file);
			}
		}
		if($submit == "Delete All") {
			$items = scandir($backup_location, SCANDIR_SORT_DESCENDING);
			foreach ($items as $item) {
				if(is_file($backup_location . $item)) {
					@unlink($backup_location . $item);
					echo "Deleted " . $backup_location . $item . "<br />";
				}
			}
		}
	}
	
	if(isset($_GET['restorefiles'])) {
		//quick restore files
		$filename = sanitize_text_field(strip_tags(trim($_GET['restorefiles'])));
		$file_parts = explode(".",$filename);
		unset($output);
		exec("tar -xvf " . $backup_location . $filename . " -C " . $wp_directory, $output);
		foreach($output as $line) {
			echo $line . "<br />";
		}
		echo "<h3>Files restored to " . $file_parts[0] . "</h3>";
	}
	
	if(isset($_GET['restoredb'])) {
		//quick restore db
		$filename = sanitize_text_field(strip_tags(trim($_GET['restoredb'])));
		$file_parts = explode(".",$filename);
		exec("rm -rf " . $backup_location . "tmpdb/");
		@mkdir($backup_location . "tmpdb/");
		unset($output);
		exec("tar -xvf " . $backup_location . $filename . " -C " . $backup_location . "tmpdb/", $output);
		foreach($output as $line) {
			echo $line . "<br />";
		}
		$db_host = DB_HOST;
		$db_name = DB_NAME;
		$db_user = DB_USER;
		$db_password = DB_PASSWORD;
		unset($output);
		//echo "DEBUG" . $db_user . "<br />";
		exec("mysql -u'$db_user' -p'$db_password' $db_name < " . $backup_location . "tmpdb/" . $file_parts[0] . ".sql", $output);
		foreach($output as $line) {
			echo $line . "<br />";
		}
		exec("rm -rf " . $backup_location . "tmpdb/");
		echo "<h3>Database restored to " . $file_parts[0] . "</h3>";
	}
	
	$items = scandir($backup_location, SCANDIR_SORT_DESCENDING);
	//print_r($items);
	echo "<h2>List Backups</h2>";
	echo "Note: We always recommend having a local copy before trying the quick restore option.<br />";
	echo "<form name='backupfiles' method='POST'>";
	wp_nonce_field( 'backupfiles' );
	echo "<input type='submit' name='submit' value='Delete' />";
	echo "<input type='submit' name='submit' value='Delete All' />";
	//echo "<input type='submit' name='submit' value='Restore Backup' /><br /><br />";
	echo "<table>";
	foreach ($items as $item) {
		if(is_file("$backup_location" . $item) && $item != ".htaccess") {
			$filesize_bytes = filesize($backup_location . $item);
			$filesize_mbytes = $filesize_bytes / 1024000;
			$filesize_mbytes_round = round($filesize_mbytes, 1);
			echo "<tr>";
			echo "<td><input type='checkbox' name='filenames[]' value='$item'></input></td>";
			echo "<td><a href='" . $backup_location_url . "$item'>" . $item . "</a></td>";
			$file_parts = explode("_", $item);
			$time_parts = explode("-", $file_parts[0]);
		 	$filetime = mktime($time_parts[3], $time_parts[4], $time_parts[5], $time_parts[1], $time_parts[2], $time_parts[0]);
		 	$date_formatted = date("jS F Y h:m.s", $filetime);
		 	echo "<td>$date_formatted</td>";
		 	echo "<td>$filesize_mbytes_round MB</td>";
		 	if(stripos($item, 'wpfiles') === FALSE) {
		 	
		 	}
		 	else {
		 		echo "<td>WP Files Archive</td>";
				echo "<td><a href='?page=wpbackupessentials&section=listbackups&restorefiles=$item'>Quick Restore</a></td>";
		 	}
		 	if(stripos($item, 'wpdb') === FALSE) {
		 	
		 	}
		 	else {
		 		echo "<td>WP Database Archive</td>";
				echo "<td><a href='?page=wpbackupessentials&section=listbackups&restoredb=$item'>Quick Restore</a></td>";
		 	}		 		
		 	
		 	if(stripos($item, 'backuplog') === FALSE) {
		 	
		 	}
		 	else {
		 		echo "<td>WP Backup Log File</td>";
		 	}	
		 		 		
		 	echo "</tr>";		 	
			echo "<tr><td></td><td colspan='4'><p style='font-size: 9px;'>Migrate Link<br />" . $backup_location_url . "$item</p></td></tr>";
			echo "</tr>";		 	
			//print_r($time_parts);
		}
	}
	echo "</table>";
	echo "</form>";
?>