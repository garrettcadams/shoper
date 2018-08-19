<?php
/******************************************************************************
 *
 * Shortcode : pgscore_list
 *
 ******************************************************************************/
function pgscore_shortcode_list( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'           => 'style-1',
		'add_icon'        => false,
		'list_items'      => '',
		'icon_type'       => 'fontawesome',
		'icon_fontawesome'=> 'fa fa-info-circle',
		'icon_openiconic' => 'vc-oi vc-oi-dial',
		'icon_typicons'   => 'typcn typcn-adjust-brightness',
		'icon_entypo'     => 'entypo-icon entypo-icon-note',
		'icon_linecons'   => 'vc_li vc_li-heart',
		'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'   => 'vc-material vc-material-cake',
		'icon_pixelicons' => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'   => '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	// List Items
	$list_items = ( function_exists('vc_param_group_parse_atts') ) ? vc_param_group_parse_atts($list_items) : ciyashop_param_group_parse_atts($list_items);
	
	// Return if no list items found
	if( !is_array( $list_items ) || empty( $list_items ) || ( (count($list_items) == 1) && empty( $list_items[0] ) ) ) {
		return;
	}
	
	/**********************************************************
	 * 
	 * Icons Settings
	 * 
	 **********************************************************/
	$icon_html = $icon_class = '';
	
	if( !empty($add_icon) && $add_icon == 'true' ){
		$icon_wrapper = false;
		
		if ( isset( ${'icon_' . $icon_type} ) && !empty(${'icon_' . $icon_type}) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${'icon_' . $icon_type};
		}
		
		if( $icon_class ){
			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_html = '<i class="' . esc_attr( $icon_class ) . '"></i>';
			}
		
			// Enqueue icon CSS for icon type
			if( function_exists('vc_icon_element_fonts_enqueue') ){
				vc_icon_element_fonts_enqueue( $icon_type );
			}
		}
	}
	
	// List Classes
	$list_classes = array();
	$list_classes[] = 'pgscore_list list';
	if( $style ){
		$list_classes[] = 'pgscore_list_'.esc_attr($style);
	}
	if( !empty($add_icon) && $add_icon == 'true' && !empty($icon_html) ){
		$list_classes[] = 'list-unstyled';
	}
	
	$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );
	
	/**********************************************************
	 * 
	 * Element Classes
	 * For base wrapper
	 * 
	 **********************************************************/
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts']        = $atts;
	$pgscore_shortcodes[$shortcode_handle]['list_items']  = $list_items;
	$pgscore_shortcodes[$shortcode_handle]['icon_html']   = $icon_html;
	$pgscore_shortcodes[$shortcode_handle]['list_classes']= $list_classes;
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('list/content', $style );?>
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
			'type'      => 'checkbox',
			'heading'   => esc_html__( 'Add Icon?', 'ciyashop' ),
			'param_name'=> 'add_icon',
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'list_items',
			'group'      => esc_html__( 'List Items', 'ciyashop' ),
			'params'     => array(
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Content', 'ciyashop' ),
					'param_name'       => 'content',
					'tooltip'          => esc_html__( 'Add item content.', 'ciyashop' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__('Content Link', 'ciyashop' ),
					'param_name'  => 'content_link',
					'admin_label' => true,
				),
			),
		),
	);

	$pgscore_iconpicker_args = array(
		'dependency' => array(
			'element'=> 'add_icon',
			'value'  => 'true',
		),
	);

	// Merge icon fields
	$shortcode_fields = array_merge(
		$shortcode_fields,
		pgscore_iconpicker($pgscore_iconpicker_args)
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                    => esc_html__( "List", 'ciyashop' ),
		"description"             => esc_html__( "Display list items.", 'ciyashop' ),
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