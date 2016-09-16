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

	// TODO need a uninstall.php file

	require_once 'includes/ucf-events-config.php';
	require_once 'includes/ucf-events-feed.php';
	require_once 'includes/ucf-events-common.php';
	require_once 'includes/ucf-events-shortcode.php';
	require_once 'includes/ucf-events-widget.php';

	if ( class_exists( 'UCF_Modular_Shortcode' ) ) {
		// TODO register shortcode interface class here
	}

} );

?>
