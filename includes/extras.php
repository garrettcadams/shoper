<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package CiyaShop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ciyashop_body_classes( $classes ) {
	
	global $ciyashop_options;
	
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) ) {
		$classes[] = 'woocommerce-active';
	}
	
	if( wp_is_mobile() ){
		
		if ( ( isset($ciyashop_options['woocommerce_mobile_sticky_footer']) && $ciyashop_options['woocommerce_mobile_sticky_footer'] ) && ( function_exists('is_product') && !is_product() ) ) {
			$classes[] = 'footer-device-active';
		}
		$classes[] = 'device-type-mobile';
		
	}else{
		$classes[] = 'device-type-desktop';
	}
	
	$classes[] = 'ciyashop-site-layout-'.ciyashop_site_layout();

	return $classes;
}
add_filter( 'body_class', 'ciyashop_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ciyashop_pingback_header() {
	if ( is_singular() && pings_open() ) {
		?>
		<link rel="pingback" href="<?php echo esc_url(bloginfo('pingback_url'));?>">
		<?php
	}
}
add_action( 'wp_head', 'ciyashop_pingback_header' );

add_action( 'init', 'ciyashop_mpc_check_class' );
function ciyashop_mpc_check_class() {
	if (  defined( 'MPC_MASSIVE_FULL' ) || ciyashop_check_plugin_active( 'mpc-massive/mpc-massive.php' ) ){
		add_filter( 'admin_body_class', 'ciyashop_add_mpc_check_class' );
		add_filter( 'body_class', 'ciyashop_add_mpc_check_class' );
	}
}

// Add class to body in Admin
function ciyashop_add_mpc_check_class( $classes ) {
	
	if( is_array($classes) ){
		$classes[] = "cs_mpc_active";
	}else{
		$classes = "$classes cs_mpc_active";
	}
	
	return $classes;
}