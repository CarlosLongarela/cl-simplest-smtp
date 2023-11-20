<?php
/**
 * Template for the contact form.
 *
 * @package CL\Simplest_SMTP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form id="cl-simplest-smtp-contact-form" method="post">
	<label for="cl-simplest-smtp-name"><?php esc_html_e( 'Name', 'cl-simplest-smtp' ); ?></label>
	<input type="text" name="cl-simplest-smtp-name" id="cl-simplest-smtp-name" required>

	<label for="cl-simplest-smtp-email"><?php esc_html_e( 'Email', 'cl-simplest-smtp' ); ?></label>
	<input type="email" name="cl-simplest-smtp-email" id="cl-simplest-smtp-email" required>

	<label for="cl-simplest-smtp-message"><?php esc_html_e( 'Message', 'cl-simplest-smtp' ); ?></label>
	<textarea name="cl-simplest-smtp-message" id="cl-simplest-smtp-message" required></textarea>

	<input type="submit" value="<?php esc_attr_e( 'Send', 'cl-simplest-smtp' ); ?>">
</form>