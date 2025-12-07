<?php

namespace LLMSTxt\PublicOutput;

/**
 * Handles the public output of the llms.txt file.
 */
class Server {

	/**
	 * Option name.
	 */
	const OPTION_NAME = 'llms_txt_content';

	/**
	 * Query var.
	 */
	const QUERY_VAR = 'llms_txt';

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		// Nothing needed here for now.
	}

	/**
	 * Register rewrite rules.
	 */
	public function add_rewrite_rules() {
		add_rewrite_rule( '^llms\.txt$', 'index.php?' . self::QUERY_VAR . '=1', 'top' );
	}

	/**
	 * Add query vars.
	 *
	 * @param array $vars Existing query vars.
	 * @return array Modified query vars.
	 */
	public function add_query_vars( $vars ) {
		$vars[] = self::QUERY_VAR;
		return $vars;
	}

	/**
	 * Template redirect handler.
	 */
	public function handle_template_redirect() {
		if ( get_query_var( self::QUERY_VAR ) ) {
			header( 'Content-Type: text/plain; charset=utf-8' );
			header( 'Cache-Control: no-cache, must-revalidate' );
			
			// Remove X-Robots-Tag to allow indexing (default behavior overridden if needed).
			header_remove( 'X-Robots-Tag' ); 

			$content = get_option( self::OPTION_NAME, '' );
			
			// Output raw content.
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			exit;
		}
	}
}
