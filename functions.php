<?php
/**
 * CiyaShop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CiyaShop
 */

ciyashop_globals_n_constants();
function ciyashop_globals_n_constants(){
	
	// Globals
	global $ciyashop_globals, $ciyashop_theme_data;
	
	$ciyashop_globals = array();
	
	$ciyashop_theme_data = wp_get_theme( get_template() );
	
	$ciyashop_globals['theme_title'] = $ciyashop_theme_data->get('Name');
	$ciyashop_globals['theme_slug']  = sanitize_title($ciyashop_theme_data->get('Name'));
	$ciyashop_globals['theme_name']  = str_replace('-', '_', sanitize_title($ciyashop_theme_data->get('Name')));
	$ciyashop_globals['theme_option']= $ciyashop_globals['theme_name'].'_options';
	
	// Backwards compatibility for __DIR__
	if ( !defined('__DIR__') ) define('__DIR__', dirname(__FILE__));
}

if ( ! function_exists( 'ciyashop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ciyashop_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on CiyaShop, use a find and replace
	 * to change 'ciyashop' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ciyashop', get_parent_theme_file_path('/languages'));

	// Add PGS Core support
	add_theme_support( 'pgs-core' );
	
	add_theme_support( 'pgs-welcome' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );    
	set_post_thumbnail_size( 150, 150 );
	
	// Custom Thumbnail Sizes
	add_image_size( 'ciyashop-logo-carousel', 200, 90, true );         // (cropped)
	add_image_size( 'ciyashop-latest-post-thumbnail', 330, 460, true );// (cropped)
	add_image_size( 'ciyashop-latest-post-thumbnail2', 500, 375, true );// (cropped)	
	add_image_size( 'ciyashop-team-member-thumbnail-v', 448, 834, true );
	add_image_size( 'ciyashop-kite-box-thumbnail', 700, 700, true );
	add_image_size( 'ciyashop-blog-thumb', 1170, 500, true );
	add_image_size( 'ciyashop-recent-post', 450, 450, true );
	add_image_size( 'ciyashop-product-180x230', 180, 230, true );
	add_image_size( 'ciyashop-brand-logo', 150, 50, false );
	
	// Support for post formats
	add_theme_support( 'post-formats', array(
		'aside',  // title less blurb
		'gallery',// gallery of images
		'link',   // quick link to other site
		'image',  // an image
		'quote',  // a quick quote
		'status', // a Facebook like status update
		'video',  // video
		'audio',  // audio
		'chat',   // chat transcript
	) );
    
    // This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'          => esc_html__( 'Primary Menu', 'ciyashop' ),
		'categories_menu'  => esc_html__( 'Categories Menu', 'ciyashop' ),
		'top_menu'         => esc_html__( 'Topbar Menu', 'ciyashop' ),
		'footer_menu'      => esc_html__( 'Footer Menu', 'ciyashop' ),
		'shortcode_v_menu' => esc_html__( 'Shortcode - Vertical Menu', 'ciyashop' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	// Declare WooCommerce support.
	add_theme_support( 'woocommerce', apply_filters( 'storefront_woocommerce_args', array(
		'single_image_width'    => 600,
		'thumbnail_image_width' => 510,
		'product_grid'          => array(
			'default_columns' => 3,
			'default_rows'    => 4,
			'min_columns'     => 1,
			'max_columns'     => 6,
			'min_rows'        => 1
		)
	) ) );
	
	// Add Woocommerce theme support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-lightbox' ); // Enable Popup
	
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	add_action( 'widgets_init', 'ciyashop_sidebars_init' );
	
	/* Remove WooCommerce OutPut Content Wrapper*/
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	
	// adding the search form
	add_filter( 'get_search_form', 'ciyashop_wpsearch' );
	
	// Custom Post Supports
	add_theme_support( 'pgs_faqs' );
	add_theme_support( 'pgs_testimonials' );
	add_theme_support( 'pgs_teams' );
	
	// Add theme support for shortcodes
	$shortcodes = apply_filters( 'ciyashop_supported_shortcodes', array(
		'pgscore_address_block',
		'pgscore_opening_hours',
		'pgscore_banner',
		'pgscore_clients',
		'pgscore_elements',
		'pgscore_image_slider',
		'pgscore_info_box',
		'pgscore_instagram_v2',
		'pgscore_list',
		'pgscore_newsletter',
		'pgscore_recent_posts',
		'pgscore_social_icons',
		'pgscore_team_members',
		'pgscore_testimonials',
		'pgscore_vertical_menu',
		'pgscore_kite_box',
	) );
	
	// Sort shortcodes
	asort($shortcodes);
	
	add_theme_support( 'pgscore_shortcodes', $shortcodes );
	
	// Add theme support for Massive Addons
	add_theme_support( 'massive-addons' );
}
endif;
add_action( 'after_setup_theme', 'ciyashop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ciyashop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ciyashop_content_width', 640 );
}
add_action( 'after_setup_theme', 'ciyashop_content_width', 0 );

/**
 * Search Form
	*
 * Call using get_search_form().
	*
 * @package CiyaShop
 */
function ciyashop_wpsearch( $form ) {
	ob_start();
	get_template_part( 'template-parts/search-form' );
	$form = ob_get_clean();
	return $form;
}

require_once get_parent_theme_file_path('/includes/base_functions.php');                // Load Base functions file

// Includes for Admin & Front
require_once get_parent_theme_file_path('/includes/sidebars.php');
require_once get_parent_theme_file_path('/includes/widgets.php');
require_once get_parent_theme_file_path('/includes/menus.php');
require_once get_parent_theme_file_path('/includes/icons/icons.php');
require_once get_parent_theme_file_path('/includes/acf/acf.php');
require_once get_parent_theme_file_path('/includes/cpt.php');
require_once get_parent_theme_file_path('/includes/external-lib-fix.php');
require_once get_parent_theme_file_path('/includes/redux/redux-init.php');
require_once get_parent_theme_file_path('/includes/scripts_and_styles.php');
require_once get_parent_theme_file_path('/includes/jetpack.php');                      // Load Jetpack compatibility file.
require_once get_parent_theme_file_path('/includes/customizer.php');                   // Customizer additions.
require_once get_parent_theme_file_path('/includes/extras.php');                       // Custom functions that act independently of the theme templates.
require_once get_parent_theme_file_path('/includes/vc/vc-fallback-functions.php');     // Fallback for vc based functions
require_once get_parent_theme_file_path('/includes/welcome/welcome.php');              // Welcome Panel

// Extend VC
global $vc_manager;
if ( $vc_manager ) {
	require_once get_parent_theme_file_path('/includes/vc/vc-init-admin.php');
	require_once get_parent_theme_file_path('/includes/vc/vc-init.php');
}

// Includes for Admin
if ( is_admin() ) {
	require_once get_parent_theme_file_path('/includes/tgm-plugin-activation/tgm-init.php');// Load TGM Plugin compatibility file.
	require_once get_parent_theme_file_path('/includes/sample-data.php');
	require_once get_parent_theme_file_path('/includes/theme-setup-wizard/wizard.php');
}

// Includes for Front
require_once get_parent_theme_file_path('/includes/template-functions.php');
require_once get_parent_theme_file_path('/includes/template-hooks.php');
require_once get_parent_theme_file_path('/includes/template-tags.php');                 	// Custom template tags for this theme.
require_once get_parent_theme_file_path('/includes/template-classes.php');
require_once get_parent_theme_file_path('/includes/comments.php');
require_once get_parent_theme_file_path('/includes/maintenance.php');
require_once get_parent_theme_file_path('/includes/acf_ported_functions.php');
require_once get_parent_theme_file_path('/includes/dynamic_css.php');                   	// Dynamic CSS


// Includes for WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_parent_theme_file_path('/includes/woocommerce/init.php');
	
	if ( !is_admin() ) {
		require_once get_parent_theme_file_path('/includes/woocommerce/init-front.php');
	}
}

