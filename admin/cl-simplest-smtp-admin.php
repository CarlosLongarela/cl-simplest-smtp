<?php
/**
 * The admin panel of the CL Simplest SMTP plugin.
 *
 * @package CL\Simplest_SMTP
 */

namespace CL\Simplest_SMTP;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin panel of the CL Simplest SMTP plugin.
 */
class Admin {

	/**
	 * The settings page slug.
	 *
	 * @var string
	 */
	private $page_slug = 'cl-simplest-smtp';

	/**
	 * The settings page title.
	 *
	 * @var string
	 */
	private $page_title = 'CL Simplest SMTP Settings';

	/**
	 * The settings page menu title.
	 *
	 * @var string
	 */
	private $menu_title = 'CL Simplest SMTP';

	/**
	 * The capability required to access the settings page.
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * The SMTP server setting.
	 *
	 * @var string
	 */
	private $server;

	/**
	 * The SMTP port setting.
	 *
	 * @var int
	 */
	private $port;

	/**
	 * The SMTP username setting.
	 *
	 * @var string
	 */
	private $username;

	/**
	 * The SMTP password setting.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * The from email setting.
	 *
	 * @var string
	 */
	private $from_email;

	/**
	 * The from name setting.
	 *
	 * @var string
	 */
	private $from_name;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Load the settings.
		$this->load_settings();

		// Add the settings page.
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

		// Register the settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Load the settings.
	 */
	private function load_settings() {
		$this->server     = get_option( 'cl_simplest_smtp_server' );
		$this->port       = get_option( 'cl_simplest_smtp_port' );
		$this->username   = get_option( 'cl_simplest_smtp_username' );
		$this->password   = get_option( 'cl_simplest_smtp_password' );
		$this->from_email = get_option( 'cl_simplest_smtp_from_email' );
		$this->from_name  = get_option( 'cl_simplest_smtp_from_name' );
	}

	/**
	 * Add the settings page.
	 */
	public function add_settings_page() {
		add_options_page(
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->page_slug,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Render the settings page.
	 */
	public function render_settings_page() {
		// Load the template.
		include_once plugin_dir_path( __FILE__ ) . 'templates/settings-page.php';
	}

	/**
	 * Register the settings.
	 */
	public function register_settings() {
		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_server'
		);

		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_port'
		);

		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_username'
		);

		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_password'
		);

		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_from_email'
		);

		register_setting(
			'cl_simplest_smtp_settings',
			'cl_simplest_smtp_from_name'
		);
	}
}