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


if ( class_exists( 'UCF_Modular_Shortcode' ) && !class_exists( 'UCF_Events_Shortcode' ) ) {

	class UCF_Events_Shortcode extends UCF_Modular_Shortcode {
		public
			$name        = 'UCF Events Feed',
			$command     = 'ucf-events-feed',
			$description = 'Displays a events feed pulled from events.ucf.edu';

		function params() {
			$layouts = UCF_Events_Config::get_layouts();
			$defaults = UCF_Events_Config::get_option_defaults();

			return array(
				array(
					'name'      => 'Title',
					'id'        => 'title',
					'help_text' => 'The title to display before the events feed.',
					'type'      => 'text',
					'default'   => $defaults['title']
				),
				array(
					'name'      => 'Feed URL',
					'id'        => 'title',
					'help_text' => 'The URL from which feed data will be fetched from events.ucf.edu. Defaults to the Feed URL set in the plugin options page.',
					'type'      => 'text',
					'default'   => $defaults['feed_url']
				),
				array(
					'name'      => 'Layout',
					'id'        => 'layout',
					'help_text' => 'The layout to use to display the events items.',
					'type'      => 'dropdown',
					'choices'   => $layouts,
					'default'   => $defaults['layout']
				),
				array(
					'name'      => 'Number of Events',
					'id'        => 'limit',
					'help_text' => 'The number of events to show.',
					'type'      => 'number',
					'default'   => $defaults['limit']
				),
				array(
					'name'      => 'Offset Event Results',
					'id'        => 'offset',
					'help_text' => 'The number of event results that should be skipped. e.g., to skip the first event in the returned results, set the offset to "1".',
					'type'      => 'number',
					'default'   => $defaults['offset']
				)
			);
		}
	}

}
