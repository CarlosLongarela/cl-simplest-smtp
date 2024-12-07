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

// Comprobar que se hyan enviado los datos de nuevo mail y validar el nonce.
if ( isset( $_POST['mail-to'], $_POST['mail-type'], $_POST['mail-method'], $_POST['cl_smtp_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['cl_smtp_nonce'] ), 'cl_simplest_smtp_test_mail_nonce' ) ) {
	$mail_to     = sanitize_email( wp_unslash( $_POST['mail-to'] ) );
	$mail_type   = sanitize_text_field( wp_unslash( $_POST['mail-type'] ) );
	$mail_method = sanitize_text_field( wp_unslash( $_POST['mail-method'] ) );

	// Set the mail headers.
	$headers = array();

	// Set the mail subject.
	$subject = __( 'Test mail from CL Simplest SMTP', 'cl-simplest-smtp' );

	// Set the mail message.
	$message = __( 'This is a test mail from the CL Simplest SMTP plugin.', 'cl-simplest-smtp' );

	if ( 'html' === $mail_type ) {
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$message  .= '<br /><strong>' . __( 'HTML version', 'cl-simplest-smtp' ) . '</strong>';
	}

	// Send the mail.
	if ( 'wp_mail' === $mail_method ) {
		$result = wp_mail( $mail_to, $subject, $message, $headers );
	} else {
		$result = mail( $mail_to, $subject, $message, implode( "\r\n", $headers ) );
	}

	// Show the result.
	if ( $result ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'The test mail was sent successfully.', 'cl-simplest-smtp' ); ?></p>
		</div>
		<?php
	} else {
		?>
		<div class="notice notice-error is-dismissible">
			<p><?php esc_html_e( 'The test mail was not sent. Please check the SMTP settings.', 'cl-simplest-smtp' ); ?></p>
		</div>
		<?php
	}
}

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
