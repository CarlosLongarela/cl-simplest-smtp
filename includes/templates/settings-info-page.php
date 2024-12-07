<?php
/**
 * The template for the settings page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ); ?></h1>

	<table class="form-table">
		<tbody>
			<tr>
				<td>
					<strong><?php esc_html_e( 'SMTP Server', 'cl-simplest-smtp' ); ?>:</strong>
					<?php echo esc_attr( CL_SIMPLEST_SMTP_HOST ); ?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'SMTP Port', 'cl-simplest-smtp' ); ?>:</strong>
					<?php echo absint( CL_SIMPLEST_SMTP_PORT ); ?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'SMTP Username', 'cl-simplest-smtp' ); ?>:</strong>
					<?php echo esc_attr( CL_SIMPLEST_SMTP_USER ); ?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'SMTP Password', 'cl-simplest-smtp' ); ?>:</strong>
					*****
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?>:</strong>
					<?php echo esc_attr( CL_SIMPLEST_SMTP_FROM ); ?>
				</td>
			</tr>
			<tr>
				<td>
					<strong><?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?>:</strong>
					<?php echo esc_attr( $from_name ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
