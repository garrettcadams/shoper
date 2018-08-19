<?php
/******************************************************************************
 *
 * Shortcode : pgscore_instagram_v2
 *
 ******************************************************************************/
function pgscore_shortcode_instagram_v2( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'              => 'default',
		'list_type'          => 'grid',
		
		'username'           => '',
		
		// Title
		'show_title'         => '',
		'title_el'           => 'h3',
		'title'              => '',
		
		// Button
		'show_button'        => '',
		'button_text'        => esc_html__( 'Follow us', 'ciyashop' ),
		'button_link'        => '|||',
		'show_icon'          => '',
		
		'image_display_target'=> 'instagram',
		
		// Instagram Items Settings
		'item_count'         => '12',
		'show_likes'         => '',
		'show_comments'      => '',
		'image_size'         => 'thumbnail',
		
		// Grid Settings
		'grid_col_xl'        => '6',
		'grid_col_lg'        => '4',
		'grid_col_md'        => '3',
		'grid_col_sm'        => '2',
		'grid_col_xs'        => '2',
		
		// Carousel Settings
		'carousel_pagination'=> '',
		'carousel_arrow'     => '',
		'carousel_gapping'   => '0',
		'carousel_items_xl'  => '5',
		'carousel_items_lg'  => '4',
		'carousel_items_md'  => '3',
		'carousel_items_sm'  => '2',
		'carousel_items_xs'  => '1',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract($atts);
	
	$images = ciyashop_scrape_instagram($username, $item_count);
	
	if( !$images || !is_array($images) || empty($images) ) return;
	
	/**********************************************************
	 * 
	 * Element Classes
	 * For base wrapper
	 * 
	**********************************************************/
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['images'] = $images;
	
	ob_start();	
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('instagram_v2/content');?>
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
			"heading"         => esc_html__("List Type", 'ciyashop' ),
			'param_name'      => 'list_type',
			'options'         => array(
				array(
					'value' => 'grid',
					'title' => 'Grid',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/instagram_v2/list_type/grid.png'),
				),
				array(
					'value' => 'carousel',
					'title' => 'Carousel',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/instagram_v2/list_type/carousel.png'),
				),
			),
			'value'           => 'grid',
			'show_label'      => true,
			'admin_label'     => true,
		),
		array(
			'type'            => 'pgscore_radio_image2',
			"heading"         => esc_html__("Style", 'ciyashop' ),
			'param_name'      => 'style',
			'options'         => array(
				array(
					'value' => 'default',
					'title' => 'Default',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/instagram_v2/style/default.png'),
				),
				array(
					'value' => 'hover-border',
					'title' => 'Hover Border',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/instagram_v2/style/hover-border.png'),
				),
			),
			'value'           => 'default',
			'show_label'      => true,
			'admin_label'     => true,
		),
		array(
			"type"            => "textfield",
			"param_name"      => "username",
			"heading"         => esc_html__( "Username", 'ciyashop' ),
			"description"     => esc_html__( 'Enter Instagram username or #hashtag.', 'ciyashop' ),
			"admin_label"     => true,
		),
		
		// Title
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Title", 'ciyashop' ),
			'param_name'      => 'show_title',
			'description'     => esc_html__( 'Select this checkbox to show title.', 'ciyashop' ),
			'admin_label'     => true,
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'dropdown',
			'heading'         => esc_html__( 'Title Element', 'ciyashop' ),
			'param_name'      => 'title_el',
			'value'           => array_flip( array(
				'h2'=> esc_html__('H2', 'ciyashop' ),
				'h3'=> esc_html__('H3', 'ciyashop' ),
				'h4'=> esc_html__('H4', 'ciyashop' ),
				'h5'=> esc_html__('H5', 'ciyashop' ),
				'h6'=> esc_html__('H6', 'ciyashop' ),
			) ),
			'std'        => 'h3',
			'description'=> esc_html__( 'Select title element.', 'ciyashop' ),
			'dependency'  => array(
				'element' => 'show_title',
				'value'   => 'true',
			),
			'group'      => esc_html__('Title Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-3",
		),
		array(
			'type'            => 'textfield',
			'heading'         => esc_html__('Title', 'ciyashop' ),
			'param_name'      => 'title',
			'admin_label'     => true,
			'dependency'  => array(
				'element' => 'show_title',
				'value'   => 'true',
			),
			'group'      => esc_html__('Title Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-9",
		),
		
		// Button
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__('Show Button', 'ciyashop' ),
			'param_name'      => 'show_button',
			'description'     => esc_html__( 'Select this checkbox to display "Follow us" button.', 'ciyashop' ),
			'admin_label'     => true,
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'         => 'textfield',
			'heading'      => esc_html__('Button Text', 'ciyashop' ),
			'param_name'   => 'button_text',
			'value'        => esc_html__( 'Follow us', 'ciyashop' ),
			'dependency'   => array(
				'element' => 'show_button',
				'value'   => 'true',
			),
			'group'        => esc_html__('Button Settings', 'ciyashop' ),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Icon', 'ciyashop' ),
			'param_name'       => 'show_icon',
			'description'      => esc_html__( 'Check this checkbox to enable "Instagram" icon.', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'show_button',
				'value'   => 'true',
			),
			'group'      => esc_html__('Button Settings', 'ciyashop' ),
		),
		
		array(
			'type'            => 'pgscore_range_slider',
			'heading'         => esc_html__( 'Item Count', 'ciyashop' ),
			'param_name'      => 'item_count',
			'min'             => 1,
			'max'             => 20,
			'value'           => 12,
			"admin_label"     => true,
			'group'           => esc_html__('Instagram Items Settings', 'ciyashop' ),
		),
		
		
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Likes", 'ciyashop' ),
			'param_name'      => 'show_likes',
			'description'     => esc_html__( 'Select this checkbox to show likes count.', 'ciyashop' ),
			'admin_label'     => true,
			'group'            => esc_html__('Instagram Items Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Comments", 'ciyashop' ),
			'param_name'      => 'show_comments',
			'description'     => esc_html__( 'Select this checkbox to show comments count.', 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__('Instagram Items Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'pgscore_notice',
			'param_name'      => 'image_size_warning',
			'notice_type'     => 'error',
			'heading'         => esc_html__( 'Important Note', 'ciyashop' ),
			'message'         => esc_html__( '"Image Size" is for how big image to load, rather than what image size to show on the front. The size of the image on the front depends on the grid size and the carousel items.', 'ciyashop' ),
			'display_header'  => false,
			'group'           => esc_html__( 'Instagram Items Settings', 'ciyashop' ),
		),
		array(
			'type'            => 'dropdown',
			'heading'         => esc_html__( 'Image Size', 'ciyashop' ),
			'param_name'      => 'image_size',
			'value'           => array_flip( array(
				'thumbnail'=> esc_html__('Thumbnail', 'ciyashop' ),
				'small'    => esc_html__('Small', 'ciyashop' ),
				'large'    => esc_html__('Large', 'ciyashop' ),
			) ),
			'std'        => 'thumbnail',
			'description'=> esc_html__( 'Select image size.', 'ciyashop' ),
			'group'      => esc_html__( 'Instagram Items Settings', 'ciyashop' ),
			'admin_label'=> true,
		),
		
		// Grid Settings
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Grid Column (Extra large &ge;1200px)', 'ciyashop' ),
			'param_name'              => 'grid_col_xl',
			'value'                   => array_flip( array(
				'6'=> esc_html__('6 Column', 'ciyashop' ),
				'4'=> esc_html__('4 Column', 'ciyashop' ),
				'3'=> esc_html__('3 Column', 'ciyashop' ),
				'2'=> esc_html__('2 Column', 'ciyashop' ),
				'1'=> esc_html__('1 Column', 'ciyashop' ),
			) ),
			'std'                     => '6',
			'description'             => esc_html__( 'Select grid columns.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'grid',
			),
			'group'                   => esc_html__( 'Grid Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Grid Column (Large &ge;992px)', 'ciyashop' ),
			'param_name'              => 'grid_col_lg',
			'value'                   => array_flip( array(
				'4'=> esc_html__('4 Column', 'ciyashop' ),
				'3'=> esc_html__('3 Column', 'ciyashop' ),
				'2'=> esc_html__('2 Column', 'ciyashop' ),
				'1'=> esc_html__('1 Column', 'ciyashop' ),
			) ),
			'std'                     => '4',
			'description'             => esc_html__( 'Select grid columns.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'grid',
			),
			'group'                   => esc_html__( 'Grid Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Grid Column (Medium &ge;768px)', 'ciyashop' ),
			'param_name'              => 'grid_col_md',
			'value'                   => array_flip( array(
				'3'=> esc_html__('3 Column', 'ciyashop' ),
				'2'=> esc_html__('2 Column', 'ciyashop' ),
				'1'=> esc_html__('1 Column', 'ciyashop' ),
			) ),
			'std'                     => '3',
			'description'             => esc_html__( 'Select grid columns.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'grid',
			),
			'group'                   => esc_html__( 'Grid Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Grid Column (Small &ge;576px)', 'ciyashop' ),
			'param_name'              => 'grid_col_sm',
			'value'                   => array_flip( array(
				'3'=> esc_html__('3 Column', 'ciyashop' ),
				'2'=> esc_html__('2 Column', 'ciyashop' ),
				'1'=> esc_html__('1 Column', 'ciyashop' ),
			) ),
			'std'                     => '2',
			'description'             => esc_html__( 'Select grid columns.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'grid',
			),
			'group'                   => esc_html__( 'Grid Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Grid Column (Extra small <576px)', 'ciyashop' ),
			'param_name'              => 'grid_col_xs',
			'value'                   => array_flip( array(
				'3'=> esc_html__('3 Column', 'ciyashop' ),
				'2'=> esc_html__('2 Column', 'ciyashop' ),
				'1'=> esc_html__('1 Column', 'ciyashop' ),
			) ),
			'std'                     => '2',
			'description'             => esc_html__( 'Select grid columns.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'grid',
			),
			'group'                   => esc_html__( 'Grid Settings', 'ciyashop' ),
		),
		
		// Carousel Settings
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Pagination", 'ciyashop' ),
			'param_name'      => 'carousel_pagination',
			'description'     => esc_html__( 'Select this checkbox to show carousel pagination navigation.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Left/Right Navigation", 'ciyashop' ),
			'param_name'      => 'carousel_arrow',
			'description'     => esc_html__( 'Select this checkbox to show carousel left/right navigation.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'pgscore_range_slider',
			'heading'         => esc_html__( 'Item Gapping', 'ciyashop' ),
			'param_name'      => 'carousel_gapping',
			'min'             => 0,
			'max'             => 20,
			'value'           => 0,
			'unit'            => 'px',
			'description'     => esc_html__( 'Select gapping between carousel items', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Carousel Items(Extra large &ge;1200px)', 'ciyashop' ),
			'param_name'              => 'carousel_items_xl',
			'value'                   => array_flip( array(
				'10'=> esc_html__('10 Items', 'ciyashop' ),
				'9' => esc_html__('9 Items', 'ciyashop' ),
				'8' => esc_html__('8 Items', 'ciyashop' ),
				'7' => esc_html__('7 Items', 'ciyashop' ),
				'6' => esc_html__('6 Items', 'ciyashop' ),
				'5' => esc_html__('5 Items', 'ciyashop' ),
				'4' => esc_html__('4 Items', 'ciyashop' ),
				'3' => esc_html__('3 Items', 'ciyashop' ),
			) ),
			'std'                     => '5',
			'description'             => esc_html__( 'Select items to display.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Carousel Items(Large &ge;992px)', 'ciyashop' ),
			'param_name'              => 'carousel_items_lg',
			'value'                   => array_flip( array(
				'8' => esc_html__('8 Items', 'ciyashop' ),
				'7' => esc_html__('7 Items', 'ciyashop' ),
				'6' => esc_html__('6 Items', 'ciyashop' ),
				'5' => esc_html__('5 Items', 'ciyashop' ),
				'4' => esc_html__('4 Items', 'ciyashop' ),
				'3' => esc_html__('3 Items', 'ciyashop' ),
				'2' => esc_html__('2 Items', 'ciyashop' ),
			) ),
			'std'                     => '4',
			'description'             => esc_html__( 'Select items to display.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Carousel Items(Medium &ge;768px)', 'ciyashop' ),
			'param_name'              => 'carousel_items_md',
			'value'                   => array_flip( array(
				'6' => esc_html__('6 Items', 'ciyashop' ),
				'5' => esc_html__('5 Items', 'ciyashop' ),
				'4' => esc_html__('4 Items', 'ciyashop' ),
				'3' => esc_html__('3 Items', 'ciyashop' ),
				'2' => esc_html__('2 Items', 'ciyashop' ),
				'1' => esc_html__('1 Item', 'ciyashop' ),
			) ),
			'std'                     => '3',
			'description'             => esc_html__( 'Select items to display.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Carousel Items(Small &ge;576px)', 'ciyashop' ),
			'param_name'              => 'carousel_items_sm',
			'value'                   => array_flip( array(
				'4' => esc_html__('4 Items', 'ciyashop' ),
				'3' => esc_html__('3 Items', 'ciyashop' ),
				'2' => esc_html__('2 Items', 'ciyashop' ),
				'1' => esc_html__('1 Item', 'ciyashop' ),
			) ),
			'std'                     => '2',
			'description'             => esc_html__( 'Select items to display.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'list_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                    => esc_html__( "Instagram", 'ciyashop' ),
		"description"             => esc_html__( "Display Instagram images.", 'ciyashop' ),
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