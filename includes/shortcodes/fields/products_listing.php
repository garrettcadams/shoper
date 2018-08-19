<?php
if( ! ( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ) ) return;
/* 
 * Shortcode : pgscore_products_listing 
 */
function pgscore_shortcode_products_listing( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'listing_type'                      => 'grid',
		'enable_intro'                      => '',
		
		'intro_title'                       => '',
		'intro_title_color'                 => '#323232',
		'intro_description'                 => '',
		'intro_description_color'           => '#969696',
		'enable_intro_link'                 => '',
		
		'link_title'                        => esc_html__('View All', 'ciyashop' ),
		'intro_link'                        => '|||',
		'intro_link_color'                  => '#323232',
		'intro_link_position'               => 'below_desc',
		'intro_link_alignment'              => 'left',
		
		'intro_position'                    => 'left',
		'intro_bg_type'                     => 'color',
		'intro_bg_color'                    => '#f5f5f5',
		'intro_bg_image'                    => '',
		'intro_bg_image_background_position'=> '',
		'intro_bg_image_background_repeat'  => '',
		'intro_bg_image_background_size'    => '',
		'intro_bg_image_ol_color'           => 'rgba(0,0,0,0.6)',
		'intro_content_alignment'           => 'left',
		
		'product_source'                    => 'product_types',
		'product_source_category'           => '',
		'product_source_product_type'       => '',

		'number_of_item'  => 5,
		
		'list_grid_columns'                 => 4,
		
		'list_carousel_items_sm'            => 2,
		'list_carousel_items_md'            => 3,
		'list_carousel_items_lg'            => 4,
		'list_carousel_items_xl'            => 5,
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	// Return if product source items are empty.
	if( $product_source == 'category' && $product_source_category == '' ){
		return;
	}elseif( $product_source == 'product_type' && $product_source_product_type == '' ){
		return;
	}
	
	// Query args
	$args = array(
		'post_type'          => 'product',
		'posts_status'       => 'publish',
		'ignore_sticky_posts'=> 1,
		'posts_per_page'     => $number_of_item,
	);
	
	if( $product_source == 'category' ){
		
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $product_source_category,
			),
		);
		
		$loop = new WP_Query( $args );
		
		if ( !$loop->have_posts() ) return;
	}elseif( $product_source == 'product_type' ){
		
		// New Arrival products
		if( $product_source_product_type == 'new_arrivals' ){
			$args['orderby'] = 'date';
			$args['order']  = 'DESC';
		
		// Featured product
		}elseif( $product_source_product_type == 'featured' ){
			$meta_query  = WC()->query->get_meta_query();
			$tax_query   = WC()->query->get_tax_query();
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
			$args['meta_query'] = $meta_query;
			$args['tax_query']  = $tax_query;
		
		// On Sale product
		}elseif( $product_source_product_type == 'on_sale' ){
			$args['meta_query']     = WC()->query->get_meta_query();
			$args['tax_query']      = WC()->query->get_tax_query();
			$args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		
		// Best Sellers Product
		}elseif( $product_source_product_type == 'best_sellers' ){
			$args['meta_key']  = 'total_sales';
			$args['orderby']   = 'meta_value_num';
			$args['meta_query']= WC()->query->get_meta_query();
			$args['tax_query'] = WC()->query->get_tax_query();
		
		// Cheapest Product
		}elseif( $product_source_product_type == 'cheapest'){
			$args['meta_key']= '_price';
			$args['orderby'] = 'meta_value_num';
			$args['order']   = 'ASC';
		}
		
		$loop = new WP_Query( $args );
		
		if ( !$loop->have_posts() ) return;
	}
	
	/*	 
	 * Element Classes
	 * For base wrapper	 
	 */
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['loop'] = $loop;
	
	if( isset($pgscore_shortcodes[$shortcode_handle]['index']) ){
		$pgscore_shortcodes[$shortcode_handle]['index'] = $pgscore_shortcodes[$shortcode_handle]['index']+1;
	}else{
		$pgscore_shortcodes[$shortcode_handle]['index'] = 1;
	}
	$pgscore_shortcodes[$shortcode_handle]['index_class'] = $shortcode_handle.'-'.$pgscore_shortcodes[$shortcode_handle]['index'];
	
	$atts['element_classes'][] = $pgscore_shortcodes[$shortcode_handle]['index_class'];
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('products_listing/content' );?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}


if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline()) ) {

	/* 
	 * Visual Composer Integration 
	 */
	$categories_hierarchy = get_terms_hierarchy( 'product_cat' );
	$categories_flat = get_terms_hierarchical_list( $categories_hierarchy );
	$categories_list = array();
	foreach( $categories_flat as $term_id => $term ){
		$categories_list[ $term->name .' ('.$term->count.')' ] = $term->slug;
	}
	$shortcode_fields = array(
		array(
			"type"       => "dropdown",
			"param_name" => "listing_type",
			"heading"    => esc_html__("Listing Type", 'ciyashop' ),
			"description"=> esc_html__("Select listing type.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'grid'     => esc_html__('Grid','ciyashop' ),
				'carousel' => esc_html__('Carousel','ciyashop' ),
			) ),
			"std"        => "grid",
			'admin_label'=> true,
		),
		array(
			'type'       => 'checkbox',
			"heading"    => esc_html__("Enable Intro", 'ciyashop' ),
			'param_name' => 'enable_intro',
			'description'=> esc_html__( 'Enable intro to display title and description (and tabs) on left side of listing.', 'ciyashop' ),
			'save_always'=> true,
			'admin_label'=> true,
		),
		
		/*  Content  */
		array(
			'type'            => 'pgscore_heading',
			'param_name'      => 'content_header_notice',
			'title'           => esc_html__('Notice','ciyashop' ),
			'title_el'        => 'h5',
			'subtitle'        => esc_html__('If "Intro" is enabled, title and subtitle will be displayed in "Intro" portion, otherwise it will be displayed at top.','ciyashop' ),
			'subtitle_el'     => 'h6',
			'group'           => esc_html__( 'Content', 'ciyashop' ),
		),
		array(
			"type"            => "textfield",
			"param_name"      => "intro_title",
			"heading"         => esc_html__( "Title", 'ciyashop' ),
			'description'     => esc_html__( "Add intro title.", 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-10",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Title Color', 'ciyashop' ),
			'param_name'      => 'intro_title_color',
			'description'     => esc_html__( 'Select title color.', 'ciyashop' ),
			'value'           => '#323232',
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-2",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"            => "textfield",
			"param_name"      => "intro_description",
			"heading"         => esc_html__( "Description", 'ciyashop' ),
			'description'     => esc_html__( "Add intro description.", 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-10",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Description Color', 'ciyashop' ),
			'param_name'      => 'intro_description_color',
			'description'     => esc_html__( 'Select description color.', 'ciyashop' ),
			'value'           => '#969696',
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-2",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			'type'       => 'checkbox',
			"heading"    => esc_html__("Enable Intro Link", 'ciyashop' ),
			'param_name' => 'enable_intro_link',
			'description'=> esc_html__( 'Enable this to display link in  Intro Content.', 'ciyashop' ),
			'group'      => esc_html__( 'Content', 'ciyashop' ),
			'admin_label'=> true,
			'dependency' => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		
		/*  Link Fields  */
		array(
			"type"      => "textfield",
			"heading"   => esc_html__( 'Link Title', 'ciyashop' ),
			"param_name"=> "link_title",
			'value'     => esc_html__('View All', 'ciyashop' ),
			'group'     => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'=> array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
		),
		array(
			'type'            => 'vc_link',
			'heading'         => esc_html__( 'Link', 'ciyashop' ),
			'param_name'      => 'intro_link',
			'description'     => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'ciyashop' ),
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Link Color', 'ciyashop' ),
			'param_name'      => 'intro_link_color',
			'description'     => esc_html__( 'Select link color.', 'ciyashop' ),
			'value'           => '#323232',
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "intro_link_position",
			"heading"                 => esc_html__("Link Position", 'ciyashop' ),
			"description"             => esc_html__('Select link position. Note: This is applicable only when "Listing Type" is set to "Carousel". If "Listing Type" is set to grid, this will be set as "Below Description" by default.', 'ciyashop' ),
			'value'                   => array_flip( array(
				'below_desc'    => esc_html__('Below Description', 'ciyashop' ),
				'with_controls' => esc_html__('With Carousel Controls', 'ciyashop' ),
			) ),
			"std"             => "below_desc",
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"            => "dropdown",
			"param_name"      => "intro_link_alignment",
			"heading"         => esc_html__("Link Alignment", 'ciyashop' ),
			"description"     => esc_html__("Select link alignment with carousel controls.", 'ciyashop' ),
			'value'           => array_flip( array(
				'left'  => esc_html__('Left', 'ciyashop' ),
				'right' => esc_html__('Right', 'ciyashop' ),
			) ),
			"std"             => "left",
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'intro_link_position',
				'value'   => 'with_controls',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		
		/*  Intro  */
		array(
			"type"                    => "pgscore_divider",
			"param_name"              => "intro_design_divider",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "intro_position",
			"heading"                 => esc_html__("Intro Position", 'ciyashop' ),
			"description"             => esc_html__("Select intro position.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'left'  => esc_html__('Left', 'ciyashop' ),
				'right' => esc_html__('Right', 'ciyashop' ),
			) ),
			"std"                     => "left",
			'admin_label'             => true,
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_content_alignment",
			"heading"    => esc_html__("Intro Content Alignment", 'ciyashop' ),
			"description"=> esc_html__("Select content alignment in Intro", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'left'  => esc_html__('Left','ciyashop' ),
				'right' => esc_html__('Right','ciyashop' ),
			) ),
			"std"        => "left",
			'group'      => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_type",
			"heading"    => esc_html__("Background Type", 'ciyashop' ),
			"description"=> esc_html__("Select intro background type.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'color' => esc_html__('Color', 'ciyashop' ),
				'image' => esc_html__('Image', 'ciyashop' ),
				'none'  => esc_html__('None', 'ciyashop' ),
			) ),
			"std"                     => "color",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
			'admin_label'             => true,
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Background Color', 'ciyashop' ),
			'param_name'      => 'intro_bg_color',
			'description'     => esc_html__( 'Select background color.', 'ciyashop' ),
			'value'           => '#f5f5f5',
			'group'           => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'color',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_position",
			"heading"    => esc_html__("Background Position", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image position.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''             => esc_html__('Select Background Position','ciyashop' ),
				'inherit'      => esc_html__('Inherit','ciyashop' ),
				'left top'     => esc_html__('Left Top','ciyashop' ),
				'left center'  => esc_html__('Left Center','ciyashop' ),
				'left bottom'  => esc_html__('Left Bottom','ciyashop' ),
				'right top'    => esc_html__('Right Top','ciyashop' ),
				'right center' => esc_html__('Right Center','ciyashop' ),
				'right bottom' => esc_html__('Right Bottom','ciyashop' ),
				'center top'   => esc_html__('Center Top','ciyashop' ),
				'center center'=> esc_html__('Center Center','ciyashop' ),
				'center bottom'=> esc_html__('Center Bottom','ciyashop' ),
			) ),
			"std"                     => "",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_repeat",
			"heading"    => esc_html__("Background Repeat", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image repeat.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''         => esc_html__('Select Background Repeat','ciyashop' ),
				'inherit'  => esc_html__('Inherit','ciyashop' ),
				'repeat'   => esc_html__('Repeat','ciyashop' ),
				'repeat-x' => esc_html__('Repeat-X','ciyashop' ),
				'repeat-y' => esc_html__('Repeat-Y','ciyashop' ),
				'no-repeat'=> esc_html__('No-Repeat','ciyashop' ),
				'initial'  => esc_html__('Initial','ciyashop' ),
			) ),
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_size",
			"heading"    => esc_html__("Background Size", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image size.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''         => esc_html__('Select Background Size','ciyashop' ),
				'inherit'  => esc_html__('Inherit','ciyashop' ),
				'auto'     => esc_html__('Auto','ciyashop' ),
				'cover'    => esc_html__('Cover','ciyashop' ),
				'contain'  => esc_html__('Contain','ciyashop' ),
				'initial'  => esc_html__('Initial','ciyashop' ),
			) ),
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Overlay Color', 'ciyashop' ),
			'param_name'      => 'intro_bg_image_ol_color',
			'description'     => esc_html__( 'Select overlay color for background image.', 'ciyashop' ),
			'value'           => 'rgba(0,0,0,0.6)',
			'group'           => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
		),
		
		/*  Products Filter  */
		array(
			"type"       => "dropdown",
			"param_name" => "product_source",
			"heading"    => esc_html__("Product Source", 'ciyashop' ),
			"description"=> esc_html__("Select product source.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'category'    => esc_html__('Category','ciyashop' ),
				'product_type'=> esc_html__('Product Type','ciyashop' ),
			) ),
			"std"        => "product_type",
			'group'      => esc_html__( 'Products', 'ciyashop' ),
			'admin_label'=> true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'product_source_category',
			'heading'    => esc_html__( 'Product Source (Category)', 'ciyashop' ),
			'description'=> esc_html__( 'Select category to display products from.', 'ciyashop' ),
			'save_always'=> true,
			'value'      => $categories_list,
			'admin_label'=> true,
			'group'      => esc_html__( 'Products', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'product_source',
				'value'  => 'category',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'product_source_product_type',
			'heading'     => esc_html__( 'Product Source (Product Type)', 'ciyashop' ),
			'value'       => ciyashop_product_types( array( 'array_flip' => true, ) ),
			'save_always' => true,
			'description' => esc_html__( 'Select product type to display products from.', 'ciyashop' ),
			'admin_label' => true,
			'group'      => esc_html__( 'Products', 'ciyashop' ),
			'dependency'  => array(
				'element'=> 'product_source',
				'value'  => 'product_type',
			),
		),
		
		
		array(
			"type"        => "textfield",
			"heading"     => esc_html__("Number of item", 'ciyashop' ),
			"param_name"  => "number_of_item",
			'group'       => esc_html__( 'Products', 'ciyashop' ),
			'admin_label' => true,
		),
		
		/*  Grid Settings  */
		array(
			"type"       => "dropdown",
			"param_name" => "list_grid_columns",
			"heading"    => esc_html__("Grid Columns", 'ciyashop' ),
			"description"=> esc_html__("Select listing grid columns.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'2'     => esc_html__('2 Column','ciyashop' ),
				'3'     => esc_html__('3 Column','ciyashop' ),
				'4'     => esc_html__('4 Column','ciyashop' ),
				'5'     => esc_html__('5 Column','ciyashop' ),
			) ),
			"std"        => "4",
			'group'      => esc_html__( 'Grid Settings', 'ciyashop' ),
			'dependency'  => array(
				'element'=> 'listing_type',
				'value'  => 'grid',
			),
		),
		
		/*  Carousel Settings  */
		array(
			"type"                    => "pgscore_divider",
			"param_name"              => "list_carousel_items_divider",
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
			'dependency'              => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'            => 'dropdown',
			'param_name'      => 'list_carousel_items_sm',
			'heading'         => esc_html__( 'Small Devices (&ge;576px )','ciyashop' ),
			'description'     => esc_html__( 'Select number of items to display at a time in small devices.', 'ciyashop' ),
			'save_always'     => true,
			'value'           => array_flip( array(
				'1'     => esc_html__('1 Item','ciyashop' ),
				'2'     => esc_html__('2 Items','ciyashop' ),
			) ),
			"std"             => "2",
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			"edit_field_class"=> "vc_col-md-3 vc_col-sm-6",
		),
		array(
			'type'            => 'dropdown',
			'param_name'      => 'list_carousel_items_md',
			'heading'         => esc_html__( 'Medium Devices ( &ge;768px )','ciyashop' ),
			'description'     => esc_html__( 'Select number of items to display at a time in medium devices.', 'ciyashop' ),
			'save_always'     => true,
			'value'           => array_flip( array(
				'1'     => esc_html__('1 Item','ciyashop' ),
				'2'     => esc_html__('2 Items','ciyashop' ),
				'3'     => esc_html__('3 Items','ciyashop' ),
			) ),
			"std"             => "3",
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			"edit_field_class"=> "vc_col-md-3 vc_col-sm-6",
		),
		array(
			'type'            => 'dropdown',
			'param_name'      => 'list_carousel_items_lg',
			'heading'         => esc_html__( 'Large Devices ( &ge;992px )','ciyashop' ),
			'description'     => esc_html__( 'Select number of items to display at a time in large devices.', 'ciyashop' ),
			'save_always'     => true,
			'value'           => array_flip( array(
				'2'     => esc_html__('2 Items','ciyashop' ),
				'3'     => esc_html__('3 Items','ciyashop' ),
				'4'     => esc_html__('4 Items','ciyashop' ),
			) ),
			"std"             => "4",
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			"edit_field_class"=> "vc_col-md-3 vc_col-sm-6",
		),
		array(
			'type'            => 'dropdown',
			'param_name'      => 'list_carousel_items_xl',
			'heading'         => esc_html__( 'Extra Large Devices ( &ge;1200px )','ciyashop' ),
			'description'     => esc_html__( 'Select number of items to display at a time in  extra large devices.', 'ciyashop' ),
			'save_always'     => true,
			'value'           => array_flip( array(
				'2'     => esc_html__('2 Items','ciyashop' ),
				'3'     => esc_html__('3 Items','ciyashop' ),
				'4'     => esc_html__('4 Items','ciyashop' ),
				'5'     => esc_html__('5 Items','ciyashop' ),
			) ),
			"std"             => "5",
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			"edit_field_class"=> "vc_col-md-3 vc_col-sm-6",
		),
		array(
			"type"       => "attach_image",
			"param_name" => "intro_bg_image",
			"heading"    => esc_html__("Background Image", 'ciyashop' ),
			"description"=> esc_html__("Upload intro background image", 'ciyashop' ),
			"holder"     => "img",
			'group'      => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Products Listing", 'ciyashop' ),
		"description"            => esc_html__( "Display product listing.", 'ciyashop' ),
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