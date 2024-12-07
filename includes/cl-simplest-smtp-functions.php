<?php
/**
 * This file contains helper functions used throughout the plugin.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

/**
 * Get the plugin option value.
 *
 * @param string $option_name The name of the option.
 * @param mixed  $default     The default value to return if the option is not set.
 *
 * @return mixed The option value.
 */
function get_option( $option_name, $default = null ) {
	$options = get_option( 'cl_simplest_smtp_options', array() );

	if ( isset( $options[ $option_name ] ) ) {
		return $options[ $option_name ];
	}

	return $default;
}

/**
 * Update the plugin option value.
 *
 * @param string $option_name The name of the option.
 * @param mixed  $value       The value to set.
 *
 * @return bool True if the option was updated, false otherwise.
 */
function update_option( $option_name, $value ) {
	$options = get_option( 'cl_simplest_smtp_options', array() );
	$options[ $option_name ] = $value;

	return update_option( 'cl_simplest_smtp_options', $options );
}

/**
 * Delete the plugin option value.
 *
 * @param string $option_name The name of the option.
 *
 * @return bool True if the option was deleted, false otherwise.
 */
function delete_option( $option_name ) {
	$options = get_option( 'cl_simplest_smtp_options', array() );

	if ( isset( $options[ $option_name ] ) ) {
		unset( $options[ $option_name ] );

		return update_option( 'cl_simplest_smtp_options', $options );
	}

	return false;
}
