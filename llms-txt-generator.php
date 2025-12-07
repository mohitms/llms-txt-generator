<?php
/**
 * Plugin Name: LLMS.txt Generator and Manager
 * Plugin URI:  https://yourdomain.com
 * Description: Create, manage, and serve an llms.txt file virtually from your WordPress dashboard.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourdomain.com
 * License:     GPL-2.0+
 * Text Domain: llms-txt-generator
 * Domain Path: /languages
 */

namespace LLMSTxt;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
 * Activation Hook
 */
function activate_plugin() {
	Core\Activator::activate();
}

/**
 * Deactivation Hook
 */
function deactivate_plugin() {
	Core\Deactivator::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate_plugin' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate_plugin' );

/**
 * Begins execution of the plugin.
 */
function run_plugin() {
	$plugin = new Core\Plugin();
	$plugin->run();
}

run_plugin();
