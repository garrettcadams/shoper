<?php
/*
 * Generate Dynamic Css property base on theme setting
 */

add_action('wp_enqueue_scripts','ciyashop_dynamic_css',50);
function ciyashop_dynamic_css(){
	global $dynamic_css, $ciyashop_options, $ciyashop_body_typo, $ciyashop_h1_typo, $ciyashop_h2_typo, $ciyashop_h3_typo, $ciyashop_h4_typo, $ciyashop_h5_typo, $ciyashop_h6_typo;
	$dynamic_css = array();
	
	do_action( 'ciyashop_dynamic_css_init', $ciyashop_options );
	
	require_once get_parent_theme_file_path('/includes/dynamic_css_helper.php');
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	do_action( 'ciyashop_before_dynamic_css', $ciyashop_options );
	
	/**
	 * Functions hooked into ciyashop_dynamic_css action
	 *
	 * @hooked ciyashop_site_layout_css            - 10
	 * @hooked ciyashop_logo_css                   - 20
	 * @hooked ciyashop_menu_font_css              - 25
	 * @hooked ciyashop_topbar_css                 - 30
	 * @hooked ciyashop_preloader_css              - 35
	 * @hooked ciyashop_header_main_css            - 40
	 * @hooked ciyashop_header_nav_css             - 50
	 * @hooked ciyashop_header_sticky_css          - 60
	 * @hooked ciyashop_page_header_css            - 70
	 * @hooked ciyashop_content_css                - 80
	 * @hooked ciyashop_footer_css                 - 90
	 */
	do_action( 'ciyashop_dynamic_css', $ciyashop_options );
	
	do_action( 'ciyashop_after_dynamic_css', $ciyashop_options );
	
	$parsed_css = ciyashop_generate_css_properties($dynamic_css);
	
	if( !empty($parsed_css) ){
		wp_add_inline_style( 'ciyashop-style', $parsed_css );
	}
}

function ciyashop_dynamic_css_page_id(){
	
	global $post;
	
	$post_id = 0;
	
	if( $post ){
		$post_id = $post->ID;
	}
	
	if( is_404() ){
		$post_id = 0;
	}elseif( is_search() ){
		$post_id = 0;
	}
	
	if( function_exists('is_shop') && is_shop() ){
		$post_id = get_option( 'woocommerce_shop_page_id' );;
	}
	
	return $post_id;
}

add_action( 'ciyashop_dynamic_css', 'ciyashop_site_layout_css'  , 10 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_logo_css'         , 20 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_menu_font_css'    , 25 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_topbar_css'       , 30 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_preloader_css'    , 35 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_header_main_css'  , 40 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_header_nav_css'   , 50 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_header_sticky_css', 60 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_page_header_css'  , 70 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_content_css'      , 80 );
add_action( 'ciyashop_dynamic_css', 'ciyashop_footer_css'       , 90 );

function ciyashop_site_layout_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	// Site Layout CSS
	$site_layout     = ciyashop_site_layout();
	
	$fixed_width     = '1300';
	$container_width = '1300';
	$auto_padding    = ( $fixed_width - $container_width ) / 2;
	$auto_margin     = ( $auto_padding ) + 15;
	
	$body_background = ( isset($ciyashop_options['body_background']) && is_array($ciyashop_options['body_background']) && !empty($ciyashop_options['body_background']) ) ? $ciyashop_options['body_background'] : array();
	
	// Site layout body background option
	if( $site_layout != 'fullwidth' && !empty($body_background) ){
		
		$body_background_params = array(
			'background-color',
			'background-repeat',
			'background-size',
			'background-attachment',
			'background-position',
			'background-image',
		);
		
		$body_background_css = array();
		foreach( $body_background_params as $body_background_param ){
			if( isset($body_background[$body_background_param]) && !empty($body_background[$body_background_param]) ){
				if( $body_background_param == 'background-image' ){
					$body_background_css[$body_background_param] = 'url(\''.$body_background[$body_background_param].'\')';
				}else{
					$body_background_css[$body_background_param] = $body_background[$body_background_param];
				}
			}
		}
		
		$body_background_css = apply_filters( 'ciyashop_body_background_css', $body_background_css, $ciyashop_options );
		
		if( !empty($body_background_css) ){
			$dynamic_css['body'] = $body_background_css;
		}
	}
	
	$dynamic_css['.ciyashop-site-layout-boxed #page,.ciyashop-site-layout-framed #page,.ciyashop-site-layout-rounded #page']['max-width'] = "{$fixed_width}px";
	if( $site_layout != 'fullwidth' ){
		$dynamic_css['.ciyashop-site-layout-boxed #page,.ciyashop-site-layout-framed #page,.ciyashop-site-layout-rounded #page']['margin-left'] = "auto";
		$dynamic_css['.ciyashop-site-layout-boxed #page,.ciyashop-site-layout-framed #page,.ciyashop-site-layout-rounded #page']['margin-right'] = "auto";
	}
	$dynamic_css['.ciyashop-site-layout-boxed .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"])']['padding-right'] = "{$auto_padding}px !important";
	$dynamic_css['.ciyashop-site-layout-boxed .vc_row[data-vc-full-width="true"]:not([data-vc-stretch-content="true"])']['padding-left'] = "{$auto_padding}px !important";
	$dynamic_css['.ciyashop-site-layout-boxed .vc_row[data-vc-full-width="true"]']['margin-left'] = "-{$auto_margin}px !important";
	$dynamic_css['.ciyashop-site-layout-boxed .vc_row[data-vc-full-width="true"]']['margin-right'] = "-{$auto_margin}px !important";
}

function ciyashop_logo_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	// Logo type "Text" font and color setttings
	if( isset($ciyashop_options['logo_type']) && $ciyashop_options['logo_type']=='text' ){
		
		$logo_text_typo_attrs = array(
			'font-family',
			'font-options',
			'font-weight',
			'font-style',
			'font-size',
			'color',
		);
		
		if( isset($ciyashop_options['logo_font']) && !empty($ciyashop_options['logo_font']) ){
			foreach( $logo_text_typo_attrs as $logo_text_typo_attr ){
				if( isset($ciyashop_options['logo_font'][$logo_text_typo_attr]) && !empty($ciyashop_options['logo_font'][$logo_text_typo_attr]) ){
					$dynamic_css['.site-title .logo-text'][$logo_text_typo_attr] = $ciyashop_options['logo_font'][$logo_text_typo_attr];
				}
			}
		}
		
		/* Mobile Site Logo text settings*/
		if(!empty($ciyashop_options['logo_font']) && $ciyashop_options['logo_font']['font-family']!=''){
			$dynamic_css['.device-type-mobile .site-title .logo-text']['font-family']    = $ciyashop_options['logo_font']['font-family'];
		}
		if(!empty($ciyashop_options['mobile_logo_font']) && $ciyashop_options['mobile_logo_font']['font-size']!=''){
			$dynamic_css['.device-type-mobile .site-title .logo-text']['font-size']    = $ciyashop_options['mobile_logo_font']['font-size'];
		}
		if(!empty($ciyashop_options['mobile_logo_font']) && $ciyashop_options['mobile_logo_font']['color']!=''){
			$dynamic_css['.device-type-mobile .site-title .logo-text']['color']    = $ciyashop_options['mobile_logo_font']['color'];
		}
		
		/* Sticky Site Logo text settings*/
		if(!empty($ciyashop_options['logo_font']) && $ciyashop_options['logo_font']['font-family']!=''){
			$dynamic_css['.sticky-site-title.h1 .logo-text']['font-family']    = $ciyashop_options['logo_font']['font-family'];
		}
		if(!empty($ciyashop_options['sticky_logo_font']) && $ciyashop_options['sticky_logo_font']['font-size']!=''){
			$dynamic_css['.sticky-site-title.h1 .logo-text']['font-size']    = $ciyashop_options['sticky_logo_font']['font-size'];
		}
		if(!empty($ciyashop_options['sticky_logo_font']) && $ciyashop_options['sticky_logo_font']['color']!=''){
			$dynamic_css['.sticky-site-title.h1 .logo-text']['color']    = $ciyashop_options['sticky_logo_font']['color'];
		}
	}
	
	
	/*End Site logo font settings */
	
	/* Site Logo Height*/
	if(isset($ciyashop_options['site-logo-max-height']) && !empty($ciyashop_options['site-logo-max-height'])){
		
		$site_logo_dimension = ciyashop_parse_redux_dimension( $ciyashop_options['site-logo-max-height'], 'px' );
		
		if( $site_logo_dimension ){
			
			if( isset($site_logo_dimension['height']) ){
				$dynamic_css['.site-header .site-title img']['max-height'] = $site_logo_dimension['height'];
			}
			
		}
	}
	
	/* Site Mobile Logo Height*/
	if(isset($ciyashop_options['mobile-logo-max-height']) && !empty($ciyashop_options['mobile-logo-max-height'])){
		
		$mobile_logo_dimension = ciyashop_parse_redux_dimension( $ciyashop_options['mobile-logo-max-height'], 'px' );
		
		if( $mobile_logo_dimension ){
			
			if( isset($mobile_logo_dimension['height']) ){
				$dynamic_css['.device-type-mobile .site-header .site-title img']['max-height'] = $mobile_logo_dimension['height'];
			}
		}
	}
	
	/*Sticky Logo height */
	if(isset($ciyashop_options['sticky-logo-max-height']) && !empty($ciyashop_options['sticky-logo-max-height'])){
		
		$sticky_logo_dimension = ciyashop_parse_redux_dimension( $ciyashop_options['sticky-logo-max-height'], 'px' );
		
		if( $sticky_logo_dimension ){
			
			if( isset($sticky_logo_dimension['height']) ){
				$dynamic_css['.site-header .sticky-site-title img']['max-height'] = $sticky_logo_dimension['height'];
			}
			
		}
	}
}

function ciyashop_preloader_css( $ciyashop_options ){
	global $dynamic_css;
	
	if(isset($ciyashop_options['preloader_background_color']) && !empty($ciyashop_options['preloader_background_color'])){
		$dynamic_css['#preloader']['background-color']=$ciyashop_options['preloader_background_color'];
	}	
}

function ciyashop_menu_font_css( $ciyashop_options ){
	global $dynamic_css;
	
	if( isset($ciyashop_options['menu_font_style_enable']) && $ciyashop_options['menu_font_style_enable'] == 'custom' ){
		$menu_text_typo_attrs = array(
			'font-family',
			'font-weight',
			'letter-spacing',
			'line-height',
			'font-style',
			'font-size',
		);

		if( isset($ciyashop_options['menu_fonts']) && !empty($ciyashop_options['menu_fonts']) ){
			foreach( $menu_text_typo_attrs as $menu_text_typo_attr ){
				if( isset($ciyashop_options['menu_fonts'][$menu_text_typo_attr]) && !empty($ciyashop_options['menu_fonts'][$menu_text_typo_attr]) ){
					$dynamic_css['.primary-nav .primary-menu > li a, .main-navigation-sticky .primary-menu > li a'][$menu_text_typo_attr] = $ciyashop_options['menu_fonts'][$menu_text_typo_attr];
				}
			}
		}
		
		if( isset($ciyashop_options['sub_menu_fonts']) && !empty($ciyashop_options['sub_menu_fonts']) ){
			if( isset($ciyashop_options['menu_fonts']['font-family']) && !empty($ciyashop_options['menu_fonts']['font-family']) ){
				$dynamic_css['.primary-nav .primary-menu > li .sub-menu > li a, .main-navigation-sticky .primary-menu > li .sub-menu > li a']['font-family'] = $ciyashop_options['menu_fonts']['font-family'];
			}
			foreach( $menu_text_typo_attrs as $menu_text_typo_attr ){
				if( isset($ciyashop_options['sub_menu_fonts'][$menu_text_typo_attr]) && !empty($ciyashop_options['sub_menu_fonts'][$menu_text_typo_attr]) ){
					$dynamic_css['.primary-nav .primary-menu > li .sub-menu > li a, .main-navigation-sticky .primary-menu > li .sub-menu > li a'][$menu_text_typo_attr] = $ciyashop_options['sub_menu_fonts'][$menu_text_typo_attr];
				}
			}
		}
	}
}	

function ciyashop_topbar_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	$topbar_bg_type = isset($ciyashop_options['topbar_bg_type']) && !empty($ciyashop_options['topbar_bg_type']) ? $ciyashop_options['topbar_bg_type'] : 'default';
	
	if( $topbar_bg_type != 'default' ){
		if( $topbar_bg_type == 'custom' ){
			$topbar_bg_color = isset($ciyashop_options['topbar_bg_color']) && !empty($ciyashop_options['topbar_bg_color']) ? $ciyashop_options['topbar_bg_color'] : array('rgba'=>'#ffffff');
			$dynamic_css['.header-style-right-topbar-main #masthead-inner > .topbar, #masthead-inner > .topbar, header.site-header .header-main-top .topbar, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom']['background-color'] = $topbar_bg_color['rgba'];
		}
		$topbar_text_color = isset($ciyashop_options['topbar_text_color']) && !empty($ciyashop_options['topbar_text_color']) ? $ciyashop_options['topbar_text_color'] : '#323232';
		$dynamic_css['.topbar .ciyashop-woocommerce-currency-switcher, .topbar-link .language span, .topbar .topbar-link > ul > li .language i, .topbar .topbar-link .language .drop-content li a, .header-style-topbar-with-main-header .ciyashop-woocommerce-currency-switcher,  .topbar .select2-container--default .select2-selection--single .select2-selection__rendered, .header-style-menu-center .topbar .select2-container--default .select2-selection--single .select2-selection__rendered, .header-style-menu-right .topbar .select2-container--default .select2-selection--single .select2-selection__rendered, .header-style-topbar-with-main-header .header-main .select2-container--default .select2-selection--single .select2-selection__rendered, .header-style-right-topbar-main .topbar .select2-container--default .select2-selection--single .select2-selection__rendered, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .topbar-link > ul > li a i, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .select2-container--default .select2-selection--single .select2-selection__rendered']['color'] = $topbar_text_color;

		$dynamic_css['.topbar .select2-container--default .select2-selection--single .select2-selection__arrow b, .header-style-menu-center .topbar .select2-container--default .select2-selection--single .select2-selection__arrow b, .header-style-menu-right .topbar .select2-container--default .select2-selection--single .select2-selection__arrow b, .header-style-topbar-with-main-header .header-main .select2-container--default .select2-selection--single .select2-selection__arrow b, .header-style-right-topbar-main .topbar .select2-container--default .select2-selection--single .select2-selection__arrow b, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .select2-container--default .select2-selection--single .select2-selection__arrow b']['border-top-color'] = $topbar_text_color;
		$dynamic_css['.topbar .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b, .header-style-menu-center .topbar .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b, .header-style-menu-right .topbar .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b, .header-style-topbar-with-main-header .header-main .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b, .header-style-right-topbar-main .topbar .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b']['border-bottom-color'] = $topbar_text_color;
		
		$topbar_link_color = isset($ciyashop_options['topbar_link_color']) && !empty($ciyashop_options['topbar_link_color']) ? $ciyashop_options['topbar_link_color'] : array(
			'regular'  => '#323232',
			'hover'    => '#04d39f',
		);
		if( isset( $topbar_link_color['regular'] ) && !empty($topbar_link_color['regular']) ){
			$dynamic_css['.topbar .topbar-link > ul > li a, .header-style-topbar-with-main-header .topbar-link > ul > li a, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .topbar-link > ul > li a']['color'] = $topbar_link_color['regular'];
		}
		if( isset( $topbar_link_color['hover'] ) && !empty($topbar_link_color['hover']) ){
			$dynamic_css['.topbar .topbar-link > ul > li a:hover i, .site-header .topbar a:hover, .topbar .topbar-link .language .drop-content li a:hover, .header-style-topbar-with-main-header .topbar-link > ul > li a:hover i, .header-style-topbar-with-main-header .topbar-link > ul > li a:hover, .header-style-right-topbar-main .header-main-bg-color-default .topbar-link > ul > li a:hover, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .topbar-link > ul > li a:hover i, .header-style-right-topbar-main #masthead-inner > .topbar.topbar-bg-color-custom .topbar-link > ul > li a:hover']['color'] = $topbar_link_color['hover'];
		}
	}
}

function ciyashop_header_main_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	$header_main_bg_type = isset($ciyashop_options['header_main_bg_type']) && !empty($ciyashop_options['header_main_bg_type']) ? $ciyashop_options['header_main_bg_type'] : 'default';
	
	if( $header_main_bg_type != 'default' ){
		if( $header_main_bg_type == 'custom' ){
			$header_main_bg_color = isset($ciyashop_options['header_main_bg_color']) && !empty($ciyashop_options['header_main_bg_color']) ? $ciyashop_options['header_main_bg_color'] : array('rgba'=>'#FFFFFF');
			$dynamic_css['header.site-header .header-main, .header-mobile, .header-style-right-topbar-main .header-main-bottom,  .header-above-content .header-main-bg-color-custom .woo-tools-cart .cart-link .count']['background-color'] = $header_main_bg_color['rgba'];
			$dynamic_css['.header-main-bg-color-custom .woo-tools-cart .cart-link .count']['color'] = $header_main_bg_color['rgba'];
		}
		$header_main_text_color = isset($ciyashop_options['header_main_text_color']) && !empty($ciyashop_options['header_main_text_color']) ? $ciyashop_options['header_main_text_color'] : '#323232';
		$dynamic_css['.header-main, .header-main .woo-tools-actions > li i, .header-main .search-button-wrap .search-button, .header-mobile .woo-tools-actions > li i, .header-mobile .mobile-butoon-search > a, .header-mobile .mobile-butoon-menu > a']['color'] = $header_main_text_color;
		$dynamic_css['.header-mobile .mobile-butoon-menu span, .header-mobile .mobile-butoon-menu span:before, .header-mobile .mobile-butoon-menu span:after']['background-color'] = $header_main_text_color;
		
		$header_main_link_color = isset($ciyashop_options['header_main_link_color']) && !empty($ciyashop_options['header_main_link_color']) ? $ciyashop_options['header_main_link_color'] : array(
			'regular'  => '#323232',
			'hover'    => '#04d39f',
		);
		if( isset($header_main_link_color['regular']) && !empty($header_main_link_color['regular']) ){
			$dynamic_css['.header-main a, .header-style-menu-center .primary-nav .primary-menu > li > a, .header-style-menu-right .primary-nav .primary-menu > li > a, .header-style-right-topbar-main .header-nav .primary-nav .primary-menu > li > a, .header-above-content .header-main-bg-color-custom .woo-tools-cart .cart-link .count']['color'] = $header_main_link_color['regular'];
		}
		if( isset( $header_main_link_color['hover'] ) && !empty($header_main_link_color['hover']) ){
			$dynamic_css['.header-main a:hover, .woo-tools-actions > li i:hover, .site-header .search-button-wrap .search-button:hover, .header-style-menu-center .header-main-bg-color-custom .primary-nav .primary-menu > li > a:hover, .header-style-right-topbar-main .header-main-bg-color-custom .primary-nav .primary-menu > li > a:hover, 
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-item > a, 
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-item > a:before,
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-item > a,
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-ancestor > a,
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-ancestor > a, 
.header-style-right-topbar-main .header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-ancestor > a, 
.header-style-right-topbar-main .header-main-bg-color-custom .primary-nav .primary-menu > li.current-menu-ancestor > a:before, 
.header-style-logo-center .header-main .woo-tools-actions > li > a:hover i, .header-main.header-main-bg-color-custom .woo-tools-actions > li i:hover, 
.header-style-default .header-main.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-default .header-main.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-logo-center .header-main.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-logo-center .header-main.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-menu-center .header-main.header-main-bg-color-custom .primary-menu > li:hover > a, 
.header-style-menu-center .header-main.header-main-bg-color-custom .primary-menu > li > a:hover,
.header-style-menu-right .header-main.header-main-bg-color-custom .primary-menu > li:hover > a, 
.header-style-menu-right .header-main.header-main-bg-color-custom .primary-menu > li > a:hover,
.header-style-topbar-with-main-header .header-main.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-topbar-with-main-header .header-main.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-menu > li:hover > a, 
.header-style-right-topbar-main .header-main.header-main-bg-color-custom .primary-menu > li > a:hover,
.header-style-menu-center .header-main.header-main-bg-color-custom .primary-menu > li.current-menu-item > a, 
.header-style-menu-center .header-main.header-main-bg-color-custom .primary-menu > li.current-menu-ancestor > a,
.header-style-menu-right .header-main.header-main-bg-color-custom .primary-menu > li.current-menu-item > a, 
.header-style-menu-right .header-main.header-main-bg-color-custom .primary-menu > li.current-menu-ancestor > a']['color'] = $header_main_link_color['hover'];
		}
		if( isset( $header_main_link_color['hover'] ) && !empty($header_main_link_color['hover']) ){
			$dynamic_css['
			.header-style-menu-center .primary-nav .primary-menu > li > a:after,
			.header-style-menu-right .primary-nav .primary-menu > li > a:after, 
			.header-main-bg-color-custom .woo-tools-cart .cart-link .count
			']['background-color'] = $header_main_link_color['hover'];
		}
	}

}

function ciyashop_header_nav_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	$header_nav_bg_type = isset($ciyashop_options['header_nav_bg_type']) && !empty($ciyashop_options['header_nav_bg_type']) ? $ciyashop_options['header_nav_bg_type'] : 'default';
	
	if( $header_nav_bg_type != 'default' ){
		if( $header_nav_bg_type == 'custom' ){
			$header_nav_bg_color = isset($ciyashop_options['header_nav_bg_color']) && !empty($ciyashop_options['header_nav_bg_color']) ? $ciyashop_options['header_nav_bg_color'] : array('rgba'=>'#04d39f');
			$dynamic_css['.site-header .header-nav']['background-color'] = $header_nav_bg_color['rgba'];
		}
		$header_nav_text_color = isset($ciyashop_options['header_nav_text_color']) && !empty($ciyashop_options['header_nav_text_color']) ? $ciyashop_options['header_nav_text_color'] : '#FFFFFF';
		$dynamic_css['.header-nav, .header-style-topbar-with-main-header .header-nav .woo-tools-actions > li i, .header-style-topbar-with-main-header .header-nav .search-button-wrap .search-button']['color'] = $header_nav_text_color;
		
		$header_nav_link_color = isset($ciyashop_options['header_nav_link_color']) && !empty($ciyashop_options['header_nav_link_color']) ? $ciyashop_options['header_nav_link_color'] : array(
			'regular'  => '#323232',
			'hover'    => '#04d39f',
		);
		if( isset( $header_nav_link_color['regular']) && !empty($header_nav_link_color['regular']) ){
			$dynamic_css['.header-nav .primary-nav .primary-menu > li a']['color'] = $header_nav_link_color['regular'];
		}
		if( isset( $header_nav_link_color['hover'] ) && !empty($header_nav_link_color['hover']) ){
			$dynamic_css['.primary-nav .primary-menu > li a:hover, 
.site-header .header-nav .search-button-wrap .search-button:hover, 
.header-style-topbar-with-main-header .header-nav .woo-tools-actions > li i:hover,  
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li.current-menu-ancestor > a, 
.header-style-default .header-nav.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-default .header-nav.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-default .header-nav.header-nav-bg-color-custom .primary-menu > li.current-menu-ancestor > a,
.header-style-logo-center .header-nav.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-logo-center .header-nav.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-logo-center .header-nav.header-nav-bg-color-custom .primary-menu > li.current-menu-ancestor > a,
.header-style-topbar-with-main-header .header-nav.header-nav-bg-color-custom .primary-menu > li:hover > a, 
.header-style-topbar-with-main-header .header-nav.header-nav-bg-color-custom .primary-menu > li > a:hover,
.header-style-topbar-with-main-header .header-nav.header-nav-bg-color-custom .primary-menu > li.current-menu-ancestor > a,
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li .sub-menu li:hover > a, 
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li .sub-menu li > a:hover, 
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li .sub-menu li.current-menu-ancestor > a, 
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li .sub-menu li.current-menu-parent > a, 
.header-nav.header-main-bg-color-default .primary-nav .primary-menu > li .sub-menu li.current-menu-item > a ']['color'] = $header_nav_link_color['hover'];
		}
		if( isset( $header_nav_link_color['hover'] ) && !empty($header_nav_link_color['hover']) ){
			$dynamic_css['body .header-style-default .primary-nav .primary-menu > li:before, body .header-style-topbar-with-main-header .primary-nav .primary-menu > li:before, body .header-style-logo-center .primary-nav .primary-menu > li:before']['background-color'] = $header_nav_link_color['hover'];
		}
	}
}

function ciyashop_header_sticky_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	// Sticky header background color
	if( isset( $ciyashop_options['sticky_header_color']) && !empty($ciyashop_options['sticky_header_color']) ){
		$dynamic_css['#header-sticky']['background-color'] = $ciyashop_options['sticky_header_color'];
	}
	
	// Sticky header text color
	if( isset( $ciyashop_options['sticky_header_text_color']) && !empty($ciyashop_options['sticky_header_text_color']) ){
		$dynamic_css['#header-sticky, .main-navigation-sticky .primary-menu > li > a, .main-navigation-sticky #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link, .header-sticky-inner .woo-tools-actions > li i']['color'] = $ciyashop_options['sticky_header_text_color'];
	}
	if( isset( $ciyashop_options['sticky_header_text_color']) && !empty($ciyashop_options['sticky_header_text_color']) ){
		$dynamic_css['#header-sticky #site-navigation-sticky-mobile .slicknav_menu .slicknav_icon-bar']['background-color'] = $ciyashop_options['sticky_header_text_color'];
	}
	
	// Sticky header link color
	if( isset( $ciyashop_options['sticky_header_link_color']) && !empty($ciyashop_options['sticky_header_link_color']) ){
		$dynamic_css['.main-navigation-sticky .primary-menu > li:hover > a, .main-navigation-sticky .primary-menu > li > a:hover, .main-navigation-sticky .primary-menu > li.current-menu-item > a, .main-navigation-sticky .primary-menu > li.current-menu-ancestor > a, .main-navigation-sticky .primary-menu > li.current-menu-ancestor > a:before, .main-navigation-sticky #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item > a.mega-menu-link:hover, .site-header .header-sticky #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current_page_item > a.mega-menu-link,
.site-header .header-sticky #mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-item.mega-current-menu-ancestor > a.mega-menu-link, .main-navigation-sticky .primary-menu > li.current-menu-item > a:before, .main-navigation-sticky .primary-menu > li.current-menu-ancestor > a:before, .header-sticky-inner .woo-tools-actions > li i:hover']['color'] = $ciyashop_options['sticky_header_link_color'];
	}
	if( isset( $ciyashop_options['sticky_header_link_color']) && !empty($ciyashop_options['sticky_header_link_color']) ){
		$dynamic_css['#header-sticky-sticky-wrapper .primary-menu > li:before, .header-sticky-inner .woo-tools-cart .cart-link .count']['background-color'] = $ciyashop_options['sticky_header_link_color'];
	}
}

function ciyashop_page_header_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	// Page header height
	$pageheader_height = ( isset($ciyashop_options['pageheader_height']) ) ? $ciyashop_options['pageheader_height'] : '150';
	if( $pageheader_height != '' ){
		$dynamic_css['.inner-intro']['height'] = $pageheader_height.'px';
	}
	
	// Generate Banner CSS from Options
	$banner_type = ( isset($ciyashop_options['banner_type']) ) ? $ciyashop_options['banner_type'] : 'image' ;
	
	if( $banner_type == 'image' ){
		
		$banner_image_bg_url = get_parent_theme_file_uri('/images/page-header.jpg');
	
		if( isset($ciyashop_options['banner_image']) && !empty($ciyashop_options['banner_image']) ){
			if( isset($ciyashop_options['banner_image']['background-image']) && !empty($ciyashop_options['banner_image']['background-image']) ){
				$banner_image_bg_url = $ciyashop_options['banner_image']['background-image'];
			}
			
			// Set other properties
			if( isset($ciyashop_options['banner_image']['background-repeat']) && !empty($ciyashop_options['banner_image']['background-repeat']) ){
				$dynamic_css['.header_intro_bg-image']['background-repeat'] = $ciyashop_options['banner_image']['background-repeat'];
			}
			if( isset($ciyashop_options['banner_image']['background-size']) && !empty($ciyashop_options['banner_image']['background-size']) ){
				$dynamic_css['.header_intro_bg-image']['background-size'] = $ciyashop_options['banner_image']['background-size'];
			}
			if( isset($ciyashop_options['banner_image']['background-attachment']) && !empty($ciyashop_options['banner_image']['background-attachment']) ){
				$dynamic_css['.header_intro_bg-image']['background-attachment'] = $ciyashop_options['banner_image']['background-attachment'];
			}
			if( isset($ciyashop_options['banner_image']['background-position']) && !empty($ciyashop_options['banner_image']['background-position']) ){
				$dynamic_css['.header_intro_bg-image']['background-position'] = $ciyashop_options['banner_image']['background-position'];
			}
		}
	
		$dynamic_css['.header_intro_bg-image']['background-image'] = 'url(\''.$banner_image_bg_url.'\')';
		
	}elseif( $banner_type == 'video' ){
		
	}elseif( $banner_type == 'color' ){
		if( !empty($ciyashop_options['banner_image_color']) ){
			$dynamic_css['.header_intro_bg-color']['background-color'] = $ciyashop_options['banner_image_color'];
		}else{
			$dynamic_css['.header_intro_bg-color']['background-color'] = '#000000';
		}
	}
	
	if( $banner_type == 'video' || $banner_type == 'image' ){
		$banner_image_opacity = ( isset($ciyashop_options['banner_image_opacity']) ) ? $ciyashop_options['banner_image_opacity'] : 'black';
		if( !empty($banner_image_opacity) && $banner_image_opacity == 'custom' ){
			$banner_image_opacity_custom_color = $ciyashop_options['banner_image_opacity_custom_color'];
			if( !empty($banner_image_opacity_custom_color) ){
				if( isset($banner_image_opacity_custom_color['rgba']) ){
					$header_intro_opacity_background_color = $banner_image_opacity_custom_color['rgba'];
				}else{
					$header_intro_opacity_background_color = ciyashop_hex2rgba($banner_image_opacity_custom_color['color'],$banner_image_opacity_custom_color['alpha']);
				}
				$dynamic_css['.header_intro_opacity::before']['background-color'] = $header_intro_opacity_background_color;
			}
		}
	}
	
	// Generate Banner CSS from Singple Page
	if( is_page() || is_single() || (function_exists('is_shop') && is_shop())){
		$header_settings_source = get_post_meta($post_id,'header_settings_source', true);
		if( $header_settings_source=='custom' ){
			// Unset data set from options
			$banner_type = '';
			unset($dynamic_css['.header_intro_bg-image']);
			unset($dynamic_css['.header_intro_opacity::before']);
			unset($dynamic_css['.header_intro_bg-color']);
			
			$banner_type = get_post_meta($post_id,'banner_type', true);
			if( empty($banner_type) ){
				$banner_type = 'image';
			}
			
			if( $banner_type && $banner_type == 'image' ){
				// Default Image
				$banner_image_bg_url = get_parent_theme_file_uri('/images/page-header.jpg');
				if( function_exists('get_field') ){
					$banner_image_bg_custom = get_field('banner_image_bg_custom');
				}else{
					$banner_image_bg_custom = false;
				}
				if( $banner_image_bg_custom && isset($banner_image_bg_custom['background-image']) && !empty($banner_image_bg_custom['background-image']) ){
					$banner_image_bg_url = $banner_image_bg_custom['background-image'];
					
					// Set other properties
					if( isset($banner_image_bg_custom['background-repeat']) && !empty($banner_image_bg_custom['background-repeat']) ){
						$dynamic_css['.header_intro_bg-image']['background-repeat'] = $banner_image_bg_custom['background-repeat'];
					}
					if( isset($banner_image_bg_custom['background-size']) && !empty($banner_image_bg_custom['background-size']) ){
						$dynamic_css['.header_intro_bg-image']['background-size'] = $banner_image_bg_custom['background-size'];
					}
					if( isset($banner_image_bg_custom['background-attachment']) && !empty($banner_image_bg_custom['background-attachment']) ){
						$dynamic_css['.header_intro_bg-image']['background-attachment'] = $banner_image_bg_custom['background-attachment'];
					}
					if( isset($banner_image_bg_custom['background-position']) && !empty($banner_image_bg_custom['background-position']) ){
						$dynamic_css['.header_intro_bg-image']['background-position'] = $banner_image_bg_custom['background-position'];
					}
				}
				$dynamic_css['.header_intro_bg-image']['background-image'] = 'url(\''.$banner_image_bg_url.'\')';
				
			}elseif( $banner_type && $banner_type == 'color' ){
				$banner_image_color = get_post_meta($post_id,'banner_image_color', true);
				
				if( $banner_image_color ){
					$dynamic_css['.header_intro_bg-color']['background-color'] = $banner_image_color;
				}
			}
			
			if( $banner_type && ( $banner_type == 'image' || $banner_type == 'video' ) ){
				$background_opacity_color = get_post_meta($post_id,'background_opacity_color', true);
				if( $background_opacity_color && $background_opacity_color == 'custom' ){
					$banner_image_opacity_custom_color   = get_post_meta($post_id,'banner_image_opacity_custom_color', true);
					$banner_image_opacity_custom_opacity = get_post_meta($post_id,'banner_image_opacity_custom_opacity', true);
					if( empty($banner_image_opacity_custom_color) ){
						$banner_image_opacity_custom_color = '#191919';
					}
					if( empty($banner_image_opacity_custom_opacity) ){
						$banner_image_opacity_custom_opacity = .8;
					}
					$banner_color = ciyashop_hex2rgba($banner_image_opacity_custom_color, $banner_image_opacity_custom_opacity);
					$dynamic_css['.header_intro_opacity::before']['background-color'] = $banner_color;
				}
			}
			
			
			/*Page Header Section Height */
			$page_header_height = get_post_meta($post_id,'page_header_height', true);
			if( $page_header_height != '' ){
				$dynamic_css['.inner-intro']['height'] = $page_header_height.'px';
			}
		}
	}
}

function ciyashop_content_css( $ciyashop_options ){
	global $dynamic_css, $ciyashop_options, $ciyashop_body_typo, $ciyashop_h1_typo, $ciyashop_h2_typo, $ciyashop_h3_typo, $ciyashop_h4_typo, $ciyashop_h5_typo, $ciyashop_h6_typo;
	
	$post_id = ciyashop_dynamic_css_page_id();
	
	/* Body Typography*/
	if(isset($ciyashop_options['typography-body']) && !empty($ciyashop_options['typography-body']) && !empty($ciyashop_body_typo['family'])){
		
		/*Body Font family, font weight, letter spacing */
		if(isset($ciyashop_options['typography-body']['font-family']) && !empty($ciyashop_options['typography-body']['font-family'])){
			if( isset($ciyashop_options['typography-body']['font-backup']) && !empty( $ciyashop_options['typography-body']['font-backup'] )){
				$dynamic_css[$ciyashop_body_typo['family']]['font-family']    = '"'.$ciyashop_options['typography-body']['font-family'].'", '.$ciyashop_options['typography-body']['font-backup'];
			}else{
				$dynamic_css[$ciyashop_body_typo['family']]['font-family']    = $ciyashop_options['h4-typography']['font-family'];
			}
		}
		
		if(isset($ciyashop_options['typography-body']['font-weight']) && !empty($ciyashop_options['typography-body']['font-weight'])){
			$dynamic_css[$ciyashop_body_typo['family']]['font-weight']    = $ciyashop_options['typography-body']['font-weight'];
		}
		
		if(isset($ciyashop_options['typography-body']['letter-spacing']) && !empty($ciyashop_options['typography-body']['letter-spacing'])){
			$dynamic_css[$ciyashop_body_typo['family']]['letter-spacing'] = $ciyashop_options['typography-body']['letter-spacing'];
		}
		
		/* Body Line Height */
		if( isset($ciyashop_options['typography-body']['line-height']) && !empty($ciyashop_options['typography-body']['line-height']) ){
			$dynamic_css[$ciyashop_body_typo['line-height']]['line-height'] = $ciyashop_options['typography-body']['line-height'];
		}
		/* Body Font Size */
		if( isset($ciyashop_options['typography-body']['font-size']) && !empty($ciyashop_options['typography-body']['font-size']) ){
			$dynamic_css[$ciyashop_body_typo['font-size']]['font-size'] = $ciyashop_options['typography-body']['font-size'];
		}
		
		
	}
	
	/* h1 Typography*/
	if(isset($ciyashop_options['h1-typography']) && !empty($ciyashop_options['h1-typography']) && !empty($ciyashop_h1_typo['family'])){
		
		/* h1 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h1-typography']['font-backup']) && !empty( $ciyashop_options['h1-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h1_typo['family']]['font-family']    = '"'.$ciyashop_options['h1-typography']['font-family'].'", '.$ciyashop_options['h1-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h1_typo['family']]['font-family']    = $ciyashop_options['ciyashop_h1_typo']['font-family'];
		}
		
		if( isset($ciyashop_options['h1-typography']['font-weight']) && !empty($ciyashop_options['h1-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h1_typo['family']]['font-weight']    = $ciyashop_options['h1-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h1-typography']['letter-spacing']) && !empty($ciyashop_options['h1-typography']['letter-spacing']) ) {
			$dynamic_css[$ciyashop_h1_typo['family']]['letter-spacing'] = $ciyashop_options['h1-typography']['letter-spacing'];
		}
		
		/* h1 Typography Line Height */
		if( isset($ciyashop_options['h1-typography']['line-height']) && !empty($ciyashop_options['h1-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h1_typo['line-height']]['line-height'] = $ciyashop_options['h1-typography']['line-height'];
		}
		/* h1 Typography Font Size */
		if( isset($ciyashop_options['h1-typography']['font-size']) && !empty($ciyashop_options['h1-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h1_typo['font-size']]['font-size'] = $ciyashop_options['h1-typography']['font-size'];
		}
	}
	
	/* h2 Typography*/
	if(isset($ciyashop_options['h2-typography']) && !empty($ciyashop_options['h2-typography']) && !empty($ciyashop_h2_typo['family'])){
		
		/* h2 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h2-typography']['font-backup']) && !empty( $ciyashop_options['h2-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h2_typo['family']]['font-family']    = '"'.$ciyashop_options['h2-typography']['font-family'].'", '.$ciyashop_options['h2-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h2_typo['family']]['font-family']    = $ciyashop_options['h2-typography']['font-family'];
		}
		
		if( isset($ciyashop_options['h2-typography']['font-weight']) && !empty($ciyashop_options['h2-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h2_typo['family']]['font-weight']    = $ciyashop_options['h2-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h2-typography']['letter-spacing']) && !empty($ciyashop_options['h2-typography']['letter-spacing']) ){
			$dynamic_css[$ciyashop_h2_typo['family']]['letter-spacing'] = $ciyashop_options['h2-typography']['letter-spacing'];
		}
		
		/* h2 Typography Line Height */
		if( isset($ciyashop_options['h2-typography']['line-height']) && !empty($ciyashop_options['h2-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h2_typo['line-height']]['line-height'] = $ciyashop_options['h2-typography']['line-height'];
		}
		/* h2 Typography Font Size */
		if( isset($ciyashop_options['h2-typography']['font-size']) && !empty($ciyashop_options['h2-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h2_typo['font-size']]['font-size'] = $ciyashop_options['h2-typography']['font-size'];
		}
	}
	
	/* h3 Typography*/
	if(isset($ciyashop_options['h3-typography']) && !empty($ciyashop_options['h3-typography']) && !empty($ciyashop_h3_typo['family'])){
		
		/* h3 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h3-typography']['font-backup']) && !empty( $ciyashop_options['h3-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h3_typo['family']]['font-family']    = '"'.$ciyashop_options['h3-typography']['font-family'].'", '.$ciyashop_options['h3-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h3_typo['family']]['font-family']    = $ciyashop_options['h3-typography']['font-family'];
		}
		
		if( isset($ciyashop_options['h3-typography']['font-weight']) && !empty($ciyashop_options['h3-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h3_typo['family']]['font-weight']    = $ciyashop_options['h3-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h3-typography']['letter-spacing']) && !empty($ciyashop_options['h3-typography']['letter-spacing']) ){
			$dynamic_css[$ciyashop_h3_typo['family']]['letter-spacing'] = $ciyashop_options['h3-typography']['letter-spacing'];
		}
		/* h3 Typography Line Height */
		if( isset($ciyashop_options['h3-typography']['line-height']) && !empty($ciyashop_options['h3-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h3_typo['line-height']]['line-height'] = $ciyashop_options['h3-typography']['line-height'];
		}
		/* h3 Typography Font Size */
		if( isset($ciyashop_options['h3-typography']['font-size']) && !empty($ciyashop_options['h3-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h3_typo['font-size']]['font-size'] = $ciyashop_options['h3-typography']['font-size'];
		}
	}
	
	/* h4 Typography*/
	if(isset($ciyashop_options['h4-typography']) && !empty($ciyashop_options['h4-typography']) && !empty($ciyashop_h4_typo['family'])){
		
		/* h4 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h4-typography']['font-backup']) && !empty( $ciyashop_options['h4-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h4_typo['family']]['font-family']    = '"'.$ciyashop_options['h4-typography']['font-family'].'", '.$ciyashop_options['h4-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h4_typo['family']]['font-family'] = $ciyashop_options['h4-typography']['font-family'];
		}
		
		if( isset($ciyashop_options['h4-typography']['font-weight']) && !empty($ciyashop_options['h4-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h4_typo['family']]['font-weight']    = $ciyashop_options['h4-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h4-typography']['letter-spacing']) && !empty($ciyashop_options['h4-typography']['letter-spacing'])){
			$dynamic_css[$ciyashop_h4_typo['family']]['letter-spacing'] = $ciyashop_options['h4-typography']['letter-spacing'];
		}
		/* h4 Typography Line Height */
		if( isset($ciyashop_options['h4-typography']['line-height']) && !empty($ciyashop_options['h4-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h4_typo['line-height']]['line-height'] = $ciyashop_options['h4-typography']['line-height'];
		}
		/* h4 Typography Font Size */
		if( isset($ciyashop_options['h4-typography']['font-size']) && !empty($ciyashop_options['h4-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h4_typo['font-size']]['font-size'] = $ciyashop_options['h4-typography']['font-size'];
		}
	}
	
	/* h5 Typography*/
	if(isset($ciyashop_options['h5-typography']) && !empty($ciyashop_options['h5-typography']) && !empty($ciyashop_h5_typo['family'])){
		
		/* h5 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h5-typography']['font-backup']) && !empty( $ciyashop_options['h5-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h5_typo['family']]['font-family']    = '"'.$ciyashop_options['h5-typography']['font-family'].'", '.$ciyashop_options['h5-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h5_typo['family']]['font-family']    = $ciyashop_options['h5-typography']['font-family'];
		}
		
		if( isset($ciyashop_options['h5-typography']['font-weight']) && !empty($ciyashop_options['h5-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h5_typo['family']]['font-weight']    = $ciyashop_options['h5-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h5-typography']['letter-spacing']) && !empty($ciyashop_options['h5-typography']['letter-spacing']) ){
			$dynamic_css[$ciyashop_h5_typo['family']]['letter-spacing'] = $ciyashop_options['h5-typography']['letter-spacing'];
		}
		/* h5 Typography Line Height */
		if( isset($ciyashop_options['h5-typography']['line-height']) && !empty($ciyashop_options['h5-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h5_typo['line-height']]['line-height'] = $ciyashop_options['h5-typography']['line-height'];
		}
		/* h5 Typography Font Size */
		if( isset($ciyashop_options['h5-typography']['font-size']) && !empty($ciyashop_options['h5-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h5_typo['font-size']]['font-size'] = $ciyashop_options['h5-typography']['font-size'];
		}
	}
	
	/* h6 Typography*/
	if(isset($ciyashop_options['h6-typography']) && !empty($ciyashop_options['h6-typography']) && !empty($ciyashop_h6_typo['family'])){
		
		/* h6 Typography Font family, font weight, letter spacing */
		if( isset($ciyashop_options['h6-typography']['font-backup']) && !empty( $ciyashop_options['h6-typography']['font-backup'] )){
			$dynamic_css[$ciyashop_h6_typo['family']]['font-family']    = '"'.$ciyashop_options['h6-typography']['font-family'].'", '.$ciyashop_options['h6-typography']['font-backup'];
		}else{
			$dynamic_css[$ciyashop_h6_typo['family']]['font-family'] = $ciyashop_options['h6-typography']['font-family'];
		}
		
		if( isset($ciyashop_options['h6-typography']['font-weight']) && !empty($ciyashop_options['h6-typography']['font-weight']) ){
			$dynamic_css[$ciyashop_h6_typo['family']]['font-weight']    = $ciyashop_options['h6-typography']['font-weight'];
		}
		if(isset($ciyashop_options['h6-typography']['letter-spacing']) && !empty($ciyashop_options['h6-typography']['letter-spacing'])){
			$dynamic_css[$ciyashop_h6_typo['family']]['letter-spacing'] = $ciyashop_options['h6-typography']['letter-spacing'];
		}
		/* h6 Typography Line Height */
		if( isset($ciyashop_options['h6-typography']['line-height']) && !empty($ciyashop_options['h6-typography']['line-height']) ){
			$dynamic_css[$ciyashop_h6_typo['line-height']]['line-height'] = $ciyashop_options['h6-typography']['line-height'];
		}
		/* h6 Typography Font Size */
		if( isset($ciyashop_options['h6-typography']['font-size']) && !empty($ciyashop_options['h6-typography']['font-size']) ){
			$dynamic_css[$ciyashop_h6_typo['font-size']]['font-size'] = $ciyashop_options['h6-typography']['font-size'];
		}
	}
}

function ciyashop_footer_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
	/* Footer Background Option For Image*/
	if(isset($ciyashop_options['footer_background_type']) && $ciyashop_options['footer_background_type']=='image' && !empty($ciyashop_options['footer_background_image'])){
		$dynamic_css['footer.site-footer']['background']="url(".$ciyashop_options['footer_background_image']['background-image'].")";
		
		if(isset($ciyashop_options['footer_background_image']['background-repeat'])){
			$dynamic_css['footer.site-footer']['background-repeat']=$ciyashop_options['footer_background_image']['background-repeat'];
		}
		if(isset($ciyashop_options['footer_background_image']['background-attachment'])){
			$dynamic_css['footer.site-footer']['background-attachment']=$ciyashop_options['footer_background_image']['background-attachment'];
		}
		if(isset($ciyashop_options['footer_background_image']['background-size'])){
			$dynamic_css['footer.site-footer']['background-size']=$ciyashop_options['footer_background_image']['background-size'];
		}
		if(isset($ciyashop_options['footer_background_image']['background-position'])){
			$dynamic_css['footer.site-footer']['background-position']=$ciyashop_options['footer_background_image']['background-position'];
		}

		if(isset($ciyashop_options['footer_background_overlay']) && $ciyashop_options['footer_background_opacity']=='custom' && !empty($ciyashop_options['footer_background_overlay'])){
			if( isset($ciyashop_options['footer_background_overlay']['rgba']) ){
				$site_footer_footer_footer_opacity_custom_background = $ciyashop_options['footer_background_overlay']['rgba'];
			}else{
				$site_footer_footer_footer_opacity_custom_background = ciyashop_hex2rgba($ciyashop_options['footer_background_overlay']['color'],$ciyashop_options['footer_background_overlay']['alpha']);
			}
			$dynamic_css['.site-footer .footer-wrapper.footer_opacity_custom']['background-color']=$site_footer_footer_footer_opacity_custom_background;
		}
	}
	
	/*Footer Background Color */
	if(isset($ciyashop_options['footer_background_type']) && $ciyashop_options['footer_background_type']=='color'){
		$dynamic_css['footer.site-footer']['background']=$ciyashop_options['footer_background_color'];
		
	}
	
	/*Footer Heading Color */
	if(isset($ciyashop_options['footer_heading_color']) && $ciyashop_options['footer_heading_color']!=''){
		$dynamic_css['.site-footer .widget .widget-title']['color']=$ciyashop_options['footer_heading_color'];
		
	}
	/*Footer Text Color */
	if(isset($ciyashop_options['footer_text_color']) && $ciyashop_options['footer_text_color']!=''){
		$dynamic_css['.site-footer h1,
		.site-footer h2,
		.site-footer h3,
		.site-footer h4,
		.site-footer h5,
		.site-footer h6,
		.site-footer,
		.site-footer a:hover,
		.site-footer .widget ul li a,
		.site-footer .widget_archive ul li:before, 
		.site-footer .widget_meta ul li:before,
		.site-footer .widget select,
		.site-footer table th,
		.site-footer table caption,
		.site-footer input[type=text], 
		.site-footer input[type=email], 
		.site-footer input[type=search], 
		.site-footer input[type=password], 
		.site-footer textarea,
		.site-footer .widget_rss ul li,
		.site-footer .widget_search .search-button,
		.site-footer .widget_tag_cloud .tagcloud a.tag-cloud-link,
		.site-footer .widget_pgs_contact_widget ul li,
		.site-footer .widget_pgs_bestseller_widget .item-detail del .amount,
		.site-footer .widget_pgs_featured_products_widget .item-detail del .amount,
		.site-footer .widget_recent_entries .recent-post .recent-post-info a,
		.site-footer .woocommerce .widget_shopping_cart .total strong, 
		.site-footer .woocommerce.widget_shopping_cart .total strong,
		.site-footer .widget-woocommerce-currency-rates ul.woocs_currency_rates li strong,
		.site-footer .woocommerce-currency-switcher-form a.dd-selected:not([href]):not([tabindex]),
		.site-footer .widget_product_tag_cloud .tagcloud a,
		.site-footer .select2-container--default .select2-selection--single .select2-selection__rendered,
		.site-footer .widget.widget_recent_comments ul li a,
		.site-footer .woocommerce ul.product_list_widget li a,
		.site-footer blockquote,
		.pgs-opening-hours ul li']['color']=$ciyashop_options['footer_text_color'];	
		}
	
	/*Footer Link Color */
	if(isset($ciyashop_options['footer_link_color']) && $ciyashop_options['footer_link_color']!=''){
		$dynamic_css['.site-footer a,
		.site-footer .widget ul li > a:hover,
		.site-footer .widget_archive ul li,
		.site-footer .widget_categories ul li .widget_categories-post-count,
		.site-footer .widget_search .search-button:hover,
		.site-footer .widget_pgs_contact_widget ul li i,
		.site-footer .widget_pgs_bestseller_widget .item-detail .amount,
		.site-footer .widget_pgs_featured_products_widget .item-detail .amount,
		.site-footer .widget.widget_recent_comments ul li a:hover,
		.site-footer .widget_recent_entries .recent-post .recent-post-info .post-date i,
		.site-footer .widget_recent_entries .recent-post .recent-post-info a:hover,
		.site-footer .woocommerce .widget_shopping_cart .total .amount, 
		.site-footer .woocommerce.widget_shopping_cart .total .amount,
		.site-footer .widget-woocommerce-currency-rates ul.woocs_currency_rates li,
		.site-footer .WOOCS_SELECTOR .dd-desc,
		.site-footer .widget_product_categories ul li .count,
		.site-footer .widget_products ins,
		.woocommerce .site-footer .widget_top_rated_products ul.product_list_widget li ins,
		.widget_top_rated_products ins,
		.site-footer .woocommerce ul.cart_list li a:hover, 
		.site-footer .woocommerce ul.product_list_widget li a:hover,
		.pgs-opening-hours ul li i']['color']=$ciyashop_options['footer_link_color'];
	}

	/*Footer Link Border Color */
	if(isset($ciyashop_options['footer_link_color']) && $ciyashop_options['footer_link_color']!=''){
		$dynamic_css['
			.widget_pgs_newsletter_widget .newsletter_form .input-area input.newsletter-email:focus
		']['border-color']=$ciyashop_options['footer_link_color'];
	}

	/*Footer Link Backgroud Color */
	if(isset($ciyashop_options['footer_link_color']) && $ciyashop_options['footer_link_color']!=''){
		$dynamic_css['
			.site-footer .footer-widgets .widget_pgs_newsletter_widget .newsletter_form .button-area .input-group-btn > .btn
		']['background']=$ciyashop_options['footer_link_color'];
	}
	
	/* Copywrite footer backgroud color*/
	if(isset($ciyashop_options['copyright_back_color']) && !empty($ciyashop_options['copyright_back_color'])){
		if( isset($ciyashop_options['copyright_back_color']['rgba']) ){
			$site_info_footer_widget_background_color = $ciyashop_options['copyright_back_color']['rgba'];
		}else{
			$site_info_footer_widget_background_color = ciyashop_hex2rgba($ciyashop_options['copyright_back_color']['color'],$ciyashop_options['copyright_back_color']['alpha']);
		}
		$dynamic_css['.site-footer .site-info']['background']=$site_info_footer_widget_background_color;
	}
	/* Footer CopyWrite Text Color */
	if(isset($ciyashop_options['copyright_text_color']) && $ciyashop_options['copyright_text_color']!=''){
		$dynamic_css['.site-footer .site-info, .site-footer .footer-widget a']['color']=$ciyashop_options['copyright_text_color'];		
		
	}
	/* Footer CopyWrite Link Color */
	if(isset($ciyashop_options['copyright_link_color']) && $ciyashop_options['copyright_link_color']!=''){
		$dynamic_css['.site-footer .footer-widget a:hover']['color']=$ciyashop_options['copyright_link_color'];
	}
}

function ciyashop_temp_css( $ciyashop_options ){
	global $dynamic_css;
	
	$post_id = ciyashop_dynamic_css_page_id();
}

function ciyashop_parse_redux_dimension( $dimension_data = array(), $units = 'px' ){
	
	// bail early if no data found
	if( empty($dimension_data) ) return false;
	
	$new_dimenstion = array();
	
	if( !isset($dimension_data['units']) || $dimension_data['units'] == '' ){
		$dimension_data['units'] = $units;
	}
	
	if( isset($dimension_data['height']) && $dimension_data['height'] != '' ){
		
		if( $dimension_data['units'] != substr($dimension_data['height'], -2) ){
			$new_dimenstion['height'] = $dimension_data['height'].$dimension_data['units'];
		}else{
			$new_dimenstion['height'] = $dimension_data['height'];
		}
	}
	
	if( isset($dimension_data['width']) && $dimension_data['width'] != '' ){
		
		if( $dimension_data['units'] != substr($dimension_data['width'], -2) ){
			$new_dimenstion['width'] = $dimension_data['width'].$dimension_data['units'];
		}else{
			$new_dimenstion['width'] = $dimension_data['width'];
		}
	}
	
	if( empty($new_dimenstion) ) return false;
	
	return $new_dimenstion;
}