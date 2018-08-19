<?php
/*
 * Shortcode : pgscore_product_deals
 */
function pgscore_shortcode_product_deals( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'                             => 'default',
		
		'enable_intro_content'              => '',
		'intro_title'                       => '',
		'intro_title_color'                 => '#323232',
		'intro_description'                 => '',
		'intro_description_color'           => '#969696',
		'product_per_page'           		=> 8,
		'product_categories'           		=> '',
		'enable_intro_link'                 => '',
		
		'intro_position'                    => 'left',
		'intro_bg_type'                     => 'color',
		'intro_bg_color'                    => '#f5f5f5',
		'intro_bg_image'                    => '',
		'intro_bg_image_background_position'=> '',
		'intro_bg_image_background_repeat'  => '',
		'intro_bg_image_background_size'    => '',
		'intro_bg_image_ol_color'           => 'rgba(0,0,0,0.6)',
		
		'link_title'                        => esc_html__('View All', 'ciyashop' ),
		'intro_link'                        => '|||',
		'intro_link_color'                  => '#323232',
		'intro_link_position'               => 'below_desc',
		'intro_link_alignment'              => 'left',
		
		'expire_message'                    => esc_html__('This offer has expired!', 'ciyashop' ),
		'counter_size'                      => 'xs',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract( $atts );
	
	$sale_ids = array();
	
	$args = array(
		'post_type'      => 'product',
		'posts_status'   => 'publish',
		'posts_per_page' => $product_per_page,
		'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
	);

	$product_categories = trim($product_categories);
	if( !empty($product_categories) ){
		$categories_array = explode(',', $product_categories);
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	$loop = new WP_Query( $args );
	if($loop->have_posts()){
		while ($loop->have_posts() ): $loop->the_post();
			$sale_ids[] = get_the_ID();
		endwhile;
	}
	
	wp_reset_query();
	
	if( !is_array($sale_ids) || ( is_array($sale_ids) && empty($sale_ids) ) ) return;
	
	/*	
	 * Element Classes
	 * For base wrapper	
	*/
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['sale_ids'] = $sale_ids;
	
	global $post;
	if( isset($pgscore_shortcodes[$shortcode_handle]['index']) ){
		$pgscore_shortcodes[$shortcode_handle]['index'] = $pgscore_shortcodes[$shortcode_handle]['index']+1;
	}else{
		$pgscore_shortcodes[$shortcode_handle]['index'] = 1;
	}
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('product_deals/content' );?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline()) ) {

	// Get Product Categories
	$product_categories_data = get_terms( array(
		'taxonomy'  => 'product_cat',
		'hide_empty'=> true,
	));

	$product_categories = array();

	if ( !is_wp_error( $product_categories_data ) ) {
		if ( is_array( $product_categories_data ) || !empty( $product_categories_data ) ) {
			foreach ( $product_categories_data as $term_data ) {
				if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
					$product_categories[ "{$term_data->name}"] = $term_data->slug;
				}
			}
		}
	}
	/*	 
	 * Visual Composer Integration	 
	 */

	$shortcode_fields = array(
		array(
			'type'                    => 'checkbox',
			"heading"                 => esc_html__("Enable Intro Content", 'ciyashop' ),
			'param_name'              => 'enable_intro_content',
			'description'             => esc_html__( 'Enable intro content to display title and description.', 'ciyashop' ),
			'admin_label'             => true,
		),
		array(
			"type"                    => "textfield",
			"param_name"              => "intro_title",
			"heading"                 => esc_html__( "Title", 'ciyashop' ),
			'description'             => esc_html__( "Add intro title.", 'ciyashop' ),
			'admin_label'             => true,
			'dependency'              => array(
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
			"edit_field_class"=> "vc_col-md-10",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Title Color', 'ciyashop' ),
			'param_name'      => 'intro_title_color',
			'description'     => esc_html__( 'Select title color.', 'ciyashop' ),
			'value'           => '#323232',
			"edit_field_class"=> "vc_col-md-2",
			'dependency'              => array(
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
		),
		array(
			"type"                    => "textfield",
			"param_name"              => "intro_description",
			"heading"                 => esc_html__( "Description", 'ciyashop' ),
			'description'             => esc_html__( "Add intro description.", 'ciyashop' ),
			'admin_label'             => true,
			"edit_field_class"=> "vc_col-md-10",
			'dependency'              => array(
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Description Color', 'ciyashop' ),
			'param_name'      => 'intro_description_color',
			'description'     => esc_html__( 'Select description color.', 'ciyashop' ),
			'value'           => '#969696',
			"edit_field_class"=> "vc_col-md-2",
			'dependency'      => array(
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
		),
		array(
			'type'       => 'pgscore_number_min_max',
			'heading'    => esc_html__( "Product Count", 'ciyashop' ),
			'param_name' => 'product_per_page',
			'value'      => '',
			'min'        => '2',
			'max'        => '10',
			'description'=> esc_html__('Enter number product to display.','ciyashop' ),
			'admin_label'=> true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__('Product Categories', 'ciyashop' ),
			'param_name' => 'product_categories',
			'description'=> esc_html__('Select categories to limit result from. To display result from all categories leave all categories unselected.', 'ciyashop' ),
			'value'      => $product_categories,
			'admin_label'=> true,
		),
		array(
			'type'                    => 'checkbox',
			"heading"                 => esc_html__("Enable Link", 'ciyashop' ),
			'param_name'              => 'enable_intro_link',
			'description'             => esc_html__( 'Enable this to display link in  Intro Content.', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
			'admin_label'             => true,
		),
		
		/* Intro Design Fields */
		array(
			"type"                    => "pgscore_divider",
			"param_name"              => "intro_design_divider",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro_content',
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
				'element'=> 'enable_intro_content',
				'value'  => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_type",
			"heading"    => esc_html__("Background Type", 'ciyashop' ),
			"description"=> esc_html__("Select intro background type.", 'ciyashop' ),
			'value'      => array_flip( array(
				'color' => esc_html__('Color', 'ciyashop' ),
				'image' => esc_html__('Image', 'ciyashop' ),
				'none'  => esc_html__('None', 'ciyashop' ),
			) ),
			"std"                     => "color",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro_content',
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
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_position",
			"heading"    => esc_html__("Background Position", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image position.", 'ciyashop' ),
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
		
		/* Link Fields */
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
			"description"             => esc_html__("Select link position.", 'ciyashop' ),
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
		
		/* Deal Fields */
		array(
			"type"       => "textfield",
			"heading"    => esc_html__("Expire Message", 'ciyashop' ),
			"param_name" => "expire_message",
			"value"      => esc_html__('This offer has expired!', 'ciyashop' ),
			"description"=> esc_html__( "Enter message to display, instead of date counter, when deal is expired.", 'ciyashop' ),
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params                      = array(
	"name"                   => esc_html__( "Product Deals", 'ciyashop' ),
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