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
 * Render the settings page with tabs.
 */
function render_settings_page() {
	$current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'info';

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ) . '</h1>';
	echo '<h2 class="nav-tab-wrapper">';
	echo '<a href="?page=cl-simplest-smtp&tab=info" class="nav-tab ' . ( 'info' === $current_tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Info', 'cl-simplest-smtp' ) . '</a>';
	echo '<a href="?page=cl-simplest-smtp&tab=settings" class="nav-tab ' . ( 'settings' === $current_tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Settings', 'cl-simplest-smtp' ) . '</a>';
	echo '<a href="?page=cl-simplest-smtp&tab=test" class="nav-tab ' . ( 'test' === $current_tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Test', 'cl-simplest-smtp' ) . '</a>';
	echo '<a href="?page=cl-simplest-smtp&tab=logs" class="nav-tab ' . ( 'logs' === $current_tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Logs', 'cl-simplest-smtp' ) . '</a>';
	echo '<a href="?page=cl-simplest-smtp&tab=help" class="nav-tab ' . ( 'help' === $current_tab ? 'nav-tab-active' : '' ) . '">' . esc_html__( 'Help', 'cl-simplest-smtp' ) . '</a>';
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
		$message = '<p>' . __( 'This is a test mail from the CL Simplest SMTP plugin.', 'cl-simplest-smtp' ) . '</p>';
		$message .= '<p><strong>' . __( 'HTML version', 'cl-simplest-smtp' ) . '</strong></p>';
	} else {
		$message = __( 'This is a test mail from the CL Simplest SMTP plugin.', 'cl-simplest-smtp' );
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
	$from_mail = get_option( 'admin_email' );

	$result = false;
	if ( 'wp_mail' === $mail_method ) {
		$result = wp_mail( $mail_to, $subject, $message, $headers );
	} else {
		$headers[] = 'From: <' . $from_mail . '>' . "\r\n";
		$result = mail( $mail_to, $subject, $message, implode( "\r\n", $headers ) );
	}

	if ( ! $result ) {
		log_mail_error( $mail_to, $subject, $mail_method );
	}

	return $result;
}

/**
 * Log mail error to the log file.
 *
 * @param string $mail_to     The recipient email address.
 * @param string $subject     The email subject.
 * @param string $mail_method The method used to send mail.
 * @return void
 */
function log_mail_error( string $mail_to, string $subject, string $mail_method ) {
	create_log_file_if_not_exists();

	$error_message = get_mail_error_message( $mail_method );
	$log_entry = sprintf(
		"[%s] Error sending mail to %s with subject '%s' using method '%s'. Error: %s\n",
		date( 'Y-m-d H:i:s' ),
		$mail_to,
		$subject,
		$mail_method,
		$error_message
	);

	$upload_dir    = wp_upload_dir();
	$log_file_path = trailingslashit( $upload_dir['basedir'] ) . CL_SIMPLEST_SMTP_LOG_FILENAME;

	// Use native PHP functions to append to the log file
	if ( is_writable( $log_file_path ) ) {
		$handle = fopen( $log_file_path, 'a' );
		if ( $handle ) {
			fwrite( $handle, $log_entry );
			fclose( $handle );
		} else {
			error_log( 'Failed to open log file for writing: ' . $log_file_path );
		}
	} else {
		error_log( 'Log file is not writable: ' . $log_file_path );
	}
}

/**
 * Display the result notice of the mail sending.
 *
 * @param bool   $result      The result of the mail sending.
 * @param string $mail_type   The type of mail (html or plain).
 * @param string $mail_method The method used to send mail.
 */
function display_mail_result_notice( bool $result, string $mail_type, string $mail_method ) {
	$text_html = ( 'html' === $mail_type ) ? __( 'Message sent as HTML', 'cl-simplest-smtp' ) : __( 'Message sent as plain text', 'cl-simplest-smtp' );
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
		$type = 'error';
	}

	wp_admin_notice(
		$message_notice,
		array(
			'type'        => $type,
			'dismissible' => true,
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
	// Initialize the WordPress filesystem.
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	WP_Filesystem();

	global $wp_filesystem;

	$upload_dir    = wp_upload_dir();
	$log_file_path = trailingslashit( $upload_dir['basedir'] ) . CL_SIMPLEST_SMTP_LOG_FILENAME;

	if ( ! $wp_filesystem->exists( $log_file_path ) ) {
		$wp_filesystem->put_contents( $log_file_path, "## Log file created on " . date( 'Y-m-d H:i:s' ) . "\n" );
	}
}

/**
 * Handle log deletion requests.
 */
function handle_log_deletion() {
	if ( ! isset( $_GET['action'] ) || 'delete_logs' !== $_GET['action'] ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'cl-simplest-smtp' ) );
	}

	$count = isset( $_GET['count'] ) ? (int) $_GET['count'] : 0;
	if ( ! in_array( $count, array( 10, 100, 1000, 10000 ), true ) ) {
		return;
	}

	// Verify nonce
	if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'delete_logs_' . $count ) ) {
		wp_die( esc_html__( 'Security check failed.', 'cl-simplest-smtp' ) );
	}

	$upload_dir = wp_upload_dir();
	$log_file = trailingslashit( $upload_dir['basedir'] ) . CL_SIMPLEST_SMTP_LOG_FILENAME;

	if ( ! file_exists( $log_file ) ) {
		return;
	}

	// Read all lines
	$lines = file( $log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
	if ( false === $lines ) {
		return;
	}

	// Keep only the newest lines
	$lines = array_slice( $lines, $count );

	// Add header line if file will be empty
	if ( empty( $lines ) ) {
		$lines[] = "## Log file cleaned on " . date( 'Y-m-d H:i:s' );
	}

	// Write back to file
	$success = file_put_contents( $log_file, implode( PHP_EOL, $lines ) . PHP_EOL );

	if ( $success ) {
		add_settings_error(
			'cl_simplest_smtp_messages',
			'logs_deleted',
			sprintf(
				/* translators: %s: formatted number of deleted entries */
				esc_html__( 'Successfully deleted the oldest %s log entries.', 'cl-simplest-smtp' ),
				number_format_i18n( $count )
			),
			'updated'
		);
	} else {
		add_settings_error(
			'cl_simplest_smtp_messages',
			'logs_delete_error',
			esc_html__( 'Error deleting log entries.', 'cl-simplest-smtp' ),
			'error'
		);
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\handle_log_deletion' );
