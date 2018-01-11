<?php
/*
Plugin Name: UCF Events
Description: Contains shortcode and widget for displaying UCF Events Feeds
Version: 2.0.1
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'UCF_EVENTS__PLUGIN_FILE', __FILE__ );

require_once 'includes/ucf-events-config.php';
require_once 'includes/ucf-events-feed.php';
require_once 'includes/ucf-events-common.php';
require_once 'includes/ucf-events-shortcode.php';
require_once 'includes/ucf-events-widget.php';

require_once 'layouts/ucf-events-classic.php';
require_once 'layouts/ucf-events-modern.php';


/**
 * Activation/deactivation hooks
 **/
if ( !function_exists( 'ucf_events_plugin_activation' ) ) {
	function ucf_events_plugin_activation() {
		return UCF_Events_Config::add_options();
	}
}

if ( !function_exists( 'ucf_events_plugin_deactivation' ) ) {
	function ucf_events_plugin_deactivation() {
		return;
	}
}

register_activation_hook( UCF_EVENTS__PLUGIN_FILE, 'ucf_events_plugin_activation' );
register_deactivation_hook( UCF_EVENTS__PLUGIN_FILE, 'ucf_events_plugin_deactivation' );


/**
 * Plugin-dependent actions:
 **/
add_action( 'plugins_loaded', function() {

	if ( class_exists( 'WP_SCIF_Shortcode' ) ) {
		add_filter( 'wp_scif_add_shortcode', 'ucf_events_shortcode_interface', 10, 1 );
		add_filter( 'wp_scif_get_preview_stylesheets', 'ucf_events_shortcode_interface_styles', 10, 1 );
	}

} );

?>
