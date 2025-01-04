<?php
/**
 * CL Simplest SMTP uninstall file.
 *
 * @package CL\Simplest_SMTP
 */

// If WordPress does not call this file, abort.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Delete options from the database.
delete_option( 'cl_simplest_smtp_options' );
