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
					<th scope="row">
						<label for="cl_simplest_smtp_server"><?php esc_html_e( 'SMTP Server', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="text" name="cl_simplest_smtp_server" value="<?php echo esc_attr( $server ); ?>" placeholder="smtp.test.null" required class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cl_simplest_smtp_port"><?php esc_html_e( 'SMTP Port', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="text" name="cl_simplest_smtp_port" value="<?php echo esc_attr( $port ); ?>" class="regular-text" placeholder="465" required autocomplete="off" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cl_simplest_smtp_username"><?php esc_html_e( 'SMTP Username', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="text" name="cl_simplest_smtp_username" value="<?php echo esc_attr( $username ); ?>" class="regular-text" placeholder="smptuser@fakedomain.null" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cl_simplest_smtp_password"><?php esc_html_e( 'SMTP Password', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="password" name="cl_simplest_smtp_password" value="<?php echo esc_attr( $password ); ?>" class="regular-text" placeholder="youruserfakepass" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cl_simplest_smtp_from_email"><?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="email" name="cl_simplest_smtp_from_email" value="<?php echo esc_attr( $from_email ); ?>" class="regular-text" placeholder="manolito@guorpresser.null" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cl_simplest_smtp_from_name"><?php esc_html_e( 'From Name', 'cl-simplest-smtp' ); ?></label>
					</th>
					<td>
						<input type="text" name="cl_simplest_smtp_from_name" value="<?php echo esc_attr( $from_name ); ?>" class="regular-text" placeholder="Manolito Guorpresser" autocomplete="off" />
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
