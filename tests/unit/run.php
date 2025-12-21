<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/SanitizerTest.php';
require_once __DIR__ . '/ServerTest.php';

$tests = [
	new SanitizerTest(),
	new ServerTest(),
];

$failures = 0;
$total    = 0;

foreach ( $tests as $test ) {
	$methods = array_filter(
		get_class_methods( $test ),
		static function ( $method ) {
			return strpos( $method, 'test' ) === 0;
		}
	);

	foreach ( $methods as $method ) {
		++$total;
		try {
			$test->{$method}();
			echo '.';
		} catch ( Exception $e ) {
			++$failures;
			echo 'F';
			fwrite( STDERR, PHP_EOL . get_class( $test ) . '::' . $method . ' - ' . $e->getMessage() . PHP_EOL );
		}
	}
}

echo PHP_EOL . sprintf( 'Ran %d tests: %d failure(s).', $total, $failures ) . PHP_EOL;

if ( $failures > 0 ) {
	exit( 1 );
}
