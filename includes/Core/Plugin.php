<?php

namespace LLMSTxt\Core;

use LLMSTxt\Admin\Settings;
use LLMSTxt\Admin\Sanitizer;
use LLMSTxt\PublicOutput\Server;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 */
class Plugin {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		$this->plugin_name = 'simple-llms-txt';
		$this->version     = '1.1.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies() {
		// Dependencies are autoloaded via the main file's autoloader or manual require.
		// We'll rely on the main file to set up autoloading.
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function set_locale() {
		$plugin_i18n = new i18n();
		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );
	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 */
	private function define_admin_hooks() {
		$sanitizer = new Sanitizer();
		$plugin_admin = new Settings( $this->get_plugin_name(), $this->get_version(), $sanitizer );

		add_action( 'admin_menu', array( $plugin_admin, 'register_admin_page' ) );
		add_action( 'admin_init', array( $plugin_admin, 'register_settings' ) );
	}

	/**
	 * Register all of the hooks related to the public facing functionality.
	 */
	private function define_public_hooks() {
		$plugin_public = new Server();

		add_action( 'init', array( $plugin_public, 'add_rewrite_rules' ) );
		add_filter( 'query_vars', array( $plugin_public, 'add_query_vars' ) );
		add_action( 'template_redirect', array( $plugin_public, 'handle_template_redirect' ) );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		// Hooks are added in constructor.
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The current version of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
