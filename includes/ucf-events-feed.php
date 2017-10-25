<?php
/**
 * Handles all feed related code.
 **/

if ( !class_exists( 'UCF_Events_Feed' ) ) {

	class UCF_Events_Feed {
		public static function get_events( $args ) {
			$args           = UCF_Events_Config::apply_option_defaults( $args );
			$feed_url       = $args['feed_url'];
			$transient_name = self::get_transient_name( $feed_url );
			$items          = get_transient( $transient_name );
			$expiration     = $args['transient_expiration'] * HOUR_IN_SECONDS;

			if ( !$items ) {
				// Fetch new degree data
				$response = wp_safe_remote_get( $feed_url, array( 'timeout' => 15 ) );

				if ( is_array( $response ) ) {
					$items = json_decode( wp_remote_retrieve_body( $response ) );
				}
				else {
					$items = false;
				}

				// Store new transient data
				set_transient( $transient_name, $items, $expiration );
			}

			// Enforce limit and offset
			if ( $items ) {
				$items = array_slice( $items, $args['offset'], $args['limit'] );
			}

			return $items;
		}

		private static function get_transient_name( $url ) {
			return 'ucf_events_' . md5( $url );
		}
	}

}
