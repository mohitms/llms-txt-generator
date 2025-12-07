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
		add_rewrite_rule( '^llms\.txt$', 'index.php?llms_txt=1', 'top' );
		
		// Seed default content if not exists
		if ( false === get_option( 'llms_txt_content' ) || '' === get_option( 'llms_txt_content' ) ) {
			$site_title = get_bloginfo( 'name' );
			$site_desc  = get_bloginfo( 'description' );
			$default_content = "# " . $site_title . "\n\nDescription: " . $site_desc . "\n\n## Core Sections\n- /: Homepage\n- /blog: Latest updates\n";
			update_option( 'llms_txt_content', $default_content );
		}

		flush_rewrite_rules();
	}
}
