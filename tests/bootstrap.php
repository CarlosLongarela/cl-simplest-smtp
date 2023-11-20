<?php
/**
 * This file sets up the testing environment for the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

// Load the Composer autoloader.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Load the plugin files.
require_once dirname( __DIR__ ) . '/cl-simplest-smtp.php';
require_once dirname( __DIR__ ) . '/includes/cl-simplest-smtp-functions.php';
require_once dirname( __DIR__ ) . '/includes/cl-simplest-smtp-mailer.php';

// Load the WordPress testing framework.
require_once getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';