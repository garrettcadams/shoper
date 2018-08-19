<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_newsletter
 * 
 ******************************************************************************/
function pgscore_shortcode_newsletter( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'            	 => 'style-1',
		'newsletter_design'  => '',
		'title'            	 => '',
		'description'      	 => '',
		'content_alignment'	 => 'right',
		'bg_type' 		   	 => 'light',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
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
		<?php pgscore_get_shortcode_templates('newsletter/content' );?>
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
			'type'            => 'pgscore_notice',
			'param_name'      => 'banner_notice_warning',
			'notice_type'     => 'warning',
			'heading'         => esc_html__( 'Important Note', 'ciyashop' ),
			'message'         => esc_html__( 'MailChimp API key and List ID settings are moved in Theme Options. So, please update settings over there.', 'ciyashop' ),
			'display_header'  => true,
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'ciyashop' ),
			'param_name' => 'style',
			'value'     => array(
				esc_html__( 'Style 1', 'ciyashop' ) => 'style-1',
				esc_html__( 'Style 2', 'ciyashop' )   => 'style-2',
				esc_html__( 'Style 3', 'ciyashop' )   => 'style-3',
			),
			'admin_label'=> true,
		),
		array(
			'type'            => 'pgscore_radio_image2',
			'param_name'      => 'newsletter_design',
			'heading'         => esc_html__('Newsletter Designs', 'ciyashop' ),
			'description'     => esc_html__('Select style.', 'ciyashop' ),
			'options'         => array(
				array(
					'value' => 'design-1',
					'title' => 'Design 1',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_1.jpg'),
				),
				array(
					'value' => 'design-2',
					'title' => 'Design 2',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_2.jpg'),
				),
				array(
					'value' => 'design-3',
					'title' => 'Design 3',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_3.jpg'),
				),
				array(
					'value' => 'design-4',
					'title' => 'Design 4',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_4.jpg'),
				),
				array(
					'value' => 'design-5',
					'title' => 'Design 5',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_5.jpg'),
				),
				array(
					'value' => 'design-6',
					'title' => 'Design 6',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/newsletter/style_6.jpg'),
				),
			),
			'description'     => esc_html__('Select the newsletter design', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'style',
				'value'  => 'style-1',
			),
			'save_always'     => true,
			'admin_label'     => true,
		),
		array(
			"type"            => "textfield",
			"class"           => "pgscore_newsletter_title",
			"heading"         => esc_html__("Title", 'ciyashop' ),
			"description"     => esc_html__("Enter title here", 'ciyashop' ),
			"param_name"      => "title",
			'value'           => "",
			'admin_label'     => true,
		),
		array(
			'type'            => 'textfield',
			'heading'         => esc_html__( 'Description', 'ciyashop' ),
			'param_name'      => 'description',
			"description"     => esc_html__("Enter description. Please ensure to add short content.", 'ciyashop' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Content Alignment', 'ciyashop' ),
			'param_name' => 'content_alignment',
			'value'     => array(
				esc_html__( 'Right', 'ciyashop' ) 	=> 'right',
				esc_html__( 'Center', 'ciyashop' )  => 'center',
				esc_html__( 'Left', 'ciyashop' )   	=> 'left',
			),
			'admin_label'=> true,
			'dependency' => array(
				'element'=> 'style',
				'value'  => 'style-2',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Content Background', 'ciyashop' ),
			'param_name' => 'bg_type',
			'value'     => array(
				esc_html__( 'Light', 'ciyashop' ) => 'light',
				esc_html__( 'Dark', 'ciyashop' )   => 'dark',
			),
			'admin_label'=> true,
			'dependency' => array(
				'element'=> 'style',
				'value'  => 'style-2',
			),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Newsletter", 'ciyashop' ),
		"description"            => esc_html__( "Display mailchimp newsletter form.", 'ciyashop' ),
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