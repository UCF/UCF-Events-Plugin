<?php
/**
 * Place common functions here.
 **/

if ( !class_exists( 'UCF_Events_Common' ) ) {

	class UCF_Events_Common {
		public function display_events( $items, $layout, $title, $display_type='default' ) {
			$include_css = UCF_Events_Config::get_option_or_default( 'include_css' );

			if ( $include_css ) {
				wp_enqueue_style( 'ucf_events_css', plugins_url( 'static/css/ucf-events.min.css', UCF_EVENTS__PLUGIN_DIR ), false, false, 'all' );
			}

			if ( has_action( 'ucf_events_display_' . $layout . '_before' ) ) {
				do_action( 'ucf_events_display_' . $layout . '_before', $items, $title, $display_type );
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
		// TODO unique filters for displaying display_type-specific titles
		ob_start();
	?>
		<div class="ucf-events ucf-events-classic">

			<?php if ( $display_type == 'widget' ): ?>

			<?php echo $title;  // Title is already formatted with heading by widget class ?>

			<?php else: ?>

			<h2 class="ucf-events-title"><?php echo $title; ?></h2>

			<?php endif; ?>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 3 );

}

if ( !function_exists( 'ucf_events_display_classic' ) ) {

	function ucf_events_display_classic( $items, $title ) {
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
