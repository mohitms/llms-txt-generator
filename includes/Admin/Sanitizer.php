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

		// Normalize unexpected input types.
		if ( ! is_string( $input ) ) {
			$input = '';
		}

		// 1. Trim whitespace from start/end.
		$input = trim( $input );

		// 1b. Enforce valid UTF-8.
		$input = wp_check_invalid_utf8( $input, true );

		// 2. Remove null bytes (basic binary safety).
		$input = str_replace( chr( 0 ), '', $input );

		// 3. Strip control characters that could break plain-text rendering.
		$input = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/u', '', $input );

		// 4. Strip all HTML tags.
		$input = wp_strip_all_tags( $input );

		// 5. Enforce a reasonable maximum length to avoid oversized outputs.
		$max_length = apply_filters( 'llms_txt_content_max_length', 20000 );
		$length_before_limit = mb_strlen( $input );
		if ( is_numeric( $max_length ) && $max_length > 0 ) {
			$max_length = (int) $max_length;
			if ( $length_before_limit > $max_length ) {
				add_settings_error(
					'llms_txt_content',
					'llms_txt_truncated',
					sprintf(
						__( 'Your LLMS.txt content was truncated to %d characters for safety.', 'simple-llms-txt' ),
						$max_length
					),
					'notice-warning'
				);
				$input = mb_substr( $input, 0, $max_length );
			}
		}

		// 6. Normalize line endings and final output format.
		$input = sanitize_textarea_field( $input );

		return $input;
	}
}
