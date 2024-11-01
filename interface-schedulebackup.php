<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
$wp_directory = get_home_path();
$wp_url = get_home_url();
$backup_location = plugin_dir_path(__FILE__) . 'backups/';
$wp_plugindir = plugin_dir_path(__FILE__);
?>
<h2>Schedule Backup</h2>
This feature is available in our FULL edition. It allows you to make hourly, daily and weekly backups!