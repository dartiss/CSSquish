<?php
/**
 * CompreSS
 *
 * Compress a CSS script.
 *
 * @package  css-compress
 * @version  0.1.1
 * 
 * @param  string $contents  CSS to be compressed.
 * @param  array  $paras     Array of passed parameters.
 * @return string            Compressed CSS.
 */
function compress_css( $contents, $paras = array( 'test' => false ) ) {

	include 'inc/load-arrays.php';

	// Strip comments.

	$start = strpos( $contents, '/*' );

	while ( false !== $start ) {
		
		$end = strpos( $contents, '*/' );
		if ( ! $end ) {
			$end = strlen( $contents );
		}
		if ( 0 == $start ) {
			$contents = substr( $contents, $end + 2 );
		} else {
			$contents = substr( $contents, 0, $start - 1 ) . substr( $contents, $end + 2 );
		}
	
		$start = strpos( $contents, '/*' );
	}

	// Remove multi-spaces.

	while ( false !== strpos( $contents, '  ' ) ) {
		$contents = str_replace( '  ', ' ', $contents );
	}

	// Replace specific characters.

	$contents = str_replace( $search_group1, $replace_group1, $contents );

	if ( false == $paras['test'] ) {
		$contents = str_replace( $search_group2, $replace_group2, $contents );
	}

	// Convert RGB decimal numbers to hex.
	// Format will be rgb(255,0,0).
	
	// Reduce hex numbers.

	$loop = 0;
	while ( $loop < 4096 ) {
		$short_hex = str_pad( dechex( $loop ), 3, '0', STR_PAD_LEFT );
		$long_hex  = substr( $short_hex, 0, 1 ) . substr( $short_hex, 0, 1 ) . substr( $short_hex, 1, 1 ) . substr( $short_hex, 1, 1 ) . substr( $short_hex, 2, 1 ) . substr( $short_hex, 2, 1 );
		$contents  = str_ireplace( $long_hex, $short_hex, $contents );

		$loop++;
	}

	// Convert hex to color codes, or color to hex, where the result will be smaller.

	foreach ( $switch_color as list( $from, $to ) ) {
		$from     = 'color:' . strtolower( $from ) . ';';
		$to       = 'color:' . strtolower( $to ) . ';';
		$contents = str_ireplace( $from, $to, $contents );
	}

	return $contents;
}
