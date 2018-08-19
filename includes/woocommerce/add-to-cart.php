<?php
/********************************************************************
 * 
 * Add "Add to Cart" to "ciyashop_product_actions"
 * 
 ********************************************************************/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'ciyashop_product_actions', 'woocommerce_template_loop_add_to_cart', 10 );

add_filter( 'woocommerce_loop_add_to_cart_link', 'ciyashop_woocommerce_loop_add_to_cart_link', 10, 2 );
function ciyashop_woocommerce_loop_add_to_cart_link( $link, $product ){
	if ( $product->is_in_stock() ){
		return '<div class="product-action product-action-add-to-cart">'.$link.'</div>';
	}
	return '';
}
add_filter( 'woocommerce_product_add_to_cart_text', 'ciyashop_custom_cart_button_text' );
function ciyashop_custom_cart_button_text() {
	return __( 'Add to Cart', 'ciyashop' );
}		