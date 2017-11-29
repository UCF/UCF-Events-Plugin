<?php
/**
 * The default functions for the classic layout
 **/

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

	function ucf_events_display_classic( $content, $items, $args, $display_type, $fallback_message='' ) {
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
			<span class="ucf-events-error"><?php echo $fallback_message; ?></span>
		<?php endif; ?>

		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_classic', 'ucf_events_display_classic', 10, 5 );

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
