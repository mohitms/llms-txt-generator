<?php
declare(strict_types=1);

use LLMSTxt\Admin\Sanitizer;

require_once __DIR__ . '/bootstrap.php';

class SanitizerTest extends LLMS_Txt_TestCase {
	public function test_truncates_and_warns(): void {
		llms_txt_reset_test_state();

		add_filter( 'llms_txt_content_max_length', function () {
			return 10;
		} );

		$sanitizer = new Sanitizer();
		$result    = $sanitizer->sanitize_content( "   Hello<script>alert('x')</script>World   " );

		$this->assertEquals( 'Helloalert', $result, 'Content should be stripped, sanitized, and truncated.' );
		$this->assertTrue( ! empty( $GLOBALS['__llms_txt_settings_errors'] ), 'Settings errors should contain truncation notice.' );
		$this->assertEquals( 'llms_txt_truncated', $GLOBALS['__llms_txt_settings_errors'][0]['code'] );
	}

	public function test_non_string_input_returns_empty_string(): void {
		llms_txt_reset_test_state();
		$sanitizer = new Sanitizer();

		$this->assertEquals( '', $sanitizer->sanitize_content( [ 'invalid' ] ), 'Non-string inputs should be coerced to empty string.' );
	}
}
