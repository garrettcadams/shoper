<?php
add_action( 'init', 'ciyashop_extend_vc_message', 1000 );
function ciyashop_extend_vc_message(){
	if ( ! function_exists( 'vc_add_params' ) ) {
		return;
	}
	
	$replacing_params = array();
	$replacing_params['message_box_style'] = array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Style', 'ciyashop' ),
		'param_name' => 'message_box_style',
		'value'      => array_merge( getVcShared( 'message_box_styles' ), array(
			esc_html__( 'Callouts', 'ciyashop' ) => 'callouts',
		)),
		'description'=> esc_html__( 'Select message box design style.', 'ciyashop' ),
	);
	
	$atts = vc_get_shortcode( 'vc_message' );
	foreach( $atts[ 'params' ] as $param_key => $param_data ){
		if( array_key_exists( $param_data['param_name'], $replacing_params) ) {
			$atts[ 'params' ][$param_key] = $replacing_params[$param_data['param_name']];
		}
	}
	
	$atts[ 'params' ][] = array(
		'type'       => 'checkbox',
		'heading'    => esc_html__( 'Hide Icon', 'ciyashop' ),
		'param_name' => 'pgscore_vc_message_hide_icon',
		'description'=> esc_html__( 'Check this to hide icon.', 'ciyashop' ),
		'group'      => esc_html__( 'Additional Settings', 'ciyashop' ),
	);
	$atts[ 'params' ][] = array(
		'type'       => 'checkbox',
		'heading'    => esc_html__( 'Closeable Box', 'ciyashop' ),
		'param_name' => 'pgscore_vc_message_closeable',
		'description'=> esc_html__( 'Check this to display close button.', 'ciyashop' ),
		'group'      => esc_html__( 'Additional Settings', 'ciyashop' ),
	);
	
	unset( $atts[ 'base' ] );
	vc_map_update( 'vc_message', $atts );
}