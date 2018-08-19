<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
require_once get_parent_theme_file_path('/includes/tgm-plugin-activation/core/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'ciyashop_register_required_plugins' );

/*
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
function ciyashop_tgmpa_plugin_list(){

	return apply_filters( 'tgmpa_plugin_list', array(
		array(
			'name'              => esc_html__( 'PGS Core', 'ciyashop' ),
			'slug'              => 'pgs-core',
			'source'            => get_parent_theme_file_path('/includes/plugins/pgs-core.zip'),
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '2.1.0',
			'details_url'       => '',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'PGS QRCode', 'ciyashop' ),
			'slug'              => 'pgs-qrcode',
			'source'            => get_parent_theme_file_path('/includes/plugins/pgs-qrcode.zip'),
			'required'          => false,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '1.0.0',
			'details_url'       => '',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Visual Composer', 'ciyashop' ),
			'slug'              => 'js_composer',
			'source'            => get_parent_theme_file_path('/includes/plugins/js_composer.zip'),
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.5.2',
			'details_url'       => 'https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Massive Addons for Visual Composer', 'ciyashop' ),
			'slug'              => 'mpc-massive',
			'source'            => get_parent_theme_file_path('/includes/plugins/mpc-massive.zip'),
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '2.3.3',
			'details_url'       => 'https://codecanyon.net/item/massive-addons-for-visual-composer/14429839',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Slider Revolution', 'ciyashop' ),
			'slug'              => 'revslider',
			'source'            => get_parent_theme_file_path('/includes/plugins/revslider.zip'),
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.4.8',
			'details_url'       => 'https://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'WooCommerce Amazon Affiliates - Wordpress Plugin', 'ciyashop' ),
			'slug'              => 'woozone',
			'source'            => get_parent_theme_file_path('/includes/plugins/woozone.zip'),
			'required'          => false,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '10.1.1',
			'details_url'       => 'https://codecanyon.net/item/woocommerce-amazon-affiliates-wordpress-plugin/3057503',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Redux Framework', 'ciyashop' ),
			'slug'              => 'redux-framework',
			'required'          => true,
			'details_url'       => 'https://wordpress.org/plugins/redux-framework/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Advanced Custom Fields PRO', 'ciyashop' ),
			'slug'              => 'advanced-custom-fields-pro',
			'source'            => get_parent_theme_file_path('/includes/plugins/advanced-custom-fields-pro.zip'),
			'required'          => true,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '5.7.1',
			'details_url'       => 'https://www.advancedcustomfields.com/pro/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Smart Product Viewer - 360&deg; Animation', 'ciyashop' ),
			'slug'              => 'smart-product-viewer',
			'source'            => get_parent_theme_file_path('/includes/plugins/smart-product-viewer.zip'),
			'required'          => false,
			'force_activation'  => false,
			'force_deactivation'=> false,
			'version'           => '1.5.1',
			'details_url'       => 'https://codecanyon.net/item/smart-product-viewer-360-animation-plugin/6277697',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Breadcrumb NavXT', 'ciyashop' ),
			'slug'              => 'breadcrumb-navxt',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/breadcrumb-navxt/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Contact Form 7', 'ciyashop' ),
			'slug'              => 'contact-form-7',
			'required'          => true,
			'details_url'       => 'https://wordpress.org/plugins/contact-form-7/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'MailChimp for WordPress', 'ciyashop' ),
			'slug'              => 'mailchimp-for-wp',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/breadcrumb-navxt/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Max Mega Menu', 'ciyashop' ),
			'slug'              => 'megamenu',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/megamenu/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'WooCommerce', 'ciyashop' ),
			'slug'              => 'woocommerce',
			'required'          => true,
			'details_url'       => 'https://wordpress.org/plugins/woocommerce/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'YITH WooCommerce Compare', 'ciyashop' ),
			'slug'              => 'yith-woocommerce-compare',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/yith-woocommerce-compare/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'YITH WooCommerce Wishlist', 'ciyashop' ),
			'slug'              => 'yith-woocommerce-wishlist',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/yith-woocommerce-wishlist/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'WooCommerce Currency Switcher', 'ciyashop' ),
			'slug'              => 'woocommerce-currency-switcher',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/woocommerce-currency-switcher/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Instagram Shop by Snapppt', 'ciyashop' ),
			'slug'              => 'shop-feed-for-instagram-by-snapppt',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/shop-feed-for-instagram-by-snapppt/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'YITH WooCommerce Brands Add-on', 'ciyashop' ),
			'slug'              => 'yith-woocommerce-brands-add-on',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/yith-woocommerce-brands-add-on/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Store Locator WordPress', 'ciyashop' ),
			'slug'              => 'agile-store-locator',
			'required'          => false,
			'details_url'       => 'https://wordpress.org/plugins/agile-store-locator/',
			'checked_in_wizard' => false,
		),
		array(
			'name'              => esc_html__( 'Envato Market', 'ciyashop' ),
			'slug'              => 'envato-market',
			'source'            => get_parent_theme_file_path('/includes/plugins/envato-market.zip'),
			'required'          => false,
			'version'           => '2.0.0',
			'details_url'       => 'https://envato.com/market-plugin/',
			'checked_in_wizard' => false,
		),
		
	));
}

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function ciyashop_register_required_plugins() {
	$plugins = ciyashop_tgmpa_plugin_list();

	$tgmpa_id = 'ciyashop'.'_recommended_plugins';

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => $tgmpa_id,           // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                  // Default absolute path to bundled plugins.
		'menu'         => 'theme-plugins',     // Menu slug.
		'parent_slug'  => 'themes.php',        // Parent menu slug.
		'capability'   => 'edit_theme_options',// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                // Show admin notices or not.
		'dismissable'  => true,                // If false, a user cannot dismiss the nag message.
		'is_automatic' => false,               // Automatically activate plugins after installation or not.
	);

	tgmpa( $plugins, $config );
}

/*
 * ciyashop_tgmpa_stat()
 * Returns plugin activation status
 */
function ciyashop_tgmpa_setup_status(){
	
	$pluginy = ciyashop_tgmpa_plugins_data();
	
	$ciyashop_tgmpa_plugins_data_all = $pluginy['all'];
	foreach( $ciyashop_tgmpa_plugins_data_all as $ciyashop_tgmpa_plugins_data_k => $ciyashop_tgmpa_plugins_data_v ){
		if( !$ciyashop_tgmpa_plugins_data_v['required'] ){
			unset($ciyashop_tgmpa_plugins_data_all[$ciyashop_tgmpa_plugins_data_k]);
		}
	}
	
	if( count($ciyashop_tgmpa_plugins_data_all) > 0 ){
		return false;
	}else{
		return true;
	}
}

/*
 * ciyashop_tgmpa_plugins_data()
 * Returns plugin activation list
 */
function ciyashop_tgmpa_plugins_data(){
	$plugins = ciyashop_tgmpa_plugin_list();
	
	$tgmpax = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	foreach ( $plugins as $plugin ) {
		call_user_func( array( $tgmpax, 'register' ), $plugin );
	}
	$pluginx = $tgmpax->plugins;
	
	$pluginy = array(
		'all'      => array(), // Meaning: all plugins which still have open actions.
		'install'  => array(),
		'update'   => array(),
		'activate' => array(),
	);

	foreach ( $tgmpax->plugins as $slug => $plugin ) {
		if ( $tgmpax->is_plugin_active( $slug ) && false === $tgmpax->does_plugin_have_update( $slug ) ) {
			// No need to display plugins if they are installed, up-to-date and active.
			continue;
		} else {
			$pluginy['all'][ $slug ] = $plugin;

			if ( ! $tgmpax->is_plugin_installed( $slug ) ) {
				$pluginy['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $tgmpax->does_plugin_have_update( $slug ) ) {
					$pluginy['update'][ $slug ] = $plugin;
				}

				if ( $tgmpax->can_plugin_activate( $slug ) ) {
					$pluginy['activate'][ $slug ] = $plugin;
				}
			}
		}
	}
	return $pluginy;
}