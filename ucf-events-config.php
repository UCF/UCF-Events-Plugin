<?php
/**
 * Handles plugin configuration
 */

// TODO set 'type' arg for all settings to 'option'
// TODO should these go under a settings page instead of the customizer?

class UCF_Events_Config {
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
			'ucf_events_feed_url'
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
			'ucf_events_include_css'
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
}

add_action( 'customize_register', array( 'UCF_Events_Config', 'ucf_events_add_customizer_settings' ) );

?>
