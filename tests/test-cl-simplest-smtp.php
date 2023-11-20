<?php
/**
 * Unit tests for CL Simplest SMTP plugin.
 *
 * @package CL_Simplest_SMTP
 */

namespace CL\Simplest_SMTP\Tests;

use CL\Simplest_SMTP_Mailer;
use WP_UnitTestCase;

/**
 * Test CL Simplest SMTP plugin.
 */
class Test_CL_Simplest_SMTP extends WP_UnitTestCase {

	/**
	 * Test sending email using SMTP server.
	 */
	public function test_send_email_using_smtp() {
		// Set up SMTP server settings.
		$server = 'smtp.example.com';
		$port = 587;
		$username = 'user@example.com';
		$password = 'password';
		$from_email = 'noreply@example.com';
		$from_name = 'Example';

		// Set up recipient email.
		$to = 'recipient@example.com';

		// Set up email subject and message.
		$subject = 'Test email';
		$message = 'This is a test email sent using SMTP server.';

		// Create new instance of Simplest SMTP Mailer.
		$mailer = new Simplest_SMTP_Mailer( $server, $port, $username, $password, $from_email, $from_name );

		// Send email using SMTP server.
		$result = $mailer->send( $to, $subject, $message );

		// Check if email was sent successfully.
		$this->assertTrue( $result );
	}

	/**
	 * Test sending email without using SMTP server.
	 */
	public function test_send_email_without_smtp() {
		// Set up recipient email.
		$to = 'recipient@example.com';

		// Set up email subject and message.
		$subject = 'Test email';
		$message = 'This is a test email sent without using SMTP server.';

		// Send email using wp_mail function.
		$result = wp_mail( $to, $subject, $message );

		// Check if email was sent successfully.
		$this->assertTrue( $result );
	}
}