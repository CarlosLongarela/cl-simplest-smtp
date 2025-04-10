<?php
/**
 * CL Simplest SMTP
 *
 * @package           CL\Simplest_SMTP
 * @author            Carlos Longarela
 * @copyright         2024 Carlos Longarela
 * @license           GPL-2.0-or-later
 * @updated           2025-01-23
 * @github            https://github.com/CarlosLongarela/cl-simplest-smtp/
 *
 * @wordpress-plugin
 * Plugin Name:       CL Simplest SMTP
 * Plugin URI:        https://wordpress.org/plugins/cl-simplest-smtp/
 * Description:       The simplest SMTP option for your WordPress.
 * Version:           1.2.2
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Tested up to:      6.7.1
 * Author:            Carlos Longarela
 * Author URI:        https://tabernawp.com/
 * Text Domain:       cl-simplest-smtp
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace CL\Simplest_SMTP;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Code is Poetry, but you are not an poet ;)' );
}

// Define plugin constants.
define( 'CL_SIMPLEST_SMTP_VERSION', '1.2.2' );
define( 'CL_SIMPLEST_SMTP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CL_SIMPLEST_SMTP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Define the log file name.
if ( ! defined( 'CL_SIMPLEST_SMTP_LOG_FILENAME' ) ) {
	define( 'CL_SIMPLEST_SMTP_LOG_FILENAME', 'cl-simplest-smtp-log.txt' );
}

/**
 * Load plugin text domain.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( 'cl-simplest-smtp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
// Load plugin text domain.
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

// Load plugin parameters from constants or from WordPress plugin options.
require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-smtp-params.php';

// Load plugin functions.
require_once CL_SIMPLEST_SMTP_PLUGIN_DIR . 'includes/cl-simplest-functions.php';


if ( check_params() ) {
	add_action( 'phpmailer_init', __NAMESPACE__ . '\use_email_smtp' );
} else {
	add_action( 'admin_notices', __NAMESPACE__ . '\show_no_params_notice' );
}

/**
 * Enqueue styles for the plugin settings page.
 *
 * @return void
 */
function enqueue_styles() {
	$screen = get_current_screen();

	if ( 'settings_page_cl-simplest-smtp' === $screen->id ) {
		wp_enqueue_style( 'cl-simplest-smtp-styles', CL_SIMPLEST_SMTP_PLUGIN_URL . 'assets/css/smtp-styles.css', array(), CL_SIMPLEST_SMTP_VERSION );
		wp_enqueue_script( 'cl-simplest-smtp-scripts', CL_SIMPLEST_SMTP_PLUGIN_URL . 'assets/js/smtp-scripts.js', array(), CL_SIMPLEST_SMTP_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles' );

/**
 * Activación del plugin.
 */
function cl_simplest_smtp_activate() {
	create_log_file_if_not_exists();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\cl_simplest_smtp_activate' );
