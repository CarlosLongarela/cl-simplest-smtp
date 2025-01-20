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

// Define log filename constant if not already defined.
if ( ! defined( 'CL_SIMPLEST_SMTP_LOG_FILENAME' ) ) {
	define( 'CL_SIMPLEST_SMTP_LOG_FILENAME', 'cl-simplest-smtp-log.txt' );
}

/**
 * Delete the log file if it exists.
 */
function cl_simplest_smtp_delete_log_file() {
	$upload_dir = wp_upload_dir();
	$log_file   = trailingslashit( $upload_dir['basedir'] ) . CL_SIMPLEST_SMTP_LOG_FILENAME;

	if ( file_exists( $log_file ) ) {
		// Initialize the WordPress filesystem.
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		WP_Filesystem();
		global $wp_filesystem;

		if ( $wp_filesystem->exists( $log_file ) ) {
			$wp_filesystem->delete( $log_file );
		}
	}
}

// Delete the log file
cl_simplest_smtp_delete_log_file();

// Delete plugin options
delete_option( 'cl_simplest_smtp_options' );
