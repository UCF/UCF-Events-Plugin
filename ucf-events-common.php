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
	<div class="ucf-events ucf-events-classic">

		<?php if ( $display_type == 'widget' ): ?>

		<h3 class="ucf-events-title widget-title"><?php echo $title; ?></h3>

		<?php else: ?>

		<h2 class="ucf-events-title"><?php echo $title; ?></h2>

		<?php endif; ?>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_before', 'ucf_events_display_classic_before', 10, 3 );


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
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 3 );


function ucf_events_display_classic_after( $items, $title ) {
	ob_start();
?>
	</div>
<?php
	echo ob_get_clean();
}

add_action( 'ucf_events_display_classic_after', 'ucf_events_display_classic_after', 10, 3 );

?>
