<?php
/**
 * Defines the events widget
 **/

if ( !class_exists( 'UCF_Events_Widget' ) ) {

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
		 * Outputs the content of the widget
		 * @param array $args
		 * @param array $instance
		 **/
		public function widget( $args, $instance ) {
			$options = UCF_Events_Config::apply_option_defaults( $instance );

			$items = UCF_Events_Feed::get_events( $options );
			$title = apply_filters( 'widget_title', $options['title'], $this->id_base );
			$title = $args['before_title'] . $title . $args['after_title'];

			ob_start();

			echo $args['before_widget'];

			UCF_Events_Common::display_events( $items, $options['layout'], $title, 'widget' );

			echo $args['after_widget'];

			echo ob_get_clean();
		}

		public function form( $instance ) {
			$options = UCF_Events_Config::apply_option_defaults( $instance );

			$title     = $options['title'];
			$feed_url  = $options['feed_url'];
			$limit     = $options['limit'];
			$layout    = $options['layout'];
			$offset    = $options['offset'];
			// TODO other args?
	?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Title' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'feed_url' ) ); ?>"><?php echo __( 'Feed URL' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'feed_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'feed_url' ) ); ?>" type="text" value="<?php echo esc_attr( $feed_url ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php echo __( 'Select Layout' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" type="text">
				<?php foreach( UCF_Events_Config::get_layouts() as $key=>$value ) : ?>
					<option value="<?php echo $key; ?>" <?php echo ( $layout == $key ) ? 'selected' : ''; ?>><?php echo $value; ?></option>
				<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo __( 'Limit Results' ); ?>:</label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>" >
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php echo __( 'Offset Results' ); ?>:</label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo esc_attr( $offset ); ?>" >
			</p>
	<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = UCF_Events_Config::apply_option_defaults( $new_instance, true );
			return $instance;
		}
	}

	add_action( 'widgets_init',
		create_function( '', 'return register_widget( "UCF_Events_Widget" );' )
	);

}
