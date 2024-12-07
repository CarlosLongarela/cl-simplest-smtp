<?php
/**
 * The admin panel of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// Exit if accessed directly.
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

// Add the settings page.
add_action( 'admin_menu', 'add_settings_page' );

// Register the settings.
add_action( 'admin_init', 'register_settings' );

/**
 * Add the settings page.
 */
function add_settings_page() {
	add_options_page(
		__( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ),
		__( 'CL Simplest SMTP', 'cl-simplest-smtp' ),
		'manage_options',
		'cl-simplest-smtp-settings',
		'render_settings_page'
	);
}

/**
 * Render the settings page.
 */
function render_settings_page() {
	// Load the template.
	include_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/settings-page.php';
}

/**
 * Register the settings.
 */
function register_settings() {
	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_server'
	);

	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_port'
	);

	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_username'
	);

	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_password'
	);

	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_from_email'
	);

	register_setting(
		'cl_simplest_smtp_settings',
		'cl_simplest_smtp_from_name'
	);
}
