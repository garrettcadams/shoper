<?php
/******************************************************************************
 *
 * Shortcode : pgscore_banner
 *
 ******************************************************************************/
function pgscore_shortcode_banner( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'                        => 'style-1',
		
		'font_size_responsive'         => '',
		'font_size'                    => '70',
		'font_size_xl'                 => '70',
		'font_size_lg'                 => '60',
		'font_size_md'                 => '50',
		'font_size_sm'                 => '40',
		'font_size_xs'                 => '30',
		'banner_padding_responsive'    => '',
		'banner_css'                   => '',
		'banner_padding_xl'            => '',
		'banner_padding_lg'            => '',
		'banner_padding_md'            => '',
		'banner_padding_sm'            => '',
		'banner_padding_xs'            => '',
		'banner_link_enable'           => '',
		'banner_link_url'              => '',
		
		'vertical_align'               => 'vtop',
		'horizontal_align'             => 'hleft',
		'banner_effect'                => 'none',
		'bg_img_source'                => 'media_library',
		'bg_img'                       => '',
		'bg_img_link'                  => '',
		
		'list_items'                   => '',
		
		// Button
		'button_text'                  => esc_html__('Click Here', 'ciyashop' ),
		'button_style'                 => 'link',
		'button_size'                  => 'md',
		'button_shape'                 => 'square',
		
		'button_text_color'            => '#323232',
		'button_color'                 => '#04d39f',
		'button_border_color'          => '#04d39f',
		'button_hover_text_color'      => '#ffffff',
		'button_hover_background_color'=> '#323232',
		'button_hover_border_color'    => '#323232',
		
		'button_border_width'          => '1',
		'button_text_transform'        => '',
		'button_letter_spacing'        => 0,
		'button_line_height'           => '',
		
		'link_url'                     => '|||',
		
		'add_badge'                    => '',
		'badge_style'                  => 'style-1',
		'badge_title'                  => '',
		'badge_type'                   => 'border',
		'badge_text_color'             => '#323232',
		'badge_background_color'       => '#ffffff',
		'badge_border_width'           => 1,
		'badge_border_color'           => '#323232',
		'badge_width'                  => '70',
		'badge_height'                 => '70',
		'badge_vertical_align'         => 'vbottom',
		'badge_horizontal_align'       => 'hright',
		'badge_font_size'              => 20,
		'badge_font_weight'            => '600',
		'badge_line_height'            => '',
		'badge_text_transform'         => '',
		
		'deal_date'                    => '',
		'expire_message'               => esc_html__('This offer has expired!', 'ciyashop' ),
		'counter_size'                 => 'sm',
		'counter_style'                => 'flat',
		'deal_padding_responsive'      => '',
		'deal_css'                     => '',
		'deal_padding_xl'              => '',
		'deal_padding_lg'              => '',
		'deal_padding_md'              => '',
		'deal_padding_sm'              => '',
		'deal_padding_xs'              => '',
		'on_expire_btn'                => 'disable'
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract( $atts );
	
	$banner_image = false;
	
	if( $bg_img_source == 'external_link' ){
		$banner_image[0] = $bg_img_link;
		$banner_image[1] = '';
		$banner_image[2] = '';
	}else{
		/* banner image is empty then return  */
		$banner_image = wp_get_attachment_image_src($bg_img, "full");
	}
	if( !isset($banner_image[0]) || empty($banner_image[0]) ){
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
	$pgscore_shortcodes[$shortcode_handle]['banner_image'] = $banner_image;
	$pgscore_shortcodes[$shortcode_handle]['show_hide_defaults'] = array( 'lg', 'md', 'sm', 'xs' );
	$pgscore_shortcodes[$shortcode_handle]['hide_classes'] = array( 'lg' => 'hidden-lg', 'md' => 'hidden-md', 'sm' => 'hidden-sm', 'xs' => 'hidden-xs' );
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('banner/content' );?>
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
	$shortcode_fields = array(
		array(
			'type'            => 'pgscore_notice',
			'param_name'      => 'banner_notice_warning',
			'notice_type'     => 'warning',
			'heading'         => esc_html__( 'Important Note', 'ciyashop' ),
			'message'         => esc_html__( 'If "Banner Image" is not selected/set, the shortcode content will not be rendered.', 'ciyashop' ),
			'display_header'  => true,
		),
		array(
			'type'                    => 'pgscore_radio_image',
			"heading"                 => esc_html__("Style", 'ciyashop' ),
			'param_name'              => 'style',
			'options'                 => array(
				'style-1' => get_parent_theme_file_uri('/images/shortcodes/fields/banner/style-1.png'),
				'deal-1'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1.png'),
				'deal-2'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-2.png'),
			),
			'show_label'              => true,
			'admin_label'             => true,
		),
		array(
			"type"                    => "dropdown",
			"class"                   => "",
			"heading"                 => esc_html__("Vertical Align", 'ciyashop' ),
			"description"             => esc_html__("Set banner text vertical position.", 'ciyashop' ),
			"param_name"              => "vertical_align",
			'value'                   => array_flip( array(
				'vtop'   => esc_html__('Top', 'ciyashop' ),
				'vmiddle'=> esc_html__('Middle', 'ciyashop' ),
				'vbottom'=> esc_html__('Bottom', 'ciyashop' ),
			) ),
			'std'                     => 'vtop',
			"edit_field_class"        => "vc_col-md-6",
			'admin_label'             => true,
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('style-1', 'deal-1'),
			),
		),
		array(
			"type"                    => "dropdown",
			"class"                   => "",
			"heading"                 => esc_html__("Horizontal Align", 'ciyashop' ),
			"description"             => esc_html__("Set banner text horizontal position", 'ciyashop' ),
			"param_name"              => "horizontal_align",
			'value'                   => array_flip( array(
				'hleft'  => esc_html__('Left', 'ciyashop' ),
				'hcenter'=> esc_html__('Center', 'ciyashop' ),
				'hright' => esc_html__('Right', 'ciyashop' ),
			) ),
			'std'                     => 'hleft',
			"edit_field_class"        => "vc_col-md-6",
			'admin_label'             => true,
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('style-1', 'deal-1'),
			),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Effect', 'ciyashop' ),
			'param_name'              => 'banner_effect',
			'value'                   => array_flip( array(
				'none'  => esc_html__('None', 'ciyashop' ),
				'border'=> esc_html__('Border', 'ciyashop' ),
				'flash' => esc_html__('Flash', 'ciyashop' ),
				'zoom'  => esc_html__('Zoom', 'ciyashop' ),
			) ),
			'std'                     => 'none',
			'description'             => esc_html__( 'Select banner effect type.', 'ciyashop' ),
			'save_always'             => true,
			'admin_label'             => true,
		),
		array(
			'type'                    => 'checkbox',
			'heading'                 => esc_html__('Banner Padding Responsive?', 'ciyashop' ),
			'param_name'              => 'banner_padding_responsive',
			'description'             => esc_html__( 'Select this checkbox to enable responsive banner padding for different width.', 'ciyashop' ),
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Banner Padding', 'ciyashop' ),
			'param_name'              => 'banner_css',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value_not_equal_to'  => 'true',
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-sm-6 vc_col-md-5 vc_col-lg-3 banner_css_wrap',
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Extra Large Devices (&ge;1200px)', 'ciyashop' ),
			'param_name'              => 'banner_padding_xl',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value'  			  => 'true',
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Large Devices (&ge;992px)', 'ciyashop' ),
			'param_name'              => 'banner_padding_lg',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value'  			  => 'true', 
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Medium Devices (&ge;768px)', 'ciyashop' ),
			'param_name'              => 'banner_padding_md',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value'               => 'true',
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Small Devices (&ge;576px)', 'ciyashop' ),
			'param_name'              => 'banner_padding_sm',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value'  			  => 'true',
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__('Extra Small Devices (<576px)', 'ciyashop' ),
			'param_name'              => 'banner_padding_xs',
			'dependency'              => array(
				'element'			  => 'banner_padding_responsive',
				'value'               => 'true',
			),
			'edit_field_class'        => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'                    => 'checkbox',
			"heading"                 => esc_html__("Font Size Responsive?", 'ciyashop' ),
			'param_name'              => 'font_size_responsive',
			'description'             => esc_html__( 'Select this checkbox to enable responsive font size for different width.', 'ciyashop' ),
		),
		array(
			'type'                    => 'pgscore_range_slider',
			'heading'                 => esc_html__( "Font Size", 'ciyashop' ),
			'param_name'              => 'font_size',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 70,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'           => 'font_size_responsive',
				'value_not_equal_to'=> 'true',
			),
		),
		/******************************************************/
		array(
			'type'                    => 'pgscore_range_slider',
			"heading"                 => esc_html__("Extra Large Devices (&ge;1200px)", 'ciyashop' ),
			'param_name'              => 'font_size_xl',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 70,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'=> 'font_size_responsive',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_range_slider',
			"heading"                 => esc_html__("Large Devices (&ge;992px)", 'ciyashop' ),
			'param_name'              => 'font_size_lg',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 60,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'=> 'font_size_responsive',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_range_slider',
			"heading"                 => esc_html__("Medium Devices (&ge;768px)", 'ciyashop' ),
			'param_name'              => 'font_size_md',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 50,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'=> 'font_size_responsive',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_range_slider',
			"heading"                 => esc_html__("Small Devices (&ge;576px)", 'ciyashop' ),
			'param_name'              => 'font_size_sm',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 40,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'=> 'font_size_responsive',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_range_slider',
			"heading"                 => esc_html__("Extra Small Devices (<576px)", 'ciyashop' ),
			'param_name'              => 'font_size_xs',
			'tooltip'                 => esc_html__( 'Choose font size', 'ciyashop' ),
			'min'                     => 10,
			'max'                     => 100,
			'value'                   => 30,
			'unit'                    => 'px',
			'dependency'              => array(
				'element'=> 'font_size_responsive',
				'value'  => 'true',
			),
		),
		/******************************************************/
		array(
			'type'                    => 'param_group',
			'param_name'              => 'list_items',
			'group'                   => esc_html__( 'List Items', 'ciyashop' ),
			'max_items'               => 5,
			'sortable'                => true,
			'deletable'               => true,
			'collapsible'             => true,
			'params'                  => array(
				array(
					"type"            => "textfield",
					"param_name"      => "title",
					"heading"         => esc_html__( "Title", 'ciyashop' ),
					'description'     => esc_html__( "Add banner text.", 'ciyashop' ),
					'admin_label'     => true,
				),
				array(
					'type'                    => 'checkbox',
					"heading"                 => esc_html__('Use google fonts ?', 'ciyashop' ),
					'param_name'              => 'use_google_font',
					'value'           		  => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
					'description'             => esc_html__( 'Select this checkbox to use google fonts.', 'ciyashop' ),
				),
				array(
					'type'       => 'google_fonts',
					'param_name' => 'banner_google_fonts',
					'settings'   => array(
						'fields' => array(
							'font_family_description' => __( 'Select font family.', 'ciyashop' ),
							'font_style_description'  => __( 'Select font styling.', 'ciyashop' ),
						),
					),
					'dependency' => array(
						'element'=> 'use_google_font',
						'value'  => 'yes',
					),
				),
				array(
					"type"                    => "dropdown",
					"param_name"              => "google_font_enqueue_source",
					"heading"                 => esc_html__( 'Google Fonts Enqueue Source', 'ciyashop' ),
					'description'             => esc_html__( 'Choose the source of Google Fonts CSS. On selecting Default option, Visual Composer will enqueue CSS directly from Google Fonts. And, the Manual option will use fonts loaded for site contents.', 'ciyashop' ),
					'value'                   => array_flip( array(
						'default' => esc_html__( 'Default', 'ciyashop' ),
						'manual'  => esc_html__( 'Manual', 'ciyashop' ),
					) ),
					'dependency' => array(
						'element'			 => 'use_google_font',
						'value'              => 'yes',
					),
					"std"                     => "default",
				),
				array(
					'type'            => 'pgscore_number_min_max',
					'heading'         => esc_html__( "Font Size (Ratio to Main Font)", 'ciyashop' ),
					'param_name'      => 'font_size',
					'min'             => 10,
					'max'             => 100,
					'value'           => 70,
					'suffix'          => '%',
					'description'     => esc_html__('Enter/select font size. This font-size will be in ratio of main font-size.', 'ciyashop' ),
					"edit_field_class"=> "vc_col-md-4",
					'admin_label'     => true,
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Color', 'ciyashop' ),
					'param_name'      => 'color',
					'description'     => esc_html__( 'Select text color.', 'ciyashop' ),
					'value'           => '#323232',
					"edit_field_class"=> "vc_col-md-4",
					'admin_label'     => true,
				),
				array(
					'type'            => 'colorpicker',
					'heading'         => esc_html__( 'Background Color', 'ciyashop' ),
					'param_name'      => 'bg_color',
					'description'     => esc_html__( 'Select text background color.', 'ciyashop' ),
					"edit_field_class"=> "vc_col-md-4",
					'admin_label'     => true,
				),
				array(
					"type"                    => "pgscore_divider",
					"param_name"              => "font_style_divider",
				),
				array(
					"type"                    => "dropdown",
					"param_name"              => "font_style",
					"heading"                 => esc_html__("Font Style", 'ciyashop' ),
					"description"             => esc_html__("Select font style.", 'ciyashop' ),
					'value'                   => array_flip( array(
						''       => esc_html__( 'Select Font Style', 'ciyashop' ),
						'normal' => esc_html__( 'Normal', 'ciyashop' ),
						'italic' => esc_html__( 'Italic', 'ciyashop' ),
						'oblique'=> esc_html__( 'Oblique', 'ciyashop' ),
						'initial'=> esc_html__( 'Initial', 'ciyashop' ),
						'inherit'=> esc_html__( 'Inherit', 'ciyashop' ),
					) ),
					'dependency' => array(
						'element'			 => 'use_google_font',
						'value_not_equal_to' => 'yes',
					),
					"std"                     => "normal",
					"edit_field_class"=> "vc_col-md-4",
				),
				array(
					"type"                    => "dropdown",
					"param_name"              => "font_weight",
					"heading"                 => esc_html__("Font Weight", 'ciyashop' ),
					"description"             => esc_html__("Select font weight.", 'ciyashop' ),
					'value'                   => array_flip( array(
						''       => esc_html__( 'Select Font Weight', 'ciyashop' ),
						'normal' => esc_html__( 'Normal', 'ciyashop' ),
						'bold'   => esc_html__( 'Bold', 'ciyashop' ),
						'bolder' => esc_html__( 'Bolder', 'ciyashop' ),
						'lighter'=> esc_html__( 'Lighter', 'ciyashop' ),
						'100'    => esc_html__( '100', 'ciyashop' ),
						'200'    => esc_html__( '200', 'ciyashop' ),
						'300'    => esc_html__( '300', 'ciyashop' ),
						'400'    => esc_html__( '400', 'ciyashop' ),
						'500'    => esc_html__( '500', 'ciyashop' ),
						'600'    => esc_html__( '600', 'ciyashop' ),
						'700'    => esc_html__( '700', 'ciyashop' ),
						'800'    => esc_html__( '800', 'ciyashop' ),
						'900'    => esc_html__( '900', 'ciyashop' ),
						'initial'=> esc_html__( 'Initial', 'ciyashop' ),
						'inherit'=> esc_html__( 'Inherit', 'ciyashop' ),
					) ),
					'dependency' => array(
						'element'            => 'use_google_font',
						'value_not_equal_to' => 'yes',
					),
					"std"                     => "400",
					"edit_field_class"=> "vc_col-md-4",
				),
				array(
					"type"                    => "dropdown",
					"param_name"              => "text_transform",
					"heading"                 => esc_html__("Text Transform", 'ciyashop' ),
					"description"             => esc_html__("Select text transformation.", 'ciyashop' ),
					'value'                   => array_flip( array(
						''          => esc_html__( 'Select Text Transform', 'ciyashop' ),
						'none'      => esc_html__('None', 'ciyashop' ),
						'capitalize'=> esc_html__('Capitalize', 'ciyashop' ),
						'uppercase' => esc_html__('Uppercase', 'ciyashop' ),
						'lowercase' => esc_html__('Lowercase', 'ciyashop' ),
						'initial'   => esc_html__('Initial', 'ciyashop' ),
						'inherit'   => esc_html__('Inherit', 'ciyashop' ),
						'unset'     => esc_html__('Unset', 'ciyashop' ),
					) ),
					"std"                     => "",
					"edit_field_class"=> "vc_col-md-4",
				),
				array(
					'type'            => 'pgscore_number_min_max',
					'heading'         => esc_html__( "Letter Spacing", 'ciyashop' ),
					'param_name'      => 'letter_spacing',
					'min'             => 0,
					'max'             => 100,
					'value'           => 0,
					'suffix'          => 'px',
					'description'     => esc_html__('Enter/select letter spacing.', 'ciyashop' ),
					"edit_field_class"=> "vc_col-md-4",
				),
				array(
					"type"            => "textfield",
					'heading'         => esc_html__( "Line Height", 'ciyashop' ),
					'param_name'      => 'line_height',
					'description'     => esc_html__( 'Enter line height i.e. 10px, 1em, or 100%. If you want to add value in decimal like [.5em], then use complete decimal format like [0.5em]. Allowed units are px, em, and %.', 'ciyashop' ),
					"edit_field_class"=> "vc_col-md-4",
				),
				array(
					'type'            => 'checkbox',
					"heading"         => esc_html__("Responsive", 'ciyashop' ),
					'description'     => esc_html__( 'Select checkbox(es) to show/hide on text on specific device size.', 'ciyashop' ),
					'param_name'      => 'text_show_hide',
					'value'           => array_flip( array(
						'xl'          => esc_html__("Extra Large Devices (&ge;1200px)", 'ciyashop' ),
						'lg'          => esc_html__("Large Devices (&ge;992px)", 'ciyashop' ),
						'md'          => esc_html__("Medium Devices (&ge;768px)", 'ciyashop' ),
						'sm'          => esc_html__("Small Devices (&ge;576px)", 'ciyashop' ),
						'xs'          => esc_html__("Extra small Devices (<576px)", 'ciyashop' ),
					) ),
					'std'             => 'xl,lg,md,sm,xs',
					"edit_field_class"=> "vc_col-md-12",
				),
			),
			'value'                   => urlencode( json_encode( array(
				array(
					'title'           => esc_html__( 'Lorem Ipsum', 'ciyashop' ),
					'font_size'       => '70',
					'color'           => '#323232',
					'text_show_hide'  => 'xl,lg,md,sm,xs',
				),
			) ) ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Image source', 'ciyashop' ),
			'param_name' => 'bg_img_source',
			'description'=> esc_html__( 'Select image source.', 'ciyashop' ),
			'value'     => array_flip( array(
				'media_library'  => esc_html__( 'Media library', 'ciyashop' ),
				'external_link'  => esc_html__( 'External link', 'ciyashop' ),
			) ),
			'std'         => 'media_library',
		),
		array(
			"type"                    => "attach_image",
			"param_name"              => "bg_img",
			"heading"                 => esc_html__("Banner Image", 'ciyashop' ),
			"description"             => esc_html__("Select/upload banner image.", 'ciyashop' ),
			"holder"                  => "img",
			'dependency'              => array(
				'element'=> 'bg_img_source',
				'value'  => 'media_library',
			),
		),
		array(
			'type'                    => 'checkbox',
			'heading'                 => esc_html__('Banner Link ?', 'ciyashop' ),
			'param_name'              => 'banner_link_enable',
			'description'             => esc_html__( 'Select this checkbox to add link on banner.', 'ciyashop' ),
		),
		array(
			'type'                    => 'vc_link',
			'heading'                 => esc_html__( 'Banner URL (Link)', 'ciyashop' ),
			'param_name'              => 'banner_link_url',
			'description'             => esc_html__( 'Add custom link on banner.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value'  => 'true',
			),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'bg_img_link',
			'heading'    => esc_html__( 'Banner Image', 'ciyashop' ),
			'description'=> esc_html__( 'Enter banner image link.', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'bg_img_source',
				'value'  => 'external_link',
			),
			'admin_label' => true,
		),
		
		// Button
		array(
			"type"                    => "textfield",
			"class"                   => "",
			"heading"                 => esc_html__( 'Button Title', 'ciyashop' ),
			"param_name"              => "button_text",
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'admin_label'             => true,
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "button_style",
			"heading"                 => esc_html__("Button Style", 'ciyashop' ),
			"description"             => esc_html__("Select button style.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'link'  => esc_html__('Link', 'ciyashop' ),
				'flat'  => esc_html__('Flat', 'ciyashop' ),
				'border'=> esc_html__('Border', 'ciyashop' ),
			) ),
			"std"                     => "link",
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-4",
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "button_size",
			"heading"                 => esc_html__("Button Size", 'ciyashop' ),
			"description"             => esc_html__("Select button size.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'xs'=> esc_html__('Extra Small', 'ciyashop' ),
				'sm'=> esc_html__('Small', 'ciyashop' ),
				'md'=> esc_html__('Medium', 'ciyashop' ),
				'lg'=> esc_html__('Large', 'ciyashop' ),
			) ),
			"std"                     => "md",
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'flat', 'border' ),
			),
			"edit_field_class"        => "vc_col-md-4",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "button_shape",
			"heading"                 => esc_html__("Button Shape", 'ciyashop' ),
			"description"             => esc_html__("Select button shape.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'square' => esc_html__('Square', 'ciyashop' ),
				'rounded'=> esc_html__('Rounded', 'ciyashop' ),
				'round'  => esc_html__('Round', 'ciyashop' ),
			) ),
			"std"                     => "square",
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'flat', 'border' ),
			),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-4",
		),
		array(
			'type'            => 'hidden',
			'param_name'      => 'button_sep_1',
			'group'           => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-12",
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Text Color', 'ciyashop' ),
			'param_name'              => 'button_text_color',
			'description'             => esc_html__( 'Select button text color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-6",
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Background Color', 'ciyashop' ),
			'param_name'              => 'button_color',
			'description'             => esc_html__( 'Select button background color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'flat' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Border Color', 'ciyashop' ),
			'param_name'              => 'button_border_color',
			'description'             => esc_html__( 'Select button border color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'border' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'            => 'hidden',
			'param_name'      => 'button_sep_2',
			'group'           => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-12",
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Text Hover Color', 'ciyashop' ),
			'param_name'              => 'button_hover_text_color',
			'description'             => esc_html__( 'Select button text hover color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-6",
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Hover Background Color', 'ciyashop' ),
			'param_name'              => 'button_hover_background_color',
			'description'             => esc_html__( 'Select button hover background color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'flat' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Button Hover Border Color', 'ciyashop' ),
			'param_name'              => 'button_hover_border_color',
			'description'             => esc_html__( 'Select button hover border color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'border' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'                    => 'pgscore_number_min_max',
			'heading'                 => esc_html__( "Button Border Width", 'ciyashop' ),
			'param_name'              => 'button_border_width',
			'min'                     => 1,
			'max'                     => 15,
			'value'                   => 1,
			'suffix'                  => 'px',
			'description'             => esc_html__('Enter/select button border width.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'button_style',
				'value'  => array( 'border' ),
			),
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "button_text_transform",
			"heading"                 => esc_html__("Text Transform", 'ciyashop' ),
			"description"             => esc_html__("Select text transformation.", 'ciyashop' ),
			'value'                   => array_flip( array(
				''          => esc_html__( 'Select Text Transform', 'ciyashop' ),
				'none'      => esc_html__('None', 'ciyashop' ),
				'capitalize'=> esc_html__('Capitalize', 'ciyashop' ),
				'uppercase' => esc_html__('Uppercase', 'ciyashop' ),
				'lowercase' => esc_html__('Lowercase', 'ciyashop' ),
				'initial'   => esc_html__('Initial', 'ciyashop' ),
				'inherit'   => esc_html__('Inherit', 'ciyashop' ),
				'unset'     => esc_html__('Unset', 'ciyashop' ),
			) ),
			"std"                     => "",
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__( "Letter Spacing", 'ciyashop' ),
			'param_name'      => 'button_letter_spacing',
			'min'             => 0,
			'max'             => 100,
			'value'           => 0,
			'suffix'          => 'px',
			'description'     => esc_html__('Enter/select letter spacing.', 'ciyashop' ),
			'group'           => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			"type"       => "textfield",
			'heading'    => esc_html__( "Line Height", 'ciyashop' ),
			'param_name' => 'button_line_height',
			'description'=> esc_html__( 'Enter line height i.e. 10px, 1em, or 100%. If you want to add value in decimal like ".5em", then use complete decimal format like "0.5em". Allowed units are px, em, and %.', 'ciyashop' ),
			'group'      => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		array(
			'type'                    => 'vc_link',
			'heading'                 => esc_html__( 'URL (Link)', 'ciyashop' ),
			'param_name'              => 'link_url',
			'description'             => esc_html__( 'Add custom link.', 'ciyashop' ),
			'group'                   => esc_html__( 'Button', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'banner_link_enable',
				'value_not_equal_to'  => 'true',
			),
		),
		
		// Badge
		array(
			'type'                    => 'checkbox',
			"heading"                 => esc_html__("Add Badge", 'ciyashop' ),
			'param_name'              => 'add_badge',
			'description'             => esc_html__( 'Select this checkbox to add badge.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => 'style-1',
			),
		),
		array(
			"type"                    => "textfield",
			"param_name"              => "badge_title",
			"heading"                 => esc_html__( "Title", 'ciyashop' ),
			'description'             => esc_html__( "Add badge title.", 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-9",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "badge_type",
			"heading"                 => esc_html__("Badge Type", 'ciyashop' ),
			"description"             => esc_html__("Select badge style.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'border'=> esc_html__('Border', 'ciyashop' ),
				'flat'  => esc_html__('Flat', 'ciyashop' ),
			) ),
			"std"                     => "border",
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-3",
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Text Color', 'ciyashop' ),
			'param_name'              => 'badge_text_color',
			'description'             => esc_html__( 'Select badge text color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'value'                   => '#323232',
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Background Color', 'ciyashop' ),
			'param_name'              => 'badge_background_color',
			'description'             => esc_html__( 'Select badge background color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'value'                   => '#ffffff',
			'dependency'              => array(
				'element'=> 'badge_type',
				'value'  => array( 'flat' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			"type"                    => "pgscore_divider",
			"param_name"              => "badge_border_fields_divider",
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_number_min_max',
			'heading'                 => esc_html__( "Badge Border Width", 'ciyashop' ),
			'param_name'              => 'badge_border_width',
			'min'                     => 1,
			'max'                     => 15,
			'value'                   => 1,
			'suffix'                  => 'px',
			'description'             => esc_html__('Enter/select badge border width.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-6",
			'dependency'              => array(
				'element'=> 'badge_type',
				'value'  => array( 'border' ),
			),
		),
		array(
			'type'                    => 'colorpicker',
			'heading'                 => esc_html__( 'Border Color', 'ciyashop' ),
			'param_name'              => 'badge_border_color',
			'description'             => esc_html__( 'Select badge border color.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'value'                   => '#323232',
			'dependency'              => array(
				'element'=> 'badge_type',
				'value'  => array( 'border' ),
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'                    => 'pgscore_number_min_max',
			'heading'                 => esc_html__( "Badge Width", 'ciyashop' ),
			'param_name'              => 'badge_width',
			'min'                     => 10,
			'max'                     => 200,
			'value'                   => 70,
			'suffix'                  => 'px',
			'description'             => esc_html__('Enter/select badge width.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			"edit_field_class"        => "vc_col-md-6",
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
		),
		array(
			'type'                    => 'pgscore_number_min_max',
			'heading'                 => esc_html__( "Badge Height", 'ciyashop' ),
			'param_name'              => 'badge_height',
			'min'                     => 10,
			'max'                     => 200,
			'value'                   => 70,
			'suffix'                  => 'px',
			'description'             => esc_html__('Enter/select badge height.', 'ciyashop' ),
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"heading"                 => esc_html__("Vertical Align", 'ciyashop' ),
			"description"             => esc_html__("Set badge vertical position.", 'ciyashop' ),
			"param_name"              => "badge_vertical_align",
			'value'                   => array_flip( array(
				'vtop'   => esc_html__('Top', 'ciyashop' ),
				'vmiddle'=> esc_html__('Middle', 'ciyashop' ),
				'vbottom'=> esc_html__('Bottom', 'ciyashop' ),
			) ),
			'std'                     => 'vbottom',
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"heading"                 => esc_html__("Horizontal Align", 'ciyashop' ),
			"description"             => esc_html__("Set badge horizontal position.", 'ciyashop' ),
			"param_name"              => "badge_horizontal_align",
			'value'                   => array_flip( array(
				'hleft'  => esc_html__('Left', 'ciyashop' ),
				'hcenter'=> esc_html__('Center', 'ciyashop' ),
				'hright' => esc_html__('Right', 'ciyashop' ),
			) ),
			'std'                     => 'hright',
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"        => "vc_col-md-6",
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__( "Font Size", 'ciyashop' ),
			'param_name'      => 'badge_font_size',
			'min'             => 10,
			'max'             => 100,
			'value'           => 20,
			'suffix'          => 'px',
			'description'     => esc_html__('Enter/select font size.', 'ciyashop' ),
			'group'           => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'pgscore_number_min_max',
			'heading'         => esc_html__( "Line Height", 'ciyashop' ),
			'param_name'      => 'badge_line_height',
			'min'             => 0,
			'max'             => 100,
			'suffix'          => 'px',
			'description'     => esc_html__('Enter/select line height.', 'ciyashop' ),
			'group'           => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "badge_font_weight",
			"heading"                 => esc_html__("Font Weight", 'ciyashop' ),
			"description"             => esc_html__("Select font weight.", 'ciyashop' ),
			'value'                   => array_flip( array(
				''       => esc_html__( 'Select Font Weight', 'ciyashop' ),
				'normal' => esc_html__( 'Normal', 'ciyashop' ),
				'bold'   => esc_html__( 'Bold', 'ciyashop' ),
				'bolder' => esc_html__( 'Bolder', 'ciyashop' ),
				'lighter'=> esc_html__( 'Lighter', 'ciyashop' ),
				'100'    => esc_html__( '100', 'ciyashop' ),
				'200'    => esc_html__( '200', 'ciyashop' ),
				'300'    => esc_html__( '300', 'ciyashop' ),
				'400'    => esc_html__( '400', 'ciyashop' ),
				'500'    => esc_html__( '500', 'ciyashop' ),
				'600'    => esc_html__( '600', 'ciyashop' ),
				'700'    => esc_html__( '700', 'ciyashop' ),
				'800'    => esc_html__( '800', 'ciyashop' ),
				'900'    => esc_html__( '900', 'ciyashop' ),
				'initial'=> esc_html__( 'Initial', 'ciyashop' ),
				'inherit'=> esc_html__( 'Inherit', 'ciyashop' ),
			) ),
			"std"                     => "600",
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "badge_text_transform",
			"heading"                 => esc_html__("Text Transform", 'ciyashop' ),
			"description"             => esc_html__("Select text transformation.", 'ciyashop' ),
			'value'                   => array_flip( array(
				''          => esc_html__( 'Select Text Transform', 'ciyashop' ),
				'none'      => esc_html__('None', 'ciyashop' ),
				'capitalize'=> esc_html__('Capitalize', 'ciyashop' ),
				'uppercase' => esc_html__('Uppercase', 'ciyashop' ),
				'lowercase' => esc_html__('Lowercase', 'ciyashop' ),
				'initial'   => esc_html__('Initial', 'ciyashop' ),
				'inherit'   => esc_html__('Inherit', 'ciyashop' ),
				'unset'     => esc_html__('Unset', 'ciyashop' ),
			) ),
			"std"                     => "",
			'group'                   => esc_html__( 'Badge', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'add_badge',
				'value'  => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		
		
		
		array(
			"type"       => "pgscore_datepicker",
			"class"      => "",
			"heading"    => esc_html__( "Deal Date", 'ciyashop' ),
			"param_name" => "deal_date",
			"value"      => '',
			"description"=> esc_html__( "Enter deal date.", 'ciyashop' ),
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-1', 'deal-2'),
			),
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__("Expire Message", 'ciyashop' ),
			"param_name" => "expire_message",
			"value"      => esc_html__('This offer has expired!', 'ciyashop' ),
			"description"=> esc_html__( "Enter message to display, instead of date counter, when deal is expired.", 'ciyashop' ),
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-1', 'deal-2'),
			),
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
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-2'),
			),
		),
		array(
			'type'                    => 'pgscore_radio_image',
			'heading'                 => esc_html__('Counter Style', 'ciyashop' ),
			'description'             => esc_html__('Select deal counter style.', 'ciyashop' ),
			'param_name'              => 'counter_style',
			'options'                 => array(
				'style-1'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_1.jpg'),
				'style-2'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_2.jpg'),
				'style-3'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_3.jpg'),
				'style-4'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_4.jpg'),
				'style-5'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_5.jpg'),
				'style-6'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_6.jpg'),
				'style-7'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_7.jpg'),
				'style-8'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_8.jpg'),
				'style-9'  => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_9.jpg'),
				'style-10' => get_parent_theme_file_uri('/images/shortcodes/fields/banner/deal-1/style_10.jpg'),
			),
			'show_label'              => true,
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-1'),
			),
		),
		array(
			'type'                    => 'css_editor',
			'heading'                 => esc_html__( 'Deal Padding', 'ciyashop' ),
			'param_name'              => 'deal_css',
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-1', 'deal-2'),
			),
			"edit_field_class"        => "vc_col-sm-12 vc_col-sm-6 vc_col-md-5 vc_col-lg-3 banner_css_wrap",
		),
		array(
			"type"                    => "dropdown",
			"heading"                 => esc_html__("On Expire Button?", 'ciyashop' ),
			"description"             => esc_html__("Select status of button on deal expire.", 'ciyashop' ),
			"param_name"              => "on_expire_btn",
			'value'                   => array_flip( array(
				'disable'  => esc_html__('Disable', 'ciyashop' ),
				'remove'   => esc_html__('Remove', 'ciyashop' ),
			) ),
			'std'                     => 'disable',
			'group'      => esc_html__( 'Deal Details', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'style',
				'value'  => array('deal-1', 'deal-2'),
			),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params                      = array(
		"name"                   => esc_html__( "Banner", 'ciyashop' ),
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