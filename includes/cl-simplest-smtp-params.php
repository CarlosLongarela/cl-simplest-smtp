<?php
/**
 * CL Simplest SMTP define parameters.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// Exit if accessed directly.
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

if ( ! defined( 'CL_SIMPLEST_SMTP_HOST' ) ) {
	// Here we define that the plugin options were setted form the database (options table).
	define( 'CL_SIMPLEST_SMTP_HOST_FROM_DB', true );

	// If the constant is not defined, get ALL the values from the plugin options.
	$cl_simplest_smtp_data = get_option( 'cl_simplest_smtp_options' );

	$cl_simplest_smtp_host   = get_option( 'cl_simplest_smtp_host' );
	$cl_simplest_smtp_port   = get_option( 'cl_simplest_smtp_port' );
	$cl_simplest_smtp_auth   = get_option( 'cl_simplest_smtp_auth' );
	$cl_simplest_smtp_user   = get_option( 'cl_simplest_smtp_user' );
	$cl_simplest_smtp_pass   = get_option( 'cl_simplest_smtp_pass' );
	$cl_simplest_smtp_secure = get_option( 'cl_simplest_smtp_secure' );
	$cl_simplest_smtp_from   = get_option( 'cl_simplest_smtp_from' );
	$cl_simplest_smtp_name   = get_option( 'cl_simplest_smtp_name' );

	define( 'CL_SIMPLEST_SMTP_HOST', esc_attr( $cl_simplest_smtp_host ) );
	define( 'CL_SIMPLEST_SMTP_AUTH', filter_var( $cl_simplest_smtp_auth, FILTER_VALIDATE_BOOLEAN ) );
	define( 'CL_SIMPLEST_SMTP_PORT', filter_var( $cl_simplest_smtp_port, FILTER_VALIDATE_INT ) );
	define( 'CL_SIMPLEST_SMTP_USER', esc_attr( $cl_simplest_smtp_user ) );
	define( 'CL_SIMPLEST_SMTP_PASS', esc_attr( $cl_simplest_smtp_pass ) );
	define( 'CL_SIMPLEST_SMTP_SECURE', esc_attr( $cl_simplest_smtp_secure ) );
	define( 'CL_SIMPLEST_SMTP_FROM', filter_var( $cl_simplest_smtp_from, FILTER_VALIDATE_EMAIL ) );
	define( 'CL_SIMPLEST_SMTP_NAME', esc_attr( $cl_simplest_smtp_name ) );
}
