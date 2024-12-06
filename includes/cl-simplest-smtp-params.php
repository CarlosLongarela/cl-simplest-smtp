<?php
/**
 * CL Simplest SMTP define parameters.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' ) ) {
	$cl_simplest_smtp = get_option( 'cl_simplest_smtp' );

	if ( false === $cl_simplest_smtp ) {
		$cl_simplest_smtp = array(
			'host'   => '',
			'auth'   => false,
			'port'   => 25,
			'user'   => '',
			'pass'   => '',
			'secure' => '',
			'from'   => '',
			'name'   => '',
		);
	}

	define( 'CL_SIMPLEST_SMTP_HOST', esc_attr( $cl_simplest_smtp['host'] ) );

	if ( ! defined( 'CL_SIMPLEST_SMTP_AUTH' ) ) {
		define( 'CL_SIMPLEST_SMTP_AUTH', filter_var( $cl_simplest_smtp['auth'], FILTER_VALIDATE_BOOLEAN ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PORT' ) ) {
		define( 'CL_SIMPLEST_SMTP_PORT', absint( $cl_simplest_smtp['port'] ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_USER' ) ) {
		define( 'CL_SIMPLEST_SMTP_USER', esc_attr( $cl_simplest_smtp['user'] ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_PASS' ) ) {
		define( 'CL_SIMPLEST_SMTP_PASS', esc_attr( $cl_simplest_smtp['pass'] ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_SECURE' ) ) {
		define( 'CL_SIMPLEST_SMTP_SECURE', esc_attr( $cl_simplest_smtp['secure'] ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_FROM' ) ) {
		define( 'CL_SIMPLEST_SMTP_FROM', filter_var( $cl_simplest_smtp['from'], FILTER_VALIDATE_EMAIL ) );
	}

	if ( ! defined( 'CL_SIMPLEST_SMTP_NAME' ) ) {
		define( 'CL_SIMPLEST_SMTP_NAME', esc_attr( $cl_simplest_smtp['name'] ) );
	}
}
