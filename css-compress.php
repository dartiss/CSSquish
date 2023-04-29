<?php
function compress_css( $contents ) {

	$len_before = strlen( $contents );
	$start      = strpos( $contents, '/*' );

	// Load arrays with color compression options (where hex is smaller than colour codes or vice versa).

	$tocolor = array(
		'#000080' => 'Navy', 
		'#008000' => 'Green', 
		'#008080' => 'Teal', 
		'#00FF00' => 'Lime', 
		'#4B0082' => 'Indigo', 
		'#800000' => 'Maroon', 
		'#800080' => 'Purple', 
		'#808000' => 'Olive', 
		'#808080' => 'Gray', 
		'#A0522D' => 'Sienna', 
		'#A52A2A' => 'Brown', 
		'#C0C0C0' => 'Silver', 
		'#CD853F' => 'Peru', 
		'#D2B48C' => 'Tan', 
		'#DA70D6' => 'Orchid', 
		'#DDA0DD' => 'Plum', 
		'#EE82EE' => 'Violet', 
		'#F0E68C' => 'Khaki', 
		'#F00'    => 'Red', 
		'#F0FFFF' => 'Azure', 
		'#F5DEB3' => 'Wheat', 
		'#F5F5DC' => 'Beige', 
		'#FA8072' => 'Salmon', 
		'#FAF0E6' => 'Linen', 
		'#FF6347' => 'Tomato', 
		'#FF7F50' => 'Coral', 
		'#FFA500' => 'Orange', 
		'#FFC0CB' => 'Pink', 
		'#FFD700' => 'Gold', 
		'#FFE4C4' => 'Bisque', 
		'#FFFAFA' => 'Snow', 
		'#FFFFF0' => 'Ivory', 
		'#808080' => 'Grey',
	);

	$tocolor = array(
		'Black'                => '#000', 
		'DarkBlue'             => '#00008B', 
		'MediumBlue'           => '#0000CD', 
		'DarkGreen'            => '#006400', 
		'DarkCyan'             => '#008B8B', 
		'DeepSkyBlue'          => '#00BFFF', 
		'DarkTurquoise'        => '#00CED1', 
		'MediumSpringGreen'    => '#00FA9A', 
		'SpringGreen'          => '#00FF7F', 
		'MidnightBlue'         => '#191970', 
		'DodgerBlue'           => '#1E90FF', 
		'LightSeaGreen'        => '#20B2AA', 
		'ForestGreen'          => '#228B22', 
		'SeaGreen'             => '#2E8B57', 
		'DarkSlateGray'        => '#2F4F4F', 
		'LimeGreen'            => '#32CD32', 
		'MediumSeaGreen'       => '#3CB371', 
		'Turquoise'            => '#40E0D0', 
		'RoyalBlue'            => '#4169E1', 
		'SteelBlue'            => '#4682B4', 
		'DarkSlateBlue'        => '#483D8B', 
		'MediumTurquoise'      => '#48D1CC', 
		'DarkOliveGreen'       => '#556B2F', 
		'CadetBlue'            => '#5F9EA0', 
		'CornFlowerBlue'       => '#6495ED', 
		'MediumAquaMarine'     => '#66CDAA', 
		'SlateBlue'            => '#6A5ACD', 
		'OliveDrab'            => '#6B8E23', 
		'SlateGray'            => '#708090', 
		'LightSlateGray'       => '#778899', 
		'MediumSlateBlue'      => '#7B68EE', 
		'LawnGreen'            => '#7CFC00', 
		'Chartreuse'           => '#7FFF00', 
		'AquaMarine'           => '#7FFFD4', 
		'LightSkyBlue'         => '#87CEFA', 
		'BlueViolet'           => '#8A2BE2', 
		'DarkMagenta'          => '#8B008B', 
		'SaddleBrown'          => '#8B4513', 
		'DarkSeaGreen'         => '#8FBC8F', 
		'LightGreen'           => '#90EE90', 
		'MediumPurple'         => '#9370DB', 
		'DarkViolet'           => '#9400D3', 
		'PaleGreen'            => '#98FB98', 
		'DarkOrchid'           => '#9932CC', 
		'YellowGreen'          => '#9ACD32', 
		'DarkGray'             => '#A9A9A9', 
		'DarkGrey'             => '#A9A9A9', 
		'LightBlue'            => '#ADD8E6', 
		'GreenYellow'          => '#ADFF2F', 
		'PaleTurquoise'        => '#AFEEEE', 
		'LightSteelBlue'       => '#B0C4DE', 
		'PowderBlue'           => '#B0E0E6', 
		'Firebrick'            => '#B22222', 
		'DarkGoldenRod'        => '#B8860B', 
		'MediumOrchid'         => '#BA55D3', 
		'RosyBrown'            => '#BC8F8F', 
		'DarkKhaki'            => '#BDB76B', 
		'MediumVioletRed'      => '#C71585', 
		'IndianRed'            => '#CD5C5C', 
		'Chocolate'            => '#D2691E', 
		'LightGray'            => '#D3D3D3', 
		'LightGrey'            => '#D3D3D3', 
		'GoldenRod'            => '#DAA520', 
		'PaleVioletRed'        => '#DB7093', 
		'Gainsboro'            => '#DCDCDC', 
		'BurlyWood'            => '#DEB887', 
		'LightCyan'            => '#E0FFFF', 
		'Lavender'             => '#E6E6FA', 
		'DarkSalmon'           => '#E9967A', 
		'PaleGoldenRod'        => '#EEE8AA', 
		'LightCoral'           => '#F08080', 
		'AliceBlue'            => '#F0F8FF', 
		'Honeydew'             => '#F0FFF0', 
		'SandyBrown'           => '#F4A460', 
		'WhiteSmoke'           => '#F5F5F5', 
		'MintCream'            => '#F5FFFA', 
		'GhostWhite'           => '#F8F8FF', 
		'AntiqueWhite'         => '#FAEBD7', 
		'LightGoldenRodYellow' => '#FAFAD2', 
		'Magenta'              => '#F0F', 
		'Fuchsia'              => '#F0F', 
		'DeepPink'             => '#FF1493', 
		'OrangeRed'            => '#FF4500', 
		'DarkOrange'           => '#FF8C00', 
		'LightSalmon'          => '#FFA07A', 
		'LightPink'            => '#FFB6C1', 
		'PeachPuff'            => '#FFDAB9', 
		'NavajoWhite'          => '#FFDEAD', 
		'Moccasin'             => '#FFE4B5', 
		'MistyRose'            => '#FFE4E1', 
		'BlanchedAlmond'       => '#FFEBCD', 
		'PapayaWhip'           => '#FFEFD5', 
		'LavenderBlush'        => '#FFF0F5', 
		'SeaShell'             => '#FFF5EE', 
		'CornSilk'             => '#FFF8DC', 
		'LemonChiffon'         => '#FFFACD', 
		'FloralWhite'          => '#FFFAF0', 
		'Yellow'               => '#FF0', 
		'LightYellow'          => '#FFFFE0', 
		'White'                => '#FFF', 
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
