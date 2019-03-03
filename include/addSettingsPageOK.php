<?php

class addSettingsPageOK {

	function __construct() {
		add_action( 'admin_init', array( $this, 'add_option_field_to_general_admin_page' ) );
	}

	public function add_option_field_to_general_admin_page() {
		add_settings_section(
			'ok_settings_section', // секция
			'Настройик оокласников',
			'',
			'general' // страница
		);

		add_settings_field(
			'ok_app_ACCESS_TOKEN',
			'ACCESS_TOKEN',
			function () {
				echo '<input name="ok_app_ACCESS_TOKEN" type="text" value="' . get_option( 'ok_app_ACCESS_TOKEN' ) . '" class="regular-text ltr"/>';
			},
			'general',
			'ok_settings_section'
		);
		register_setting( 'general', 'ok_app_ACCESS_TOKEN' );

		add_settings_field(
			'ok_app_PRIVATE_KEY',
			'PRIVATE_KEY',
			function () {
				echo '<input name="ok_app_PRIVATE_KEY" type="text" value="' . get_option( 'ok_app_PRIVATE_KEY' ) . '" class="regular-text ltr"/>';
			},
			'general',
			'ok_settings_section'
		);
		register_setting( 'general', 'ok_app_PRIVATE_KEY' );


		add_settings_field(
			'ok_app_PUBLIC_KEY',
			'PUBLIC_KEY',
			function () {
				echo '<input name="ok_app_PUBLIC_KEY" type="text" value="' . get_option( 'ok_app_PUBLIC_KEY' ) . '" class="regular-text ltr"/>';
			},
			'general',
			'ok_settings_section'
		);
		register_setting( 'general', 'ok_app_PUBLIC_KEY' );


		add_settings_field(
			'ok_app_GROUP_ID',
			'ID группы',
			function () {
				echo '<input name="ok_app_GROUP_ID" type="text" value="' . get_option( 'ok_app_GROUP_ID' ) . '" class="regular-text ltr"/>';
			},
			'general',
			'ok_settings_section'
		);
		register_setting( 'general', 'ok_app_GROUP_ID' );
	}

}