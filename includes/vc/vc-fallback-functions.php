<?php
/**
 * @param $atts_string
 *
 * @since 4.4
 * @return array|mixed
 * 
 * migrated from: vc_param_group_parse_atts
 */
function ciyashop_param_group_parse_atts( $atts_string ) {
	$array = json_decode( urldecode( $atts_string ), true );

	return $array;
}


/**
 * @param $value
 *
 * @since 4.2
 * @return array
 */
function ciyashop_build_link( $value ) {
	return ciyashop_parse_multi_attribute( $value, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );
}


/**
 * Parse string like "title:Hello world|weekday:Monday" to array('title' => 'Hello World', 'weekday' => 'Monday')
 *
 * @param $value
 * @param array $default
 *
 * @since 4.2
 * @return array
 */
function ciyashop_parse_multi_attribute( $value, $default = array() ) {
	$result = $default;
	$params_pairs = explode( '|', $value );
	if ( ! empty( $params_pairs ) ) {
		foreach ( $params_pairs as $pair ) {
			$param = preg_split( '/\:/', $pair );
			if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
				$result[ $param[0] ] = rawurldecode( $param[1] );
			}
		}
	}

	return $result;
}

/**
 * Convert string to a valid css class name.
 *
 * @since 4.3
 *
 * @param string $class
 *
 * @return string
 */
function ciyashop_build_safe_css_class( $class ) {
	return preg_replace( '/\W+/', '', strtolower( str_replace( ' ', '_', strip_tags( $class ) ) ) );
}