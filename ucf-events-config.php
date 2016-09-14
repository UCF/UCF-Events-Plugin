<?php
/**
 * Handles plugin configuration
 */

// TODO should these go under a settings page instead of the customizer?

class UCF_Events_Config {
	public static
		$default_options = array(
			'title'             => 'Events',
			'layout'            => 'classic',
			'feed_url'          => 'http://events.ucf.edu/upcoming/feed.json',
			'limit'             => 3,
			'offset'            => 0,
			'include_css'       => true,
			'use_rich_snippets' => false  // TODO implement this
		);

	public static function ucf_events_add_customizer_sections( $wp_customize ) {
		$wp_customize->add_section(
			'ucf_events_plugin_settings',
			array(
				'title' => 'UCF Events Plugin Settings'
			)
		);
	}

	public static function ucf_events_add_customizer_settings( $wp_customize ) {
		$wp_customize->add_setting(
			'ucf_events_feed_url',
			array(
				'type'    => 'option',
				'default' => self::$default_options['feed_url']
			)
		);
		$wp_customize->add_control(
			'ucf_events_feed_url',
			array(
				'type'        => 'text',
				'label'       => 'UCF Events JSON Feed URL',
				'description' => 'The URL of the desired JSON feed from events.ucf.edu.',
				'section'     => 'ucf_events_plugin_settings'
			)
		);

		$wp_customize->add_setting(
			'ucf_events_include_css',
			array(
				'type'    => 'option',
				'default' => self::$default_options['include_css']
			)
		);
		$wp_customize->add_control(
			'ucf_events_include_css',
			array(
				'type'        => 'checkbox',
				'label'       => 'Include Default CSS',
				'description' => 'Include the default css stylesheet on the page.',
				'section'     => 'ucf_events_plugin_settings'
			)
		);
	}

	public static function get_layouts() {
		$layouts = array(
			'classic' => 'Classic Layout',
		);

		$layouts = apply_filters( 'ucf_events_get_layouts', $layouts );

		return $layouts;
	}

	/**
	 * Returns a list of default plugin options.
	 * @return array
	 **/
	public static function get_default_options() {
		return self::$default_options;
	}

	/**
	 * Returns an array with plugin defaults applied.
	 * @param array $list
	 * @param boolean $list_keys_only Modifies results to only return array key
	 *                                values present in $list.
	 * @return array
	 **/
	public static function apply_default_options( $list, $list_keys_only=false ) {
		$defaults = self::get_default_options();
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
				case 'include_css':
					$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
					break;
				default:
					break;
			}
		}

		return $list;
	}
}

add_action( 'customize_register', array( 'UCF_Events_Config', 'ucf_events_add_customizer_sections' ) );
add_action( 'customize_register', array( 'UCF_Events_Config', 'ucf_events_add_customizer_settings' ) );

?>
