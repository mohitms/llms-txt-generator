<?php

namespace LLMSTxt\Core;

/**
 * Define the internationalization functionality.
 */
class i18n {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'llms-txt-generator',
			false,
			dirname( dirname( dirname( plugin_basename( __FILE__ ) ) ) ) . '/languages/'
		);
	}
}
