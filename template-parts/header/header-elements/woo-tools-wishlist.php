<?php
global $yith_wcwl;

// Return if compare plugin is not installed/activated ($yith_woocompare == null)
if( !$yith_wcwl || wp_is_mobile()) return;

$wishlist_url = $yith_wcwl->get_wishlist_url();
?>
<li class="woo-tools-action woo-tools-wishlist">
	<a href="<?php echo esc_url($wishlist_url);?>"><?php ciyashop_wishlist_icon();?></a>
</li>