<?php
/**
 * Handles the registration of the UCF Events Shortcode
 **/

if ( class_exists( 'UCF_Modular_Shortcode' ) ) {
	class UCF_Events_Shortcode extends UCF_Modular_Shortcode {
		public
			$name        = 'UCF Events Feed',
			$command     = 'ucf-events-feed',
			$description = 'Displays a events feed pulled from events.ucf.edu',
			$callback    = 'callback',
			$wysiwyg     = TRUE;

		function params() {
			$layouts = UCF_Events_Config::get_layouts();

			return array(
				array(
					'name'      => 'Title',
					'id'        => 'title',
					'help_text' => 'The title to display before the events feed',
					'type'      => 'text',
					'default'   => 'Events'
				),
				array(
					'name'      => 'Layout',
					'id'        => 'layout',
					'help_text' => 'The layout to use to display the events items',
					'type'      => 'dropdown',
					'choices'   => $layouts,
					'default'   => 'classic'
				),
				array(
					'name'      => 'Number of Events Items',
					'id'        => 'limit',
					'help_text' => 'The number of events items to show',
					'type'      => 'number',
					'default'   => '3'
				)
				// TODO other args
			);
		}

		function callback( $attr, $content='' ) {
			$attr = shortcode_atts( array(
				'title'    => 'Events',
				'layout'   => 'classic',
				'limit'    => 3
				// TODO other args
			), $attr );

			$title = $attr['title'];
			$layout = $attr['layout'];

			$args = array(
				'limit'    => $attr['limit'] ? (int) $attr['limit'] : 3
				// TODO other args
			);

			$items = UCF_Events_Feed::get_events_items( $args );
			echo UCF_Events_Common::display_events_items( $items, $layout, $title );
		}
	}
}


?>
