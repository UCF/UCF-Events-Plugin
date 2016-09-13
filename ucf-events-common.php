<?php
/**
 * Place common functions here.
 **/

class UCF_Events_Common {
	public function display_events_items( $items, $layout, $title ) {
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
	<div class="events classic">
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
	foreach( $items as $item ) :
?>
		<div class="events-item">
			<?php // TODO event content ?>
		</div>
<?php
	endforeach;

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
