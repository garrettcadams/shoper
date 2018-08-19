<?php
/******************************************************************************
 *
 * Shortcode : pgscore_clients
 *
 ******************************************************************************/
function pgscore_shortcode_clients( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'        	  => 'slider',
		'slider_elements' => 'none',
		'grid_elements'   => '2',
		'slides'          => '',
		'img_size'        => 'full',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	$slides = ( function_exists('vc_param_group_parse_atts') ) ? vc_param_group_parse_atts($atts['slides']) : ciyashop_param_group_parse_atts($atts['slides']);
	
	// Return shortcode if no required content found to display the shortcode perfectly.
	if( !is_array( $slides ) || empty( $slides ) ) {
		return;
	}
	
	/*********************************************
	 * 
	 * Check for thumbnail size
	 * 
	 *********************************************/
	if( empty($img_size) ){
		$img_size = 'full';
	}
	global $_wp_additional_image_sizes;
	
	$thumb_size = '';
	if ( is_string( $img_size ) && ( ( !empty( $_wp_additional_image_sizes[ $img_size ] ) && is_array( $_wp_additional_image_sizes[ $img_size ] ) ) || in_array( $img_size, array('thumbnail', 'thumb', 'medium', 'large', 'full') ) ) ) {
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
	
	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	 **********************************************************/
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['slides_data'] = $slides;
	$pgscore_shortcodes[$shortcode_handle]['thumb_size'] = $thumb_size;
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('clients/content' );?>
	</div>
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
			'param_name'      => 'style',
			'heading'         => esc_html__( 'List Style', 'ciyashop' ),
			'options'         => array(
				array(
					'value' => 'slider',
					'title' => 'Slider',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/clients/style-1.png'),
				),
				array(
					'value' => 'grid',
					'title' => 'Grid',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/clients/style-2.png'),
				),
			),
			'admin_label'     => true,
		),
		array(
			'type'      => 'dropdown',
			'heading'   => esc_html__( 'Slider Navigations', 'ciyashop' ),
			'param_name'=> 'slider_elements',
			'value'     => array_flip( array(
				'none'      => esc_html__( 'None', 'ciyashop' ),
				'pagination'=> esc_html__( 'Pagination Control', 'ciyashop' ),
				'prevnext'  => esc_html__( 'Prev/Next Buttons', 'ciyashop' ),
				'both'      => esc_html__( 'Both', 'ciyashop' ),
			) ),
			'description'=> esc_html__( 'Select slider navigations controls type.', 'ciyashop' ),
			'admin_label'=> true,
			'group'      => esc_html__( 'Slider Settings', 'ciyashop' ),
			'dependency'=> array(
				'element'=> 'style',
				'value'  => array(
					'slider',
				)
			),
		),
		array(
			'type'      => 'dropdown',
			'heading'   => esc_html__( 'Grid Columns', 'ciyashop' ),
			'param_name'=> 'grid_elements',
			'value'     => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'description'=> esc_html__( 'Select number of columns in Grid view.', 'ciyashop' ),
			'admin_label'=> true,
			'group'      => esc_html__( 'Grid Settings', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'style',
				'value'  => array(
					'grid',
				)
			),
		),
		array(
			'type'            => 'textfield',
			'heading'         => esc_html__( 'Image Size', 'ciyashop' ),
			'param_name'      => 'img_size',
			'value'           => 'full',
			'description'     => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'       => 'param_group',
			"heading"     => esc_html__("Logo Images", 'ciyashop' ),
			'value'      => '',
			'param_name' => 'slides',
			'params'     => array(
				array(
					"type"        => "attach_image",
					"heading"     => esc_html__("Slide Image", 'ciyashop' ),
					"param_name"  => "slide_image",
					'admin_label' => true,
				),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__("Title", 'ciyashop' ),
					"description" => esc_html__("Enter title.", 'ciyashop' ),
					"param_name"  => "title",
					'admin_label' => true,
				),
				array(
					"type"        => "vc_link",
					"heading"     => esc_html__("Image Link", 'ciyashop' ),
					"param_name"  => "image_link",
					'admin_label' => true,
				),
			),
			"group"     => esc_html__("Logo Images", 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Clients Logo", 'ciyashop' ),
		"description"            => esc_html__( "Display clients logo as grid and carousel.", 'ciyashop' ),
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