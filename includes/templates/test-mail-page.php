<?php
/**
 * The template for the test mail page of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

// Check that the new mail data has been sent and validate the nonce.
CL\Simplest_SMTP\send_test_mail()
?>

<div class="cl-test-mail-settings">
	<h2><?php esc_html_e( 'Test mail', 'cl-simplest-smtp' ); ?>:</h2>

	<form method="post" action="">
		<?php wp_nonce_field( 'cl_simplest_smtp_test_mail_nonce', 'cl_smtp_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th>
					<label for="mail-to">
						<?php esc_html_e( 'Mail To', 'cl-simplest-smtp' ); ?>:
					</label>
				</th>
				<td>
					<input type="email" name="mail-to" id="mail-to" required class="regular-text" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="mail-type">
						<?php esc_html_e( 'Mail type', 'cl-simplest-smtp' ); ?>:
					</label>
				</th>
				<td>
					<select name="mail-type">
						<option value="html"><?php esc_html_e( 'HTML mail', 'cl-simplest-smtp' ); ?></option>
						<option value="plain"><?php esc_html_e( 'Plain mail', 'cl-simplest-smtp' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label for="mail-method">
						<?php esc_html_e( 'Mail method', 'cl-simplest-smtp' ); ?>:
					</label>
				</th>
				<td>
					<select name="mail-method">
						<option value="wp_mail"><?php esc_html_e( 'WordPress Mail method (using current SMTP options)', 'cl-simplest-smtp' ); ?></option>
						<option value="php_mail"><?php esc_html_e( 'Native PHP mail (ignoring WordPress SMTP options)', 'cl-simplest-smtp' ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<?php submit_button( __( 'Send test mail', 'cl-simplest-smtp' ) ); ?>
	</form>
</div>
