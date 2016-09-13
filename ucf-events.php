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


// TODO: do these includes need to be wrapped in the plugins_loaded action anymore?

add_action( 'plugins_loaded', function() {
	// if ( ! class_exists( 'UCF_Modular' ) ) {
	// 	wp_die(
	// 		__( 'This plugin requires the UCF Modular Framework plugin to be installed and activated.' ),
	// 		__( 'Error' ),
	// 		array( 'back_link' => true )
	// 	);
	// }

	include_once 'ucf-events-config.php';
	include_once 'ucf-events-feed.php';
	include_once 'ucf-events-common.php';
	include_once 'ucf-events-shortcode.php';
	include_once 'ucf-events-widget.php';

	// add_action( UCF_Modular::$slug . '_config', UCF_Modular::$config->add_shortcode( 'UCF_News_Shortcode' ) );

} );

?>
