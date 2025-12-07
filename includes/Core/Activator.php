<?php

namespace LLMSTxt\Core;

/**
 * Fired during plugin activation.
 */
class Activator {

	/**
	 * Activate the plugin.
	 *
	 * Add rewrite rules and flush them.
	 */
	public static function activate() {
		// specific rewrite rules are added here just for flushing.
		// In a real scenario, we might want to dependency inject the rules logic, 
		// but to keep it simple and decoupled, we repeat the specific rule or instantiate the public class.
		// Instantiating the public class is better to avoid duplication.
		
		// We'll rely on the main plugin file's activation hook which usually runs after class loading.
		// But since this is a static method called by the hook, we need to ensure the rule is known.
		
		add_rewrite_rule( '^llms\.txt$', 'index.php?llms_txt=1', 'top' );
		flush_rewrite_rules();
	}
}
