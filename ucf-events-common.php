<?php
/**
 * Place common functions here.
 **/

class UCF_Events_Common {
	public function display_events( $items, $layout, $title ) {
		if ( get_option( 'ucf_events_include_css', False ) ) {
			wp_enqueue_style( 'ucf_events_css', plugins_url( 'static/css/ucf-events.min.css', __FILE__ ), false, false, 'all' );
		}

		if ( has_action( 'ucf_events_display_' . $layout . '_before' ) ) {
			do_action( 'ucf_events_display_' . $layout . '_before', $items, $title );
		}

		if ( has_action( 'ucf_events_display_' . $layout  ) ) {
			do_action( 'ucf_events_display_' . $layout, $items, $title );
		}

		if ( has_action( 'ucf_events_display_' . $layout . '_after' ) ) {
			do_action( 'ucf_events_display_' . $layout . '_after', $items, $title );
		}
	}
}


function ucf_events_display_classic_before( $items, $title ) {
	ob_start();
?>
	<div class="events events-classic">
		<h2 class="events-title"><?php echo $title; ?></h2>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 2 );


function ucf_events_display_classic( $items, $title ) {
	ob_start();
?>
	<div class="events-items">
<?php
	if ( $items ):
		foreach( $items as $event ) :
			$starts = new DateTime( $event->starts );
?>
		<div class="events-item">
			<div class="events-item-when">
				<time class="event-start-datetime" datetime="<?php echo $starts->format( 'c' ); ?>">
					<span class="event-start-date"><?php echo $starts->format( 'F j' ); ?></span>
					<span class="event-start-year"><?php echo $starts->format( 'Y' ); ?></span>
					<span class="event-start-time"><?php echo $starts->format( 'g:i a' ); ?></span>
				</time>
			</div>
			<div class="events-item-content">
				<a class="event-title" href="<?php echo $event->url; ?>">
					<?php echo $event->title; ?>
				</a>
				<a class="event-location" href="<?php echo $event->location_url; ?>">
					<?php echo $event->location; ?>
				</a>
				<div class="event-description">
					<?php echo $event->description; ?>
				</div>
			</div>
		</div>
<?php
		endforeach;
	else:
?>
		<span class="events-error">No events found.</span>
<?php
	endif;

	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 2 );


function ucf_events_display_classic_after( $items, $title ) {
	ob_start();
?>
	</div>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_after', 'ucf_events_display_classic_after', 10, 2 );

?>
