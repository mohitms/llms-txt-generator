<?php
/**
 * Plugin Name:       Simple LLMS.txt
 * Plugin URI:        https://example.com/simple-llms-txt
 * Description:       Create and manage the llms.txt file to provide context for Large Language Models (LLMs).
 * Version:           1.1.0
 * Author:            Mohit
 * Author URI:        https://example.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-llms-txt
 * Domain Path:       /languages
 */

namespace LLMSTxt;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'SIMPLE_LLMS_TXT_VERSION', '1.1.0' );

/**
 * Simple Autoloader for namespaces.
 * Maps LLMSTxt\Namespace\Class to includes/Namespace/Class.php
 */
spl_autoload_register( function ( $class ) {
	$prefix = 'LLMSTxt\\';
	$base_dir = plugin_dir_path( __FILE__ ) . 'includes/';

	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$relative_class = substr( $class, $len );
	
	// Replace namespace separators with directory separators in the relative class name, append with .php
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
});

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/Core/Activator.php
 */
function activate_simple_llms_txt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Core/Activator.php';
	LLMSTxt\Core\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/Core/Deactivator.php
 */
function deactivate_simple_llms_txt() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Core/Deactivator.php';
	LLMSTxt\Core\Deactivator::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate_simple_llms_txt' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate_simple_llms_txt' );

/**
 * Begins execution of the plugin.
 */
function run_simple_llms_txt() {
	if ( ! function_exists( 'add_action' ) ) {
		return;
	}

	$plugin_class_path = plugin_dir_path( __FILE__ ) . 'includes/Core/Plugin.php';
	if ( file_exists( $plugin_class_path ) ) {
		require_once $plugin_class_path;
	}

	if ( class_exists( '\LLMSTxt\Core\Plugin' ) ) {
		$plugin = new LLMSTxt\Core\Plugin();
		$plugin->run();
	}
}

run_simple_llms_txt();
