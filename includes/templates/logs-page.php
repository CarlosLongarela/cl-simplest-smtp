<?php
/**
 * The template for the logs page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

// Ensure the log file exists.
create_log_file_if_not_exists();

// Path to the log file.
$upload_dir    = wp_upload_dir();
$log_file_path = trailingslashit( $upload_dir['basedir'] ) . 'cl-simplest-smtp-log.txt';

// Number of lines to display (default value)
$lines_to_display = isset( $_GET['lines'] ) ? (int) $_GET['lines'] : 100;

// Initialize the WordPress filesystem.
if ( ! function_exists( 'WP_Filesystem' ) ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
}

WP_Filesystem();

global $wp_filesystem;

/**
 * Read the last lines of a file using WordPress filesystem API.
 *
 * @param string $filepath The path to the log file.
 * @param int    $lines    The number of lines to read.
 * @return string The last lines of the file.
 */
function tail_file( $filepath, $lines = 100 ) {
	global $wp_filesystem;

	if ( ! $wp_filesystem->exists( $filepath ) ) {
		return '';
	}

	$lines_array = $wp_filesystem->get_contents_array( $filepath );
	if ( false === $lines_array ) {
		return '';
	}

	$total_lines = count( $lines_array );

	// Get the last $lines lines and reverse the order
	$recent_lines = array_slice( $lines_array, max( 0, $total_lines - $lines ) );
	$recent_lines = array_reverse( $recent_lines );

	// Convert each line to a list item using array_map
	$recent_lines = array_map( function( $line ) {
		return '<li>' . esc_html( $line ) . '</li>';
	}, $recent_lines );

	return '<ol class="cl-simplest-smtp-logs-list">' . implode( '', $recent_lines ) . '</ol>';
}

// Display the log content.
echo '<div class="cl-simplest-smtp-logs cl-airmail-border">';

// Add buttons for different line counts
$current_url = remove_query_arg( 'lines' );
echo '<div class="cl-simplest-smtp-log-buttons">';
foreach ( array( 10, 100, 1000, 10000 ) as $line_count ) {
	$button_url   = add_query_arg( 'lines', $line_count, $current_url );
	$button_class = $lines_to_display === $line_count ? 'button button-primary' : 'button';

	printf(
		'<a href="%s" class="%s">%s</a> ',
		esc_url( $button_url ),
		esc_attr( $button_class ),
		sprintf(
			/* translators: %s: formatted number of lines to display */
			esc_html__( 'Show last %s entries', 'cl-simplest-smtp' ),
			number_format_i18n( $line_count )
		)
	);
}
echo '</div>';
echo '<h2>' . esc_html__( 'Logs', 'cl-simplest-smtp' ) . '</h2>';
echo '<p><strong><em>' . esc_html__( 'Log format is: "[Date-hour] Error sending mail to [mail to] with subject [subject] using mail method [mail method]. Error: [error message]"', 'cl-simplest-smtp' ) . '</em></strong></p>';
if ( $wp_filesystem->exists( $log_file_path ) ) {
	echo tail_file( $log_file_path, $lines_to_display );
} else {
	echo '<p>' . esc_html__( 'There are no records available.', 'cl-simplest-smtp' ) . '</p>';
}
echo '</div>';
