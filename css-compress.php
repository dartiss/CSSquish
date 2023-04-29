<?php
/**
 * CompreSS
 *
 * Compress a CSS script.
 *
 * @package  css-compress
 * 
 * @param string $contents  CSS to be compressed.
 * @return array            Array containing compressed CSS as well as statistics.
 */
function compress_css( $contents ) {

	$len_before = strlen( $contents );
	$start      = strpos( $contents, '/*' );

	// Load arras with color compression options (where hex is smaller than colour codes or vice versa).

	$switch_color = array(
		array( '#000080', 'Navy' ),
		array( '#008000', 'Green' ), 
		array( '#008080', 'Teal' ), 
		array( '#00FF00', 'Lime' ), 
		array( '#4B0082', 'Indigo' ), 
		array( '#800000', 'Maroon' ), 
		array( '#800080', 'Purple' ), 
		array( '#808000', 'Olive' ), 
		array( '#808080', 'Gray' ), 
		array( '#A0522D', 'Sienna' ), 
		array( '#A52A2A', 'Brown' ), 
		array( '#C0C0C0', 'Silver' ), 
		array( '#CD853F', 'Peru' ), 
		array( '#D2B48C', 'Tan' ), 
		array( '#DA70D6', 'Orchid' ), 
		array( '#DDA0DD', 'Plum' ), 
		array( '#EE82EE', 'Violet' ), 
		array( '#F0E68C', 'Khaki' ), 
		array( '#F00', 'Red' ), 
		array( '#F0FFFF', 'Azure' ), 
		array( '#F5DEB3', 'Wheat' ), 
		array( '#F5F5DC', 'Beige' ), 
		array( '#FA8072', 'Salmon' ), 
		array( '#FAF0E6', 'Linen' ), 
		array( '#FF6347', 'Tomato' ), 
		array( '#FF7F50', 'Coral' ), 
		array( '#FFA500', 'Orange' ), 
		array( '#FFC0CB', 'Pink' ), 
		array( '#FFD700', 'Gold' ), 
		array( '#FFE4C4', 'Bisque' ), 
		array( '#FFFAFA', 'Snow' ), 
		array( '#FFFFF0', 'Ivory' ), 
		array( '#808080', 'Grey' ),
		array( 'Black', '#000' ), 
		array( 'DarkBlue', '#00008B' ), 
		array( 'MediumBlue', '#0000CD' ), 
		array( 'DarkGreen', '#006400' ), 
		array( 'DarkCyan', '#008B8B' ), 
		array( 'DeepSkyBlue', '#00BFFF' ), 
		array( 'DarkTurquoise', '#00CED1' ), 
		array( 'MediumSpringGreen', '#00FA9A' ), 
		array( 'SpringGreen', '#00FF7F' ), 
		array( 'MidnightBlue', '#191970' ), 
		array( 'DodgerBlue', '#1E90FF' ), 
		array( 'LightSeaGreen', '#20B2AA' ), 
		array( 'ForestGreen', '#228B22' ), 
		array( 'SeaGreen', '#2E8B57' ), 
		array( 'DarkSlateGray', '#2F4F4F' ), 
		array( 'LimeGreen', '#32CD32' ), 
		array( 'MediumSeaGreen', '#3CB371' ), 
		array( 'Turquoise', '#40E0D0' ), 
		array( 'RoyalBlue', '#4169E1' ), 
		array( 'SteelBlue', '#4682B4' ), 
		array( 'DarkSlateBlue', '#483D8B' ), 
		array( 'MediumTurquoise', '#48D1CC' ), 
		array( 'DarkOliveGreen', '#556B2F' ), 
		array( 'CadetBlue', '#5F9EA0' ), 
		array( 'CornFlowerBlue', '#6495ED' ), 
		array( 'MediumAquaMarine', '#66CDAA' ), 
		array( 'SlateBlue', '#6A5ACD' ), 
		array( 'OliveDrab', '#6B8E23' ), 
		array( 'SlateGray', '#708090' ), 
		array( 'LightSlateGray', '#778899' ), 
		array( 'MediumSlateBlue', '#7B68EE' ), 
		array( 'LawnGreen', '#7CFC00' ), 
		array( 'Chartreuse', '#7FFF00' ), 
		array( 'AquaMarine', '#7FFFD4' ), 
		array( 'LightSkyBlue', '#87CEFA' ), 
		array( 'BlueViolet', '#8A2BE2' ), 
		array( 'DarkMagenta', '#8B008B' ), 
		array( 'SaddleBrown', '#8B4513' ), 
		array( 'DarkSeaGreen', '#8FBC8F' ), 
		array( 'LightGreen', '#90EE90' ), 
		array( 'MediumPurple', '#9370DB' ), 
		array( 'DarkViolet', '#9400D3' ), 
		array( 'PaleGreen', '#98FB98' ), 
		array( 'DarkOrchid', '#9932CC' ), 
		array( 'YellowGreen', '#9ACD32' ), 
		array( 'DarkGray', '#A9A9A9' ), 
		array( 'DarkGrey', '#A9A9A9' ), 
		array( 'LightBlue', '#ADD8E6' ), 
		array( 'GreenYellow', '#ADFF2F' ), 
		array( 'PaleTurquoise', '#AFEEEE' ), 
		array( 'LightSteelBlue', '#B0C4DE' ), 
		array( 'PowderBlue', '#B0E0E6' ), 
		array( 'Firebrick', '#B22222' ), 
		array( 'DarkGoldenRod', '#B8860B' ), 
		array( 'MediumOrchid', '#BA55D3' ), 
		array( 'RosyBrown', '#BC8F8F' ), 
		array( 'DarkKhaki', '#BDB76B' ), 
		array( 'MediumVioletRed', '#C71585' ), 
		array( 'IndianRed', '#CD5C5C' ), 
		array( 'Chocolate', '#D2691E' ), 
		array( 'LightGray', '#D3D3D3' ), 
		array( 'LightGrey', '#D3D3D3' ), 
		array( 'GoldenRod', '#DAA520' ), 
		array( 'PaleVioletRed', '#DB7093' ), 
		array( 'Gainsboro', '#DCDCDC' ), 
		array( 'BurlyWood', '#DEB887' ), 
		array( 'LightCyan', '#E0FFFF' ), 
		array( 'Lavender', '#E6E6FA' ), 
		array( 'DarkSalmon', '#E9967A' ), 
		array( 'PaleGoldenRod', '#EEE8AA' ), 
		array( 'LightCoral', '#F08080' ), 
		array( 'AliceBlue', '#F0F8FF' ), 
		array( 'Honeydew', '#F0FFF0' ), 
		array( 'SandyBrown', '#F4A460' ), 
		array( 'WhiteSmoke', '#F5F5F5' ), 
		array( 'MintCream', '#F5FFFA' ), 
		array( 'GhostWhite', '#F8F8FF' ), 
		array( 'AntiqueWhite', '#FAEBD7' ), 
		array( 'LightGoldenRodYellow', '#FAFAD2' ), 
		array( 'Magenta', '#F0F' ), 
		array( 'Fuchsia', '#F0F' ), 
		array( 'DeepPink', '#FF1493' ), 
		array( 'OrangeRed', '#FF4500' ), 
		array( 'DarkOrange', '#FF8C00' ), 
		array( 'LightSalmon', '#FFA07A' ), 
		array( 'LightPink', '#FFB6C1' ), 
		array( 'PeachPuff', '#FFDAB9' ), 
		array( 'NavajoWhite', '#FFDEAD' ), 
		array( 'Moccasin', '#FFE4B5' ), 
		array( 'MistyRose', '#FFE4E1' ), 
		array( 'BlanchedAlmond', '#FFEBCD' ), 
		array( 'PapayaWhip', '#FFEFD5' ), 
		array( 'LavenderBlush', '#FFF0F5' ), 
		array( 'SeaShell', '#FFF5EE' ), 
		array( 'CornSilk', '#FFF8DC' ), 
		array( 'LemonChiffon', '#FFFACD' ), 
		array( 'FloralWhite', '#FFFAF0' ), 
		array( 'Yellow', '#FF0' ), 
		array( 'LightYellow', '#FFFFE0' ), 
		array( 'White', '#FFF' ), 
	);

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

	$search  = array( chr( 9 ), chr( 10 ), chr( 13 ), ': ', ' :', ' {', '{ ', '} ', ' }', ', ', ' ,', '; ', ' ;' );
	$replace = array( '', '', '', ':', ':', '{', '{', '}', '}', ',', ',', ';', ';' ); 

	$contents = str_replace( $search, $replace, $contents );
	
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

	// Create output array.

	$result['output']  = $contents;
	$result['before']  = $len_before;
	$result['after']   = strlen( $contents );
	$result['percent'] = 100 - ( ( $result['after'] / $len_before ) * 100 );

	return $result;
}
