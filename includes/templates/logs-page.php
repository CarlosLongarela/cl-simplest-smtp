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
$log_file_path = get_log_file_path();

// Number of lines to display (default value).
$lines_to_display = 100; // Default value.
if ( isset( $_GET['lines'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'cl_simplest_smtp_display_lines' ) ) {
	$lines_to_display = (int) $_GET['lines'];
}

// Initialize the WordPress filesystem.
if ( ! function_exists( 'WP_Filesystem' ) ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
}

WP_Filesystem();

global $wp_filesystem;

/**
 * Read the last lines of a file efficiently.
 *
 * @param string $filepath The path to the log file.
 * @param int    $lines    The number of lines to read.
 * @return string The last lines of the file.
 */
function tail_file( $filepath, $lines = 100 ) {
	if ( ! file_exists( $filepath ) ) {
		return '';
	}

	$fp = fopen( $filepath, 'r' );
	if ( ! $fp ) {
		return '';
	}

	$line_count = 0;
	$pos = -2; // Skip potential trailing newline.
	$output = '';

	// Start from the end and work backwards.
	fseek( $fp, 0, SEEK_END );
	$end_pos = ftell( $fp );

	while ( $line_count < $lines && abs( $pos ) <= $end_pos ) {
		fseek( $fp, $pos, SEEK_END );
		$char = fgetc( $fp );
		if ( "\n" === $char ) {
			$line_count++;
		}
		$pos--;
	}

	// Move back one to include the last line read.
	if ( $line_count > 0 ) {
		fseek( $fp, $pos + 2, SEEK_END );
	} else {
		fseek( $fp, 0 );
	}

	$recent_lines = array();
	while ( ! feof( $fp ) ) {
		$line = fgets( $fp );
		if ( false !== $line ) {
			$line = trim( $line );
			if ( ! empty( $line ) ) {
				$recent_lines[] = '<li>' . esc_html( $line ) . '</li>';
			}
		}
	}
	fclose( $fp );

	$recent_lines = array_reverse( $recent_lines );

	return '<ol class="cl-simplest-smtp-logs-list">' . implode( '', $recent_lines ) . '</ol>';
}

// Display the log content.
echo '<div class="cl-simplest-smtp-logs cl-airmail-border">';

echo '<h2>' . esc_html__( 'Logs', 'cl-simplest-smtp' ) . '</h2>';

// Add buttons for different line counts.
$current_url = remove_query_arg( array( 'lines', 'delete' ) );
echo '<div class="cl-simplest-smtp-log-buttons">';
// View buttons.
foreach ( array( 10, 100, 1000, 10000 ) as $line_count ) {
	$button_url   = wp_nonce_url( add_query_arg( 'lines', $line_count, $current_url ), 'cl_simplest_smtp_display_lines' );
	$button_class = $lines_to_display === $line_count ? 'button button-primary' : 'button';

	printf(
		'<a href="%s" class="%s">%s</a> ',
		esc_url( $button_url ),
		esc_attr( $button_class ),
		sprintf(
			/* translators: %s: formatted number of lines to display */
			esc_html__( '%s entries', 'cl-simplest-smtp' ),
			esc_html( number_format_i18n( $line_count ) )
		)
	);
}

echo '</div>';

// Delete buttons.
echo '<div class="cl-simplest-smtp-delete-buttons">';

echo '<span class="cl-simplest-smtp-delete-buttons-title">' . esc_html__( 'Delete oldest', 'cl-simplest-smtp' ) . ':</span>';

foreach ( array( 10, 100, 1000, 10000 ) as $delete_count ) {
	$delete_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'delete_logs',
				'count'  => $delete_count,
				'page'   => 'cl-simplest-smtp',
				'tab'    => 'logs',
			),
			admin_url( 'options-general.php' )
		),
		'delete_logs_' . $delete_count
	);

	printf(
		'<a href="%s" class="button button-link-delete" onclick="return confirm(\'%s\');">%s</a> ',
		esc_url( $delete_url ),
		esc_js(
			sprintf(
				/* translators: %s: formatted number of entries to delete */
				__( 'Are you sure you want to delete the oldest %s entries?', 'cl-simplest-smtp' ),
				number_format_i18n( $delete_count )
			)
		),
		sprintf(
			/* translators: %s: formatted number of entries to delete */
			esc_html__( '%s entries', 'cl-simplest-smtp' ),
			esc_html( number_format_i18n( $delete_count ) )
		)
	);
}
echo '</div>';

echo '<p><strong><em>' . esc_html__( 'Log format is: "[Date-hour] Error sending mail to [mail to] with subject [subject] using mail method [mail method]. Error: [error message]"', 'cl-simplest-smtp' ) . '</em></strong></p>';

if ( $wp_filesystem->exists( $log_file_path ) ) {
	echo wp_kses_post( tail_file( $log_file_path, $lines_to_display ) );
} else {
	echo '<p>' . esc_html__( 'There are no records available.', 'cl-simplest-smtp' ) . '</p>';
}
echo '</div>';
