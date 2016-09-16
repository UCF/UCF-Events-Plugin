<?php
/**
 * Handles plugin configuration
 */

// TODO move to custom options page in admin

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
				'use_rich_snippets'    => false  // TODO implement this (currently does nothing)
			);

		public static function ucf_events_add_customizer_sections( $wp_customize ) {
			$wp_customize->add_section(
				self::$option_prefix . 'plugin_settings',
				array(
					'title' => 'UCF Events Plugin Settings'
				)
			);
		}

		public static function ucf_events_add_customizer_settings( $wp_customize ) {
			$wp_customize->add_setting(
				self::$option_prefix . 'feed_url',
				array(
					'type'    => 'option',
					'default' => self::$option_defaults['feed_url']
				)
			);
			$wp_customize->add_control(
				self::$option_prefix . 'feed_url',
				array(
					'type'        => 'text',
					'label'       => 'UCF Events JSON Feed URL',
					'description' => 'The default URL to use for event feeds from events.ucf.edu.',
					'section'     => self::$option_prefix . 'plugin_settings'
				)
			);

			$wp_customize->add_setting(
				self::$option_prefix . 'include_css',
				array(
					'type'    => 'option',
					'default' => self::$option_defaults['include_css']
				)
			);
			$wp_customize->add_control(
				self::$option_prefix . 'include_css',
				array(
					'type'        => 'checkbox',
					'label'       => 'Include Default CSS',
					'description' => 'Include the default css stylesheet for event results within the theme.<br>Leave this checkbox checked unless your theme provides custom styles for event results.',
					'section'     => self::$option_prefix . 'plugin_settings'
				)
			);

			$wp_customize->add_setting(
				self::$option_prefix . 'use_rich_snippets',
				array(
					'type'    => 'option',
					'default' => self::$option_defaults['use_rich_snippets']
				)
			);
			$wp_customize->add_control(
				self::$option_prefix . 'use_rich_snippets',
				array(
					'type'        => 'checkbox',
					'label'       => 'Use rich snippets',
					'description' => 'Include rich snippet data for displayed events. <a target="_blank" href="https://developers.google.com/search/docs/guides/intro-structured-data">More info</a>',
					'section'     => self::$option_prefix . 'plugin_settings'
				)
			);

			$wp_customize->add_setting(
				self::$option_prefix . 'transient_expiration',
				array(
					'type'    => 'option',
					'default' => self::$option_defaults['transient_expiration']
				)
			);
			$wp_customize->add_control(
				self::$option_prefix . 'transient_expiration',
				array(
					'type'        => 'text',
					'label'       => 'Transient data expiration',
					'description' => 'The length of time, in hours, event data should be cached before fresh data is fetched. Updates to this value will not take effect until after any existing transient events data expires.',
					'section'     => self::$option_prefix . 'plugin_settings'
				)
			);
		}

		public static function get_layouts() {
			$layouts = array(
				'classic' => 'Classic Layout',
			);

			$layouts = apply_filters( self::$option_prefix . 'get_layouts', $layouts );

			return $layouts;
		}

		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the customizer.
		 *
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			// Apply default values configurable within the customizer:
			$customizer_defaults = array(
				'feed_url'             => get_option( self::$option_prefix . 'feed_url' ),
				'include_css'          => get_option( self::$option_prefix . 'include_css' ),
				'use_rich_snippets'    => get_option( self::$option_prefix . 'use_rich_snippets' ),
				'transient_expiration' => get_option( self::$option_prefix . 'transient_expiration' )
			);

			$customizer_defaults = self::format_options( $customizer_defaults );

			// Force customizer options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $customizer_defaults );

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
					case 'use_rich_snippets':
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
	}

	add_action( 'customize_register', array( 'UCF_Events_Config', 'ucf_events_add_customizer_sections' ) );
	add_action( 'customize_register', array( 'UCF_Events_Config', 'ucf_events_add_customizer_settings' ) );

}
