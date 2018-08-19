<?php
/******************************************************************************
 *
 * Shortcode : pgscore_info_box
 *
 ******************************************************************************/
function pgscore_shortcode_info_box( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'layout'                  => 'style_1',
		'content_alignment'       => 'center',
		'icon_position'           => 'left',
		'icon_disable'            => '',
		
		// Content
		'title'                   => '',
		'title_el'                => 'h3',
		'title_color'             => '#323232',
		'description'             => '',
		
		// Step
		'enable_step'             => '',
		'step'                    => '01',
		'style_2_step_position'   => 'above_title',
		'style_4_step_color'      => '#323232',
		'style_5_step_color'      => '#323232',
		
		// Icon
		'icon_disable'            => '',
		'icon_style'              => 'default', // default, border, flat
		'icon_size'               => 'md',
		'icon_shape'              => 'square', // square, rounded, round
		
		// Icon - Background
		'icon_background_color'   => '#878787',
		
		// Icon - Border
		'icon_border_color'       => '#878787',
		'icon_border_width'       => '5',
		'icon_border_style'       => '',
		
		// Icon (Outer Border)
		'icon_enable_outer_border'=> '',
		'icon_outer_border_color' => '#323232',
		'icon_outer_border_width' => '5',
		'icon_outer_border_style' => '',
		
		// Icon - Source
		'icon_source'             => 'font', // font, image
		
		// Icon - Type            = Image
		'icon_image'              => '',
		
		// Icon - Type            = Font
		'icon_color'              => '#323232',
		'icon_type'               => 'fontawesome',
		'icon_fontawesome'        => 'fa fa-chevron-right',
		'icon_openiconic'         => 'vc-oi vc-oi-right',
		'icon_typicons'           => 'typcn typcn-chevron-right',
		'icon_entypo'             => 'entypo-icon entypo-icon-right-open',
		'icon_linecons'           => 'vc_li vc_li-heart',
		'icon_monosocial'         => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'           => 'vc-material vc-material-cake',
		'icon_pixelicons'         => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'           => 'glyph-icon flaticon-right-arrow-1',
		
		// Link
		'link_enable'             => '',
		'link_url'                => '',
		'link_on'                 => 'title',
		'link_custom_onclick'     => '',
		'link_custom_onclick_code'=> '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract( $atts );
	
	// Return shortcode if no required content found to display the shortcode perfectly.
	if( empty( $title ) && empty( $description ) ) {
		return;
	}
	
	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html = $icon_class = '';
	$icon_wrapper = false;
	 
	if( isset($icon_source) && $icon_source == 'font' ){
		$current_icon = 'icon_' . $icon_type;
		
		if ( isset( ${$current_icon} ) && !empty(${$current_icon}) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${$current_icon};
		}
	}
	
	if( isset($icon_class) && empty($icon_class) ){
		$icon_disable == 'true';
	}
	
	if( isset($icon_disable) && $icon_disable == '' ){
		if( isset($icon_source) && $icon_source == 'font' ){
			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_style = '';
				if( in_array( $layout, array('style_1','style_2','style_3') ) ){
					if( isset($icon_color) && !empty($icon_color) ){
						$icon_style = ' style="color:'.esc_attr($icon_color).';"';
					}
				}
				$icon_html = '<i class="'.esc_attr($icon_class).'"'.$icon_style.'></i>';
			}
			
			// Enqueue icon CSS for icon type
			if( function_exists('vc_icon_element_fonts_enqueue') ){
				vc_icon_element_fonts_enqueue( $icon_type );
			}
			
		}elseif( isset($icon_source) && $icon_source == 'image' ){
			if( !empty($icon_image) ){
				$icon_image_size = array(
					'xs' => array(16,16),
					'sm' => array(20,20),
					'md' => array(24,24),
					'lg' => array(28,28),
				);
				
				$banner_image = wp_get_attachment_image_src( $icon_image, "pgscore-thumbnail-80" );
				$icon_html = '<img src="'.esc_url($banner_image[0]).'">';
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
	$pgscore_shortcodes[$shortcode_handle]['icon_html'] = $icon_html;
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('info_box/content' );?>
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
	function ciyashop_info_box_steps_number(){
		$steps_number = array();
		foreach (range(1, 99) as $number) {
			
			if( strlen($number) == 1 ) $number = "0{$number}";
			
			$steps_number[$number] = $number;
		}
		return $steps_number;
	}
	$shortcode_fields = array_merge(
		array(
			array(
				'type'            => 'pgscore_radio_image2',
				"heading"         => esc_html__("Layout", 'ciyashop' ),
				'param_name'      => 'layout',
				'options'         => array(
					array(
						'value' => 'style_1',
						'title' => 'Style 1',
						'image' => get_parent_theme_file_uri('/images/shortcodes/fields/info_box/style_1.png'),
					),
					array(
						'value' => 'style_2',
						'title' => 'Style 2',
						'image' => get_parent_theme_file_uri('/images/shortcodes/fields/info_box/style_2.png'),
					),
					array(
						'value' => 'style_3',
						'title' => 'Style 3',
						'image' => get_parent_theme_file_uri('/images/shortcodes/fields/info_box/style_3.png'),
					),
					array(
						'value' => 'style_4',
						'title' => 'Style 4',
						'image' => get_parent_theme_file_uri('/images/shortcodes/fields/info_box/style_4.png'),
					),
					array(
						'value' => 'style_5',
						'title' => 'Style 5',
						'image' => get_parent_theme_file_uri('/images/shortcodes/fields/info_box/style_5.png'),
					),
				),
				'show_label'      => true,
				'admin_label'     => true,
			),
			array(
				"type"            => "pgscore_radio",
				"heading"         => esc_html__("Content Alignment", 'ciyashop' ),
				"param_name"      => "content_alignment",
				'value'           => array_flip(array(
					'left'  => '<i class="dashicons dashicons-editor-alignleft"></i>',
					'center'=> '<i class="dashicons dashicons-editor-aligncenter"></i>',
					'right' => '<i class="dashicons dashicons-editor-alignright"></i>',
				)),
				"std"             => "center",
				"class"           => "pgscore_radio_label_only",
				'edit_field_class'=> 'vc_col-sm-6 vc_column',
				'save_always'     => true,
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_1', 'style_2', 'style_3' ),
				),
			),
			array(
				"type"            => "pgscore_radio",
				"heading"         => esc_html__("Icon Position", 'ciyashop' ),
				"param_name"      => "icon_position",
				'value'           => array_flip(array(
					'left'  => '<i class="dashicons dashicons-editor-outdent"></i>',
					'right' => '<i class="dashicons dashicons-editor-indent"></i>',
				)),
				"std"             => "left",
				"class"           => "pgscore_radio_label_only",
				'edit_field_class'=> 'vc_col-sm-6 vc_column',
				'save_always'     => true,
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_2' ),
				),
			),
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__( 'Disable Icon?', 'ciyashop' ),
				'param_name'       => 'icon_disable',
				'description'      => esc_html__( 'Check this checkbox to disable icon.', 'ciyashop' ),
				'value'            => array(
					esc_html__( 'Disable', 'ciyashop' ) => 'true'
				),
				'std'              => '',
				'admin_label'      => true,
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_1', 'style_2', 'style_3' ),
				),
			),
			
			/*---------------------------- Content ----------------------------*/
			array(
				"type"       => "textfield",
				"param_name" => "title",
				"heading"    => esc_html__("Title", 'ciyashop' ),
				"description"=> esc_html__("Enter title.", 'ciyashop' ),
				'admin_label'=> true,
				'group'      => esc_html__( 'Content', 'ciyashop' ),
			),
			array(
				"type"       => "dropdown",
				"param_name" => "title_el",
				"heading"    => esc_html__("Title Element Tag", 'ciyashop' ),
				"description"=> esc_html__("Select title element tag.", 'ciyashop' ),
				"std"        => "h3",
				'value'      => array_flip( array(
					'h2'  => esc_html__( 'H2', 'ciyashop' ),
					'h3'  => esc_html__( 'H3', 'ciyashop' ),
					'h4'  => esc_html__( 'H4', 'ciyashop' ),
					'h5'  => esc_html__( 'H5', 'ciyashop' ),
					'h6'  => esc_html__( 'H6', 'ciyashop' ),
				)),
				'group'       => esc_html__( 'Content', 'ciyashop' ),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Title Color', 'ciyashop' ),
				'description'=> esc_html__( 'Select title color.', 'ciyashop' ),
				'value'      => '#323232',
				'group'      => esc_html__( 'Content', 'ciyashop' ),
			),
			array(
				"type"       => "textfield",
				"param_name" => "description",
				"heading"    => esc_html__("Description", 'ciyashop' ),
				"description"=> esc_html__("Enter description. Please ensure to add short content.", 'ciyashop' ),
				'holder'     => 'div',
				'group'      => esc_html__( 'Content', 'ciyashop' ),
			),
			
			/*---------------------------- Step ----------------------------*/
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__( 'Enable Step?', 'ciyashop' ),
				'param_name'       => 'enable_step',
				'description'      => esc_html__( 'select this checkbox to enable step.', 'ciyashop' ),
				'group'       => esc_html__( 'Step', 'ciyashop' ),
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_2', 'style_3', 'style_4' ),
				),
			),
			array(
				"type"            => "dropdown",
				"param_name"      => "step",
				"heading"         => esc_html__("Step", 'ciyashop' ),
				"description"     => esc_html__("Select step number.", 'ciyashop' ),
				'value'           => array_flip( ciyashop_info_box_steps_number() ),
				'group'           => esc_html__( 'Step', 'ciyashop' ),
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_2', 'style_3', 'style_4', 'style_5' ),
				),
			),
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Step Position", 'ciyashop' ),
				"param_name"      => "style_2_step_position",
				'value'           => array_flip( array(
					'above_title'  => esc_html__( 'Above Title', 'ciyashop' ),
					'under_icon'   => esc_html__( 'Under Icon', 'ciyashop' ),
					'opposite_icon'=> esc_html__( 'Oposite Icon', 'ciyashop' ),
				) ),
				"std"             => "above_title",
				'group'           => esc_html__( 'Step', 'ciyashop' ),
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_2' ),
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'style_4_step_color',
				'heading'    => esc_html__( 'Step Color', 'ciyashop' ),
				'description'=> esc_html__( 'Select step color.', 'ciyashop' ),
				'value'      => '#323232',
				'group'           => esc_html__( 'Step', 'ciyashop' ),
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_4' ),
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'style_5_step_color',
				'heading'    => esc_html__( 'Step Color', 'ciyashop' ),
				'description'=> esc_html__( 'Select step color.', 'ciyashop' ),
				'value'      => '#323232',
				'group'           => esc_html__( 'Step', 'ciyashop' ),
				'dependency' => array(
					'element'=> 'layout',
					'value'  => array( 'style_5' ),
				),
			),
			
			/*---------------------------- Icon ----------------------------*/
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Icon Style", 'ciyashop' ),
				"param_name"      => "icon_style",
				'value'           => array_flip(array(
					'default'=> esc_html__( 'Default', 'ciyashop' ),
					'flat'   => esc_html__( 'Flat', 'ciyashop' ),
					'border' => esc_html__( 'Border', 'ciyashop' ),
				)),
				"std"             => "default",
				'group'            => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column vc_column-with-padding',
				'dependency'      => array(
					'element'           => 'icon_disable',
					'value_not_equal_to'=> 'true',
				),
			),
			array(
				'type'            => 'dropdown',
				'heading'         => esc_html__( 'Icon Size', 'ciyashop' ),
				'param_name'      => 'icon_size',
				'description'     => esc_html__( 'Select icon size.', 'ciyashop' ),
				'value'           => array_flip( array(
					'xs'=> esc_html__( 'Extra Small', 'ciyashop' ),
					'sm'=> esc_html__( 'Small', 'ciyashop' ),
					'md'=> esc_html__( 'medium', 'ciyashop' ),
					'lg'=> esc_html__( 'Large', 'ciyashop' ),
				) ),
				'std'             => 'md',
				'admin_label'     => true,
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element'           => 'icon_disable',
					'value_not_equal_to'=> 'true',
				)
			),
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Icon Shape", 'ciyashop' ),
				"param_name"      => "icon_shape",
				"description"     => "Select icon shape.",
				'value'           => array_flip(array(
					'square' => esc_html__( 'Square', 'ciyashop' ),
					'rounded'=> esc_html__( 'Rounded', 'ciyashop' ),
					'round'  => esc_html__( 'Round', 'ciyashop' ),
				)),
				"std"             => "square",
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('flat', 'border'),
				)
			),
			array(
				'type'            => 'colorpicker',
				'heading'         => esc_html__( 'Background Color', 'ciyashop' ),
				'param_name'      => 'icon_background_color',
				'description'     => esc_html__( 'Select icon background color.', 'ciyashop' ),
				'value'           => '#ccc',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('flat'),
				)
			),
			array(
				'type'            => 'colorpicker',
				'heading'         => esc_html__( 'Border Color', 'ciyashop' ),
				'param_name'      => 'icon_border_color',
				'description'     => esc_html__( 'Select border color.', 'ciyashop' ),
				'value'           => '#ccc',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('border'),
				)
			),
			array(
				'type'            => 'pgscore_number_min_max',
				'heading'         => esc_html__( "Border Width", 'ciyashop' ),
				'description'     => esc_html__('Enter/select border width.', 'ciyashop' ),
				'param_name'      => 'icon_border_width',
				'min'             => 1,
				'max'             => 10,
				'value'           => 5,
				'suffix'          => 'px',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('border'),
				)
			),
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Border Style", 'ciyashop' ),
				"param_name"      => "icon_border_style",
				"description"     => "Select border style.",
				'value'           => array_flip( array(
					''       => esc_html__( 'Theme defaults', 'ciyashop' ),
					'solid'  => esc_html__( 'Solid', 'ciyashop' ),
					'dotted' => esc_html__( 'Dotted', 'ciyashop' ),
					'dashed' => esc_html__( 'Dashed', 'ciyashop' ),
					'double' => esc_html__( 'Double', 'ciyashop' ),
					'groove' => esc_html__( 'Groove', 'ciyashop' ),
					'ridge'  => esc_html__( 'Ridge', 'ciyashop' ),
				) ),
				"std"             => "",
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('border'),
				)
			),
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__( 'Enable Outer Border', 'ciyashop' ),
				'param_name'       => 'icon_enable_outer_border',
				'description'      => esc_html__( 'Check this checkbox to enable outer border.', 'ciyashop' ),
				'value'            => array(
					esc_html__( 'Enable', 'ciyashop' ) => 'true'
				),
				'std'              => '',
				'group'            => esc_html__( 'Icon', 'ciyashop' ),
				'dependency'      => array(
					'element' => 'icon_style',
					'value'   => array('flat', 'border'),
				)
			),
			array(
				'type'            => 'colorpicker',
				'heading'         => esc_html__( 'Outer Border Color', 'ciyashop' ),
				'param_name'      => 'icon_outer_border_color',
				'description'     => esc_html__( 'Select border color.', 'ciyashop' ),
				'value'           => '#ccc',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element'  => 'icon_enable_outer_border',
					'not_empty'=> true,
				)
			),
			array(
				'type'            => 'pgscore_number_min_max',
				'heading'         => esc_html__( "Outer Border Width", 'ciyashop' ),
				'description'     => esc_html__('Enter/select border width.', 'ciyashop' ),
				'param_name'      => 'icon_outer_border_width',
				'min'             => 1,
				'max'             => 10,
				'value'           => 5,
				'suffix'          => 'px',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				"edit_field_class"=> "vc_col-md-4",
				'dependency'      => array(
					'element'  => 'icon_enable_outer_border',
					'not_empty'=> true,
				)
			),
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Outer Border Style", 'ciyashop' ),
				"param_name"      => "icon_outer_border_style",
				"description"     => "Select border style.",
				'value'           => array_flip( array(
					''       => esc_html__( 'Theme defaults', 'ciyashop' ),
					'solid'  => esc_html__( 'Solid', 'ciyashop' ),
					'dotted' => esc_html__( 'Dotted', 'ciyashop' ),
					'dashed' => esc_html__( 'Dashed', 'ciyashop' ),
					'double' => esc_html__( 'Double', 'ciyashop' ),
					'groove' => esc_html__( 'Groove', 'ciyashop' ),
					'ridge'  => esc_html__( 'Ridge', 'ciyashop' ),
				) ),
				"std"             => "",
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-4 vc_column',
				'dependency'      => array(
					'element'  => 'icon_enable_outer_border',
					'not_empty'=> true,
				)
			),
			array(
				"type"            => "dropdown",
				"heading"         => esc_html__("Icon Source", 'ciyashop' ),
				"param_name"      => "icon_source",
				'value'           => array_flip(array(
					'font' => esc_html__( 'Font', 'ciyashop' ),
					'image'=> esc_html__( 'Image', 'ciyashop' ),
				)),
				"std"             => "font",
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-12 vc_column',
				'dependency'      => array(
					'element'           => 'icon_disable',
					'value_not_equal_to'=> 'true',
				),
				"class"           => "pgscore_radio_label_only",
				'save_always'     => true,
				'admin_label'     => true,
			),
			array(
				"type"            => "attach_image",
				"param_name"      => "icon_image",
				"heading"         => esc_html__("Icon Image", 'ciyashop' ),
				"description"     => esc_html__("Upload/select icon image.", 'ciyashop' ),
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'edit_field_class'=> 'vc_col-sm-6 vc_column',
				'dependency'      => array(
					'element'     => 'icon_source',
					'value'       => 'image',
				),
			),
			array(
				'type'            => 'colorpicker',
				'heading'         => esc_html__( 'Icon Color', 'ciyashop' ),
				'param_name'      => 'icon_color',
				'description'     => esc_html__( 'Select icon color.', 'ciyashop' ),
				'value'           => '#323232',
				'group'           => esc_html__( 'Icon', 'ciyashop' ),
				'dependency'      => array(
					'element'     => 'icon_source',
					'value'       => 'font',
				),
			),
		),
		pgscore_iconpicker( array(
			'dependency' => array(
				'element' => 'icon_source',
				'value'   => 'font',
			),
			'group'      => esc_html__( 'Icon', 'ciyashop' ),
		) )
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                    => esc_html__( "Info Box", 'ciyashop' ),
		"description"             => esc_html__( "Information box with icon and link.", 'ciyashop' ),
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