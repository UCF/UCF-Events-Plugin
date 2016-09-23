<?php
/**
 * Handles plugin configuration
 */

if ( !class_exists( 'UCF_Events_Config' ) ) {

	class UCF_Events_Config {
		public static
			$option_prefix = 'ucf_events_',
			$option_defaults = array(
				'title'                => 'Events',
				'layout'               => 'classic',
				'feed_url'             => 'http://events.ucf.edu/upcoming/feed.json',
				'limit'                => 3,
				'offset'               => 0,
				'include_css'          => true,
				'transient_expiration' => 3,  // hours
			);

		public static function get_layouts() {
			$layouts = array(
				'classic' => 'Classic Layout',
			);

			$layouts = apply_filters( self::$option_prefix . 'get_layouts', $layouts );

			return $layouts;
		}

		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the options page.
		 *
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			// Apply default values configurable within the options page:
			$configurable_defaults = array(
				'feed_url'             => get_option( self::$option_prefix . 'feed_url' ),
				'include_css'          => get_option( self::$option_prefix . 'include_css' ),
				'transient_expiration' => get_option( self::$option_prefix . 'transient_expiration' )
			);

			$configurable_defaults = self::format_options( $configurable_defaults );

			// Force configurable options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}

		/**
		 * Returns an array with plugin defaults applied.
		 *
		 * @param array $list
		 * @param boolean $list_keys_only Modifies results to only return array key
		 *                                values present in $list.
		 * @return array
		 **/
		public static function apply_option_defaults( $list, $list_keys_only=false ) {
			$defaults = self::get_option_defaults();
			$options = array();

			if ( $list_keys_only ) {
				foreach ( $list as $key => $val ) {
					$options[$key] = !empty( $val ) ? $val : $defaults[$key];
				}
			}
			else {
				$options = array_merge( $defaults, $list );
			}

			$options = self::format_options( $options );

			return $options;
		}

		/**
		 * Performs typecasting, sanitization, etc on an array of plugin options.
		 *
		 * @param array $list
		 * @return array
		 **/
		public static function format_options( $list ) {
			foreach ( $list as $key => $val ) {
				switch ( $key ) {
					case 'limit':
					case 'offset':
						$list[$key] = intval( $val );
						break;
					case 'transient_expiration':
						$list[$key] = floatval( $val );
						break;
					case 'include_css':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 *
		 * @param $option_name
		 * @return mixed
		 **/
		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name = self::$option_prefix . $option_name_no_prefix;

			$option = get_option( $option_name );
			$option_formatted = self::apply_option_defaults( array(
				$option_name_no_prefix => $option
			), true );

			return $option_formatted[$option_name_no_prefix];
		}

		/**
		 * Initializes setting registration with the Settings API.
		 **/
		public static function settings_init() {
			// Register settings
			register_setting( 'ucf_events', self::$option_prefix . 'feed_url' );
			register_setting( 'ucf_events', self::$option_prefix . 'include_css' );
			register_setting( 'ucf_events', self::$option_prefix . 'transient_expiration' );

			// Register setting sections
			add_settings_section(
				'ucf_events_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_events' // settings page slug
			);

			// Register fields
			add_settings_field(
				self::$option_prefix . 'feed_url',
				'UCF Events JSON Feed URL',  // formatted field title
				array( 'UCF_Events_Config', 'display_settings_field' ), // display callback
				'ucf_events',  // settings page slug
				'ucf_events_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'feed_url',
					'description' => 'The default URL to use for event feeds from events.ucf.edu.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'include_css',
				'Include Default CSS',  // formatted field title
				array( 'UCF_Events_Config', 'display_settings_field' ),  // display callback
				'ucf_events',  // settings page slug
				'ucf_events_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_css',
					'description' => 'Include the default css stylesheet for event results within the theme.<br>Leave this checkbox checked unless your theme provides custom styles for event results.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'transient_expiration',
				'Transient Data Expiration',  // formatted field title
				array( 'UCF_Events_Config', 'display_settings_field' ),  // display callback
				'ucf_events',  // settings page slug
				'ucf_events_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'transient_expiration',
					'description' => 'The length of time, in hours, event data should be cached before fresh data is fetched. Updates to this value will not take effect until after any existing transient events data expires.',
					'type'        => 'number'
				)
			);
		}

		/**
		 * Displays an individual setting's field markup.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';

			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'number':
					ob_start();
				?>
					<input type="number" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}
		?>

		<?php
			echo $markup;
		}


		/**
		 * Registers the settings page to display in the WordPress admin.
		 **/
		public static function add_options_page() {
			$page_title = 'UCF Events Settings';
			$menu_title = 'UCF Events';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_events';
			$callback   = array( 'UCF_Events_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}


		/**
		 * Displays the plugin's settings page form.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_events' );
				do_settings_sections( 'ucf_events' );
				submit_button();
				?>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}

	}

}
