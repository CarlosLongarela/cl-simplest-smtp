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

// Allowed number of lines to display.
$allowed_line_counts = array( 10, 100, 1000, 10000 );

// Number of lines to display (default value).
$lines_to_display = 100; // Default value.
if ( isset( $_GET['lines'] ) && isset( $_GET['lines_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_GET['lines_nonce'] ) ), 'cl_simplest_smtp_display_lines' ) ) {
	$requested_lines = (int) $_GET['lines'];
	if ( in_array( $requested_lines, $allowed_line_counts, true ) ) {
		$lines_to_display = $requested_lines;
	}
}

/**
 * Read the last lines of a file efficiently, reading backwards in chunks.
 *
 * @param string $filepath The path to the log file.
 * @param int    $lines    The number of lines to read.
 * @return string The last lines of the file (newest first) as an HTML ordered list.
 */
function tail_file( string $filepath, int $lines = 100 ): string {
	if ( ! file_exists( $filepath ) ) {
		return '';
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
	$fp = fopen( $filepath, 'rb' );
	if ( ! $fp ) {
		return '';
	}

	$chunk_size = 8192;
	$buffer     = '';
	$newlines   = 0;

	fseek( $fp, 0, SEEK_END );
	$pos = ftell( $fp );

	// Read chunks from the end until we have more lines than needed or we reach the start.
	while ( $pos > 0 && $newlines <= $lines ) {
		$read = min( $chunk_size, $pos );
		$pos -= $read;
		fseek( $fp, $pos );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fread
		$chunk     = fread( $fp, $read );
		$newlines += substr_count( $chunk, "\n" );
		$buffer    = $chunk . $buffer;
	}
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
	fclose( $fp );

	$rows = explode( "\n", $buffer );

	// The first row is incomplete if we didn't reach the start of the file.
	if ( $pos > 0 ) {
		array_shift( $rows );
	}

	$rows = array_filter( array_map( 'trim', $rows ), 'strlen' );
	$rows = array_reverse( array_slice( $rows, -$lines ) );

	$recent_lines = array();
	foreach ( $rows as $row ) {
		$recent_lines[] = '<li>' . esc_html( $row ) . '</li>';
	}

	return '<ol class="cl-simplest-smtp-logs-list">' . implode( '', $recent_lines ) . '</ol>';
}

// Result of a previous deletion (read-only, the deletion itself is nonce protected).
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( isset( $_GET['cl_logs_deleted'] ) ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$deleted_count = (int) $_GET['cl_logs_deleted'];

	if ( in_array( $deleted_count, $allowed_line_counts, true ) ) {
		show_admin_notice(
			sprintf(
				/* translators: %s: formatted number of deleted entries */
				esc_html__( 'Successfully deleted the oldest %s log entries.', 'cl-simplest-smtp' ),
				number_format_i18n( $deleted_count )
			),
			array(
				'type'        => 'success',
				'dismissible' => true,
			)
		);
	} else {
		show_admin_notice(
			esc_html__( 'Error deleting log entries.', 'cl-simplest-smtp' ),
			array(
				'type'        => 'error',
				'dismissible' => true,
			)
		);
	}
}

// Display the log content.
echo '<div class="cl-simplest-smtp-logs cl-airmail-border">';

echo '<h2>' . esc_html__( 'Logs', 'cl-simplest-smtp' ) . '</h2>';

// Add buttons for different line counts.
$current_url = remove_query_arg( array( 'lines', 'lines_nonce', 'cl_logs_deleted' ) );
$lines_nonce = wp_create_nonce( 'cl_simplest_smtp_display_lines' );
echo '<div class="cl-simplest-smtp-log-buttons">';
// View buttons.
foreach ( $allowed_line_counts as $line_count ) {
	$button_url   = add_query_arg(
		array(
			'lines'       => $line_count,
			'lines_nonce' => $lines_nonce,
		),
		$current_url
	);
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

foreach ( $allowed_line_counts as $delete_count ) {
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

if ( file_exists( $log_file_path ) ) {
	echo wp_kses_post( tail_file( $log_file_path, $lines_to_display ) );
} else {
	echo '<p>' . esc_html__( 'There are no records available.', 'cl-simplest-smtp' ) . '</p>';
}
echo '</div>';
