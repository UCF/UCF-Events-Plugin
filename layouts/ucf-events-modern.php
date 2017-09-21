<?php
/**
 * The default functions for both modern and modern_nodesc layouts
 **/

// Modern - Before
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

// Modern - Title
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

// Modern - main loop
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

// Modern - after
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

// Modern No Desc. - Before
if ( !function_exists( 'ucf_events_display_modern_nodesc_before' ) ) {

	function ucf_events_display_modern_nodesc_before( $content, $items, $args, $display_type ) {
		ob_start();
	?>
		<div class="ucf-events ucf-events-modern-nodesc">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_modern_nodesc_before', 'ucf_events_display_modern_nodesc_before', 10, 4 );

}

// Modern No Desc. - Title
add_filter( 'ucf_events_display_modern_nodesc_title', 'ucf_events_display_modern_title', 10, 4 );

// Modern No Desc. - main loop
if ( !function_exists( 'ucf_events_display_modern_nodesc' ) ) {

	function ucf_events_display_modern_nodesc( $content, $items, $args, $display_type ) {
		if ( ! is_array( $items ) ) { $items = array( $items ); }
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
			</div>
			<?php endforeach; ?>

		<?php else: ?>
			<span class="ucf-events-error">No events found.</span>
		<?php endif; ?>

		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_events_display_modern_nodesc', 'ucf_events_display_modern_nodesc', 10, 4 );

}

// Modern No Desc. - After
add_filter( 'ucf_events_display_modern_nodesc_after', 'ucf_events_display_modern_after', 10, 4 );
