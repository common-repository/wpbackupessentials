<?php
/*
Plugin Name: WP Backup Essentials
Plugin URI:  http://www.dovetechnologies.net/wpbackupessentials.html
Description: WP Backup Essentials is all you'll need to backup your Wordpress website quickly and painlessly!
Version:     16.6.4
Author:      Dove Technologies
Author URI:  http://www.dovetechnologies.net
*/

//WP Plugin Documentation: https://developer.wordpress.org/plugins/



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


register_activation_hook( __FILE__, 'wpbackupessentials_activation' );
register_deactivation_hook( __FILE__, 'wpbackupessentials_deactivation' );




function wpbackupessentials_activation() {

	
}


function wpbackupessentials_deactivation() {

}

function wpbackupessentials_add_adminlink() {
    //add an item to the menu
    add_menu_page (
        'WP Backup Essentials Administration',
        'WP Backup Essentials',
        'manage_options',
        'wpbackupessentials',
        'wpbackupessentials_loadadminpage',
        plugin_dir_url( __FILE__ ).'icons/icon24.png',
        '23.56'
    );
}
add_action('admin_menu', 'wpbackupessentials_add_adminlink' );


function load_custom_wp_admin_style() {
		$plugin_url_path = plugin_dir_url( __FILE__ );
        wp_register_style( 'custom_wp_admin_css', $plugin_url_path . 'default.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


function wpbackupessentials_loadadminpage() {
	$wp_directory = get_home_path();
	$backup_location = $wp_directory . 'wp-content/wpbe_backups/';

	if (is_dir($backup_location)) {
		
	}
	else {
		@mkdir($backup_location);
	}	

	include(plugin_dir_path(__FILE__) . "functions.php");
	include(plugin_dir_path(__FILE__) . "interface-header.php");
	
	if(!isset($_GET['section'])) {
		include(plugin_dir_path(__FILE__) . 'interface-main.php');
	}
	else {
		$section = $_GET['section'];
		if ($section == "livebackup") {
			include("interface-livebackup.php");
		}		
		elseif ($section == "listbackups") {
			include("interface-listbackups.php");
		}
		elseif ($section == "restorebackups") {
			include("interface-restorebackups.php");
		}
		elseif ($section == "diags") {
			include("interface-diags.php");
		}		
		elseif ($section == "migrate") {
			include("interface-migrate.php");
		}
			
	}
}

?>