<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_product_deal
 * 
 ******************************************************************************/
function pgscore_shortcode_product_deal( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'         => 'default',
		'product_id'    => '',
		'expire_message'=> esc_html__('This offer has expired!', 'ciyashop' ),
		'counter_size'  => 'sm',
		'on_expire_btn' => 'disable',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract( $atts );
	
	if( empty($product_id) ){
		return;
	}
	
	$sale_ids = wc_get_product_ids_on_sale();
	
	// bail early, if product not found in sales.
	if( !in_array($product_id, $sale_ids) ) return;
	
	global $product;
	$product = wc_get_product( (int) $product_id );
	
	if ( is_object( $product ) ) {
		$atts['product'] = $product;
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
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('product_deal/content' );?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

/******************************************************************************
 * 
 * Visual Composer Integration
 * 
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline()) ) {
	function ciyashop_products_on_sale_data($placeholder){
		$data = array();
		$sale_ids = wc_get_product_ids_on_sale();
		
		if( is_array($sale_ids) && !empty($sale_ids) ){
			if( $placeholder ){
				$data[] = esc_html__( 'Select Product', 'ciyashop' );
			}
			foreach( $sale_ids as $sale_id ){
				$product_object = wc_get_product( (int) $sale_id );
				if ( is_object( $product_object ) ) {
					$product_sku = $product_object->get_sku();
					$product_title = $product_object->get_title();
					$product_id = $product_object->get_id();

					$product_title_display = '';
					if ( ! empty( $product_title ) ) {
						$product_title_display = ' - ' . esc_html__( 'Title', 'ciyashop' ) . ': ' . $product_title;
					}

					$product_id_display = esc_html__( 'Id', 'ciyashop' ) . ': ' . $product_id;

					$data[$product_id] = $product_id_display . $product_title_display;
				}
			}
		}
		return $data;
	}

	$shortcode_fields = array(
		array(
			'type'            => 'pgscore_notice',
			'param_name'      => 'product_schedule_warning',
			'notice_type'     => 'warning',
			'heading'         => esc_html__( 'Important Note', 'ciyashop' ),
			'message'         => esc_html__( 'If the Start Date is greater than the Current Date, or the End Date is less than the current date, the selected items will not be shown on the front. Also, if the Sale Price is not entered, it will not be shown.', 'ciyashop' ),
			'display_header'  => true,
		),
		array(
			"type"                    => "dropdown",
			"heading"                 => esc_html__("Product", 'ciyashop' ),
			"description"             => esc_html__("Select product from products in sale.", 'ciyashop' ),
			"param_name"              => "product_id",
			'value'                   => array_flip( ciyashop_products_on_sale_data(true) ),
			'admin_label'             => true,
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__("Expire Message", 'ciyashop' ),
			"param_name" => "expire_message",
			"value"      => esc_html__('This offer has expired!', 'ciyashop' ),
			"description"=> esc_html__( "Enter message to display, instead of date counter, when deal is expired.", 'ciyashop' ),
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
		),
		array(
			"type"                    => "dropdown",
			"heading"                 => esc_html__("Counter Size", 'ciyashop' ),
			"description"             => esc_html__("Select deal counter size.", 'ciyashop' ),
			"param_name"              => "counter_size",
			'value'                   => array_flip( array(
				'xs'=> esc_html__('Extra Small', 'ciyashop' ),
				'sm'=> esc_html__('Small', 'ciyashop' ),
				'md'=> esc_html__('Medium', 'ciyashop' ),
				'lg'=> esc_html__('Large', 'ciyashop' ),
			) ),
			'std'                     => 'sm',
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
		),	
		
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params                      = array(
	"name"                   => esc_html__( "Product Deal", 'ciyashop' ),
		"base"                   => $shortcode_tag,
		"class"                  => "pgscore_element_wrapper",
		"controls"               => "full",
		"icon"                   => pgscore_vc_shortcode_icon( $shortcode_tag ),
		"category"               => esc_html__('Potenza Core', 'ciyashop' ),
		"show_settings_on_create"=> true,
		"params"                 => $shortcode_fields,
	);

	vc_map( $params );

	add_filter( 'vc_autocomplete_pgscore_product_deal_id_callback', 'ciyashop_shortcode_product_deal_autocomplete_suggester', 10, 1 );
	add_filter( 'vc_autocomplete_pgscore_product_deal_id_render', 'ciyashop_shortcode_product_deal_autocomplete_render', 10, 1 );
	function ciyashop_shortcode_product_deal_autocomplete_suggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$query = $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
			FROM {$wpdb->posts} AS a
			LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
			WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query )
		);
		$post_meta_infos = $wpdb->get_results( $query, ARRAY_A );

		$product_ids_on_sale = wc_get_product_ids_on_sale();
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'ciyashop' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'ciyashop' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'ciyashop' ) . ': ' . $value['sku'] : '' );
				$results[] = $data;
			}
		}

		return $results;
	}

	function ciyashop_shortcode_product_deal_autocomplete_render( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			if ( is_object( $product_object ) ) {
				$product_sku = $product_object->get_sku();
				$product_title = $product_object->get_title();
				$product_id = $product_object->get_id();

				$product_sku_display = '';
				if ( ! empty( $product_sku ) ) {
					$product_sku_display = ' - ' . esc_html__( 'Sku', 'ciyashop' ) . ': ' . $product_sku;
				}

				$product_title_display = '';
				if ( ! empty( $product_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'ciyashop' ) . ': ' . $product_title;
				}

				$product_id_display = esc_html__( 'Id', 'ciyashop' ) . ': ' . $product_id;

				$data = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
}