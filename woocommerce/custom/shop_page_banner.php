<?php
global $ciyashop_options;
$pro_shop_banner_show= $ciyashop_options['pro-shop-banner_show'];
$pro_shop_banner     = $ciyashop_options['pro-shop-banner'];

if( $pro_shop_banner_show == 1 && ( $pro_shop_banner && is_array($pro_shop_banner) && isset($pro_shop_banner['url']) && $pro_shop_banner['url'] != '' ) ){
	?>
	<div class="right-banner">
		<img alt="<?php esc_attr_e( 'Shop Banner', 'ciyashop' );?>" src="<?php echo esc_url($pro_shop_banner['url']);?>" class="img-fluid">
	</div>
	<?php
}