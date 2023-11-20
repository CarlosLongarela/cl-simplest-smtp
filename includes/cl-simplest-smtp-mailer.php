<?php
/**
 * CL Simplest SMTP Mailer class.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * CL Simplest SMTP Mailer class.
 */
class CL_Simplest_SMTP_Mailer {

	/**
	 * SMTP server.
	 *
	 * @var string
	 */
	private $server;

	/**
	 * SMTP port.
	 *
	 * @var int
	 */
	private $port;

	/**
	 * SMTP username.
	 *
	 * @var string
	 */
	private $username;

	/**
	 * SMTP password.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * From email address.
	 *
	 * @var string
	 */
	private $from_email;

	/**
	 * From name.
	 *
	 * @var string
	 */
	private $from_name;

	/**
	 * Constructor.
	 *
	 * @param string $server     SMTP server.
	 * @param int    $port       SMTP port.
	 * @param string $username   SMTP username.
	 * @param string $password   SMTP password.
	 * @param string $from_email From email address.
	 * @param string $from_name  From name.
	 */
	public function __construct( $server, $port, $username, $password, $from_email, $from_name ) {
		$this->server     = $server;
		$this->port       = $port;
		$this->username   = $username;
		$this->password   = $password;
		$this->from_email = $from_email;
		$this->from_name  = $from_name;
	}

	/**
	 * Sends an email using the SMTP server.
	 *
	 * @param string $to      Recipient email address.
	 * @param string $subject Email subject.
	 * @param string $message Email message.
	 *
	 * @return bool Whether the email was sent successfully.
	 */
	public function send( $to, $subject, $message ) {
		$mail = new PHPMailer( true );

		try {
			//Server settings
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host       = $this->server;
			$mail->SMTPAuth   = true;
			$mail->Username   = $this->username;
			$mail->Password   = $this->password;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = $this->port;

			//Recipients
			$mail->setFrom( $this->from_email, $this->from_name );
			$mail->addAddress( $to );

			//Content
			$mail->isHTML( true );
			$mail->Subject = $subject;
			$mail->Body    = $message;

			$mail->send();
			return true;
		} catch ( Exception $e ) {
			return false;
		}
	}
}