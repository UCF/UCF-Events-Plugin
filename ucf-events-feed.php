<?php
/**
 * Handles all feed related code.
 **/

class UCF_Events_Feed {
	public static function get_events( $args ) {
		// TODO check for transient data before fetching new content

		$args = UCF_Events_Config::apply_default_options( $args );

		// Fetch new degree data
		$opts = array(
			'http' => array(
				'timeout' => 15
			)
		);
		$context = stream_context_create( $opts );
		$file = file_get_contents( $args['feed_url'], false, $context );
		$items = json_decode( $file );

		// Enforce limit and offset
		if ( $items ) {
			$items = array_slice( $items, $args['offset'], $args['limit'] );
		}

		// TODO set transient data here

		return $items;
	}
}

?>
