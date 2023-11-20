<?php
/**
 * This file contains the code for the public-facing part of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

/**
 * Sets up the contact form and handles the form submission.
 */
class Public_Facing {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'cl_simplest_smtp_contact_form', array( $this, 'render_contact_form' ) );
		add_action( 'wp_ajax_cl_simplest_smtp_send_email', array( $this, 'send_email' ) );
		add_action( 'wp_ajax_nopriv_cl_simplest_smtp_send_email', array( $this, 'send_email' ) );
	}

	/**
	 * Renders the contact form.
	 *
	 * @return string The HTML for the contact form.
	 */
	public function render_contact_form() {
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'templates/contact-form.php' );
		return ob_get_clean();
	}

	/**
	 * Sends an email using the SMTP server.
	 */
	public function send_email() {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'cl_simplest_smtp_send_email' ) ) {
			wp_send_json_error( 'Invalid nonce.' );
		}

		$to = sanitize_email( $_POST['to'] );
		$subject = sanitize_text_field( $_POST['subject'] );
		$message = wp_kses_post( $_POST['message'] );

		$mailer = new Simplest_SMTP_Mailer();
		$result = $mailer->send( $to, $subject, $message );

		if ( $result ) {
			wp_send_json_success( 'Email sent successfully.' );
		} else {
			wp_send_json_error( 'Failed to send email.' );
		}
	}
}

new Public_Facing();