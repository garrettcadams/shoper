<?php
function ciyashop_content_wrapper_classes( $class = '' ){
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_content_wrapper_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr( $classes );
}

function ciyashop_content_container_classes( $class = '' ){
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_content_container_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr( $classes );
}

/**
 * Custom template tags for CiyaShop.
 *
 * @package CiyaShop
 * @since 1.0.0
 */

if ( ! function_exists( 'ciyashop_classes_main_area' ) ) {

	/**
	 * Classes main area.
	 *
	 * @since 1.0.0
	 * 
	 * @param  mixed  $class    Custom classes.
	 * @return string Classes name.
	 */
	function ciyashop_classes_main_area( $class = '' ) {
		global $ciyashop_options;
		
		$blog_sidebar       = ( isset($ciyashop_options['blog_sidebar']) && $ciyashop_options['blog_sidebar'] != ''               ) ? $ciyashop_options['blog_sidebar']        : 'right_sidebar';
		$page_sidebar       = ( isset($ciyashop_options['page_sidebar']) && $ciyashop_options['page_sidebar'] != ''               ) ? $ciyashop_options['page_sidebar']        : 'right_sidebar';
		$search_page_sidebar= ( isset($ciyashop_options['search_page_sidebar']) && $ciyashop_options['search_page_sidebar'] != '' ) ? $ciyashop_options['search_page_sidebar'] : 'right_sidebar';
		
		$main_area_classes = array();
		
		$main_area_classes[] = ciyashop_class_builder( $class );
	
		if(
			( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && ( is_checkout() || is_cart() || is_account_page() ) )
			|| is_page_template( 'templates/full-width.php' )
			|| is_page_template( 'templates/faq.php' )
			|| is_page_template( 'templates/team.php' )
			|| ( !is_home() && ( is_front_page() && ciyashop_is_vc_enabled() ) )
		){
			$main_area_classes['col'] = 'col-sm-12';
		}elseif( (is_home() || is_archive()) && $blog_sidebar != 'full_width' && is_active_sidebar( 'sidebar-1' ) ) {
			if( $blog_sidebar == 'left_sidebar' ){
				$main_area_classes['col'] = 'col-sm-12 col-md-12 col-lg-8 col-xl-9 order-xl-2 order-lg-2';
			}else{
				$main_area_classes['col'] = 'col-sm-12 col-md-12 col-lg-8 col-xl-9';
			}
		}elseif( ( ( is_page() && $page_sidebar != 'full_width' ) || ( is_search() && $search_page_sidebar != 'full_width' ) ) && is_active_sidebar( 'sidebar-1' ) ){
			if( (is_page() && $page_sidebar == 'left_sidebar') || (is_search() && $search_page_sidebar == 'left_sidebar') ){
				$main_area_classes['col'] = 'col-sm-12 col-md-12 col-lg-8 col-xl-9 order-xl-2 order-lg-2';
			}else{
				$main_area_classes['col'] = 'col-sm-12 col-md-12 col-lg-8 col-xl-9';
			}
		}else{
			$main_area_classes['col'] = 'col-sm-12 col-md-12 col-lg-12 col-xl-12';
		}
		
		$main_area_classes = apply_filters( 'ciyashop_classes_main_area', $main_area_classes );
		
		$main_area_classes = ciyashop_class_builder( $main_area_classes );
		
		echo esc_attr( $main_area_classes );
	}
}

function ciyashop_page_classes( $class = '' ){
	
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	$show_header = ciyashop_show_header();

	if( empty( $show_header ) && ( is_search() ) ){
		$show_header = true;
	}

	$classes[] = 'hfeed';
	$classes[] = 'site';

	if(empty( $show_header )){
		$classes[] = 'page-header-hidden';
	}
	
	$classes = apply_filters( 'ciyashop_page_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr( $classes );
}

function ciyashop_header_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array('site-header');
	
	$classes[] = ciyashop_class_builder( $class );
	
	$ciyashop_header_type = ciyashop_header_type();
	
	$classes[] = "header-style-".$ciyashop_header_type;
	
	$show_search = ciyashop_show_search();
	$search_box_shape = ( isset($ciyashop_options['search_box_shape']) && $ciyashop_options['search_box_shape'] != '' ) ? $ciyashop_options['search_box_shape'] : 'square';
	
	if( $ciyashop_header_type == 'default' && $show_search ){
		$classes[] = "header-search-shape-".$search_box_shape;
	}

	if( $ciyashop_header_type == 'logo-center' ){
		if( $show_search ){
			$classes[] = "menu-with-search";
		}else{
			$classes[] = "menu-without-search";
		}
	}
	
	if( $ciyashop_header_type == 'menu-center' || $ciyashop_header_type == 'menu-right' ){
		if( isset($ciyashop_options['header_above_content']) && $ciyashop_options['header_above_content'] == 1 ){
			$classes[] = 'header-above-content';
		}
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_header_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr( $classes );
}

function ciyashop_topbar_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array('topbar');
	
	$classes[] = ciyashop_class_builder( $class );
	
	// Topbar Background Color
	$topbar_bg_type = isset($ciyashop_options['topbar_bg_type']) && !empty($ciyashop_options['topbar_bg_type']) ? $ciyashop_options['topbar_bg_type'] : 'default';
	if( isset($ciyashop_options['topbar_bg_type']) && !empty($ciyashop_options['topbar_bg_type']) ){
		$classes[] = 'topbar-bg-color-'.$topbar_bg_type;
	}
	
	if( ciyashop_topbar_enable() == 'enable' ){
		$classes[] = 'topbar-desktop-on';
	}else{
		$classes[] = 'topbar-desktop-off';
	}
	
	if( ciyashop_topbar_mobile_enable() == 'enable' ){
		$classes[] = 'topbar-mobile-on';
	}else{
		$classes[] = 'topbar-mobile-off';
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_topbar_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}

function ciyashop_topbar_container_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array('container');
	
	$ciyashop_header_type = ciyashop_header_type();
	
	if( $ciyashop_header_type == 'menu-center' || $ciyashop_header_type == 'menu-right' ){
		$header_width = isset($ciyashop_options['header_width']) && $ciyashop_options['header_width'] != '' ? $ciyashop_options['header_width'] : 'full_width';
		if( $header_width == 'full_width' ){
			$classes = array('container-fluid');
		}else{
			$classes = array('container');
		}
	}
	
	$classes[] = ciyashop_class_builder( $class );
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_topbar_container_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}

function ciyashop_header_main_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	// Header (Main) Background Color
	$header_main_bg_type = isset($ciyashop_options['header_main_bg_type']) && !empty($ciyashop_options['header_main_bg_type']) ? $ciyashop_options['header_main_bg_type'] : 'default';
	if( isset($ciyashop_options['header_main_bg_type']) && !empty($ciyashop_options['header_main_bg_type']) ){
		$classes[] = 'header-main-bg-color-'.$header_main_bg_type;
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_header_main_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr($classes);
}

function ciyashop_header_main_container_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array('container');
	
	$ciyashop_header_type = ciyashop_header_type();
	
	if( $ciyashop_header_type == 'menu-center' || $ciyashop_header_type == 'menu-right' ){
		$header_width = isset($ciyashop_options['header_width']) && $ciyashop_options['header_width'] != '' ? $ciyashop_options['header_width'] : 'full_width';
		if( $header_width == 'full_width' ){
			$classes = array('container-fluid');
		}else{
			$classes = array('container');
		}
	}
	
	$classes[] = ciyashop_class_builder( $class );
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_header_main_container_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}

function ciyashop_header_nav_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	// Header (Main) Background Color
	$header_nav_bg_type = isset($ciyashop_options['header_nav_bg_type']) && !empty($ciyashop_options['header_nav_bg_type']) ? $ciyashop_options['header_nav_bg_type'] : 'default';
	if( isset($ciyashop_options['header_nav_bg_type']) && !empty($ciyashop_options['header_nav_bg_type']) ){
		$classes[] = 'header-nav-bg-color-'.$header_nav_bg_type;
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_header_nav_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr($classes);
}

// Intro Classes
function ciyashop_page_header_classes( $class = '' ){
    global $post, $ciyashop_options;
    
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	// Set classes from Options
	$banner_type = ( isset($ciyashop_options['banner_type']) ) ? $ciyashop_options['banner_type'] : 'image';
	if( empty($banner_type) ){
		$banner_type = 'color';
	}
	
	$classes['header_intro_bg'] = 'header_intro_bg-' . $banner_type;
	
	if( $banner_type == 'image' || $banner_type == 'video' ){
		$banner_image_opacity = ( isset($ciyashop_options['banner_image_opacity']) ) ? $ciyashop_options['banner_image_opacity'] : 'black';
		if( !empty($banner_image_opacity) ){
			$classes['header_intro_opacity'] = 'header_intro_opacity';
			$classes['header_intro_opacity_type'] = 'header_intro_opacity-' . $banner_image_opacity;
		}
	}
	
	if( is_page() || is_single() ){
		$post_id = $post->ID;
		
		$header_settings_source = get_post_meta($post_id,'header_settings_source',true);
		
		if( function_exists('get_field') && $header_settings_source && $header_settings_source == 'custom' ){
			unset($classes['header_intro_bg']);
			unset($classes['header_intro_opacity']);
			unset($classes['header_intro_opacity_type']);
			
			$banner_type = get_post_meta( $post_id, 'banner_type', true );
			if( empty($banner_type) ){
				$banner_type = 'image';
			}
			
			$classes['header_intro_bg'] = 'header_intro_bg-' . $banner_type;
			
			if( $banner_type && ( $banner_type == 'image' || $banner_type == 'video' ) ){
				$classes['header_intro_opacity'] = 'header_intro_opacity';
				$background_opacity_color = get_post_meta($post_id,'background_opacity_color', true);
				if( $background_opacity_color ){
					$classes['header_intro_opacity_type'] = 'header_intro_opacity-' . $background_opacity_color;
				}
			}
		}
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_page_header_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	echo esc_attr($classes);
}

function ciyashop_page_header_container_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_page_header_container_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}

function ciyashop_page_header_row_classes( $class = '' ){
	global $ciyashop_options, $post;
	
	if( is_search() ){
		$post_id = 0;
	}else{
		if( $post ){
			$post_id = $post->ID;
		}else{
			$post_id = 0;
		}
	}
	
	$classes = array();
	
	$classes[] = ciyashop_class_builder( $class );
	
	$titlebar_view    = ( isset( $ciyashop_options['titlebar_view'] ) )    ? $ciyashop_options['titlebar_view']    : 'default';
	
	$header_settings_source = get_post_meta($post_id,'header_settings_source',true);
	if( $header_settings_source == 'custom' ){
		$titlebar_view = get_post_meta( $post_id, 'titlebar_text_align', true );
	}
	
	if( $titlebar_view == 'default' ){
		$classes[] = 'intro-section-center';
	}elseif($titlebar_view =='allleft'){
		$classes[] = 'intro-section-left';
	}elseif($titlebar_view =='allright'){
		$classes[] = 'intro-section-right';
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_page_header_row_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}

function ciyashop_footer_wrapper_classes( $class = '', $echo = true ){
	global $ciyashop_options;
	
	$classes = array('footer-wrapper');
	
	$ciyashop_header_type = ciyashop_header_type();
	
	$classes[] = ciyashop_class_builder( $class );
	
	if( isset($ciyashop_options['footer_background_opacity']) && $ciyashop_options['footer_background_opacity'] == 'custom' ){
		$classes[] = 'footer_opacity_custom';
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_footer_wrapper_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	if( $echo ){
		echo esc_attr($classes);
	}else{
		return esc_attr($classes);
	}
}

function ciyashop_header_sticky_classes( $class = '' ){
	global $ciyashop_options;
	
	$classes = array('header-sticky');
	
	$classes[] = ciyashop_class_builder( $class );
	
	if( ciyashop_sticky_header() ){
		$classes[] = 'header-sticky-desktop-on';
	}else{
		$classes[] = 'header-sticky-desktop-off';
	}
	
	if( ciyashop_mobile_sticky_header() ){
		$classes[] = 'header-sticky-mobile-on';
	}else{
		$classes[] = 'header-sticky-mobile-off';
	}
	
	/**
	 * Filter the list of CSS classes for header.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes An array of header classes.
	 */
	$classes = apply_filters( 'ciyashop_header_sticky_classes', $classes );
	
	$classes = ciyashop_class_builder( $classes );
	
	return esc_attr($classes);
}