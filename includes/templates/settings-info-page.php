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

<div class="cl-info-settings">
	<?php esc_html_e( 'These setting can\'t be changed here because are configured in a configuration file (maybe <code>wp-config.php</code> or similar to <code>user-settings.php</code>). To change these settings you have to edit these <code>CL_SIMPLEST_SMTP*</code> constants that you previously setted.', 'cl-simplest-smtp' ); ?>
</div>

<div class="cl-smtp-preview-settings">
	<p>
		<strong><?php esc_html_e( 'SMTP Server', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo esc_attr( CL_SIMPLEST_SMTP_HOST ); ?>
	</p>

	<p>
		<strong><?php esc_html_e( 'SMTP Port', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo absint( CL_SIMPLEST_SMTP_PORT ); ?>
	</p>

	<p>
		<strong><?php esc_html_e( 'SMTP Username', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo esc_attr( CL_SIMPLEST_SMTP_USER ); ?>
	</p>

	<p>
		<strong><?php esc_html_e( 'SMTP Password', 'cl-simplest-smtp' ); ?>:</strong>
		*****
	</p>

	<p>
		<strong><?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo esc_attr( CL_SIMPLEST_SMTP_FROM ); ?>
	</p>

	<p>
		<strong><?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo esc_attr( $from_name ); ?>
	</p>
</div>
