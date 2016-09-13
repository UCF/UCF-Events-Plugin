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

	require_once 'ucf-events-config.php';
	require_once 'ucf-events-feed.php';
	require_once 'ucf-events-common.php';
	require_once 'ucf-events-shortcode.php';
	require_once 'ucf-events-widget.php';

	if ( class_exists( 'UCF_Modular_Shortcode' ) ) {
		// TODO register shortcode interface class here
	}

} );

?>
