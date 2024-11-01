<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$plugin_path = plugin_dir_path(__FILE__);
$wp_plugindir = plugin_dir_path(__FILE__);
$plugin_url_path = plugin_dir_url( __FILE__ );
$home_url = get_home_url();
?>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $plugin_url_path . 'default.css'; ?>"> -->
<div id="main_header">
<img id='logo' src='<?php echo $plugin_url_path . 'icons/icon64.png'; ?>' /><p id="productname">WP Backup Essentials</p>
<p id="companyname">Powered by <a style='text-decoration: none;' href='http://www.dovetechnologies.net' target='_blank'>Dove Technologies</a> | Version <?php echo $config['version']; ?></p>
</div>

<div id="main_header_right">
<?php

	echo "BUY THE FULL VERSION FOR MORE AWESOME FEATURES!<br /><a style='font-color:#FFFFFF;' target='_blank' href='http://www.dovetechnologies.net/wpbe-specialoffer.html'>Click here for special pricing</a><br />";


?>
</div>

<div id="wpbe_menu">
	<a class="wpbe_link_top" href="?page=wpbackupessentials&section=diags">Diagnostics</a>
	<a class="wpbe_link_top" href="http://www.dovetechnologies.net/wpbackupessentials.html" target="_blank">Check for updates</a>
	<br /><br />
	<a class="wpbe_link" href="?page=wpbackupessentials"><img id='icon' src='<?php echo $plugin_url_path . 'icons/home-128px.png'; ?>' /><br />Home</a>
	<a class="wpbe_link" href="?page=wpbackupessentials&section=livebackup"><img id='icon' src='<?php echo $plugin_url_path . 'icons/livebackup-128px.png'; ?>' /><br />Live Backup</a>
	<a class="wpbe_link" href="?page=wpbackupessentials&section=listbackups"><img id='icon' src='<?php echo $plugin_url_path . 'icons/listbackups-128px.png'; ?>' /><br />List Backups</a>
	<a class="wpbe_link" href="?page=wpbackupessentials&section=migrate"><img id='icon' src='<?php echo $plugin_url_path . 'icons/migrate-128px.png'; ?>' /><br />Migrate</a>
</div>

<div class="clearboth"></div>