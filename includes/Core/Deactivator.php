<?php

namespace LLMSTxt\Core;

/**
 * Fired during plugin deactivation.
 */
class Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Flush rewrite rules to clean up.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
