<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
$wp_directory = get_home_path();
$wp_url = get_home_url();
$wp_plugindir = plugin_dir_path(__FILE__);
?>
<h2>Live Backup</h2>
Live backups are manual backups which you can do in realtime (live). When you create a new backup, your wordpress files and database is gzipped into the backups directory. After a backup has completed, you can click on <a href='?page=wpbackupessentials&section=listbackups'>List Backups</a> to all your backups as well as initiate additional restoration functions.<br />
<br />
<b>IMPORTANT: IF this page stops loading information during the backup process after a few minutes, this can cause the backup process to fail. <br />
Please consider purchasing the full edition which comes with cron support and beats the php timeout limits<br />
</b>
<br />
<br />
<form name="livebackup" method="POST">
	<?php wp_nonce_field( 'livebackup' ); ?>
	<select name="dstname">
		<option value="local-dbandwpfiles">local-dbandwpfiles</option>
		<option value="local-dbonly">local-dbonly</option>
		<option value="local-wpfilesonly">local-wpfilesonly</option>
		<?php
		$items = scandir($wp_plugindir, SCANDIR_SORT_ASCENDING);
		foreach ($items as $item) {
			if (is_file($wp_plugindir . $item)) {
				if (stripos($item, 'destination-config-') === FALSE) {
			
				}
				else {
					//found destination-config-
					$filename = str_ireplace(".cfg", "", $item);
					$filename = str_ireplace("destination-config-", "", $filename);
					echo "<option value='$filename'>$filename</option>";
				}
			}
		}
		?>
	</select>
	<input type="submit" name="submit" value="Create Backup" />
</form>

<?php
if(isset($_POST['submit'])) {
	check_admin_referer( 'livebackup' );
	$submitval = sanitize_text_field($_POST['submit']);
	$dstname = sanitize_text_field($_POST['dstname']);
	
	include("runbackup.php");
	
	
	/*
	$time_string = date("Y-m-d-h-m-s",time());
	//echo $time_string . "<br />";

	//echo $wp_directory . "<br />";
	
	echo "<br /><br />";
	
	if($debug) {
		echo DB_HOST . "<br />";
		echo DB_NAME . "<br />";
		echo DB_USER . "<br />";
		echo DB_PASSWORD . "<br />";
	}
	
	$db_host = DB_HOST;
	$db_name = DB_NAME;
	$db_user = DB_USER;
	$db_password = DB_PASSWORD;
	
	$backup_location = plugin_dir_path(__FILE__) . 'backups/';
	
	$backup_files_cmd = "cd $wp_directory;" . "tar -zcvf " . $backup_location . $time_string . "_wpfiles.tar.gz * --exclude 'wp-content/plugins/wpbackupessentials/backups/*' &";
	$backup_db_cmd = "mysqldump -u'$db_user' -p'$db_password' $db_name > " . $backup_location . $time_string . "_wpdb.sql; tar -zcvf " . $backup_location . $time_string . "_wpdb.tar.gz " . $backup_location . $time_string . "_wpdb.sql; rm -rf " . $backup_location . $time_string . "_wpdb.sql &";
	
	if($dstname == "local") {
		//echo $backup_files_cmd . "<br />";
		echo "Backing up files...";
		exec($backup_files_cmd);
		echo "done [ <a href='$wp_url/wp-content/plugins/wpbackupessentials/backups/" . $time_string . "_wpfiles.tar.gz'>" . $time_string . "_wpfiles.tar.gz</a> ]<br />";
		
		//echo $backup_db_cmd . "<br />";
		echo "Backing up database...";
		exec($backup_db_cmd);
		echo "done [ <a href='$wp_url/wp-content/plugins/wpbackupessentials/backups/" . $time_string . "_wpdb.tar.gz'>" . $time_string . "_wpdb.tar.gz</a> ]<br />";
		echo "<br />";
		echo "Backup process completed";
	}
	*/

}

?>