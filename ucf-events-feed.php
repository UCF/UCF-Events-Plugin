<?php
/**
 * Handles all feed related code.
 **/

class UCF_Events_Feed {
	public static function get_events_items( $args ) {
		// TODO check for transient data before fetching new content

		$args = array(
			'url'        => get_theme_mod( 'ucf_events_feed_url', 'https://events.ucf.edu/upcoming/feed.json' ), // TODO make option, not theme mod
			'limit'      => isset( $args['limit'] ) ? (int) $args['limit'] : 3,
			'offset'     => isset( $args['offset'] ) ? (int) $args['offset'] : null,
			// TODO other args
		);

		// Empty array of indexes with no value.
		$keys = array_keys( $args, NULL );

		foreach( $keys as $key ) {
			unset( $args[$key] );
		}

		// TODO build url with any extra options?
		$req_url = $args['url'];

		$opts = array(
			'http' => array(
				'timeout' => 15
			)
		);

		$context = stream_context_create( $opts );

		$file = file_get_contents( $req_url, false, $context );

		$items = json_decode( $file );

		// Force results count limit
		if ( $items && count( $items ) > $args['limit'] ) {
			$items = array_slice( $items, 0, $args['limit'] );
		}

		// TODO set transient data here

		return $items;
	}
}

?>
