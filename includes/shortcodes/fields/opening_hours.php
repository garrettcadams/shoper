<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_opening_hours
 * 
 ******************************************************************************/
function pgscore_shortcode_opening_hours( $atts, $content = null, $shortcode_handle = '' ) {
	
	$default_custom = array(
		'title'         => '',
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
		<?php pgscore_get_shortcode_templates('opening_hours/content' );?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

/******************************************************************************
 * 
 * Visual Composer Integration
 * 
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	$shortcode_fields = array(
		array(
			'type'       	=> 'textfield',
			'heading'    	=> esc_html__('Title', 'ciyashop' ),
			'param_name' 	=> 'title',
			'admin_label'   => true,
			'value'         => esc_html__( 'Opening Hours', 'ciyashop' ),
			'description'	=> esc_html__( 'To display the timing you have to add the time in theme options at "Appearance > Theme Options > Site Info > Opening Hours".', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params                      = array(
		"name"                   => esc_html__( "Opening Hours", 'ciyashop' ),
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