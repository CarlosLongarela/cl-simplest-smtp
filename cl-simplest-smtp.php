<?php
/**
 * Plugin Name: CL Simplest SMTP
 * Plugin URI: https://example.com/plugins/cl-simplest-smtp/
 * Description: A simple SMTP plugin for WordPress.
 * Version: 1.0.0
 * Author: Carlos Longarela
 * Author URI: https://tabernawp.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cl-simplest-smtp
 * Domain Path: /languages
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'CL_SIMPLEST_SMTP_VERSION', '1.0.0' );
define( 'CL_SIMPLEST_SMTP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CL_SIMPLEST_SMTP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin text domain.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( 'cl-simplest-smtp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
// Load plugin text domain.
add_action( 'plugins_loaded', 'CL\Simplest_SMTP\load_text_domain' );

// Load plugin files.
//require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'admin/cl-simplest-smtp-admin.php';
//require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-smtp-functions.php';
//require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-smtp-mailer.php';
//require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'public/cl-simplest-smtp-public.php';
