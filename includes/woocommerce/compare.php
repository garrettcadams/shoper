<?php
/********************************************************************
 * 
 * Product Loop
 * 
 ********************************************************************/
// Move "Compare button" to "ciyashop_product_actions"
function ciyashop_wc_compare() {
	if( class_exists('YITH_Woocompare') ){
		global $yith_woocompare;
		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link'), 20 );
		add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_start', 29 );
		add_action( 'ciyashop_product_actions', array( $yith_woocompare->obj, 'add_compare_link' ), 30 );
		add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_end', 31 );
	}
}
add_action( 'init', 'ciyashop_wc_compare', 19 );

function ciyashop_product_action_compare_wrapper_start(){
	?>
	<div class="product-action product-action-compare">
	<?php
}
function ciyashop_product_action_compare_wrapper_end(){
	?>
	</div>
	<?php
}

add_action( 'yith_woocompare_popup_head', 'ciyashop_compare_init' );
function ciyashop_compare_init(){
	
	// add 'woocommerce-compare' class
	add_filter( 'body_class', 'ciyashop_compare_body_class' );
}

function ciyashop_compare_body_class( $classes ) {
	
	$classes[] = 'woocommerce-compare';
    
	return $classes;
}

add_filter( 'wp_title', 'ciyashop_compare_wp_title', 10, 3 );
function ciyashop_compare_wp_title( $title, $sep, $seplocation ){
	if ( ( isset( $_REQUEST['action'] ) || $_REQUEST['action'] == 'yith-woocompare-view-table' ) ){
		$title = esc_html__( 'Product Comparison', 'ciyashop' );
	}
	return $title;
}

// Load theme's style
function prefix_add_footer_styles() {
	
	global $wp_styles;
	
	if ( ( $wp_styles instanceof WP_Styles ) ) {
		wp_styles()->do_items( 'ciyashop-style' );
		wp_styles()->do_items( 'ciyashop-responsive' );
		wp_styles()->do_items( 'ciyashop-color-customize' );
	}
};
add_action( 'yith_woocompare_after_main_table', 'prefix_add_footer_styles' );