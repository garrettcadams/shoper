<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define('CIYASHOP_PRODUCT_KEY', 'c097cb30fd31dc506445323601d9c14c');

if( ! defined( 'PGS_ENVATO_API' ) ) define( 'PGS_ENVATO_API', 'http://envatoapi.potenzaglobalsolutions.com/' );

if( !class_exists('Ciyashop_Theme_Activation') ){
	class Ciyashop_Theme_Activation{
		public static $_instance = NULL;
		public function __construct() {
			do_action( 'ciyashop_theme_class_loaded' );
            $this-> init();
		}

		public static function init() {		
			add_action( 'init', array( __CLASS__, 'ciyashop_set_theme_credentials' ) );
		}
		
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public static function ciyashop_set_theme_credentials() {
			if(isset($_POST['ciyashop_verify_theme']) && isset($_POST['ciyashop_activation_nonce'])) {
				if(isset($_POST['ciyashop_verify_theme']['purchase_key']) && wp_verify_nonce( $_POST['ciyashop_activation_nonce'], 'ciyashop_activation-verify-token' )) {
					
					// If empty key supplied
					if( empty($_POST['ciyashop_verify_theme']['purchase_key']) ){
						delete_option('ciyashop_pgs_token');  // update pgs_token
						delete_site_transient('ciyashop_auth_msg');
						delete_option('ciyashop_theme_purchase_key'); // update purchase_key
						return;
					} else {
						$product_purchase_key = sanitize_text_field($_POST['ciyashop_verify_theme']['purchase_key']);
						$args = array(
							'product_key'   => CIYASHOP_PRODUCT_KEY,
							'purchase_key'  => $product_purchase_key,
							'site_url' 		=> get_site_url(),
							'action'		=> 'register'
						);
						
						$url = add_query_arg( $args, trailingslashit(PGS_ENVATO_API) . 'verifyproduct');
						$response = wp_remote_get( $url, array( 'timeout' => 2000 ) );
						
						if( is_wp_error($response) ){
							set_site_transient('ciyashop_auth_notice', esc_html__('There was an error processing your request, please try again later!','ciyashop') );
							delete_site_transient('ciyashop_auth_msg');
							return false;
						}
						
						$response_code = wp_remote_retrieve_response_code( $response );
						$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
						
						if ( $response_code == '200' ) {
							if($response_body['status'] == 1){
								set_site_transient('ciyashop_auth_msg', $response_body['message'] );
								delete_site_transient('ciyashop_auth_notice');
								update_option('ciyashop_pgs_token', $response_body['pgs_token']);
								update_option('ciyashop_theme_purchase_key', $product_purchase_key);
								return $response_body['pgs_token'];
							}
							
							if($response_body['status'] != 429){
								delete_option('ciyashop_pgs_token');
								update_option('ciyashop_theme_purchase_key', $product_purchase_key);
							}
							set_site_transient('ciyashop_auth_notice', $response_body['message'] );
							delete_site_transient('ciyashop_auth_msg');
							return false;
						}
						else {
							delete_site_transient('ciyashop_auth_msg');
							set_site_transient('ciyashop_auth_notice', $response_body['message'] );
							return false;
						}
					}
				}
			}
		}
		
		public static function ciyashop_verify_theme() {
			$pgs_token = get_option('ciyashop_pgs_token');
			if( $pgs_token && !empty($pgs_token)){
				return $pgs_token;
			}
			return false;
		}
	}
}
Ciyashop_Theme_Activation::instance();
?>