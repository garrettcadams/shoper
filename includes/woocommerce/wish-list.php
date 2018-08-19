<?php
add_action( 'wp_head', 'ciyashop_wc_wishlist' );
function ciyashop_wc_wishlist(){
	if(
		( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
	) {
		add_action( 'ciyashop_product_actions', 'ciyashop_product_actions_add_wishlist_link', 20 );
	}
}

/********************************************************************
 * 
 * Product Loop
 * 
 ********************************************************************/
// Add wishlist icon
function ciyashop_product_actions_add_wishlist_link(){
	?>
	<div class="product-action product-action-wishlist">
		<?php echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );?>
	</div>
	<?php
}