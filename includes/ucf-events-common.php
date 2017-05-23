<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Events_Common' ) ) {

	class UCF_Events_Common {
		public function display_events( $items, $layout, $title, $display_type='default' ) {

			if ( has_action( 'ucf_events_display_' . $layout . '_before' ) ) {
				do_action( 'ucf_events_display_' . $layout . '_before', $items, $title, $display_type );
			}

			if ( has_action( 'ucf_events_display_' . $layout . '_title' ) ) {
				do_action( 'ucf_events_display_' . $layout . '_title', $items, $title, $display_type );
			}

			if ( has_action( 'ucf_events_display_' . $layout  ) ) {
				do_action( 'ucf_events_display_' . $layout, $items, $title, $display_type );
			}

			if ( has_action( 'ucf_events_display_' . $layout . '_after' ) ) {
				do_action( 'ucf_events_display_' . $layout . '_after', $items, $title, $display_type );
			}
		}
	}
}

if ( !function_exists( 'ucf_events_display_classic_before' ) ) {

	function ucf_events_display_classic_before( $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-events ucf-events-classic">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_classic_title' ) ) {

	function ucf_events_display_classic_title( $items, $title, $display_type ) {
		$formatted_title = $title;

		switch ( $display_type ) {
			case 'widget':
				// title is already formatted at the widget level
				break;
			case 'default':
			default:
				$formatted_title = '<h2 class="ucf-events-title">' . $title . '</h2>';
				break;
		}

		echo $formatted_title;
	}

	add_action( 'ucf_events_display_classic_title', 'ucf_events_display_classic_title', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_classic' ) ) {

	function ucf_events_display_classic( $items, $title ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
		ob_start();
	?>
		<div class="ucf-events-list">

		<?php if ( $items ): ?>
			<div class="ucf-events-subheadings ucf-event-row">
				<div class="ucf-event-col ucf-event-when">
					<strong class="events-subheading">Date</strong>
				</div>
				<div class="ucf-event-col ucf-event-content">
					<strong class="ucf-events-subheading">Description</strong>
				</div>
			</div>

			<?php
			foreach( $items as $event ) :
				$starts = new DateTime( $event->starts );
			?>
			<div class="ucf-event ucf-event-row">
				<div class="ucf-event-col ucf-event-when">
					<time class="ucf-event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
						<span class="ucf-event-start-date"><?php echo $starts->format( 'M j' ); ?></span>
						<span class="ucf-event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
					</time>
				</div>
				<div class="ucf-event-col ucf-event-content">
					<a class="ucf-event-title" href="<?php echo $event->url; ?>">
						<?php echo $event->title; ?>
					</a>
					<a class="ucf-event-location" href="<?php echo $event->location_url; ?>">
						<?php echo $event->location; ?>
					</a>
				</div>
			</div>
			<?php endforeach; ?>

		<?php else: ?>
			<span class="ucf-events-error">No events found.</span>
		<?php endif; ?>

		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_classic_after' ) ) {

	function ucf_events_display_classic_after( $items, $title ) {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_classic_after', 'ucf_events_display_classic_after', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_modern_before' ) ) {

	function ucf_events_display_modern_before( $items, $title, $display_type ) {
		ob_start();
	?>
		<div class="ucf-events ucf-events-modern">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_modern_before', 'ucf_events_display_modern_before', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_modern_title' ) ) {

	function ucf_events_display_modern_title( $items, $title, $display_type ) {
		$formatted_title = $title;

		switch ( $display_type ) {
			case 'widget':
				// title is already formatted at the widget level
				break;
			case 'default':
			default:
				$formatted_title = '<h2 class="ucf-events-title h4 text-uppercase mb-4">' . $title . '</h2>';
				break;
		}

		echo $formatted_title;
	}

	add_action( 'ucf_events_display_modern_title', 'ucf_events_display_modern_title', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_modern' ) ) {

	function ucf_events_display_modern( $items, $title ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
		ob_start();
	?>
		<div class="ucf-events-list">

		<?php if ( $items ): ?>
			<?php
			$numItems = count( $items );
			$i = 0;
			foreach( $items as $event ) :
				$starts = new DateTime( $event->starts );
				$margin = ( ++$i === $numItems ) ? "" : "mb-4";
			?>
			<div class="ucf-event ucf-event-row <?php echo $margin ?>">
				<div class="ucf-event-when h5 text-uppercase text-primary font-weight-bold">
					<time class="ucf-event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
						<span class="ucf-event-start-date"><?php echo $starts->format( 'M j' ); ?></span>
						<span class="ucf-event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
					</time>
				</div>
				<div class="ucf-event-title-wrapper mb-1">
					<a class="ucf-event-title text-inverse font-weight-bold" href="<?php echo $event->url; ?>">
						<?php echo $event->title; ?>
					</a>
				</div>
				<div class="ucf-event-location-wrapper">
					<a class="ucf-event-location text-inverse" href="<?php echo $event->location_url; ?>">
						<?php echo $event->location; ?>
					</a>
				</div>
			</div>
			<?php endforeach; ?>

		<?php else: ?>
			<span class="ucf-events-error">No events found.</span>
		<?php endif; ?>

		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_modern', 'ucf_events_display_modern', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_modern_after' ) ) {

	function ucf_events_display_modern_after( $items, $title ) {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_modern_after', 'ucf_events_display_modern_after', 10, 3 );

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
