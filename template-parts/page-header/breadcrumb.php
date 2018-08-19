<?php
global $ciyashop_options;

$page_id = get_the_ID();
if(function_exists('is_shop') && is_shop()){
	$page_id = get_option( 'woocommerce_shop_page_id' );
}elseif( is_home() && get_option('page_for_posts') ) {
	$page_id = get_option('page_for_posts');
}

$breadcrumbs           = '';
$display_breadcrumb    = ( isset($ciyashop_options['display_breadcrumb']) ) ? $ciyashop_options['display_breadcrumb'] : 0;
$hide_breadcrumb_mobile= ( isset($ciyashop_options['hide_breadcrumb_mobile']) ) ? $ciyashop_options['hide_breadcrumb_mobile'] : 0;

/* Start particular page breadcrumb setting*/
$header_settings_source = get_post_meta($page_id,'header_settings_source', true);
if( $header_settings_source == 'custom' ){
	$display_breadcrumb = get_post_meta($page_id,'display_breadcrumb',true);
	$hide_breadcrumb_mobile = get_post_meta($page_id,'display_breadcrumb_on_mobile', true);
}

/* End particular page breadcrumb setting*/
$breadcrumbs_class = '';
if( $hide_breadcrumb_mobile == 0 && $hide_breadcrumb_mobile != '' ){
	$breadcrumbs_class='breadcrumbs-hide-mobile';
}

$show_on_front     = get_option( 'show_on_front' );
$page_on_front     = get_option( 'page_on_front' );
$page_for_posts_id = get_option( 'page_for_posts' );

if(
	function_exists( 'bcn_display_list' )
	&& ( !is_home() || ( is_home() && $show_on_front == 'page' ) )
	&& $display_breadcrumb == 1 && !is_404()
){
	?>
	<ul class="page-breadcrumb breadcrumbs <?php echo esc_attr($breadcrumbs_class);?>" typeof="BreadcrumbList" vocab="http://schema.org/">
		<?php bcn_display_list();?>
	</ul>
	<?php
}