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

if ( defined( 'CL_SIMPLEST_SMTP_FROM' ) && ! empty( CL_SIMPLEST_SMTP_FROM ) ) {
	$from_mail = CL_SIMPLEST_SMTP_FROM;
} else {
	$from_mail = '';
}

if ( defined( 'CL_SIMPLEST_SMTP_NAME' ) && ! empty( CL_SIMPLEST_SMTP_NAME ) ) {
	$from_name = CL_SIMPLEST_SMTP_NAME;
} else {
	$from_name = '';
}
?>

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
					<input type="text" name="cl_simplest_smtp_server" value="<?php echo esc_attr( CL_SIMPLEST_SMTP_HOST ); ?>" placeholder="smtp.test.null" required class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cl_simplest_smtp_port"><?php esc_html_e( 'SMTP Port', 'cl-simplest-smtp' ); ?></label>
				</th>
				<td>
					<input type="text" name="cl_simplest_smtp_port" value="<?php echo esc_attr( CL_SIMPLEST_SMTP_PORT ); ?>" class="regular-text" placeholder="465" required autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cl_simplest_smtp_username"><?php esc_html_e( 'SMTP Username', 'cl-simplest-smtp' ); ?></label>
				</th>
				<td>
					<input type="text" name="cl_simplest_smtp_username" value="<?php echo esc_attr( CL_SIMPLEST_SMTP_USER ); ?>" class="regular-text" placeholder="smptuser@fakedomain.null" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cl_simplest_smtp_password"><?php esc_html_e( 'SMTP Password', 'cl-simplest-smtp' ); ?></label>
				</th>
				<td>
					<input type="password" name="cl_simplest_smtp_password" value="<?php echo esc_attr( CL_SIMPLEST_SMTP_PASS ); ?>" class="regular-text" placeholder="youruserfakepass" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="cl_simplest_smtp_from_email"><?php esc_html_e( 'From Email', 'cl-simplest-smtp' ); ?></label>
				</th>
				<td>
					<input type="email" name="cl_simplest_smtp_from_email" value="<?php echo esc_attr( $from_mail ); ?>" class="regular-text" placeholder="manolito@guorpresser.null" autocomplete="off" />
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
