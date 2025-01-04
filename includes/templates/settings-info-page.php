<?php
/**
 * The template for the info page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

if ( defined( 'CL_SIMPLEST_SMTP_FROM' ) ) {
	$from_mail = CL_SIMPLEST_SMTP_FROM;
} else {
	$from_mail = '';
}

if ( defined( 'CL_SIMPLEST_SMTP_NAME' ) ) {
	$from_name = CL_SIMPLEST_SMTP_NAME;
} else {
	$from_name = '';
}
?>

<div class="cl-info-settings">
	<?php
	$info_message = '<p><strong>' . esc_html__( 'CONGRATULATIONS ! Your SMTP settings are saved in a configuration file. This is good for speed and security.', 'cl-simplest-smtp' ) . '</strong></p>';

	$info_message .= '<p>' . wp_kses(
		__( 'These setting can\'t be changed here because are saved in a configuration file (maybe <code>wp-config.php</code> or something similar to <code>user-settings.php</code>).', 'cl-simplest-smtp' ),
		array( 'code' => array() )
	) . '</p>';

	$info_message .= '<p>' . wp_kses(
		__( 'To change these settings you have to edit these <code>CL_SIMPLEST_SMTP*</code> constants that you previously setted.', 'cl-simplest-smtp' ),
		array( 'code' => array() )
	) . '</p>';

	wp_admin_notice( $info_message, array( 'type' => 'success' ) );
	?>
</div>

<div class="cl-smtp-preview-settings cl-airmail-border">
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
		<?php echo esc_attr( $from_mail ); ?>
	</p>

	<p>
		<strong><?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?>:</strong>
		<?php echo esc_attr( $from_name ); ?>
	</p>
</div>
