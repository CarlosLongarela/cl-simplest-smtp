<?php
/**
 * Plugin Name: CL Simplest SMTP
 * Plugin URI: https://wordpress.org/plugins/cl-simplest-smtp/
 * Description: The simplest SMTP option for your WordPress.
 * Version: 1.0.0
 * Author: Carlos Longarela
 * Author URI: https://tabernawp.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cl-simplest-smtp
 * Domain Path: /languages
 * Requires at least: 6.4
 * Requires PHP: 7.4
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

// Define plugin constants.
define( 'CL_SIMPLEST_SMTP_VERSION', '1.0.0' );
define( 'CL_SIMPLEST_SMTP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CL_SIMPLEST_SMTP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// TODO: Solo para testing.
//define( 'CL_SIMPLEST_SMTP_HOST', 'smtp-relay.brevo.com' );
//define( 'CL_SIMPLEST_SMTP_AUTH', true );
//define( 'CL_SIMPLEST_SMTP_PORT', 587 );
//define( 'CL_SIMPLEST_SMTP_USER', '802435001@smtp-brevo.com' );
//define( 'CL_SIMPLEST_SMTP_PASS', 'nYWgDahjb8H5EGtz' );
//define( 'CL_SIMPLEST_SMTP_SECURE', 'tls' );
//define( 'CL_SIMPLEST_SMTP_FROM', 'carlos@longarela.eu' );
//define( 'CL_SIMPLEST_SMTP_NAME', 'Carlos Longarela' );

/**
 * Load plugin text domain.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( 'cl-simplest-smtp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
// Load plugin text domain.
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

// Load plugin parameters from constants or from WordPress plugin options.
require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-smtp-params.php';

// Load plugin main hook.
require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-smtp-hook.php';

/**
 * Check if plugin options are configured and show an admin notice if not.
 */
function check_plugin_options() {
	if ( ! check_params() ) {
		$error_message = sprintf(
			wp_kses(
				/* translators: %s: URL to settings page */
				__( '<strong>CL Simplest SMTP:</strong> You can\'t send mails using this plugin. Please <a href="%s">configure the plugin settings</a>.', 'cl-simplest-smtp' ),
				array(
					'strong' => array(),
					'a'      => array(
						'href' => array(),
					),

				)
			),
			esc_url( admin_url( 'options-general.php?page=cl-simplest-smtp' ) )
		);

		wp_admin_notice(
			$error_message,
			array(
				'type'        => 'error',
				'dismissible' => true,
			)
		);
	}
}
add_action( 'admin_notices', __NAMESPACE__ . '\check_plugin_options' );

/**
 * Register the settings menu.
 */
function register_settings_menu() {
	add_options_page(
		__( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ),
		__( 'CL Simplest SMTP', 'cl-simplest-smtp' ),
		'manage_options',
		'cl-simplest-smtp',
		__NAMESPACE__ . '\render_settings_page'
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\register_settings_menu' );

/**
 * Register plugin settings.
 */
function register_plugin_settings() {
	register_setting( 'cl_simplest_smtp_options_group', 'cl_simplest_smtp_options', 'sanitize_callback' );
}
add_action( 'admin_init', __NAMESPACE__ . '\register_plugin_settings' );

/**
 * Sanitize callback for plugin options.
 *
 * @param array $options The options to sanitize.
 * @return array The sanitized options.
 */
function sanitize_callback( $options ) {
	// Sanitize each option as needed.
	$options['host']   = sanitize_text_field( $options['host'] );
	$options['auth']   = isset( $options['auth'] ) ? (bool) $options['auth'] : false;
	$options['port']   = absint( $options['port'] );
	$options['user']   = sanitize_text_field( $options['user'] );
	$options['pass']   = sanitize_text_field( $options['pass'] );
	$options['secure'] = sanitize_text_field( $options['secure'] );
	$options['from']   = sanitize_email( $options['from'] );
	$options['name']   = sanitize_text_field( $options['name'] );

	return $options;
}

/**
 * Render the settings page.
 */
function render_settings_page() {
	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ) . '</h1>';

	if ( defined( 'CL_SIMPLEST_SMTP_HOST_FROM_DB' ) ) {
		// Load the template.
		require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/settings-page.php';
	} else {
		// Load the template.
		require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/settings-info-page.php';
	}

	echo '</div>';
}
