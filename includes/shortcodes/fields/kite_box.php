<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_kite_box
 * 
 ******************************************************************************/

function pgscore_shortcode_kite_box( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
	
		'kitebox_images'               	=> '',
		'kitebox_content'               => '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );
	
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
		<?php pgscore_get_shortcode_templates('kite_box/content' );?>
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
			'type'            => 'pgscore_notice',
			'param_name'      => 'kitebox_images_warning',
			'notice_type'     => 'error',
			'heading'         => esc_html__( 'Important Note', 'ciyashop' ),
			'message'         => esc_html__( 'Select SQUARE image, with minimum 700px * 700px resolution. Otherwise, structure looks broken.', 'ciyashop' ),
			'display_header'  => false,
			'group'           => esc_html__( 'Images', 'ciyashop' ),
		),
		array(
			'type'            => 'param_group',
			'param_name'      => 'kitebox_images',
			'max_items'		  => 4,
			'description'     => esc_html__( 'You can add maximum four images.', 'ciyashop' ),
			'params'          => array(
				array(
					"type"        => "attach_image",
					"heading"     => esc_html__("Image", 'ciyashop' ),
					"param_name"  => "content_image",
				),
				array(
					'type'            => 'textfield',
					'heading'         => esc_html__('Title', 'ciyashop' ),
					'param_name'      => 'image_title',
					'admin_label'     => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Enable Button', 'ciyashop' ),
					'param_name'  => 'kitebox_image_enable_link',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Button Text', 'ciyashop' ),
					'param_name'  => 'kite_box_image_button_text',
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'kitebox_image_enable_link',
						'value'   => 'true',
					),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__('Button Link', 'ciyashop' ),
					'description' => esc_html__('Select/enter url.', 'ciyashop' ),
					'param_name'  => 'kite_box_content_button_link',
					'dependency'  => array(
						'element' => 'kitebox_image_enable_link',
						'value'   => 'true',
					),
				),
			),
			'group'    => esc_html__( 'Images', 'ciyashop' ),
		),
		array(
			'type'            => 'param_group',
			'max_items'		  => 3,
			'param_name'      => 'kitebox_content',
			'description'     => esc_html__( 'You can add maximum three elements.', 'ciyashop' ),
			'params'          => array(
				array(
					'type'            => 'textfield',
					'heading'         => esc_html__('Title', 'ciyashop' ),
					'param_name'      => 'content_title',
					'admin_label'     => true,
				),
				array(
					'type'            => 'textfield',
					'heading'         => esc_html__('Description', 'ciyashop' ),
					'param_name'      => 'content_description',
					'admin_label'     => true,
				),
			),
			'group'    => esc_html__( 'Content', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Kite Box", 'ciyashop' ),
		"description"            => esc_html__( "Display Kite Shaped Content.", 'ciyashop' ),
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