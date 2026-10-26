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
	// Check all required parameters are defined and have valid values.
	if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' )
		|| ! defined( 'CL_SIMPLEST_SMTP_USER' )
		|| ! defined( 'CL_SIMPLEST_SMTP_PASS' )
		|| ! defined( 'CL_SIMPLEST_SMTP_AUTH' )
		|| ! is_bool( CL_SIMPLEST_SMTP_AUTH )
		|| ! defined( 'CL_SIMPLEST_SMTP_PORT' )
		|| ! is_int( CL_SIMPLEST_SMTP_PORT )
		|| CL_SIMPLEST_SMTP_PORT < 1
		|| CL_SIMPLEST_SMTP_PORT > 65535
		|| ! defined( 'CL_SIMPLEST_SMTP_SECURE' )
		|| ( 'tls' !== CL_SIMPLEST_SMTP_SECURE && 'ssl' !== CL_SIMPLEST_SMTP_SECURE )
	) {
		return false;
	}

	return true;
}

/**
 * Show an admin notice, with a fallback for WordPress versions older than 6.4 (without wp_admin_notice()).
 *
 * @param string $message The notice message (HTML allowed).
 * @param array  $args    Notice arguments: type, dismissible and paragraph_wrap.
 * @return void
 */
function show_admin_notice( string $message, array $args = array() ) {
	if ( function_exists( 'wp_admin_notice' ) ) {
		wp_admin_notice( $message, $args );
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'type'           => 'info',
			'dismissible'    => false,
			'paragraph_wrap' => true,
		)
	);

	if ( $args['paragraph_wrap'] ) {
		$message = '<p>' . $message . '</p>';
	}

	printf(
		'<div class="notice notice-%1$s%2$s">%3$s</div>',
		esc_attr( $args['type'] ),
		$args['dismissible'] ? ' is-dismissible' : '',
		wp_kses_post( $message )
	);
}

/**
 * Check if plugin options are configured and show an admin notice if not.
 */
function show_no_params_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

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

	show_admin_notice(
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
	register_setting(
		'cl_simplest_smtp_options_group',
		'cl_simplest_smtp_options',
		array(
			'sanitize_callback' => __NAMESPACE__ . '\sanitize_options',
		)
	);
}
add_action( 'admin_init', __NAMESPACE__ . '\register_plugin_settings' );

/**
 * Sanitize callback for plugin options.
 *
 * Values are stored raw (only sanitized), they are escaped on output.
 * The password is never sanitized as text because it could contain any character.
 *
 * @param mixed $options The options to sanitize.
 * @return array The sanitized options.
 */
function sanitize_options( $options ): array {
	if ( ! is_array( $options ) ) {
		$options = array();
	}

	$old_options = get_option( 'cl_simplest_smtp_options' );
	$old_pass    = ( is_array( $old_options ) && isset( $old_options['pass'] ) ) ? (string) $old_options['pass'] : '';

	$secure = isset( $options['secure'] ) ? sanitize_key( $options['secure'] ) : '';
	$pass   = isset( $options['pass'] ) && is_string( $options['pass'] ) ? $options['pass'] : '';

	return array(
		'host'   => isset( $options['host'] ) ? sanitize_text_field( $options['host'] ) : '',
		'auth'   => ! empty( $options['auth'] ),
		'port'   => isset( $options['port'] ) ? absint( $options['port'] ) : 0,
		'user'   => isset( $options['user'] ) ? sanitize_text_field( $options['user'] ) : '',
		// An empty password field keeps the current password (it is never printed in the form).
		'pass'   => '' === $pass ? $old_pass : $pass,
		'secure' => in_array( $secure, array( 'ssl', 'tls' ), true ) ? $secure : '',
		'from'   => isset( $options['from'] ) ? sanitize_email( $options['from'] ) : '',
		'name'   => isset( $options['name'] ) ? sanitize_text_field( $options['name'] ) : '',
	);
}

/**
 * Render the settings page with tabs.
 */
function render_settings_page() {
	$allowed_tabs = array(
		'info'     => __( 'Info', 'cl-simplest-smtp' ),
		'settings' => __( 'Settings', 'cl-simplest-smtp' ),
		'test'     => __( 'Test', 'cl-simplest-smtp' ),
		'logs'     => __( 'Logs', 'cl-simplest-smtp' ),
		'help'     => __( 'Help', 'cl-simplest-smtp' ),
	);

	// Tab navigation is read-only, so a whitelist is enough (no nonce needed).
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$current_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'info';
	if ( ! isset( $allowed_tabs[ $current_tab ] ) ) {
		$current_tab = 'info';
	}

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ) . '</h1>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $allowed_tabs as $tab => $tab_label ) {
		printf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			esc_url( admin_url( 'options-general.php?page=cl-simplest-smtp&tab=' . $tab ) ),
			( $tab === $current_tab ? 'nav-tab-active' : '' ),
			esc_html( $tab_label )
		);
	}
	echo '</h2>';

	switch ( $current_tab ) {
		case 'info':
			render_info_tab();
			break;
		case 'settings':
			render_settings_tab();
			break;
		case 'test':
			render_test_tab();
			break;
		case 'logs':
			render_logs_tab();
			break;
		case 'help':
			render_help_tab();
			break;
	}

	echo '</div>';
}

/**
 * Render the "Settings" tab content.
 */
function render_settings_tab() {
	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/settings-page.php';
}

/**
 * Render the "Test" tab content.
 */
function render_test_tab() {
	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/test-mail-page.php';
}

/**
 * Render the "Info" tab content.
 */
function render_info_tab() {
	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/settings-info-page.php';
}

/**
 * Render the "Logs" tab content.
 */
function render_logs_tab() {
	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/logs-page.php';
}

/**
 * Render the "Help" tab content.
 */
function render_help_tab() {
	require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/templates/help-page.php';
}

/**
 * Send a test mail.
 */
function send_test_mail() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['mail-to'], $_POST['mail-type'], $_POST['mail-method'], $_POST['cl_smtp_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['cl_smtp_nonce'] ), 'cl_simplest_smtp_test_mail_nonce' ) ) {
		$mail_to     = sanitize_email( wp_unslash( $_POST['mail-to'] ) );
		$mail_type   = sanitize_text_field( wp_unslash( $_POST['mail-type'] ) );
		$mail_method = sanitize_text_field( wp_unslash( $_POST['mail-method'] ) );

		$headers = prepare_mail_headers( $mail_type );
		$subject = __( 'Test mail from CL Simplest SMTP', 'cl-simplest-smtp' );
		$message = prepare_mail_message( $mail_type );

		$result = send_mail( $mail_to, $subject, $message, $headers, $mail_method );

		display_mail_result_notice( $result, $mail_type, $mail_method );
	}
}

/**
 * Prepare mail headers based on mail type.
 *
 * @param string $mail_type The type of mail (html or plain).
 * @return array The prepared headers.
 */
function prepare_mail_headers( string $mail_type ): array {
	$headers   = array();
	$headers[] = 'MIME-Version: 1.0';

	if ( 'html' === $mail_type ) {
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
	} else {
		$headers[] = 'Content-Type: text/plain; charset=UTF-8';
	}

	return $headers;
}

/**
 * Prepare mail message based on mail type.
 *
 * @param string $mail_type The type of mail (html or plain).
 * @return string The prepared message.
 */
function prepare_mail_message( string $mail_type ): string {
	if ( 'html' === $mail_type ) {
		$message  = '<p>' . __( 'This is a test mail from the CL Simplest SMTP plugin.', 'cl-simplest-smtp' ) . '</p>';
		$message .= '<p><strong>' . __( 'HTML version', 'cl-simplest-smtp' ) . '</strong></p>';
	} else {
		$message  = __( 'This is a test mail from the CL Simplest SMTP plugin.', 'cl-simplest-smtp' );
		$message .= "\n\n" . __( 'Plain text version', 'cl-simplest-smtp' );
	}

	return $message;
}

/**
 * Send mail using the specified method.
 *
 * @param string $mail_to     The recipient email address.
 * @param string $subject     The email subject.
 * @param string $message     The email message.
 * @param array  $headers     The email headers.
 * @param string $mail_method The method to send mail (wp_mail or native).
 * @return bool The result of the mail sending.
 */
function send_mail( string $mail_to, string $subject, string $message, array $headers, string $mail_method ): bool {
	if ( 'wp_mail' === $mail_method ) {
		// Errors are logged by the wp_mail_failed hook.
		return wp_mail( $mail_to, $subject, $message, $headers );
	}

	$headers[] = 'From: <' . get_option( 'admin_email' ) . '>';
	$result    = mail( $mail_to, $subject, $message, implode( "\r\n", $headers ) );

	if ( ! $result ) {
		log_mail_error( $mail_to, $subject, $mail_method, get_mail_error_message( $mail_method ) );
	}

	return $result;
}

/**
 * Log every wp_mail() failure on the site.
 *
 * @param \WP_Error $error The error returned by wp_mail().
 * @return void
 */
function log_wp_mail_failed( $error ) {
	if ( ! is_wp_error( $error ) ) {
		return;
	}

	$data    = $error->get_error_data();
	$mail_to = '';
	$subject = '';

	if ( is_array( $data ) ) {
		if ( isset( $data['to'] ) ) {
			$mail_to = is_array( $data['to'] ) ? implode( ', ', $data['to'] ) : (string) $data['to'];
		}
		if ( isset( $data['subject'] ) ) {
			$subject = (string) $data['subject'];
		}
	}

	log_mail_error( $mail_to, $subject, 'wp_mail', $error->get_error_message() );
}
add_action( 'wp_mail_failed', __NAMESPACE__ . '\log_wp_mail_failed' );

/**
 * Log mail error to the log file.
 *
 * @param string $mail_to       The recipient email address.
 * @param string $subject       The email subject.
 * @param string $mail_method   The method used to send mail.
 * @param string $error_message The error message.
 * @return void
 */
function log_mail_error( string $mail_to, string $subject, string $mail_method, string $error_message ) {
	create_log_file_if_not_exists();

	// Avoid line breaks inside an entry, one entry per line.
	$log_entry = str_replace(
		array( "\r", "\n" ),
		' ',
		sprintf(
			"[%s] Error sending mail to %s with subject '%s' using method '%s'. Error: %s",
			gmdate( 'Y-m-d H:i:s' ),
			$mail_to,
			$subject,
			$mail_method,
			$error_message
		)
	) . "\n";

	$log_file_path = get_log_file_path();

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- Atomic append, not available in WP_Filesystem.
	if ( false === file_put_contents( $log_file_path, $log_entry, FILE_APPEND | LOCK_EX ) ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( 'CL Simplest SMTP: failed to write to log file: ' . $log_file_path );
	}
}

/**
 * Get the log file name.
 *
 * If the CL_SIMPLEST_SMTP_LOG_FILENAME constant is not defined, the name includes a
 * site-specific hash (based on the WordPress salts) so it can't be guessed from outside.
 *
 * @return string The log file name.
 */
function get_log_filename(): string {
	if ( defined( 'CL_SIMPLEST_SMTP_LOG_FILENAME' ) && '' !== CL_SIMPLEST_SMTP_LOG_FILENAME ) {
		return sanitize_file_name( basename( CL_SIMPLEST_SMTP_LOG_FILENAME ) );
	}

	return 'cl-simplest-smtp-log-' . substr( wp_hash( 'cl-simplest-smtp-log' ), 0, 16 ) . '.txt';
}

/**
 * Get the log file path and ensure the directory exists with an index.html file.
 *
 * @return string The full path to the log file.
 */
function get_log_file_path(): string {
	static $log_file = null;

	if ( null !== $log_file ) {
		return $log_file;
	}

	$upload_dir = wp_upload_dir();
	$log_dir    = trailingslashit( $upload_dir['basedir'] ) . 'cl-simplest-smtp';
	$log_file   = trailingslashit( $log_dir ) . get_log_filename();

	if ( ! is_dir( $log_dir ) ) {
		wp_mkdir_p( $log_dir );
	}

	$index_file = trailingslashit( $log_dir ) . 'index.html';
	if ( ! file_exists( $index_file ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( $index_file, '' );
	}

	// Move the log file with the old predictable name (versions <= 1.2.4) to the new one.
	$legacy_file = trailingslashit( $log_dir ) . 'cl-simplest-smtp-log.txt';
	if ( $legacy_file !== $log_file && file_exists( $legacy_file ) && ! file_exists( $log_file ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.rename_rename
		rename( $legacy_file, $log_file );
	}

	return $log_file;
}

/**
 * Display the result notice of the mail sending.
 *
 * @param bool   $result      The result of the mail sending.
 * @param string $mail_type   The type of mail (html or plain).
 * @param string $mail_method The method used to send mail.
 */
function display_mail_result_notice( bool $result, string $mail_type, string $mail_method ) {
	$text_html      = ( 'html' === $mail_type ) ? __( 'Message sent as HTML', 'cl-simplest-smtp' ) : __( 'Message sent as plain text', 'cl-simplest-smtp' );
	$test_mail_type = ( 'wp_mail' === $mail_method ) ? __( 'WordPress Mail method (using current SMTP options)', 'cl-simplest-smtp' ) : __( 'Native PHP mail (ignoring WordPress SMTP options)', 'cl-simplest-smtp' );

	if ( $result ) {
		$message_notice  = '<p>' . esc_html__( 'Fantastic! The test mail was sent successfully.', 'cl-simplest-smtp' ) . '</p>';
		$message_notice .= '<p>' . esc_html( $text_html ) . '</p>';
		$message_notice .= '<p>' . esc_html__( 'Mail method:', 'cl-simplest-smtp' ) . ' ' . esc_html( $test_mail_type ) . '</p>';
		$message_notice .= '<p>' . esc_html__( 'Please check your inbox.', 'cl-simplest-smtp' ) . '</p>';
		$type            = 'success';
	} else {
		$message_notice  = '<p>' . esc_html__( 'Error: The test mail was not sent. Please check the SMTP or mail settings.', 'cl-simplest-smtp' ) . '</p>';
		$message_notice .= '<p>' . esc_html( $text_html ) . '</p>';
		$message_notice .= '<p>' . esc_html__( 'Mail method:', 'cl-simplest-smtp' ) . ' ' . esc_html( $test_mail_type ) . '</p>';
		$message_notice .= '<p><strong>' . esc_html__( 'The error returned the following message:', 'cl-simplest-smtp' ) . '</strong></p>';
		$message_notice .= '<p><em>' . esc_html( get_mail_error_message( $mail_method ) ) . '</em></p>';
		$type            = 'error';
	}

	show_admin_notice(
		$message_notice,
		array(
			'type'           => $type,
			'dismissible'    => true,
			'paragraph_wrap' => false,
		)
	);
}

/**
 * Get the error message from the mail sending process.
 *
 * @param string $mail_method The method used to send mail.
 * @return string The error message.
 */
function get_mail_error_message( string $mail_method ): string {
	if ( 'wp_mail' === $mail_method ) {
		global $phpmailer;
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		return ! empty( $phpmailer->ErrorInfo ) ? $phpmailer->ErrorInfo : '';
	} else {
		$error_message = error_get_last();
		return ! empty( $error_message['message'] ) ? $error_message['message'] : '';
	}
}

/**
 * Create the log file if it does not exist.
 *
 * @return void
 */
function create_log_file_if_not_exists() {
	$log_file_path = get_log_file_path();

	if ( ! file_exists( $log_file_path ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( $log_file_path, '## Log file created on ' . gmdate( 'Y-m-d H:i:s' ) . "\n", LOCK_EX );
	}
}

/**
 * Handle log deletion requests.
 */
function handle_log_deletion() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce is verified below.
	if ( ! isset( $_GET['page'], $_GET['action'] ) || 'cl-simplest-smtp' !== $_GET['page'] || 'delete_logs' !== $_GET['action'] ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'cl-simplest-smtp' ) );
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce is verified below.
	$count = isset( $_GET['count'] ) ? (int) $_GET['count'] : 0;
	if ( ! in_array( $count, array( 10, 100, 1000, 10000 ), true ) ) {
		return;
	}

	// Verify nonce.
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'delete_logs_' . $count ) ) {
		wp_die( esc_html__( 'Security check failed.', 'cl-simplest-smtp' ) );
	}

	$log_file = get_log_file_path();
	$success  = false;

	if ( file_exists( $log_file ) ) {
		$lines = file( $log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

		if ( false !== $lines ) {
			// Keep only the newest lines.
			$lines = array_slice( $lines, $count );

			// Add header line if file will be empty.
			if ( empty( $lines ) ) {
				$lines[] = '## Log file cleaned on ' . gmdate( 'Y-m-d H:i:s' );
			}

			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
			$success = false !== file_put_contents( $log_file, implode( "\n", $lines ) . "\n", LOCK_EX );
		}
	}

	// Redirect (Post/Redirect/Get) so reloading the page doesn't delete more entries.
	wp_safe_redirect(
		add_query_arg(
			array(
				'page'            => 'cl-simplest-smtp',
				'tab'             => 'logs',
				'cl_logs_deleted' => $success ? $count : 0,
			),
			admin_url( 'options-general.php' )
		)
	);
	exit;
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_log_deletion' );
