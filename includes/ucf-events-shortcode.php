<?php
/**
 * Handles the registration of the UCF Events Shortcode
 **/

if ( !function_exists( 'sc_ucf_events' ) ) {

	function sc_ucf_events( $atts, $content='' ) {
		$defaults = UCF_Events_Config::get_option_defaults();

		// NOTE: some attributes in $atts may have no effect within the shortcode.
		$atts = shortcode_atts( $defaults, $atts, 'sc_ucf_events' );
		$atts = UCF_Events_Config::format_options( $atts );

		$items = UCF_Events_Feed::get_events( $atts );

		ob_start();

		echo UCF_Events_Common::display_events( $items, $atts['layout'], $atts, 'shortcode', $content );

		return ob_get_clean(); // Shortcode must *return*!  Do not echo the result!
	}
	add_shortcode( 'ucf-events', 'sc_ucf_events' );

}

if ( ! function_exists( 'ucf_events_shortcode_interface' ) ) {
	function ucf_events_shortcode_interface( $shortcodes ) {
		$settings = array(
			'command' => 'ucf-events',
			'name'    => 'UCF Event List',
			'desc'    => 'Displays a list of events.',
			'content' => false,
			'preview' => true,
			'fields'  => array(
				array(
					'param'    => 'title',
					'name'     => 'Title',
					'desc'     => 'The title to display above the events list.',
					'type'     => 'text'
				),
				array(
					'param'    => 'layout',
					'name'     => 'Layout',
					'desc'     => 'The layout used to display the events.',
					'type'     => 'select',
					'options'  => UCF_Events_Config::get_layouts()
				),
				array(
					'param'    => 'feed_url',
					'name'     => 'Feed URL',
					'desc'     => 'The url to fetch the events from.',
					'type'     => 'text'
				),
				array(
					'param'    => 'limit',
					'name'     => 'Limit',
					'desc'     => 'The number of events to show.',
					'type'     => 'text'
				),
				array(
					'param'    => 'offset',
					'name'     => 'Offset',
					'desc'     => 'The number of events to skip.',
					'type'     => 'text'
				)
			)
		);

		$shortcodes[] = $settings;

		return $shortcodes;
	}
}

if ( ! function_exists( 'ucf_events_shortcode_interface_styles' ) ) {
	function ucf_events_shortcode_interface_styles( $stylesheets ) {
		$stylesheets[] = plugins_url( 'static/css/ucf-events.min.css', UCF_EVENTS__PLUGIN_FILE );
		return $stylesheets;
	}
}
