<?php
add_filter( 'ciyashop_content_wrapper_classes', 'ciyashop_add_content_wrapper_vc_enabled_class' );
function ciyashop_add_content_wrapper_vc_enabled_class( $classes ){
	
	// Check if VC is enabled and append vc-enabled class
	if( ciyashop_is_vc_enabled() ){
		$classes[] =  'content-wrapper-vc-enabled';
	}
	
	return $classes;
}