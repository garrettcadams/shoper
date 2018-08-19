<?php
global $ciyashop_options, $ciyashop_title;

$page_id = get_the_ID();

if(function_exists('is_shop') && is_shop()){
	$page_id=get_option( 'woocommerce_shop_page_id' );;
}
$title = get_the_title();
$post_type = get_post_type();

$show_on_front     = get_option( 'show_on_front' );
$page_on_front     = get_option( 'page_on_front' );
$page_for_posts_id = get_option( 'page_for_posts' );

if( is_home() ){
	if( $show_on_front == 'page' ){
		$page_for_posts_data = get_post($page_for_posts_id);
		$title = $page_for_posts_data->post_title;
	}
}elseif( is_archive() ){
	if ( is_day() ){
		$title = sprintf( esc_html__( 'Daily Archives: %s', 'ciyashop' ), '<span>' . get_the_date() . '</span>' );
	}elseif ( is_month() ){
		$title = sprintf( esc_html__( 'Monthly Archives: %s', 'ciyashop' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ciyashop' ) ) . '</span>' );
	}elseif ( is_year() ){
		$title = sprintf( esc_html__( 'Yearly Archives: %s', 'ciyashop' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ciyashop' ) ) . '</span>' );
	}elseif ( is_category()){
		$title = sprintf( esc_html__( 'Category Archives: %s', 'ciyashop' ), '<span>' . single_cat_title( '', false ) . '</span>' );
	}elseif(is_tax()){
		$title = single_cat_title("", false);
	}elseif ( is_tag() ){
		$title = sprintf( esc_html__( 'Tag Archives: %s', 'ciyashop' ), '<span>' . single_tag_title( '', false ) . '</span>' );;
	}elseif ( is_author() ){
		$title = sprintf( esc_html__( 'Author Archives: %s', 'ciyashop' ), '<span>' . get_the_author() . '</span>' );
	}elseif(function_exists('is_shop') && is_shop() && $page_id!=''){
		$title = get_the_title($page_id);
	}elseif(is_archive() && get_post_type()=='post'){
		$title = esc_html__( 'Archives', 'ciyashop' );
	}else{
		$title =  post_type_archive_title( '', false );
	}
}elseif( is_search() ){
	$title = esc_html__( 'Search', 'ciyashop' );
}elseif( is_404() ){
	
	if( isset( $ciyashop_options['fourofour_page_title_source'] ) && $ciyashop_options['fourofour_page_title_source'] == 'custom'
		&& isset( $ciyashop_options['fourofour_page_title'] ) && !empty($ciyashop_options['fourofour_page_title'])
	){
		$title = $ciyashop_options['fourofour_page_title'];
	}else{
		$title = esc_html__( '404 error', 'ciyashop' );
	}
	
}elseif( function_exists('dokan_is_store_page') && dokan_is_store_page() ){
	$store_user    = dokan()->vendor->get( get_query_var( 'author' ) );
	$title = $store_user->get_shop_name();
}elseif(function_exists('is_shop') && is_shop()){
	$title = get_the_title($page_id);
}


$ciyashop_title = $title;
$ciyashop_title = apply_filters( 'ciyashop_title', $ciyashop_title );
?>
<div class="intro-title-inner">
    <h1><?php echo html_entity_decode(esc_html($ciyashop_title));?></h1>
</div>