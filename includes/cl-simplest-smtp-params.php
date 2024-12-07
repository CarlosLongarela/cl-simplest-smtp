<?php
/**
 * CL Simplest SMTP define parameters.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' ) ) {
	// Here we define that the plugin options were setted form the database (options table).
	define( 'CL_SIMPLEST_SMTP_HOST_FROM_DB', true );

	// If the constant is not defined, get ALL the values from the plugin options.
	$cl_simplest_smtp_data = get_option( 'cl_simplest_smtp_options' );

	if ( empty( $cl_simplest_smtp_data ) ) {
		$cl_simplest_smtp_host   = '';
		$cl_simplest_smtp_auth   = false;
		$cl_simplest_smtp_port   = '';
		$cl_simplest_smtp_user   = '';
		$cl_simplest_smtp_pass   = '';
		$cl_simplest_smtp_secure = '';
		$cl_simplest_smtp_from   = '';
		$cl_simplest_smtp_name   = '';
	} else {
		if ( isset( $cl_simplest_smtp_data['host'] ) ) {
			$cl_simplest_smtp_host = esc_attr( $cl_simplest_smtp_data['host'] );
		} else {
			$cl_simplest_smtp_host = '';
		}

		if ( isset( $cl_simplest_smtp_data['auth'] ) ) {
			$cl_simplest_smtp_auth = filter_var( $cl_simplest_smtp_data['auth'], FILTER_VALIDATE_BOOLEAN );
		} else {
			$cl_simplest_smtp_auth = false;
		}

		if ( isset( $cl_simplest_smtp_data['port'] ) ) {
			$cl_simplest_smtp_port = filter_var( $cl_simplest_smtp_data['port'], FILTER_VALIDATE_INT );
		} else {
			$cl_simplest_smtp_port = '';
		}

		if ( isset( $cl_simplest_smtp_data['user'] ) ) {
			$cl_simplest_smtp_user = esc_attr( $cl_simplest_smtp_data['user'] );
		} else {
			$cl_simplest_smtp_user = '';
		}

		if ( isset( $cl_simplest_smtp_data['pass'] ) ) {
			$cl_simplest_smtp_pass = esc_attr( $cl_simplest_smtp_data['pass'] );
		} else {
			$cl_simplest_smtp_pass = '';
		}

		if ( isset( $cl_simplest_smtp_data['secure'] ) ) {
			$cl_simplest_smtp_secure = esc_attr( $cl_simplest_smtp_data['secure'] );
		} else {
			$cl_simplest_smtp_secure = '';
		}

		if ( isset( $cl_simplest_smtp_data['from'] ) ) {
			$cl_simplest_smtp_from = filter_var( $cl_simplest_smtp_data['from'], FILTER_VALIDATE_EMAIL );
		} else {
			$cl_simplest_smtp_from = '';
		}

		if ( isset( $cl_simplest_smtp_data['name'] ) ) {
			$cl_simplest_smtp_name = esc_attr( $cl_simplest_smtp_data['name'] );
		} else {
			$cl_simplest_smtp_name = '';
		}
	}

	define( 'CL_SIMPLEST_SMTP_HOST', $cl_simplest_smtp_host );
	define( 'CL_SIMPLEST_SMTP_AUTH', $cl_simplest_smtp_auth );
	define( 'CL_SIMPLEST_SMTP_PORT', $cl_simplest_smtp_port );
	define( 'CL_SIMPLEST_SMTP_USER', $cl_simplest_smtp_user );
	define( 'CL_SIMPLEST_SMTP_PASS', $cl_simplest_smtp_pass );
	define( 'CL_SIMPLEST_SMTP_SECURE', $cl_simplest_smtp_secure );
	define( 'CL_SIMPLEST_SMTP_FROM', $cl_simplest_smtp_from );
	define( 'CL_SIMPLEST_SMTP_NAME', $cl_simplest_smtp_name );
}
