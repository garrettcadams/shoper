<?php
/* 
 * Shortcode : pgscore_team_members 
 */

// Return if custom post type is not supported
if( !current_theme_supports('pgs_teams') ) return;

function pgscore_shortcode_team_members( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'                  => 'style-1',
		'posts_per_page'         => 10,
		'categories'             => '',
		'show_pagination_control'=> 'no',
		'show_prev_next_buttons' => 'no',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	$args = array(
		'post_type'     => 'teams',
		'posts_per_page'=> $atts['posts_per_page'],
	);
	
	if( !empty($categories) ){
		$categories_array = explode(',', $categories);
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'team-category',
					'field'    => 'term_id',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	$the_query = new WP_Query( $args );
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
	
	$listlist_classes = array();
	$list_classes[] = 'pgscore_team_member_list';
	
	if( $style ){
		$list_classes[] = 'pgscore_team_members_style_'.esc_attr($style);
	}
	$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<div class="<?php echo esc_attr($list_classes);?>">
			<?php pgscore_get_shortcode_templates('team_members/content', 'carousel');?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	/*	 
	 * Visual Composer Integration	 
	 */
	$testimonial_categories = pgscore_get_terms( array( // You can pass arguments from get_terms (except hide_empty)
		'taxonomy'   => 'team-category',
		'pad_counts' => true,
	));
	$shortcode_fields = array(
		array(
			'type'            => 'pgscore_radio_image2',
			"heading"         => esc_html__("Style", 'ciyashop' ),
			'param_name'      => 'style',
			'options'         => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/team_members/style-1.png'),
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 2',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/team_members/style-3.png'),
				),
			),
			'show_label'      => true,
			'admin_label'     => true,
		),
		array(
			'type'       => 'pgscore_number_min_max',
			'heading'    => esc_html__( "Count", 'ciyashop' ),
			'param_name' => 'posts_per_page',
			'value'      => '',
			'min'        => '1',
			'max'        => '10',
			'description'=> esc_html__('Enter number of members to display.','ciyashop' ),
			'admin_label'=> true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__('Categories', 'ciyashop' ),
			'param_name' => 'categories',
			'description'=> esc_html__('Select categories to limit result from. To display result from all categories leave all categories unselected.', 'ciyashop' ),
			'value'      => $testimonial_categories,
			'admin_label'=> true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Show Pagination Control', 'ciyashop' ),
			'param_name'      => 'show_pagination_control',
			'description'     => esc_html__( 'Select this checkbox to display pagination controls.', 'ciyashop' ),
			'value'           => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
			'edit_field_class'=> 'vc_col-sm-6 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
		array(
			'type'            => 'checkbox',
			'heading'         => esc_html__( 'Show Prev/Next Buttons', 'ciyashop' ),
			'param_name'      => 'show_prev_next_buttons',
			'description'     => esc_html__( 'Select this checkbox to display prev/next buttons.', 'ciyashop' ),
			'value'           => array( esc_html__( 'Yes', 'ciyashop' )=> 'yes' ),
			'edit_field_class'=> 'vc_col-sm-6 vc_column',
			'group'           => esc_html__( 'Slider Settings', 'ciyashop' ),
			'admin_label'     => true,
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                    => esc_html__( "Team Members", 'ciyashop' ),
		"description"             => esc_html__( "Display team members.", 'ciyashop' ),
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