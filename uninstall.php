<?php
/**
 * Uninstall CL Simplest SMTP.
 *
 * @package CL\Simplest_SMTP
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete the log directory (with all log files) and the legacy log file if they exist.
 */
function cl_simplest_smtp_delete_log_files() {
	$upload_dir = wp_upload_dir();
	$base_dir   = trailingslashit( $upload_dir['basedir'] );
	$log_dir    = $base_dir . 'cl-simplest-smtp';

	// Log file location used by very old versions.
	$legacy_files = array( $base_dir . 'cl-simplest-smtp-log.txt' );
	if ( defined( 'CL_SIMPLEST_SMTP_LOG_FILENAME' ) && '' !== CL_SIMPLEST_SMTP_LOG_FILENAME ) {
		$legacy_files[] = $base_dir . sanitize_file_name( basename( CL_SIMPLEST_SMTP_LOG_FILENAME ) );
	}

	foreach ( $legacy_files as $legacy_file ) {
		if ( is_file( $legacy_file ) ) {
			wp_delete_file( $legacy_file );
		}
	}

	if ( ! is_dir( $log_dir ) ) {
		return;
	}

	// Initialize the WordPress filesystem.
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	global $wp_filesystem;

	if ( WP_Filesystem() && $wp_filesystem ) {
		$wp_filesystem->delete( $log_dir, true );
	}
}

// Delete the log files.
cl_simplest_smtp_delete_log_files();

// Delete plugin options.
delete_option( 'cl_simplest_smtp_options' );
