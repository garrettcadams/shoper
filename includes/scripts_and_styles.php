<?php
/**
 * Register Google fonts for CiyaShop.
 * */
function ciyashop_google_fonts_url() {

	$fonts_url        = '';
	$fonts            = array();
	$font_args        = array();
	$base_url         =  "//fonts.googleapis.com/css";

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'ciyashop' ) ) {
		$fonts['family']['Montserrat'] = 'Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,900';
	}
	
	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'ciyashop' ) ) {
		$fonts['family']['Lato'] = 'Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic';
	}
	
	$fonts['subsets'] = 'devanagari,latin-ext';
	
	$fonts = apply_filters( 'ciyashop_google_fonts', $fonts );

	/* Prepapre URL if font family defined. */
	if( !empty( $fonts['family'] ) ){
		
		/* format family to string */
		if( is_array($fonts['family']) ){
			$fonts['family'] = implode( '|', $fonts['family'] );
		}
		
		$font_args['family'] = urlencode( trim( $fonts['family'] ) );
		
		if( !empty( $fonts['subsets'] ) ){
			
			/* format subsets to string */
			if( is_array( $fonts['subsets'] ) ){
				$fonts['subsets'] = implode( ',', $fonts['subsets'] );
			}
			
			$font_args['subsets'] = urlencode( trim( $fonts['subsets'] ) );
		}
		
		$fonts_url = add_query_arg( $font_args, $base_url );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 * */
function ciyashop_scripts( ) {

	global $ciyashop_options, $wp_styles;
	
	if( $wp_styles ){
		foreach($wp_styles->queue as $key => $value){
			if($value == 'pgscore-front' ){
				unset($wp_styles->queue[$key]);
			}
		}
	}

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	$color_customize_css = get_parent_theme_file_uri("/css/color_customize.css");
	if ( is_multisite() ) {
		global $blog_id;

		// Site CSS Path
		$color_customize_css_path = get_parent_theme_file_path("/css/blog/".$blog_id."-color_customize.css");

		// Check if site CSS exists
		if( file_exists( $color_customize_css_path ) ){
			$color_customize_css = get_parent_theme_file_uri("/css/blog/".$blog_id."-color_customize.css");
		}
	}

	$select2_css_src = get_parent_theme_file_uri('/css/select2/select2.min.css');
	$select2_js_src  = get_parent_theme_file_uri('/js/select2/select2'.$suffix.'.js');

	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, '2.7.0', ">=" ) ) {
			$select2_css_src = get_parent_theme_file_uri('/css/select2/select2.min.css');
			$select2_js_src  = get_parent_theme_file_uri('/js/select2/select2'.$suffix.'.js');
		}
	}

	//Stylesheets
	wp_enqueue_style( 'ciyashop-google-fonts'    , ciyashop_google_fonts_url() , array(), '' );                                       // Google Fonts

	if ( is_rtl() ) {
		wp_enqueue_style( 'bootstrap'                 , get_parent_theme_file_uri('/css/bootstrap-rtl.min.css') );
	}else{
		wp_enqueue_style( 'bootstrap'                 , get_parent_theme_file_uri('/css/bootstrap.min.css') );
	}

	wp_enqueue_style( 'select2'                   , $select2_css_src );
	wp_enqueue_style( 'jquery-ui'                 , get_parent_theme_file_uri('/css/jquery-ui/jquery-ui.min.css') );
	wp_enqueue_style( 'font-awesome'              , get_parent_theme_file_uri('/css/font-awesome.min.css') );
	wp_enqueue_style( 'owl-carousel'              , get_parent_theme_file_uri('/css/owl-carousel.min.css') );
	wp_enqueue_style( 'magnific-popup'            , get_parent_theme_file_uri('/css/magnific-popup/magnific-popup.css') );
	wp_enqueue_style( 'slick'                     , get_parent_theme_file_uri('/css/slick-slider/slick.css') );
	wp_enqueue_style( 'slick-theme'               , get_parent_theme_file_uri('/css/slick-slider/slick-theme.css') );
	wp_enqueue_style( 'slicknav'                  , get_parent_theme_file_uri('/css/slicknav/slicknav.min.css') );
	wp_enqueue_style( 'pgscore-front' );
	wp_enqueue_style( 'ciyashop-style'           , get_parent_theme_file_uri('/css/style.css') );
	wp_enqueue_style( 'ciyashop-responsive'      , get_parent_theme_file_uri('/css/responsive.css'), array('ciyashop-style') );
	wp_enqueue_style( 'ciyashop-color-customize' , $color_customize_css );                                                           // Color Customizer style

	//Scripts
	if ( is_rtl() ){
		wp_enqueue_script( 'bootstrap'               , get_parent_theme_file_uri('/js/bootstrap-rtl/bootstrap-rtl'.$suffix.'.js')                      , array('jquery')           , '', true );
	}else{
		wp_enqueue_script( 'bootstrap'               , get_parent_theme_file_uri('/js/bootstrap/bootstrap'.$suffix.'.js')                           , array('jquery')           , '', true );
	}
	
	if( $ciyashop_options['blog_layout'] == 'masonry' && ( is_home() || is_author() || is_category() || is_archive() || is_tag() || is_tax() || is_date() || is_day() || is_month() || is_year() ) ){
		wp_enqueue_script( 'masonry' );
	}

	wp_enqueue_script( 'owl-carousel'            , get_parent_theme_file_uri('/js/owl.carousel'.$suffix.'.js')                        , array()        , ''                  , true );
	wp_enqueue_script( 'select2'                 , $select2_js_src                                                                    , array()        , ''                  , true );
	wp_enqueue_script( 'jquery.countdown'        , get_parent_theme_file_uri('/js/jquery.countdown/jquery.countdown'.$suffix.'.js')   , array()        , ''                  , true );
	wp_enqueue_script( 'slick-min-js'            , get_parent_theme_file_uri('/js/slick-slider/slick'.$suffix.'.js')                  , array()        , ''                  , true );
	wp_enqueue_script( 'slicknav'                , get_parent_theme_file_uri('/js/slicknav/jquery.slicknav'.$suffix.'.js')            , array()        , ''                  , true );
	wp_enqueue_script( 'stickyjs'                , get_parent_theme_file_uri('/js/stickyjs/jquery.sticky'.$suffix.'.js')              , array('jquery'), ''                  , true );
	wp_enqueue_script( 'magnific-popup'          , get_parent_theme_file_uri('/js/magnific-popup/jquery.magnific-popup'.$suffix.'.js'), array('jquery'), ''                  , true );
	wp_enqueue_script( 'matchheight'             , get_parent_theme_file_uri('/js/matchheight/jquery.matchHeight'.$suffix.'.js')      , array('jquery'), ''                  , true );
	wp_enqueue_script( 'js-cookie'               , get_parent_theme_file_uri('/js/js-cookie/js.cookie'.$suffix.'.js')                 , array('jquery'), ''                  , true );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_register_script( 'ciyashop-main_js'      , get_parent_theme_file_uri('/js/main'.$suffix.'.js')                                 , array('jquery'), ''                  , true );

	if ( class_exists( 'WooCommerce' ) && is_product() ){
		wp_enqueue_script( 'ciyashop-single-product',        get_parent_theme_file_uri('/js/wc/ciyashop-single-product'.$suffix.'.js'),        array('jquery' , 'ciyashop-main_js'), '', true );
		wp_enqueue_script( 'ciyashop-add-to-cart-variation', get_parent_theme_file_uri('/js/wc/ciyashop-add-to-cart-variation'.$suffix.'.js'), array('jquery' , 'ciyashop-main_js'), '', true );
	}

	// Localize the script with new data
	$show_sticky_header = false;
	if( wp_is_mobile() ){
		if( ciyashop_sticky_header() && ciyashop_mobile_sticky_header() ){
			$show_sticky_header = true;
		}
	}else{
		if( ciyashop_sticky_header() ){
			$show_sticky_header = true;
		}
	}
	$ciyashop_l10n = array(
		'ajax_url'              => admin_url('admin-ajax.php'),
		'pgs_compare'           => esc_html__('Compare', 'ciyashop' ),
		'pgs_wishlist'          => esc_html__('Wishlist', 'ciyashop' ),
		'promopopup_hide_mobile'=> (isset($ciyashop_options['promo_popup_hide_mobile'])) ? esc_js($ciyashop_options['promo_popup_hide_mobile']) : '',
		'main_promopopup'       => (isset($ciyashop_options['promo_popup'])) ? esc_js($ciyashop_options['promo_popup']) : '',
		'sticky_header'         => ciyashop_sticky_header() ? 1 : 0,
		'sticky_header_mobile'  => ciyashop_mobile_sticky_header() ? 1 : 0,
		'device_type'           => wp_is_mobile() ? 'mobile' : 'desktop',
		'show_sticky_header'    => $show_sticky_header ? 1 : 0,
	);

	$ciyashop_l10n = apply_filters( 'ciyashop_l10n', $ciyashop_l10n );

	wp_localize_script( 'ciyashop-main_js', 'ciyashop_l10n', $ciyashop_l10n );

	// Enqueued script with localized data.
	wp_enqueue_script( 'ciyashop-main_js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Add custom CSS
	if(isset($ciyashop_options['custom_css'])){
		$custom_css = trim(strip_tags($ciyashop_options['custom_css']));
		if( !empty($custom_css) ){
			wp_add_inline_style( 'ciyashop-style', $custom_css );
		}
	}

	// Add custom Javascript
	if( isset($ciyashop_options['custom_js']) && !empty($ciyashop_options['custom_js']) ){
		$custom_js = trim(strip_tags($ciyashop_options['custom_js']));
		if( !empty($custom_js) ){
			wp_add_inline_script( 'ciyashop-main_js', $custom_js );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ciyashop_scripts' );

/*
 * Enqueue admin scripts and styles.
 */
function ciyashop_admin_enqueue_scripts( $hook ){

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Javascript
	wp_register_script( 'clipboard'         , get_parent_theme_file_uri('/js/clipboard/clipboard'.$suffix.'.js'), array('jquery'), '', true );
	wp_register_script( 'bootstrap'         , get_parent_theme_file_uri('/js/bootstrap/bootstrap.bundle'.$suffix.'.js'), array('jquery'), '', true );
	wp_register_script( 'ciyashop_admin_js', get_parent_theme_file_uri('/js/admin'.$suffix.'.js'), array('jquery', 'clipboard', 'bootstrap') );

	// Localize the script with new data
	$translation_array = array(
		'theme_options_url' => admin_url( 'themes.php?page=ciyashop-options' ),
	);
	wp_localize_script( 'ciyashop_admin_js', 'ciyashop_admin', $translation_array );

	wp_enqueue_script( 'ciyashop_admin_js' );


	// CSS
	wp_register_style( 'jquery-ui'            , get_parent_theme_file_uri('/css/jquery-ui/jquery-ui.min.css') );
	wp_register_style( 'font-awesome'         , get_parent_theme_file_uri('/css/font-awesome.min.css') );
	wp_register_style( 'cs-bootstrap'         , get_parent_theme_file_uri('/css/admin/cs-bootstrap.css') );
	wp_register_style( 'ciyashop-admin-style' , get_parent_theme_file_uri('/css/admin_style.css'), array('jquery-ui', 'cs-bootstrap', 'font-awesome') );

	wp_enqueue_style( 'ciyashop-admin-style' );
	if ( class_exists( 'WooCommerce' ) ) {
		$custom_css = '.redux-group-tab-link-li .el-shopping-cart:before {
	font-family: WooCommerce !important;
	content: "\e03d";
}';
		wp_add_inline_style( 'ciyashop-admin-style', $custom_css );
	}
}
add_action( 'admin_enqueue_scripts', 'ciyashop_admin_enqueue_scripts' );