<?php
declare(strict_types=1);

use LLMSTxt\PublicOutput\Server;

require_once __DIR__ . '/bootstrap.php';

class TestableServer extends Server {
	public $headers         = [];
	public $removed_headers = [];
	public $output;

	protected function send_header( $header ) {
		$this->headers[] = $header;
	}

	protected function remove_header( $name ) {
		$this->removed_headers[] = $name;
	}

	protected function finish_response( $content ) {
		$this->output = $content;
	}
}

class ServerTest extends LLMS_Txt_TestCase {
	public function test_outputs_sanitized_content_with_headers(): void {
		llms_txt_reset_test_state();

		$GLOBALS['__llms_txt_query_vars']['llms_txt'] = 1;
		$GLOBALS['__llms_txt_options']['llms_txt_content'] = "Hello<script>alert(1)</script>\x07World";

		add_filter( 'llms_txt_additional_headers', function () {
			return [
				'X-Custom-Header' => 'LLMS-TXT',
			];
		} );

		$server = new TestableServer();
		$server->handle_template_redirect();

		$this->assertTrue( in_array( 'Content-Type: text/plain; charset=utf-8', $server->headers, true ), 'Content-Type header missing' );
		$this->assertTrue( in_array( 'Cache-Control: no-cache, must-revalidate', $server->headers, true ), 'Cache-Control header missing' );
		$this->assertTrue( in_array( 'X-Content-Type-Options: nosniff', $server->headers, true ), 'nosniff header missing' );
		$this->assertTrue( in_array( 'X-Custom-Header: LLMS-TXT', $server->headers, true ), 'Custom header missing' );
		$this->assertTrue( in_array( 'X-Robots-Tag', $server->removed_headers, true ), 'X-Robots-Tag should be removable' );
		$this->assertEquals( 'Helloalert(1)World', $server->output, 'Output should be sanitized to plain text.' );
	}
}
