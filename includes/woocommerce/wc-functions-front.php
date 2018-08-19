<?php
function ciyashop_product_tab_layout(){
	global $ciyashop_options;

	$product_tab_layout = ( isset($ciyashop_options['product-tab-layout']) && !empty($ciyashop_options['product-tab-layout']) ) ? $ciyashop_options['product-tab-layout'] : 'default';

	$product_tab_layout = apply_filters( 'ciyashop_product_tab_layout', $product_tab_layout, $ciyashop_options );

	return $product_tab_layout;
}

function ciyashop_product_page_width(){
	global $ciyashop_options;

	$product_page_width = ( isset($ciyashop_options['product-page-width']) && !empty($ciyashop_options['product-page-width']) ) ? $ciyashop_options['product-page-width'] : 'fixed';

	$product_page_width = apply_filters( 'ciyashop_product_page_width', $product_page_width, $ciyashop_options );

	return $product_page_width;
}

function ciyashop_shop_page_width(){
	global $ciyashop_options;

	$shop_page_width = ( isset($ciyashop_options['shop-page-width']) && !empty($ciyashop_options['shop-page-width']) ) ? $ciyashop_options['shop-page-width'] : 'fixed';

	$shop_page_width = apply_filters( 'ciyashop_shop_page_width', $shop_page_width, $ciyashop_options );

	return $shop_page_width;
}

add_action( 'woocommerce_single_product_summary', 'ciyashop_product_sale_countdown', 21 );
add_action( 'woocommerce_after_shop_loop_item_title', 'ciyashop_product_sale_countdown', 11 );
if( ! function_exists( 'ciyashop_product_sale_countdown' ) ) {
	function ciyashop_product_sale_countdown() {
		global $post, $ciyashop_options, $product;

		if(is_single() && get_post_type()=='product' && $ciyashop_options['product_countdown']==0){
			return;
		}elseif(!is_single() && $ciyashop_options['shop_countdown']==0){
			return;
		}

		if(!$product->is_on_sale()){
			return;
		}

		$sale_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );

		if( ! $sale_date ) return;

		$counter_data = array(
			'days'           => esc_html__("Day", 'ciyashop' ),
			'hours'          => esc_html__("Hrs", 'ciyashop' ),
			'minutes'        => esc_html__("Min", 'ciyashop' ),
			'seconds'        => esc_html__("Sec", 'ciyashop' ),
		);

		$counter_data = json_encode($counter_data);
		?>
		<div class="woo-product-countdown-wrapper">
			<?php
			if( is_single() && !empty($ciyashop_options['product_countdown_title']) ){
				?>
				<h6><?php echo esc_html($ciyashop_options['product_countdown_title']);?></h6>
				<?php
			}
			?>
			<div class="woo-product-countdown woo-timer deal-counter-wrapper">
				<div class="deal-counter" data-countdown-date="<?php echo esc_attr( date( 'Y/m/d', $sale_date ) ); ?>" data-counter_data="<?php echo esc_attr($counter_data);?>"></div>
			</div>
		</div>
		<?php

	}
}

function ciyashop_single_product_style(){
	global $ciyashop_options;

	$style = isset($ciyashop_options['product_page_style']) && $ciyashop_options['product_page_style'] != '' ? $ciyashop_options['product_page_style'] : 'classic';

	$style = apply_filters( 'ciyashop_single_product_style', $style );

	return $style;
}

function ciyashop_single_product_thumbnail_position(){
	global $ciyashop_options;

	$product_style = ciyashop_single_product_style();

	if( $product_style == 'wide_gallery' ) return 'none';

	$thumbnail_position = isset($ciyashop_options['product_page_thumbnail_position']) && $ciyashop_options['product_page_thumbnail_position'] != '' ? $ciyashop_options['product_page_thumbnail_position'] : 'bottom';

	$thumbnail_position = apply_filters( 'ciyashop_single_product_thumbnail_position', $thumbnail_position );

	return $thumbnail_position;
}

if ( ! function_exists( 'ciyashop_header_cart_count' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function ciyashop_header_cart_count() {
		$cart_count = WC()->cart->get_cart_contents_count();

		if($cart_count > 9){
			$cart_count = '9+';
		}
		?>
		<span class="cart-count count"><?php echo esc_html($cart_count);?></span>
		<?php
	}
}

if ( ! function_exists( 'ciyashop_cart_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ciyashop_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		ciyashop_header_cart_count();
		$fragments['.woo-tools-cart .cart-count'] = ob_get_clean();

		return $fragments;
	}
}

function ciyashop_sale_flash_label( $sale_html, $post, $product ){

	global $ciyashop_options;

	// Reset label
	$sale_html = '';

	$product_sale           = isset($ciyashop_options['product-sale']) && $ciyashop_options['product-sale'] != '' ? $ciyashop_options['product-sale'] : true;
	$product_sale_textperc  = isset($ciyashop_options['product_sale_textperc']) && $ciyashop_options['product_sale_textperc'] != '' ? $ciyashop_options['product_sale_textperc'] : 'text';
	$product_sale_label     = isset($ciyashop_options['product-sale-label']) && $ciyashop_options['product-sale-label'] != '' ? $ciyashop_options['product-sale-label'] : esc_html__( 'Sale', 'ciyashop' );

	if( $product_sale_textperc == 'percent' ){

		$percentage = 0;

		if( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ){

			$regular_price = $product->get_regular_price();
			$sale_price = $product->get_sale_price();

			if ($regular_price)
				$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

		} elseif( $product->is_type( 'variable' ) ){

			$available_variations = $product->get_available_variations();

			if($available_variations){

				$percents = array();
				foreach($available_variations as $variations){

					$regular_price = $variations['display_regular_price'];
					$sale_price = $variations['display_price'];

					if ($regular_price){
						$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
						$percents[] = $percentage;
					}
				}

				$max_discount = min($percents);
				$percentage = 'Up to '.$max_discount;
			}
		}

		$sale_label = $percentage.'%';
	}else{
		$sale_label = $product_sale_label;
	}

	if( $product_sale ){
		$sale_html = '<span class="onsale">' . esc_html( $sale_label ) . '</span>';
	}

	return $sale_html;
}

function ciyashop_featured_label( $featured_html, $post, $product ){

	global $ciyashop_options;

	// Reset label
	$featured_html = '';

	$product_hot      = isset($ciyashop_options['product-hot']) && $ciyashop_options['product-hot'] != '' ? $ciyashop_options['product-hot'] : true;
	$product_hot_label = isset($ciyashop_options['product-hot-label']) && $ciyashop_options['product-hot-label'] != '' ? $ciyashop_options['product-hot-label'] : esc_html__( 'Hot', 'ciyashop' );

	if( $product_hot ){
		$featured_html = '<span class="featured">' . esc_html( $product_hot_label ) . '</span>';
	}

	return $featured_html;
}

// Return cart item key based on product id.
function ciyashop_wc_get_cart_item_key( $product_id  = ''){
	if( !$product_id ) return false;

	global $woocommerce;

	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
		if($cart_item['product_id'] == $product_id ){
			return $cart_item_key;
		}
	}

	return false;
}

function ciyashop_is_woocommerce_page () {
	global $post;

	if( class_exists( 'WooCommerce' ) ){

		if( is_woocommerce() || is_cart() || is_checkout() || is_checkout_pay_page() || is_account_page() || is_view_order_page() || is_edit_account_page()
		|| is_order_received_page() || is_add_payment_method_page() || is_lost_password_page() ){
			return true;
		}

		if( isset($post->post_content) && has_shortcode( $post->post_content, 'yith_wcwl_wishlist') ) {
			return true;
		}
	}

	return false;
}