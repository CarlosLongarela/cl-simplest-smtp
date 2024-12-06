<?php
/**
 * The template for the settings page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get the saved settings.
$server     = get_option( 'cl_simplest_smtp_server' );
$port       = get_option( 'cl_simplest_smtp_port' );
$username   = get_option( 'cl_simplest_smtp_username' );
$password   = get_option( 'cl_simplest_smtp_password' );
$from_email = get_option( 'cl_simplest_smtp_from_email' );
$from_name  = get_option( 'cl_simplest_smtp_from_name' );

?>
<div class="wrap">
	<h1><?php esc_html_e( 'CL Simplest SMTP Settings', 'cl-simplest-smtp' ); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'cl_simplest_smtp_settings' ); ?>
		<?php do_settings_sections( 'cl_simplest_smtp_settings' ); ?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'SMTP Server', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="text" name="cl_simplest_smtp_server" value="<?php echo esc_attr( $server ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'SMTP Port', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="text" name="cl_simplest_smtp_port" value="<?php echo esc_attr( $port ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'SMTP Username', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="text" name="cl_simplest_smtp_username" value="<?php echo esc_attr( $username ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'SMTP Password', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="password" name="cl_simplest_smtp_password" value="<?php echo esc_attr( $password ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="email" name="cl_simplest_smtp_from_email" value="<?php echo esc_attr( $from_email ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?></th>
					<td>
						<input type="text" name="cl_simplest_smtp_from_name" value="<?php echo esc_attr( $from_name ); ?>" class="regular-text">
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
