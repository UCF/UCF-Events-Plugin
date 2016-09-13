<?php
/**
 * Defines the events widget
 **/

class UCF_Events_Widget extends WP_Widget {
	/**
	 * Sets up the widget
	 **/
	public function __construct() {
		$widget_opts = array(
			'classname'   => 'ucf_events',
			'description' => 'UCF Events Widget'
		);
		parent::__construct( 'ucf_events_widget', 'UCF Events Widget', $widget_opts );
	}

	/**
	 * Returns an array of $instance options with defaults applied.
	 * @param array $instance
	 **/
	public function get_instance_options( $instance ) {
		return UCF_Events_Config::apply_default_options( $instance );
	}

	/**
	 * Outputs the content of the widget
	 * @param array $args
	 * @param array $instance
	 **/
	public function widget( $args, $instance ) {
		$options = $this->get_instance_options( $instance );

		$items = UCF_Events_Feed::get_events_items( array(
			'title'    => $options['title'],
			'limit'    => $options['limit']
			// TODO other args
		) );

		ob_start();
?>
		<aside class="widget ucf-events-widget">
<?php
		UCF_Events_Common::display_events_items( $items, $options['layout'], $options['title'] );
?>
		</aside>
<?php
		echo ob_get_clean();
	}

	public function form( $instance ) {
		$options = $this->get_instance_options( $instance );

		$title  = $options['title'];
		$limit  = $options['limit'];
		$layout = $options['layout'];
		// TODO other args
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php echo __( 'Select Layout' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="text">
			<?php foreach( UCF_Events_Config::get_layouts() as $key=>$value ) : ?>
				<option value="<?php echo $key; ?>" <?php echo ( $layout == $key ) ? 'selected' : ''; ?>><?php echo $value; ?></option>
			<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo __( 'Limit results' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>" >
		</p>
<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $this->get_instance_options( $new_instance );
		return $instance;
	}
}

add_action( 'widgets_init',
	create_function( '', 'return register_widget( "UCF_Events_Widget" );' )
);

?>
