<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Events_Common' ) ) {

	class UCF_Events_Common {
		public static function display_events( $items, $layout, $args, $display_type='default', $content='' ) {
			ob_start();

			// Before
			$layout_before = ucf_events_display_classic_before( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_events_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_events_display_' . $layout . '_before', $layout_before, $items, $args, $display_type );
			}
			echo $layout_before;

			// Title
			$layout_title = ucf_events_display_classic_title( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_events_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_events_display_' . $layout . '_title', $layout_title, $items, $args, $display_type );
			}
			echo $layout_title;

			// Main content/loop
			$layout_content = ucf_events_display_classic( '', $items, $args, $display_type, $content );
			if ( has_filter( 'ucf_events_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_events_display_' . $layout, $layout_content, $items, $args, $display_type, $content );
			}
			echo $layout_content;

			// After
			$layout_after = ucf_events_display_classic_after( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_events_display_' . $layout . '_after' ) ) {
				$layout_after = apply_filters( 'ucf_events_display_' . $layout . '_after', $layout_after, $items, $args, $display_type );
			}
			echo $layout_after;

			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'ucf_events_enqueue_assets' ) ) {
	function ucf_events_enqueue_assets() {
		$include_css = UCF_Events_Config::get_option_or_default( 'include_css' );

		if ( $include_css ) {
			wp_enqueue_style( 'ucf_events_css', plugins_url( 'static/css/ucf-events.min.css', UCF_EVENTS__PLUGIN_FILE ), false, false, 'all' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'ucf_events_enqueue_assets' );
}

if ( ! function_exists( 'ucf_events_whitelist_host' ) ) {
	function ucf_events_whitelist_host( $allow, $host, $url ) {
		$default_url = UCF_Events_Config::get_option_or_default( 'feed_url' );
		$default_host = parse_url( $default_url, PHP_URL_HOST );
		if ( $default_host === $host ) {
			$allow = true;
		}

		return $allow;
	}

	add_filter( 'http_request_host_is_external', 'ucf_events_whitelist_host', 10, 3 );
}
