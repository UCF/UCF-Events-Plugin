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

		echo UCF_Events_Common::display_events( $items, $atts['layout'], $atts['title'], 'shortcode' );

		return ob_get_clean(); // Shortcode must *return*!  Do not echo the result!
	}
	add_shortcode( 'ucf-events', 'sc_ucf_events' );

}

if ( ! function_exists( 'ucf_events_shortcode_interface' ) ) {
	function ucf_events_shortcode_interface( $shortcodes ) {
		$fields = array(
			array(
				'label'       => 'Title',
				'attr'        => 'title',
				'description' => 'The title to display above the events list.',
				'encode'      => false,
				'type'        => 'text'
			),
			array(
				'label'       => 'Layout',
				'attr'        => 'layout',
				'description' => 'The layout used to display the events.',
				'type'        => 'select',
				'options'     => UCF_Events_Config::get_layouts('ARRAY_A')
			),
			array(
				'label'       => 'Feed URL',
				'attr'        => 'feed_url',
				'description' => 'The url to fetch the events from.',
				'type'        => 'url',
				'meta'        => array(
					'placeholder' => 'https://events.ucf.edu/upcoming/feed.json'
				)
			),
			array(
				'label'       => 'Limit',
				'attr'        => 'limit',
				'description' => 'The number of events to display.',
				'type'        => 'number'
			),
			array(
				'label'       => 'Offset',
				'attr'        => 'offset',
				'description' => 'The number of events to skip.',
				'type'        => 'number'
			)
		);

		$args = array(
			'label'         => 'UCF Event List',
			'listItemImage' => 'dashicons-calendar',
			'inner_content' => false,
			'attrs'         => $fields
		);

		shortcode_ui_register_for_shortcode( 'ucf-events', $args );
	}
}

if ( ! function_exists( 'ucf_events_wysiwyg_styles' ) ) {
	function ucf_events_wysiwyg_styles() {
		if ( UCF_Events_Config::get_option_or_default( 'include_css' ) ) {
			add_editor_style( plugins_url( 'static/css/ucf-events.min.css', UCF_EVENTS__PLUGIN_FILE ) );
		}
	}
}
