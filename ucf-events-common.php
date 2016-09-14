<?php
/**
 * Place common functions here.
 **/

class UCF_Events_Common {
	public function display_events( $items, $layout, $title, $display_type='default' ) {
		if ( get_option( 'ucf_events_include_css', False ) ) {
			wp_enqueue_style( 'ucf_events_css', plugins_url( 'static/css/ucf-events.min.css', __FILE__ ), false, false, 'all' );
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


function ucf_events_display_classic_before( $items, $title, $display_type ) {
	ob_start();
?>
	<aside class="ucf-events ucf-events-classic">

	<?php if ( $display_type == 'widget' ): ?>

	<h3 class="events-title widget-title"><?php echo $title; ?></h3>

	<?php else: ?>

	<h2 class="events-title"><?php echo $title; ?></h2>

	<?php endif; ?>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 3 );


function ucf_events_display_classic( $items, $title ) {
	ob_start();
?>
	<div class="events">

	<?php if ( $items ): ?>
		<div class="events-subheadings event-row">
			<div class="event-col event-when">
				<strong class="events-subheading">Date</strong>
			</div>
			<div class="event-col event-content">
				<strong class="events-subheading">Description</strong>
			</div>
		</div>

		<?php
		foreach( $items as $event ) :
			$starts = new DateTime( $event->starts );
		?>
		<div class="event event-row">
			<div class="event-col event-when">
				<time class="event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
					<span class="event-start-date"><?php echo $starts->format( 'M j' ); ?></span>
					<span class="event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
				</time>
			</div>
			<div class="event-col event-content">
				<a class="event-title" href="<?php echo $event->url; ?>">
					<?php echo $event->title; ?>
				</a>
				<a class="event-location" href="<?php echo $event->location_url; ?>">
					<?php echo $event->location; ?>
				</a>
			</div>
		</div>
		<?php endforeach; ?>

	<?php else: ?>
		<span class="events-error">No events found.</span>
	<?php endif; ?>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 3 );


function ucf_events_display_classic_after( $items, $title ) {
	ob_start();
?>
	</aside>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_after', 'ucf_events_display_classic_after', 10, 3 );

?>
