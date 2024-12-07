<?php
/**
 * CL Simplest SMTP hook to send mail.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

/**
 * Configure internal WordPress phpmailer to use SMTP.
 *
 * @param object $phpmailer PhpMailer object.
 *
 * @return void
 */
function use_email_smtp( $phpmailer ) {
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$phpmailer->isSMTP();
	$phpmailer->Host       = CL_SIMPLEST_SMTP_HOST;
	$phpmailer->SMTPAuth   = CL_SIMPLEST_SMTP_AUTH;
	$phpmailer->Port       = CL_SIMPLEST_SMTP_PORT;
	$phpmailer->Username   = CL_SIMPLEST_SMTP_USER;
	$phpmailer->Password   = CL_SIMPLEST_SMTP_PASS;
	$phpmailer->SMTPSecure = CL_SIMPLEST_SMTP_SECURE;

	if ( defined( 'CL_SIMPLEST_SMTP_FROM' ) && ! empty( CL_SIMPLEST_SMTP_FROM ) ) {
		$phpmailer->From = CL_SIMPLEST_SMTP_FROM;
	}

	if ( defined( 'CL_SIMPLEST_SMTP_NAME' ) && ! empty( CL_SIMPLEST_SMTP_NAME ) ) {
		$phpmailer->FromName = CL_SIMPLEST_SMTP_NAME;
	}
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}

/**
 * Check if all parameters are defined and correct.
 *
 * @return bool
 */
function check_params() {
	if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_AUTH' ) || ! is_bool( CL_SIMPLEST_SMTP_AUTH ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PORT' ) || ! is_int( CL_SIMPLEST_SMTP_PORT ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_USER' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PASS' ) ) {
		return false;
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_SECURE' ) || ( 'tls' !== CL_SIMPLEST_SMTP_SECURE && 'ssl' !== CL_SIMPLEST_SMTP_SECURE ) ) {
		return false;
	}

	return true;
}

if ( check_params() ) {
	add_action( 'phpmailer_init', 'CL\Simplest_SMTP\use_email_smtp' );
}
