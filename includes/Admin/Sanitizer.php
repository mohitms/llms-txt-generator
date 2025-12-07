<?php

namespace LLMSTxt\Admin;

/**
 * Handles sanitization of plugin options.
 */
class Sanitizer {

	/**
	 * Sanitize the content before saving.
	 *
	 * @param string $input User input.
	 * @return string Sanitized input (HTML stripped).
	 */
	public function sanitize_content( $input ) {
		// Strict security check: ensure the user actually has permission 
		// even if they bypassed the UI check.
		if ( ! current_user_can( 'manage_options' ) ) {
			add_settings_error( 
				'llms_txt_content', 
				'llms_txt_capability_error', 
				__( 'You do not have permission to edit this setting.', 'simple-llms-txt' ) 
			);
			return get_option( 'llms_txt_content' );
		}

		// 1. Trim whitespace from start/end.
		$input = trim( $input );

		// 2. Remove null bytes (basic binary safety).
		$input = str_replace( chr( 0 ), '', $input );

		// 3. Strip all HTML tags.
		$input = wp_strip_all_tags( $input );

		return $input;
	}
}
