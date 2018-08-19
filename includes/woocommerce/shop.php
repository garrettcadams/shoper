<?php
// Remove Shop page title
add_filter( 'woocommerce_show_page_title', 'ciyashop_woocommerce_hide_page_title' ); // Hide Page Title
function ciyashop_woocommerce_hide_page_title(){
	return false;
}

// Remove default breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


// Content Wrappers
add_action( 'woocommerce_before_main_content', 'ciyashop_woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'ciyashop_woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'ciyashop_woocommerce_output_content_wrapper' ) ) {
	/**
	 * Output the start of the page wrapper.
	 *
	 */
	function ciyashop_woocommerce_output_content_wrapper() {
		if( get_query_var( 'store' ) == '' ){
			wc_get_template( 'global/wrapper-start.php' );
		}
	}
}

if ( ! function_exists( 'ciyashop_woocommerce_output_content_wrapper_end' ) ) {
	/**
	 * Output the end of the page wrapper.
	 *
	 */
	function ciyashop_woocommerce_output_content_wrapper_end() {
		if( get_query_var( 'store' ) == '' ){
			wc_get_template( 'global/wrapper-end.php' );
		}
	}
}

// Sidebars
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); // Remove Default Sidebars

// Archive Banner
add_action( 'woocommerce_archive_description', 'ciyashop_shop_page_banner', 5 );
if ( ! function_exists( 'ciyashop_shop_page_banner' ) ) {

	/**
	 * Show banner above archive description.
	 * 
	 */
	function ciyashop_shop_page_banner() {
		wc_get_template( 'custom/shop_page_banner.php' );
	}
}

/**********************************************************
 * 
 * Shop Product Container Width
 * 
 **********************************************************/
add_filter( 'ciyashop_content_container_classes', 'ciyashop_shop_page_width_class' );

function ciyashop_shop_page_width_class( $classes ){
	
	if( is_shop() ){
		$shop_page_width = ciyashop_shop_page_width();

		// Unset 'container-fluid' class
		$cf_index = array_search('container-fluid', $classes);
		if( $cf_index ) unset($classes[$cf_index]);
		
		// Unset 'container' class
		$c_index = array_search('container', $classes); // $key = 2;
		if( $c_index ) unset($classes[$c_index]);
		
		if( $shop_page_width == 'wide' ){
			$classes = array('container-fluid');
		}else{
			$classes = array('container');
		}
	}
	
	return $classes;
}