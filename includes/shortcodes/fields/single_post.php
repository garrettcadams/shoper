<?php
/******************************************************************************
 * 
 * Shortcode : pgscore_single_post
 * 
 ******************************************************************************/
function pgscore_shortcode_single_post( $atts, $content = null, $shortcode_handle = '' ) {
	
	$default_custom = array(
		'post_id'            => '',
		'show_excerpt'       => '',
		'excerpt_length'     => '200',
		'show_categories'    => '',
		'show_social_sharing'=> '',
		'img_size'           => 'thumbnail',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	
	extract( $atts );
	
	if( empty($post_id) ){
		return;
	}
	
	/*********************************************
	 * 
	 * Check for thumbnail size
	 * 
	 *********************************************/
	if( empty($img_size) ){
		$img_size = 'thumbnail';
	}
	
	$image_sizes = ciyashop_get_image_sizes();
	
	$thumb_size = $thumb_size_w = $thumb_size_h = '';
	if( isset($image_sizes[$img_size]) && is_array($image_sizes[$img_size]) ){
		$image_size  = $image_sizes[$img_size];
		
		$thumb_size  = $img_size;
		if( $img_size != 'full' ){
			$thumb_size_w= $image_size['width'];
			$thumb_size_h= $image_size['height'];
		}
	}elseif( strpos($img_size, 'x') !== false ) {
		$img_size = explode('x', $img_size);
		
		// Check for PHP version
		if (version_compare(PHP_VERSION, '5.3.0', '<')) { // PHP < 5.3
			$img_size = array_filter($img_size, create_function('$value', 'return $value !== "";'));
		}else{ // PHP 5.3 and later
			$img_size = array_filter($img_size, function($value) { return $value !== ''; });
		}
		
		if( count($img_size) == 2 && is_numeric($img_size[0]) && is_numeric($img_size[1]) ){
			$thumb_size   = $img_size;
			$thumb_size_w = $img_size[0];
			$thumb_size_h = $img_size[1];
		}
	}else{
		$thumb_size = 'thumbnail';
		$thumb_size_w = $image_sizes[$thumb_size]['width'];
		$thumb_size_h = $image_sizes[$thumb_size]['height'];
	}
	
	if( $thumb_size == '' ){
		$thumb_size = 'thumbnail';
	}
	
	$atts['thumb_size']   = $thumb_size;
	$atts['thumb_size_w'] = $thumb_size_w;
	$atts['thumb_size_h'] = $thumb_size_h;
	
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
		<?php pgscore_get_shortcode_templates('single_post/content' );?>
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
		// Auto Search
		array(
			'type'       => 'autocomplete',
			'heading'    => esc_html__( 'Select Post', 'ciyashop' ),
			'param_name' => 'post_id',
			'description'=> esc_html__( 'Input post title to see suggestions.', 'ciyashop' ),
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Excerpt", 'ciyashop' ),
			'param_name'      => 'show_excerpt',
			'description'     => esc_html__( 'Select this checkbox to display excerpt.', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'pgscore_range_slider',
			'heading'         => esc_html__( 'Excerpt length', 'ciyashop' ),
			'param_name'      => 'excerpt_length',
			'min'             => 100,
			'max'             => 1000,
			'value'           => 200,
			'unit'            => 'chr(s)',
			'description'     => esc_html__( 'Select excerpt length (in characters) to display on front.', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'show_excerpt',
				'value'  => 'true',
			),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Categories", 'ciyashop' ),
			'param_name'      => 'show_categories',
			'description'     => esc_html__( 'Select this checkbox to display categories.', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Social Sharing", 'ciyashop' ),
			'param_name'      => 'show_social_sharing',
			'description'     => esc_html__( 'Select this checkbox to display social sharing icons.', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Image size', 'ciyashop' ),
			'param_name' => 'img_size',
			'value'      => 'thumbnail',
			'description'=> esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'ciyashop' ),
			'admin_label'     => true,
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params                      = array(
		"name"                   => esc_html__( "Single Post", 'ciyashop' ),
		"base"                   => $shortcode_tag,
		"class"                  => "pgscore_element_wrapper",
		"controls"               => "full",
		"icon"                   => pgscore_vc_shortcode_icon( $shortcode_tag ),
		"category"               => esc_html__('Potenza Core', 'ciyashop' ),
		"show_settings_on_create"=> true,
		"params"                 => $shortcode_fields,
	);

	vc_map( $params );

	add_filter( 'vc_autocomplete_pgscore_single_post_post_id_callback', 'ciyashop_shortcode_single_post_autocomplete_suggester', 10, 1 );
	add_filter( 'vc_autocomplete_pgscore_single_post_post_id_render', 'ciyashop_shortcode_single_post_autocomplete_render', 10, 1 );
	function ciyashop_shortcode_single_post_autocomplete_suggester( $query ) {
		global $wpdb;
		$post_id = (int) $query; 
		
		$query = $wpdb->prepare( "SELECT ID AS id, post_title AS title
			FROM {$wpdb->posts} WHERE post_type = 'post' AND post_title LIKE '%%%s%%' AND post_status = 'publish' ", stripslashes( $query ), stripslashes( $query )
		);
		$post_meta_infos = $wpdb->get_results( $query, ARRAY_A );
		
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'ciyashop' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'ciyashop' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}
		
		return $results;
		
	}

	function ciyashop_shortcode_single_post_autocomplete_render( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get post
			$post_object = get_post( (int) $query );
			 
			if ( is_object( $post_object ) ) {
				$post_title = $post_object->post_title;
				$post_id = $post_object->ID;
				$post_title_display = '';
				if ( ! empty( $post_title ) ) {
					$post_title_display = ' - ' . esc_html__( 'Title', 'ciyashop' ) . ': ' . $post_title;
				}

				$post_id_display = esc_html__( 'Id', 'ciyashop' ) . ': ' . $post_id;

				$data = array();
				$data['value'] = $post_id;
				$data['label'] = $post_id_display . $post_title_display;
				
				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
}