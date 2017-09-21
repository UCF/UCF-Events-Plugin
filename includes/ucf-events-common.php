<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Events_Common' ) ) {

	class UCF_Events_Common {
		public static function display_events( $items, $layout, $args, $display_type='default' ) {
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
			$layout_content = ucf_events_display_classic( '', $items, $args, $display_type );
			if ( has_filter( 'ucf_events_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_events_display_' . $layout, $layout_content, $items, $args, $display_type );
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

if ( !function_exists( 'ucf_events_display_classic_before' ) ) {

	function ucf_events_display_classic_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-events ucf-events-classic">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_classic_title' ) ) {

	function ucf_events_display_classic_title( $content, $items, $args, $display_type ) {
		$formatted_title = $args['title'];

		switch( $display_type ) {
			case 'widget':
				break;
			case 'default':
			default:
				if ( $formatted_title ) {
					$formatted_title = '<h2 class="ucf-events-title">' . $formatted_title . '</h2>';
				}
				break;
		}

		return $formatted_title;
	}

	add_filter( 'ucf_events_display_classic_title', 'ucf_events_display_classic_title', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_classic' ) ) {

	function ucf_events_display_classic( $content, $items, $args, $display_type ) {
		if ( $items && ! is_array( $items ) ) { $items = array( $items ); }
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
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_classic_after' ) ) {

	function ucf_events_display_classic_after( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_classic_after', 'ucf_events_display_classic_after', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_modern_before' ) ) {

	function ucf_events_display_modern_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-events ucf-events-modern">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_modern_before', 'ucf_events_display_modern_before', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_modern_title' ) ) {

	function ucf_events_display_modern_title( $content, $items, $args, $display_type ) {
		$formatted_title = $args['title'];

		switch( $display_type ) {
			case 'widget':
				break;
			case 'default':
			default:
				if ( $formatted_title ) {
					$formatted_title = '<h2 class="ucf-events-title">' . $formatted_title . '</h2>';
				}
				break;
		}

		return $formatted_title;
	}

	add_filter( 'ucf_events_display_modern_title', 'ucf_events_display_modern_title', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_modern' ) ) {

	function ucf_events_display_modern( $content, $items, $args, $display_type ) {
		if ( $items && ! is_array( $items ) ) { $items = array( $items ); }
		ob_start();
	?>
		<div class="ucf-events-list">

		<?php if ( $items ): ?>
			<?php
			$num_items = count( $items ) - 1;
			foreach( $items as $i => $event ) :
				$starts = new DateTime( $event->starts );
				$margin = ( $i === $num_items ) ? "" : " ucf-event-row-margin";
			?>
			<div class="ucf-event ucf-event-row<?php echo $margin; ?>">
				<div class="ucf-event-when">
					<time class="ucf-event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
						<span class="ucf-event-start-date"><?php echo $starts->format( 'M j' ); ?></span>
						<span class="ucf-event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
					</time>
				</div>
				<div class="ucf-event-title-wrapper">
					<a class="ucf-event-title" href="<?php echo $event->url; ?>">
						<?php echo $event->title; ?>
					</a>
				</div>
				<div class="ucf-event-description-wrapper">
					<?php echo wp_trim_words( $event->description, 40, '&hellip;' ); ?>
				</div>
			</div>
			<?php endforeach; ?>

		<?php else: ?>
			<span class="ucf-events-error">No events found.</span>
		<?php endif; ?>

		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_modern', 'ucf_events_display_modern', 10, 4 );

}

if ( !function_exists( 'ucf_events_display_modern_after' ) ) {

	function ucf_events_display_modern_after( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_modern_after', 'ucf_events_display_modern_after', 10, 4 );

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
