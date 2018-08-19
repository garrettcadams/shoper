<?php
require_once get_parent_theme_file_path('/includes/woocommerce/wc-functions.php');
require_once get_parent_theme_file_path('/includes/woocommerce/quick-view.php');

add_filter( 'ciyashop_supported_shortcodes', 'ciyashop_add_woocommerce_supported_shortcodes' );
function ciyashop_add_woocommerce_supported_shortcodes( $shortcodes ){
	
	if ( class_exists( 'WooCommerce' ) ) {
		$shortcodes = array_merge( $shortcodes, array(
			'pgscore_categorybox',
			'pgscore_single_product_slider',
			'pgscore_product_deal',
			'pgscore_product_deals',
			'pgscore_multi_tab_products_listing',
			'pgscore_products_listing',
			'pgscore_product_showcase',
		) );
	}
	
	return $shortcodes;
}

/********************************************************************
 * 
 * Ajax
 * 
 ********************************************************************/
function ciyashop_quick_view(){
	if( isset($_GET['id']) ) {
		$id = (int) $_GET['id'];
	}
	if( ! $id ) {
		return;
	}

	global $post, $ciyashop_options;

	$args = array( 'post__in' => array($id), 'post_type' => 'product' );

	$quick_posts = get_posts( $args );

	$quick_view_variable = $ciyashop_options['quick_view'];

	foreach( $quick_posts as $post ) :
		setup_postdata($post);
		remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
		
		if( !$ciyashop_options['quick_view_product_name'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		}
		if( $ciyashop_options['quick_view_product_name'] && $ciyashop_options['quick_view_product_link'] ){
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			add_action( 'woocommerce_single_product_summary', 'ciyashop_woocommerce_template_single_title', 5 );
		}
		if(!$ciyashop_options['quick_view_product_categories'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 29 );
		}
		if(!$ciyashop_options['quick_view_product_price'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		}
		if(!$ciyashop_options['quick_view_product_star_rating'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}
		if(!$ciyashop_options['quick_view_product_short_description'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}
		if(!$ciyashop_options['quick_view_product_add_to_cart'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}
		if(!$ciyashop_options['quick_view_product_share_icon'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		}
		// Disable add to cart button for catalog mode
		if( $ciyashop_options['woocommerce_catalog_mode'] ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		} elseif( ! $quick_view_variable ) {
			// If no needs to show variations
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
		}
		
		remove_action( 'woocommerce_single_product_summary', 'ciyashop_product_sale_countdown', 41 );
		remove_action( 'woocommerce_after_shop_loop_item', 'ciyashop_product_sale_countdown', 25 );
		
		get_template_part('woocommerce/content', 'quick-view');
	endforeach;

	wp_reset_postdata();

	die();
}

add_action( 'wp_ajax_ciyashop_quick_view', 'ciyashop_quick_view' );
add_action( 'wp_ajax_nopriv_ciyashop_quick_view', 'ciyashop_quick_view' );

/**********************************************************
 * 
 * Product Share
 * 
 **********************************************************/
add_action( 'woocommerce_share', 'ciyashop_woocommerce_share', 10, 0 );


/**********************************************************
 * 
 * Single Product Share
 * 
 **********************************************************/
function ciyashop_woocommerce_share() {
	global $product, $ciyashop_options;
	
	if( !$ciyashop_options['product-share-buttons'] ){
		return;
	}
	?>
	<div class="share-wrapper social-profiles">
		<span class="share-label"><?php esc_html_e('Share :', 'ciyashop' );?></span>
		<ul class="share-links">
			<?php
			$social_shares = array(
				'facebook' => array(
					'class'     => 'facebook',
					'icon_class'=> 'fa fa-facebook',
				),
				'twitter' => array(
					'class'     => 'twitter',
					'icon_class'=> 'fa fa-twitter',
				),
				'linkedin' => array(
					'class'     => 'linkedin',
					'icon_class'=> 'fa fa-linkedin',
				),
				'google_plus' => array(
					'class'     => 'googleplus',
					'icon_class'=> 'fa fa-google-plus',
				),
				'pinterest' => array(
					'class'     => 'pinterest',
					'icon_class'=> 'fa fa-pinterest',
				),
			);
			
			foreach( $social_shares as $social_share_k => $social_share_d ){
				$social_share_stat   = isset($ciyashop_options[$social_share_k.'_share']) ? $ciyashop_options[$social_share_k.'_share'] : 1;
				if( $social_share_stat ){
					?>
					<li>
						<?php
						if( $social_share_k == 'pinterest' ){
							?>
							<a href="#" class="share-link <?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr(get_the_title());?>" data-url="<?php echo esc_url(get_permalink());?>" data-image="<?php echo esc_url(ciyashop_logo_url());?>">
								<i class="<?php echo esc_attr($social_share_d['icon_class']);?>"></i>
							</a>
							<?php
						}else{
							?>
							<a href="#" class="share-link <?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr(get_the_title());?>" data-url="<?php echo esc_url(get_permalink());?>">
								<i class="<?php echo esc_attr($social_share_d['icon_class']);?>"></i>
							</a>
							<?php
						}
						?>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</div>
	<?php
}

/* Set the registration info text on woocommerce register page */
add_action('woocommerce_register_form_start','ciyashop_register_form_start');
function ciyashop_register_form_start(){
	global $ciyashop_options;
	
	if($ciyashop_options['enable_registration_text'] && $ciyashop_options['registration_text']!=''){
		?>
		<div class="woo-registration-info">
		<?php echo do_shortcode($ciyashop_options['registration_text']); ?>
		</div>
		<?php
	}
}