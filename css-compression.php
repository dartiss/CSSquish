<?php
function compress_css( $contents ) {

	$len_before = strlen( $contents );
	$start      = strpos( $contents, '/*' );

	// Strip comments.

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

	$contents = str_replace( chr( 9 ), '', $contents );
	$contents = str_replace( chr( 10 ), '', $contents );
	$contents = str_replace( chr( 13 ), '', $contents );
	$contents = str_replace( ': ', ':', $contents );
	$contents = str_replace( ' :', ':', $contents );
	$contents = str_replace( ' {', '{', $contents );
	$contents = str_replace( '{ ', '{', $contents );
	$contents = str_replace( '} ', '}', $contents );
	$contents = str_replace( ' }', '}', $contents );
	$contents = str_replace( ', ', ',', $contents );
	$contents = str_replace( ' ,', ',', $contents );
	$contents = str_replace( '; ', ';', $contents );
	$contents = str_replace( ' ;', ';', $contents );
	
	// Reduce hex numbers.

	$hex_string = '0123456789ABCDEF';
	
	$i1 = 0;
	while ( $i1 < 16 ) {
		$i2 = 0;
		while ( $i2 < 16 ) {
			$i3 = 0;
			while ( $i3 < 16 ) {
				$search   = substr( $hex_string, $i1, 1 ) . substr( $hex_string, $i1, 1 ) . substr( $hex_string, $i2, 1 );
				$search   = $search . substr( $hex_string, $i2, 1 ) . substr( $hex_string, $i3, 1 ) . substr( $hex_string, $i3, 1 );
				$replace  = substr( $hex_string, $i1, 1 ) . substr( $hex_string, $i2, 1 ) . substr( $hex_string, $i3, 1 );
				$contents = str_replace( $search, $replace, $contents );
				$i3++;
			}
			$i2++;
		}
		$i1++;
	}

	// Create output array.

	$result['output']  = $contents;
	$result['before']  = $len_before;
	$result['after']   = strlen( $contents );
	$result['percent'] = 100 - ( ( $result['after'] / $len_before ) * 100 );

	return $result;
}
