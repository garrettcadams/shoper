<?php
if( ! ( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ) ) return;
/******************************************************************************
 * 
 * Shortcode : pgscore_product_showcase
 * 
 ******************************************************************************/
function pgscore_shortcode_product_showcase( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'title'             => '',
		'title_el'          => 'h3',
		'product_type'  	=> 'recently-viewed',
		'number_of_item'	=> '6',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract($atts);
	
	$query_args = array(
		'posts_per_page' => $number_of_item,
		'no_found_rows'  => 1,
		'post_status'    => 'publish',
		'post_type'      => 'product',
	);
	
	if($product_type == 'recently-viewed'){
		$woocommerce_recently_viewed = ( isset($_COOKIE['woocommerce_recently_viewed']) && $_COOKIE['woocommerce_recently_viewed'] != '' ) ? sanitize_text_field( wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : '';
		$viewed_products = ! empty( $woocommerce_recently_viewed ) ? (array) explode( '|', $woocommerce_recently_viewed ) : array();
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
		if ( empty( $viewed_products ) ) {
			return;
		}

		$query_args['post__in'] = $viewed_products;
		$query_args['orderby'] = 'post__in';
		
		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'outofstock',
					'operator' => 'NOT IN',
				),
			);
		}
	}elseif($product_type == 'featured-products'){
		$query_args['meta_query']= WC()->query->get_meta_query();
		$query_args['tax_query'] = WC()->query->get_tax_query();
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		);
		$query_args['tax_query']  = $tax_query;
	}elseif($product_type == 'products-in-sale'){
		$product_ids_on_sale    = wc_get_product_ids_on_sale();
		$product_ids_on_sale[]  = 0;
		$query_args['post__in'] = $product_ids_on_sale;
	}elseif($product_type == 'top-rated-products'){
		$query_args['meta_key']  = '_wc_average_rating';
		$query_args['orderby']   = 'meta_value_num';
		$query_args['order']     = 'DESC';
		$query_args['meta_query']= WC()->query->get_meta_query();
		$query_args['tax_query'] = WC()->query->get_tax_query();
	}
	
	$loop = new WP_Query( $query_args );
	if( !$loop->have_posts() ) {
		return;
	}
	
	/**********************************************************
	 * 
	 * Element Classes
	 * For base wrapper
	 * 
	**********************************************************/
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['loop'] = $loop;
	
    ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('product_showcase/content');?>
	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}

/******************************************************************************
 * 
 * Visual Composer Integration
 * 
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline()) ) {
	$shortcode_fields = array(
		array(
			'type'       => 'textfield',
			'param_name' => 'title',
			'heading'    => esc_html__('Title', 'ciyashop' ),
			'description'=> esc_html__('Enter title.', 'ciyashop' ),
			'admin_label'=> true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'title_el',
			'heading'    => esc_html__('Title Element Tag', 'ciyashop' ),
			'description'=> esc_html__('Select title element tag.', 'ciyashop' ),
			'std'        => 'h3',
			'value'      => array_flip( array(
				'h1'  => esc_html__( 'H1', 'ciyashop' ),
				'h2'  => esc_html__( 'H2', 'ciyashop' ),
				'h3'  => esc_html__( 'H3', 'ciyashop' ),
				'h4'  => esc_html__( 'H4', 'ciyashop' ),
				'h5'  => esc_html__( 'H5', 'ciyashop' ),
				'h6'  => esc_html__( 'H6', 'ciyashop' ),
			)),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Product Type', 'ciyashop' ),
			'param_name' => 'product_type',
			'value'      => array (
				esc_html__('Recently Viewed', 'ciyashop' )   => 'recently-viewed',
				esc_html__('Featured Products', 'ciyashop' )   => 'featured-products',
				esc_html__('Products in Sale', 'ciyashop' )  => 'products-in-sale',
				esc_html__('Top Rated Products', 'ciyashop' )=> 'top-rated-products',
			),
			'save_always' => true,                
			'description' => esc_html__( 'Select type of product to display in slider.', 'ciyashop' ),
			'admin_label' => true,
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__("Number of item", 'ciyashop' ),                
			"param_name"  => "number_of_item",
			"description" => esc_html__( 'Enter number of products to display in slider.', 'ciyashop' ),
			'admin_label' => true,
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Product Showcase", 'ciyashop' ),
		"base"                   => $shortcode_tag,
		"class"                  => "pgscore_element_wrapper",
		"controls"               => "full",
		"icon"                   => pgscore_vc_shortcode_icon( $shortcode_tag ),
		"category"               => esc_html__('Potenza Core', 'ciyashop' ),
		"show_settings_on_create"=> true,
		"params"                 => $shortcode_fields,
	);

	vc_map( $params );
}