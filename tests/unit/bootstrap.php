<?php
declare(strict_types=1);

$GLOBALS['__llms_txt_filters']          = [];
$GLOBALS['__llms_txt_options']          = [];
$GLOBALS['__llms_txt_settings_errors']  = [];
$GLOBALS['__llms_txt_query_vars']       = [];

function llms_txt_reset_test_state(): void {
	$GLOBALS['__llms_txt_filters']          = [];
	$GLOBALS['__llms_txt_options']          = [];
	$GLOBALS['__llms_txt_settings_errors']  = [];
	$GLOBALS['__llms_txt_query_vars']       = [];
}

function add_filter( $tag, $callback, $priority = 10, $accepted_args = 1 ) {
	$GLOBALS['__llms_txt_filters'][ $tag ][ $priority ][] = [ $callback, $accepted_args ];
}

function apply_filters( $tag, $value ) {
	$args = func_get_args();
	array_shift( $args ); // drop tag.

	if ( empty( $GLOBALS['__llms_txt_filters'][ $tag ] ) ) {
		return $value;
	}

	ksort( $GLOBALS['__llms_txt_filters'][ $tag ] );

	foreach ( $GLOBALS['__llms_txt_filters'][ $tag ] as $priority => $callbacks ) {
		foreach ( $callbacks as $callback_data ) {
			$callback      = $callback_data[0];
			$accepted_args = $callback_data[1];
			$callback_args = array_slice( $args, 0, $accepted_args );
			$value         = call_user_func_array( $callback, $callback_args );
			$args[0]       = $value; // ensure next filter receives updated value.
		}
	}

	return $value;
}

function current_user_can( $cap ) {
	return true;
}

function add_settings_error( $setting, $code, $message, $type = 'error' ) {
	$GLOBALS['__llms_txt_settings_errors'][] = [
		'setting' => $setting,
		'code'    => $code,
		'message' => $message,
		'type'    => $type,
	];
}

function wp_check_invalid_utf8( $string ) {
	return $string;
}

function wp_strip_all_tags( $string ) {
	return strip_tags( $string );
}

function sanitize_textarea_field( $string ) {
	$string = strip_tags( (string) $string );
	$string = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/u', '', $string );
	$string = preg_replace( '/[\r\n]+/', "\n", $string );
	return trim( $string );
}

function __( $text ) {
	return $text;
}

function get_option( $name, $default = '' ) {
	return $GLOBALS['__llms_txt_options'][ $name ] ?? $default;
}

function get_query_var( $name ) {
	return $GLOBALS['__llms_txt_query_vars'][ $name ] ?? null;
}

// Load classes directly to avoid requiring WordPress bootstrap.
require_once __DIR__ . '/../../includes/Admin/Sanitizer.php';
require_once __DIR__ . '/../../includes/PublicOutput/Server.php';

/**
 * Minimal test harness.
 */
abstract class LLMS_Txt_TestCase {
	protected function assertEquals( $expected, $actual, string $message = '' ): void {
		if ( $expected !== $actual ) {
			throw new Exception( $message ?: sprintf( 'Failed asserting that [%s] matches expected [%s].', var_export( $actual, true ), var_export( $expected, true ) ) );
		}
	}

	protected function assertTrue( $condition, string $message = '' ): void {
		if ( true !== $condition ) {
			throw new Exception( $message ?: 'Failed asserting that condition is true.' );
		}
	}
}
