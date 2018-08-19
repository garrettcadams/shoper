<?php
function ciyashop_remove_cart_item() {
	global $woocommerce;
	
	if( !empty($_POST['_wpnonce']) ){
		if( isset( $_POST['_wpnonce'] ) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'woocommerce-cart' ) ){
		
			$cart_item_key = false;
			
			if( !empty($_POST['product_id']) && !empty($_POST['remove_item']) ){
				
				$cart_item_key = sanitize_text_field( wp_unslash( $_POST['remove_item'] ) );
				
			}elseif( empty($_POST['product_id']) && !empty($_POST['remove_item']) ){
				
				$cart_item_key = sanitize_text_field( wp_unslash( $_POST['remove_item'] ) );
				
			}elseif( !empty($_POST['product_id']) && empty($_POST['remove_item']) ){
				
				$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );
				
				$cart_item_key = ciyashop_wc_get_cart_item_key($product_id);
			}
			
			// Remove cart item
			if( $cart_item_key ){
				$woocommerce->cart->remove_cart_item($cart_item_key);
			}
		}
	}
	
	echo WC_AJAX::get_refreshed_fragments();
	die();
	
}
add_action('wp_ajax_ciyashop_remove_cart_item', 'ciyashop_remove_cart_item');
add_action('wp_ajax_nopriv_ciyashop_remove_cart_item', 'ciyashop_remove_cart_item');