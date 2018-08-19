<?php
add_action( 'woocommerce_before_single_product', 'ciyashop_woocommerce_init_loop' );
function ciyashop_woocommerce_init_loop(){
	global $ciyashop_options;
}

/********************************************************************
 *
 * Products Loop Customization
 *
 ********************************************************************/
function ciyashop_products_loop_classes( $classes = array() ){
	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}

	$classes[] = 'products-loop';
	$classes[] = 'row';

	if( is_product() ){
		$classes[] = 'owl-carousel';
	}else{
		$column = ciyashop_loop_columns();
		$classes[] = 'products-loop-column-'.$column;

		$gridlist_view = isset($_COOKIE['gridlist_view']) ? sanitize_text_field( wp_unslash( $_COOKIE['gridlist_view'] ) ) : 'grid';
		$classes[] = $gridlist_view;
	}

	$classes = apply_filters( 'ciyashop_products_loop_classes', $classes );
	$classes = ciyashop_class_builder( $classes );

	return $classes;
}

/********************************************************************
 *
 * Add link to product title
 *
 ********************************************************************/
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
add_filter( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_title', 9 );
function ciyashop_woocommerce_shop_loop_item_title(){
	global $product;
	?>
	<h3 class="product-name">
		<a href="<?php echo esc_url(get_the_permalink(get_the_ID()));?>">
			<?php echo esc_html(get_the_title(get_the_ID()));?>
		</a>
	</h3><!-- .product-name-->
	<?php
}


/********************************************************************
 *
 * Remove product link default callback
 *
 ********************************************************************/
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/********************************************************************
 *
 * Extra wrappers to product loop.
 *
 ********************************************************************/
add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_add_innerdiv_start', 5 );                // .product-inner opening
add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_add_innerdiv_end', 20);                   // .product-inner closing

add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_start', 6 );           // .product-thumbnail opening
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_end', 19 );      // .product-thumbnail closing

add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_start', 7 );     // .product-thumbnail-inner opening
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_end', 16 );// .product-thumbnail-inner closing

add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_title_product_info_open', 5 );            // .product-info opening
add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_woocommerce_after_shop_loop_item_product_info_close', 20);         // .product-info closing

function ciyashop_wc_before_shop_loop_item_add_innerdiv_start(){
	?>
	<div class="product-inner">
	<?php
}
function ciyashop_wc_before_shop_loop_item_add_innerdiv_end(){
	?>
	</div><!-- .product-inner -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_start(){
	?>
	<div class="product-thumbnail">
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_end(){
	?>
	</div><!-- .product-thumbnail -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_start(){
	?>
	<div class="product-thumbnail-inner">
		<a href="<?php echo esc_url( get_permalink() )?>" rel="bookmark">
		<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_end(){
		?>
		</a>
	</div><!-- .product-thumbnail-inner -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_title_product_info_open(){
	?>
	<div class="product-info">
	<?php
}

function ciyashop_woocommerce_after_shop_loop_item_product_info_close(){
	?>
	</div><!-- .product-info -->
	<?php
}

/********************************************************************
 *
 * Apply filter on woocommerce before loop item title
 *
 ********************************************************************/
add_action( 'woocommerce_shortcode_before_products_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_before_shop_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_after_single_product_summary', 'ciyashop_shop_loop_item_hover_style_init', 0 );
add_action( 'dokan_store_profile_frame_after', 'ciyashop_shop_loop_item_hover_style_init'  );

function ciyashop_shop_loop_item_hover_style_init( $template_name ){

	global $ciyashop_options;

	$product_hover_style = ciyashop_product_hover_style();

	if( in_array( $product_hover_style, array('default','image-center', 'image-left', 'image-bottom', 'image-bottom-bar') ) ){
		add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_actions', 18 );
		add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_product_actions', 5 );
	}elseif( in_array( $product_hover_style, array('info-bottom','info-bottom-bar') ) ){
		add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_product_actions', 5 );
	}

	// Show Hide Sale
	add_filter( 'woocommerce_sale_flash', 'ciyashop_sale_flash_label', 10, 3 );

	// Show Hide Featured
	add_filter( 'ciyashop_featured', 'ciyashop_featured_label', 10, 3 );

	add_filter( 'post_class', 'ciyashop_product_classes' );
}

function ciyashop_product_actions(){
	/**
	 * ciyashop_before_product_actions hook.
	 *
	 * @hooked ciyashop_product_actions_wrapper_open - 10
	 */
	do_action( 'ciyashop_before_product_actions' );

	/**
	 * ciyashop_product_actions hook.
	 *
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 * @hooked ciyashop_product_actions_add_wishlist_link - 20
	 * @hooked add_compare_link - 30
	 */
	do_action( 'ciyashop_product_actions' );

	/**
	 * ciyashop_after_product_actions hook.
	 *
	 * @hooked ciyashop_product_actions_wrapper_close - 10
	 */
	do_action( 'ciyashop_after_product_actions' );
}

add_action( 'ciyashop_before_product_actions', 'ciyashop_product_actions_wrapper_open' );
function ciyashop_product_actions_wrapper_open(){
	global $ciyashop_options;
	
	?>
	<div class="product-actions">
	<?php
	if( isset( $ciyashop_options['product_hover_style'] ) && $ciyashop_options['product_hover_style'] == 'default' ) {
		?>
		<div class="product-actions-inner">
		<?php
	}
}

add_action( 'ciyashop_after_product_actions', 'ciyashop_product_actions_wrapper_close' );
function ciyashop_product_actions_wrapper_close(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_style'] ) && $ciyashop_options['product_hover_style'] == 'default') {
		?>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}

/********************************************************************
 *
 * Add product style class
 *
 ********************************************************************/
function ciyashop_product_classes( $classes ) {
	global $post, $ciyashop_options;
	
	// Set Product Hover Style Class
	$product_hover_style = ciyashop_product_hover_style();
	$classes[] = 'product-hover-style-'.$product_hover_style;

	// Set Product Hover Button Shape Class
	if( in_array( $product_hover_style, array('image-center', 'image-left', 'image-bottom', 'info-bottom') ) ){
		$product_hover_button_shape = ciyashop_product_hover_button_shape();
		$classes[] = 'product-hover-button-shape-'.$product_hover_button_shape;
	}

	// Set Product Hover Button Style Class
	if( in_array( $product_hover_style, array('image-center', 'image-left', 'image-bottom') ) ){
		$product_hover_button_style = ciyashop_product_hover_button_style();
		$classes[] = 'product-hover-button-style-'.$product_hover_button_style;
	}
	
	// Set Product Hover style class for default style
	if( $product_hover_style == 'default' ){
		$product_hover_default_button_style = ciyashop_product_hover_default_button_style();
		$classes[] = 'product-hover-button-style-'.$product_hover_default_button_style;
	}

	// Set Product Hover Bar Style Class
	if( in_array( $product_hover_style, array('image-bottom-bar', 'info-bottom-bar') ) ){
		$product_hover_bar_style = ciyashop_product_hover_bar_style();
		$classes[] = 'product-hover-bar-style-'.$product_hover_bar_style;
	}

	// Set Product Hover Bar Style Class
	if( in_array( $product_hover_style, array('image-bottom-bar', 'info-bottom', 'info-bottom-bar') ) ){
		$product_hover_add_to_cart_position = ciyashop_product_hover_add_to_cart_position();
		$classes[] = 'product-hover-act-position-'.$product_hover_add_to_cart_position;
	}
	
	// Product Title length
	if( isset($ciyashop_options['product_title_length']) && !empty($ciyashop_options['product_title_length']) ){
		$classes[] = 'product_title_type-'.$ciyashop_options['product_title_length'];
	}
	
	$icon_type = isset($ciyashop_options['product_hover_icon_type']) && !empty($ciyashop_options['product_hover_icon_type']) ? $ciyashop_options['product_hover_icon_type'] : 'fill-icon';

	$classes[] = 'product_icon_type-'.$icon_type;

	$classes = apply_filters( 'ciyashop_product_classes', $classes, $post );

	return $classes;
}

/********************************************************************
 *
 * Remove woocommerce rating for chnage position
 * Add woocommerce rating to new position
 *
 ********************************************************************/
add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_wc_shop_loop_item_rating', 10 );
function ciyashop_wc_shop_loop_item_rating(){
	global $product;
	$rating_count = $product->get_rating_count();

	if( $rating_count <= 0 ) return;
	?>
	<div class="star-rating-wrapper">
		<?php

		/**
		 * ciyashop_loop_item_rating hook.
		 *
		 * @hooked woocommerce_template_loop_rating - 10
		 */
		do_action( 'ciyashop_loop_item_rating' );
		?>
	</div><!-- .star-rating-wrapper -->
	<?php
}
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'ciyashop_loop_item_rating', 'woocommerce_template_loop_rating' );

/********************************************************************
 *
 * Out of Stock
 *
 ********************************************************************/
if( ! function_exists('ciyashop_product_availability') ) {
	function ciyashop_product_availability() {
		global $ciyashop_options;

		if( is_shop() && ! $ciyashop_options['product-out-of-stock-icon'] ) return;

		global $product;

		if( is_shop() || !$product->is_in_stock()){
			echo wc_get_stock_html( $product );
		}

	}
}
add_action( 'woocommerce_before_shop_loop_item_title','ciyashop_product_availability', 10 );
add_action( 'ciyashop_before_product_actions', 'ciyashop_product_availability', 5 );

/********************************************************************
 *
 * Catalog Mode
 *
 ********************************************************************/
add_action( 'wp_head', 'ciyashop_woocommerce_catalog_mode' );
function ciyashop_woocommerce_catalog_mode(){

	if ( class_exists( 'WooCommerce' ) ) {
		global $ciyashop_options;

		if(isset($ciyashop_options['woocommerce_catalog_mode']) && $ciyashop_options['woocommerce_catalog_mode']==1){
			remove_action( 'ciyashop_product_actions', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
		}
	}
}

/* * ******************************************************************
 *
 * Hide Price
 *
 * ****************************************************************** */
add_filter('woocommerce_get_price_html', 'ciyashop_hide_price', 99, 2);

if (!function_exists('ciya_sh0op_hide_price')) {

    function ciyashop_hide_price($price, $product) {
        global $ciyashop_options;
        if (isset($ciyashop_options['woocommerce_catalog_mode']) && $ciyashop_options['woocommerce_catalog_mode'] == 1) {
            if (isset($ciyashop_options['woocommerce_price_hide']) && $ciyashop_options['woocommerce_price_hide'] == 1) {
                $price = '';
            }
        }
        return $price;
    }

}

// Set products per page.
add_filter('loop_shop_per_page','ciya_chop_woocommerce_loop_shop_per_page');
function ciya_chop_woocommerce_loop_shop_per_page($posts_per_page){
	global $ciyashop_options;
	if( isset($ciyashop_options['products_per_page']) && $ciyashop_options['products_per_page']!='' ){
		$posts_per_page = $ciyashop_options['products_per_page'];
	}
	return $posts_per_page;
}

/********************************************************************
 *
 * Others
 *
 ********************************************************************/
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);


/**
 * Change the placeholder image
 */
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
function custom_woocommerce_placeholder_img_src( $src ) {

	// replace with path to your image
	$src = get_parent_theme_file_uri('/images/product-placeholder.jpg');

	return $src;
}

/********************************************************************
 *
 * Remove woocommerce price for change position
 * Add woocommerce price to new position
 *
 ********************************************************************/

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 8 );