<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CiyaShop
 */

if( !is_active_sidebar( 'sidebar-1' ) ) return;

if( !is_home() && (is_front_page() && ciyashop_is_vc_enabled()) ) return;

if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && ( is_checkout() || is_cart()|| is_account_page() ) ) return;

global $ciyashop_options;

$blog_sidebar       = ( isset($ciyashop_options['blog_sidebar']) && $ciyashop_options['blog_sidebar'] != ''               ) ? $ciyashop_options['blog_sidebar']        : 'right_sidebar';
$page_sidebar       = ( isset($ciyashop_options['page_sidebar']) && $ciyashop_options['page_sidebar'] != ''               ) ? $ciyashop_options['page_sidebar']        : 'right_sidebar';
$search_page_sidebar= ( isset($ciyashop_options['search_page_sidebar']) && $ciyashop_options['search_page_sidebar'] != '' ) ? $ciyashop_options['search_page_sidebar'] : 'right_sidebar';

if( (is_page() && $page_sidebar == 'full_width') || (is_search() && $search_page_sidebar == 'full_width') ) return;

$sidebar_classes = array();

if(
	( (is_home() || is_archive() || is_single()) && $blog_sidebar == 'left_sidebar' )
	|| (is_page() && $page_sidebar == 'left_sidebar')
	|| (is_search() && $search_page_sidebar == 'left_sidebar')
){
	$sidebar_classes[] = 'sidebar col-sm-12 col-md-12 col-lg-4 col-xl-3 order-xl-1 order-lg-1 column';

}else{
	$sidebar_classes[] = 'sidebar col-sm-12 col-md-12 col-lg-4 col-xl-3 column';
}

$sidebar_classes = implode( ' ', array_filter( array_unique( $sidebar_classes ) ) );
?>
<div class="<?php echo esc_attr($sidebar_classes);?>">
    <aside id="secondary" class="widget-area" role="complementary">
    	<?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- #secondary -->
</div>