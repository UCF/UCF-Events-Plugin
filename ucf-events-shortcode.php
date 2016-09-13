<?php
/**
 * Handles the registration of the UCF Events Shortcode
 **/

function sc_ucf_events( $atts, $content='' ) {
	$defaults = UCF_Events_Config::get_default_options();

	$atts = shortcode_atts( $defaults, $atts, 'sc_ucf_events' );
	$atts = UCF_Events_Config::format_options( $atts );

	$args = array(
		'limit'    => $atts['limit']
		// TODO other args
	);

	$items = UCF_Events_Feed::get_events_items( $args );
	echo UCF_Events_Common::display_events_items( $items, $atts['layout'], $atts['title'] );
}
add_shortcode( 'ucf-events', 'sc_ucf_events' );


if ( class_exists( 'UCF_Modular_Shortcode' ) ) {
	class UCF_Events_Shortcode extends UCF_Modular_Shortcode {
		public
			$name        = 'UCF Events Feed',
			$command     = 'ucf-events-feed',
			$description = 'Displays a events feed pulled from events.ucf.edu';

		function params() {
			$layouts = UCF_Events_Config::get_layouts();
			$defaults = UCF_Events_Config::get_default_options();

			return array(
				array(
					'name'      => 'Title',
					'id'        => 'title',
					'help_text' => 'The title to display before the events feed',
					'type'      => 'text',
					'default'   => $defaults['title']
				),
				array(
					'name'      => 'Layout',
					'id'        => 'layout',
					'help_text' => 'The layout to use to display the events items',
					'type'      => 'dropdown',
					'choices'   => $layouts,
					'default'   => $defaults['layout']
				),
				array(
					'name'      => 'Number of Events Items',
					'id'        => 'limit',
					'help_text' => 'The number of events items to show',
					'type'      => 'number',
					'default'   => $defaults['limit']
				)
				// TODO other args
			);
		}
	}
}


?>
