<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_image_slider
 * 
 ******************************************************************************/
function pgscore_shortcode_image_slider( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'                  => 'style-1',
		'img_size'               => 'pgscore-slider-thumbnail',
		'slides_per_view'        => 3,
		'slides_per_view_xx'     => '',
		'slides_per_view_xs'     => '',
		'slides_per_view_sm'     => '',
		'slides_per_view_md'     => '',
		'slide_margin'           => '',
		'show_pagination_control'=> '',
		'show_prev_next_buttons' => '',
		'enable_infinity_loop'   => '',
		'enable_caption'         => false,
		'slides'                 => '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );
	
	/*********************************************
	 * 
	 * Check for slides
	 * 
	 *********************************************/
	$slides_data = ( function_exists('vc_param_group_parse_atts') ) ? vc_param_group_parse_atts($slides) : ciyashop_param_group_parse_atts($slides);
	
	if( !is_array( $slides_data ) || empty( $slides_data ) || ( (count($slides_data) == 1) && empty( $slides_data[0] ) ) ) {
		return;
	}
	
	/*********************************************
	 * 
	 * Check for thumbnail size
	 * 
	 *********************************************/
	if( empty($img_size) ){
		$img_size = 'pgscore-slider-thumbnail';
	}
	
	global $_wp_additional_image_sizes;
	
	$thumb_size = '';
	if (
		is_string( $img_size ) && (
			( !empty( $_wp_additional_image_sizes[ $img_size ] ) && is_array( $_wp_additional_image_sizes[ $img_size ] ) )
			|| in_array( $img_size, array('thumbnail', 'thumb', 'medium', 'large', 'full') )
		)
	) {
		$thumb_size = $img_size;
	}elseif( strpos($img_size, 'x') !== false) {
		$img_size = explode('x', $img_size);
		
		// Check for PHP version
		if (version_compare(PHP_VERSION, '5.3.0', '<')) { // PHP < 5.3
			$img_size = array_filter($img_size, create_function('$value', 'return $value !== "";'));
		}else{ // PHP 5.3 and later
			$img_size = array_filter($img_size, function($value) { return $value !== ''; });
		}
		
		if( count($img_size) == 2 && is_numeric($img_size[0]) && is_numeric($img_size[1]) ){
			$thumb_size = $img_size;
		}
	}
	if( empty($thumb_size) ){
		return;
	}
	
	foreach( $slides_data as $slide_tk => $slide_td ){
		if( empty($slide_td['image']) ){
			unset($slides_data[$slide_tk]);
		}else{
			$image_thumb = wp_get_attachment_image_src($slide_td['image'], $thumb_size, false);
			$image_full  = wp_get_attachment_image_src($slide_td['image'], 'full', false);
			
			if( $image_thumb && !empty($image_thumb[0]) ){
				$slides_data[$slide_tk]['image_thumbnail']       = $image_thumb[0];
				$slides_data[$slide_tk]['image_thumbnail_width'] = $image_thumb[1];
				$slides_data[$slide_tk]['image_thumbnail_height']= $image_thumb[2];
				$slides_data[$slide_tk]['image_url']             = $image_full[0];
				$slides_data[$slide_tk]['image_url_width']       = $image_full[1];
				$slides_data[$slide_tk]['image_url_height']      = $image_full[2];
			}else{
				unset($slides_data[$slide_tk]);
			}
		}
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
	$pgscore_shortcodes[$shortcode_handle]['slides_data'] = $slides_data;
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('image_slider/content' );?>
	</div>
	<!-- Shortcode Base Wrapper -->
	<?php
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
			'type'            => 'pgscore_radio_image2',
			"heading"         => esc_html__("Style", 'ciyashop' ),
			'param_name'      => 'style',
			'options'         => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/image_slider/style-1.png'),
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/image_slider/style-2.png'),
				),
			),
			'show_label'      => true,
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Enable Caption', 'ciyashop' ),
			'param_name'      => 'enable_caption',
			'admin_label'     => true,
			'description'     => esc_html__( 'Select this to enable caption on slides.', 'ciyashop' ),
			'group'           => esc_html__( 'Slides', 'ciyashop' ),
		),
		array(
			'type'            => 'param_group',
			'value'           => '',
			'param_name'      => 'slides',
			'params'          => array(
				array(
					"type"            => "attach_image",
					"heading"         => esc_html__("Slide Image", 'ciyashop' ),
					"param_name"      => "image",
					'admin_label'     => true,
				),
				array(
					"type"            => "textfield",
					"heading"         => esc_html__("Title", 'ciyashop' ),
					"param_name"      => "title",
					'description'     => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'ciyashop' ),
					'edit_field_class'=> 'vc_col-sm-6 vc_column',
					'admin_label'     => true,
				),
				array(
					"type"            => "textfield",
					"heading"         => esc_html__("Subtitle", 'ciyashop' ),
					"param_name"      => "subtitle",
					'description'     => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'ciyashop' ),
					'edit_field_class'=> 'vc_col-sm-6 vc_column',
					'admin_label'     => true,
				),
				array(
					'type'            => 'dropdown',
					'heading'         => esc_html__( 'On Click Action', 'ciyashop' ),
					'param_name'      => 'onclick',
					'value'           => array_flip( array(
						'link_no'    => esc_html__( 'None', 'ciyashop' ),
						'link_image' => esc_html__( 'Image Popup', 'ciyashop' ),
						'custom_link'=> esc_html__( 'Open Link', 'ciyashop' ),
					) ),
					'description'     => esc_html__( 'Select action for click event.', 'ciyashop' ),
					'edit_field_class'=> 'vc_col-sm-4 vc_column',
				),
				array(
					'type'            => 'vc_link',
					'heading'         => esc_html__( 'Custom Link', 'ciyashop' ),
					'param_name'      => 'custom_link',
					'description'     => esc_html__( 'Add custom link.', 'ciyashop' ),
					'edit_field_class'=> 'vc_col-sm-4 vc_column',
					'dependency' => array(
						'element' => 'onclick',
						'value' => array( 'custom_link' ),
					),
				),
			),
			'group'    => esc_html__( 'Slides', 'ciyashop' ),
		),
		array(
			'type'            => 'textfield',
			'heading'         => esc_html__( 'Carousel Thumbnail Size', 'ciyashop' ),
			'param_name'      => 'img_size',
			'value'           => 'pgscore-slider-thumbnail',
			'description'     => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "pgscore-slider-thumbnail" size.', 'ciyashop' ),
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Show Pagination Control', 'ciyashop' ),
			'param_name'      => 'show_pagination_control',
			'description'     => esc_html__( 'Check this checkbox to display pagination controls.', 'ciyashop' ),
			'value'           => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
			'edit_field_class'=> 'vc_col-sm-6 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Show Prev/Next Buttons', 'ciyashop' ),
			'param_name'      => 'show_prev_next_buttons',
			'description'     => esc_html__( 'Check this checkbox to display prev/next buttons.', 'ciyashop' ),
			'value'           => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
			'edit_field_class'=> 'vc_col-sm-6 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Infinity Loop', 'ciyashop' ),
			'param_name'      => 'enable_infinity_loop',
			'description'     => esc_html__( 'Check this checkbox to enable infinity loop and display carousel in circular loop.', 'ciyashop' ),
			'value'           => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Slides per view','ciyashop' ),
			'param_name'      => 'slides_per_view',
			'min'             => '1',
			'max'             => '10',
			'value'           => '3',
			'description'     => esc_html__( 'Enter number of slides to display at the same time.', 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_heading',
			'heading'         => esc_html__('Slides Counts in Responsive View','ciyashop' ),
			'param_name'      => 'responsive_slide_counts_header',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Slides per view ( < 480px)','ciyashop' ),
			'param_name'      => 'slides_per_view_xx',
			'min'             => '1',
			'max'             => '10',
			'description'     => esc_html__( 'Enter number of slides to display at the same time.', 'ciyashop' ),
			'edit_field_class'=> 'vc_col-sm-3 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Slides per view ( < 768px)','ciyashop' ),
			'param_name'      => 'slides_per_view_xs',
			'min'             => '1',
			'max'             => '10',
			'description'     => esc_html__( 'Enter number of slides to display at the same time.', 'ciyashop' ),
			'edit_field_class'=> 'vc_col-sm-3 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Slides per view ( < 992px)','ciyashop' ),
			'param_name'      => 'slides_per_view_sm',
			'min'             => '1',
			'max'             => '10',
			'description'     => esc_html__( 'Enter number of slides to display at the same time.', 'ciyashop' ),
			'edit_field_class'=> 'vc_col-sm-3 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Slides per view ( < 1200px)','ciyashop' ),
			'param_name'      => 'slides_per_view_md',
			'min'             => '1',
			'max'             => '10',
			'description'     => esc_html__( 'Enter number of slides to display at the same time.', 'ciyashop' ),
			'edit_field_class'=> 'vc_col-sm-3 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_html',
			'heading'         => esc_html__('Responsive slide counts','ciyashop' ),
			'param_name'      => 'responsive_slide_counts_header',
			'html'            => '<h4>'.esc_html__( 'Note: Count entered in "Slides per view" will be used for device width above 1200px.', 'ciyashop' ).'</h4>',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__('Margin','ciyashop' ),
			'param_name'      => 'slide_margin',
			'min'             => '0',
			'max'             => '100',
			'value'           => '0',
			'description'     => esc_html__( 'Enter margin, in pixels (px), between each item.', 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Image Slider", 'ciyashop' ),
		"description"            => esc_html__( "Display image slider/carousel.", 'ciyashop' ),
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