<?php
/* 
 * Shortcode : pgscore_testimonials 
 */

if( !current_theme_supports('pgs_testimonials') ) return; // Return if custom post type is not supported

function pgscore_shortcode_testimonials( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'         => 'style-1',
		'show_title'    => '',
		'title'         => '',
		'carousel_speed'=> 2500,
		'posts_per_page'=> 3,
		'categories'    => '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	$args = array(
		'post_type'          => 'testimonials',
		'posts_per_page'     => ( !empty( $posts_per_page ) && is_numeric($posts_per_page) ) ? $posts_per_page : 3,
		'post_status'        => array('publish'),
		'ignore_sticky_posts'=> true,
	);
	
	if( !empty($categories) ){
		$categories_array = explode(',', $categories);
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'testimonial-category',
					'field'    => 'term_id',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	$the_query = new WP_Query( $args );
	
	// bail early if no posts found
	if ( !$the_query->have_posts() ) {
		return;
	}
	
	/*	  
	 * Element Classes
	 * For base wrapper	  
	 */
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['the_query'] = $the_query;
	
	/*
	 * Shortcode Instance Index and Classes
	 */
	if( isset($pgscore_shortcodes[$shortcode_handle]['index']) ){
		$pgscore_shortcodes[$shortcode_handle]['index'] = $pgscore_shortcodes[$shortcode_handle]['index']+1;
	}else{
		$pgscore_shortcodes[$shortcode_handle]['index'] = 1;
	}
	$pgscore_shortcodes[$shortcode_handle]['index_class'] = $shortcode_handle.'-'.$pgscore_shortcodes[$shortcode_handle]['index'];
	
	$atts['element_classes'][] = $pgscore_shortcodes[$shortcode_handle]['index_class'];
	/*
	 * Shortcode Instance Index and Classes END
	 */
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('testimonials/content' );?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {

	/* 
	 * Visual Composer Integration 
	 */
	$testimonial_categories = pgscore_get_terms( array( // You can pass arguments from get_terms (except hide_empty)
		'taxonomy'   => 'testimonial-category',
		'pad_counts' => true,
	));

	$shortcode_fields = array(
		array(
			'type'            => 'pgscore_radio_image2',
			'heading'         => esc_html__('Style', 'ciyashop' ),
			'param_name'      => 'style',
			'options'         => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'ciyashop' ),
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/testimonials/style-1.png'),
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'ciyashop' ),
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/testimonials/style-2.png'),
				),
				array(
					'value' => 'style-3',
					'title' => esc_html__( 'Style 3', 'ciyashop' ),
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/testimonials/style-3.png'),
				),
			),
			'value'           => 'style-1',
			'show_label'      => true,
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			"heading"         => esc_html__("Show Title", 'ciyashop' ),
			'param_name'      => 'show_title',
			'description'     => esc_html__( 'Select this checkbox to display title.', 'ciyashop' ),
			'admin_label'     => true,
			'dependency' => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'ciyashop' ),
			'param_name' => 'title',
			'description'=> esc_html__( 'Enter title.', 'ciyashop' ),
			'dependency' => array(
				'element' => 'show_title',
				'value'   => 'true',
			),
			'admin_label'=> true,
		),
		array(
			'type'            => 'pgscore_range_slider',
			'heading'         => esc_html__( 'Carousel Speed', 'ciyashop' ),
			'param_name'      => 'carousel_speed',
			'min'             => 1000,
			'max'             => 10000,
			'value'           => 2500,
			'unit'            => 'ms',
			'description'     => esc_html__( 'Enter carousel speed in milliseconds.', 'ciyashop' ),
			'dependency' => array(
				'element' => 'style',
				'value'   => array(
					'style-2',
					'style-3',
				)
			),
			'group'           => esc_html__( 'Carousel Settings', 'ciyashop' ),
		),
		array(
			'type'       => 'pgscore_number_min_max',
			'heading'    => esc_html__( "Count", 'ciyashop' ),
			'param_name' => 'posts_per_page',
			'value'      => '3',
			'min'        => '1',
			'max'        => '10',
			'description'=> esc_html__('Enter number of testimonial items to display.','ciyashop' ),
			'admin_label'=> true,
			'group'      => esc_html__( 'Post Settings', 'ciyashop' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__('Categories', 'ciyashop' ),
			'param_name' => 'categories',
			'description'=> esc_html__('Select categories to limit result from. To display result from all categories leave all categories unselected.', 'ciyashop' ),
			'value'      => $testimonial_categories,
			'admin_label'=> true,
			'group'      => esc_html__( 'Post Settings', 'ciyashop' ),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Testimonials", 'ciyashop' ),
		"description"            => esc_html__( "Display testimonials.", 'ciyashop' ),
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