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
			$this->send_header( 'Content-Type: text/plain; charset=utf-8' );
			$this->send_header( 'Cache-Control: no-cache, must-revalidate' );
			$this->send_header( 'X-Content-Type-Options: nosniff' );
			
			// Allow integrators to keep or remove X-Robots-Tag for this endpoint.
			$remove_x_robots = apply_filters( 'llms_txt_remove_x_robots_tag', true );
			if ( $remove_x_robots ) {
				$this->remove_header( 'X-Robots-Tag' ); 
			}

			$extra_headers = apply_filters( 'llms_txt_additional_headers', array() );
			if ( is_array( $extra_headers ) && ! empty( $extra_headers ) ) {
				foreach ( $extra_headers as $header_name => $header_value ) {
					if ( is_string( $header_name ) && '' !== $header_name && is_string( $header_value ) ) {
						$this->send_header( $header_name . ': ' . $header_value );
					}
				}
			}

			$content = get_option( self::OPTION_NAME, '' );
			$content = apply_filters( 'llms_txt_content', $content );
			$content = sanitize_textarea_field( $content );
			
			// Output raw content.
			$this->finish_response( $content );
		}
	}

	/**
	 * Send a header string.
	 *
	 * @param string $header Header string.
	 */
	protected function send_header( $header ) {
		header( $header );
	}

	/**
	 * Remove a specific header by name.
	 *
	 * @param string $name Header name.
	 */
	protected function remove_header( $name ) {
		header_remove( $name );
	}

	/**
	 * Finalize the response with output and exit.
	 *
	 * @param string $content Content to output.
	 */
	protected function finish_response( $content ) {
		echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}
}
