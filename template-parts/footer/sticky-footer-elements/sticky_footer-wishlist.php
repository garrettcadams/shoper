<?php
global $yith_wcwl;

// Return if compare plugin is not installed/activated ($yith_woocompare == null)
if( !$yith_wcwl ) return;

$woo_wishlist_classes[] = 'sticky-footer-mobile-woo-wishlist';

if( function_exists('yith_wcwl_is_wishlist_page') && yith_wcwl_is_wishlist_page() ){
	$woo_wishlist_classes[] = 'sticky-footer-active';
}

$woo_wishlist_classes = implode( ' ', array_filter( array_unique( $woo_wishlist_classes ) ) );	
$wishlist_url = $yith_wcwl->get_wishlist_url();
?>
<div class="<?php echo esc_attr( $woo_wishlist_classes )?>">
	<a href="<?php echo esc_url( $wishlist_url );?>"><i class="vc_icon_element-icon glyph-icon pgsicon-ecommerce-heart"></i></a>
</div>