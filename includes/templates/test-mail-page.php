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
CL\Simplest_SMTP\send_test_mail();

$admin_mail = get_option( 'admin_email' );
?>

<div class="cl-smtp-test-page cl-airmail-border">
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
					<input type="email" name="mail-to" id="mail-to" value="<?php echo esc_html( $admin_mail ); ?>" required class="regular-text" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="mail-type">
						<?php esc_html_e( 'Mail type', 'cl-simplest-smtp' ); ?>:
					</label>
				</th>
				<td>
					<input type="radio" name="mail-type" value="html" id="mail-type-html" checked />
					<label for="mail-type-html"><?php esc_html_e( 'HTML mail', 'cl-simplest-smtp' ); ?></label>
					<br />
					<input type="radio" name="mail-type" value="plain" id="mail-type-plain" />
					<label for="mail-type-plain"><?php esc_html_e( 'Plain mail', 'cl-simplest-smtp' ); ?></label>
				</td>
			</tr>
			<tr>
				<th>
					<label for="mail-method">
						<?php esc_html_e( 'Mail method', 'cl-simplest-smtp' ); ?>:
					</label>
				</th>
				<td>
					<input type="radio" name="mail-method" value="wp_mail" id="mail-method-wp_mail" checked />
					<label for="mail-method-wp_mail"><?php esc_html_e( 'WordPress Mail method (using current SMTP options)', 'cl-simplest-smtp' ); ?></label>
					<br />
					<input type="radio" name="mail-method" value="php_mail" id="mail-method-php_mail" />
					<label for="mail-method-php_mail"><?php esc_html_e( 'Native PHP mail (ignoring WordPress SMTP options)', 'cl-simplest-smtp' ); ?></label>
				</td>
			</tr>
		</table>

		<?php submit_button( __( 'Send test mail', 'cl-simplest-smtp' ) ); ?>
	</form>
</div>
