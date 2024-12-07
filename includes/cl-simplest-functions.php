<?php
/**
 * CL Simplest SMTP hook to send mail.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

/**
 * Configure internal WordPress phpmailer to use SMTP.
 *
 * @param object $phpmailer PhpMailer object.
 *
 * @return void
 */
function use_email_smtp( $phpmailer ) {
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$phpmailer->isSMTP();
	$phpmailer->Host       = CL_SIMPLEST_SMTP_HOST;
	$phpmailer->SMTPAuth   = CL_SIMPLEST_SMTP_AUTH;
	$phpmailer->Port       = CL_SIMPLEST_SMTP_PORT;
	$phpmailer->Username   = CL_SIMPLEST_SMTP_USER;
	$phpmailer->Password   = CL_SIMPLEST_SMTP_PASS;
	$phpmailer->SMTPSecure = CL_SIMPLEST_SMTP_SECURE;

	if ( defined( 'CL_SIMPLEST_SMTP_FROM' ) && ! empty( CL_SIMPLEST_SMTP_FROM ) ) {
		$phpmailer->From = CL_SIMPLEST_SMTP_FROM;
	}

	if ( defined( 'CL_SIMPLEST_SMTP_NAME' ) && ! empty( CL_SIMPLEST_SMTP_NAME ) ) {
		$phpmailer->FromName = CL_SIMPLEST_SMTP_NAME;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}

/**
 * Check if all parameters are defined and correct.
 *
 * @return bool
 */
function check_params() {
	if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_AUTH' ) || ! is_bool( CL_SIMPLEST_SMTP_AUTH ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PORT' ) || ! is_int( CL_SIMPLEST_SMTP_PORT ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_USER' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PASS' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_SECURE' ) || ( 'tls' !== CL_SIMPLEST_SMTP_SECURE && 'ssl' !== CL_SIMPLEST_SMTP_SECURE ) ) {
		return false;
	}

	return true;
}

/**
 * Check if plugin options are configured and show an admin notice if not.
 */
function show_no_params_notice() {
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

	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/test-mail-page.php';

	echo '</div>';
}
