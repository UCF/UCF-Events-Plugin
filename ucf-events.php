<?php
/*
Plugin Name: UCF Events
Description: Contains shortcode and widget for displaying UCF Events Feeds
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action( 'plugins_loaded', function() {

	define( 'UCF_EVENTS__PLUGIN_DIR', __FILE__ );

	require_once 'includes/ucf-events-config.php';
	require_once 'includes/ucf-events-feed.php';
	require_once 'includes/ucf-events-common.php';
	require_once 'includes/ucf-events-shortcode.php';
	require_once 'includes/ucf-events-widget.php';

	// Register actions
	add_action( 'admin_init', array( 'UCF_Events_Config', 'settings_init' ) );
	add_action( 'admin_menu', array( 'UCF_Events_Config', 'add_options_page' ) );

	if ( class_exists( 'UCF_Modular_Shortcode' ) ) {
		// TODO register shortcode interface class here
	}

} );

?>
