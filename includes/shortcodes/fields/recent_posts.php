<?php
/* 
 * Shortcode : pgscore_recent_posts 
 */
function pgscore_shortcode_recent_posts( $atts, $content = null, $shortcode_handle = '' ) {
	$default_custom = array(
		'style'                             => 'style-1',
		'listing_type'                      => 'grid',
		'enable_intro'                      => '',
		
		// Intro Settings
		'intro_title'                       => '',
		'intro_title_color'                 => '#323232',
		'intro_description'                 => '',
		'intro_description_color'           => '#969696',
		'enable_intro_link'                 => '',
		
		// Link Settings
		'link_title'                        => esc_html__('View All', 'ciyashop' ),
		'intro_link'                        => '|||',
		'intro_link_color'                  => '#323232',
		'intro_link_position'               => 'below_desc',
		'intro_link_alignment'              => 'left',
		
		// Intro Design
		'intro_position'                    => 'left',
		'intro_content_alignment'           => 'left',
		'intro_bg_type'                     => 'color',
		'intro_bg_color'                    => '#f5f5f5',
		'intro_bg_image'                    => '',
		'intro_bg_image_background_position'=> '',
		'intro_bg_image_background_repeat'  => '',
		'intro_bg_image_background_size'    => '',
		'intro_bg_image_ol_color'           => 'rgba(0,0,0,0.6)',
		
		// Carousel Settings
		'carousel_items_xl'         		=> 4,
		'carousel_items_lg'        			=> 3,
		'carousel_items_md'         		=> 2,
		'carousel_items_sm'         		=> 1,
		'carousel_margin'         			=> 15,
		
		
		// Grid Settings
		'grid_column_xl'                    => '2',
		
		// Post Settings
		'post_type'                         => 'post',
		'ignore_sticky_posts'               => true,
		'posts_per_page'                    => 10,
		'categories'                        => '',
	);
	
	$default_atts = apply_filters( 'pgscore_shortcode_atts-'.$shortcode_handle, $default_custom, $shortcode_handle );
	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract($atts);
	
	$args = array(
		'post_type'          => $post_type,
		'post_status'        => array('publish'),
		'posts_per_page'     => $posts_per_page,
		'ignore_sticky_posts'=> $ignore_sticky_posts,
	);
	
	$categories = trim($categories);
	if( !empty($categories) ){
		$categories_array = explode(',', $categories);
		if( is_array($categories_array) && !empty($categories_array) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $categories_array
				)
			);
		}
	}
	
	$loop = new WP_Query( $args );
	
	// Return if no posts found.
	if ( !$loop->have_posts() ) return;
	
	/*	 
	 * Element Classes
	 * For base wrapper	 
	 */
	$atts['element_classes'] = array();
	
	global $pgscore_shortcodes;
	$pgscore_shortcodes[$shortcode_handle]['atts'] = $atts;
	$pgscore_shortcodes[$shortcode_handle]['loop'] = $loop;
	
	if( isset($pgscore_shortcodes[$shortcode_handle]['index']) ){
		$pgscore_shortcodes[$shortcode_handle]['index'] = $pgscore_shortcodes[$shortcode_handle]['index']+1;
	}else{
		$pgscore_shortcodes[$shortcode_handle]['index'] = 1;
	}
	$pgscore_shortcodes[$shortcode_handle]['index_class'] = $shortcode_handle.'-'.$pgscore_shortcodes[$shortcode_handle]['index'];
	
	$atts['element_classes'][] = $pgscore_shortcodes[$shortcode_handle]['index_class'];
	
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts );?> class="<?php pgscore_element_classes( $atts );?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates('recent_posts/content' );?>
	</div>
	<?php
	return ob_get_clean();
}
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline()) ) {

	/*	 
	 * Visual Composer Integration	 
	 */
	$recent_post_categories_data = get_terms( array(
		'taxonomy'  => 'category',
		'hide_empty'=> true,
	));

	$recent_post_categories = array();

	if ( !is_wp_error( $recent_post_categories_data ) ) {
		if ( is_array( $recent_post_categories_data ) || !empty( $recent_post_categories_data ) ) {
			foreach ( $recent_post_categories_data as $term_data ) {
				if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
					$recent_post_categories[ "{$term_data->name} ({$term_data->count})"] = $term_data->slug;
				}
			}
		}
	}

	$categories_hierarchy = get_terms_hierarchy( 'category' );
	$categories_flat = get_terms_hierarchical_list( $categories_hierarchy );
	$categories_list = array();
	foreach( $categories_flat as $term_id => $term ){
		$categories_list[ str_repeat("&mdash; ", $term->depth) . $term->name .' ('.$term->count.')' ] = $term_id;
	}
	$shortcode_fields = array(
		array(
			'type'            => 'pgscore_radio_image2',
			'param_name'      => 'style',
			"heading"         => esc_html__("Style", 'ciyashop' ),
			"description"     => esc_html__("Select style.", 'ciyashop' ),
			'options'         => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/recent_posts/style-1.png'),
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/recent_posts/style-2.png'),
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 3',
					'image' => get_parent_theme_file_uri('/images/shortcodes/fields/recent_posts/style-3.png'),
				),
			),
			'save_always'     => true,
			'admin_label'     => true,
		),
		array(
			"type"        => "dropdown",
			"class"       => "",
			"heading"     => esc_html__("List Type", 'ciyashop' ),
			"description" => esc_html__("Select list type.", 'ciyashop' ),
			"param_name"  => "listing_type",
			"value"       => array(
				esc_html__( "Grid", 'ciyashop' )      => 'grid',
				esc_html__( "Carousel", 'ciyashop' )  => 'carousel',
			),
			'save_always'=> true,
			'admin_label'=> true,
		),
		array(
			'type'       => 'checkbox',
			"heading"    => esc_html__("Enable Intro", 'ciyashop' ),
			'param_name' => 'enable_intro',
			'description'=> esc_html__( 'Enable intro to display title and description (and tabs) on left side of listing.', 'ciyashop' ),
			'save_always'=> true,
			'admin_label'=> true,
			'dependency' => array(
				'element'=> 'style',
				'value'  => 'style-1',
			),
		),
		
		/* Intro Settings */
		array(
			"type"            => "textfield",
			"param_name"      => "intro_title",
			"heading"         => esc_html__( "Title", 'ciyashop' ),
			'description'     => esc_html__( "Add intro title.", 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-10",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Title Color', 'ciyashop' ),
			'param_name'      => 'intro_title_color',
			'description'     => esc_html__( 'Select title color.', 'ciyashop' ),
			'value'           => '#323232',
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-2",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"            => "textfield",
			"param_name"      => "intro_description",
			"heading"         => esc_html__( "Description", 'ciyashop' ),
			'description'     => esc_html__( "Add intro description.", 'ciyashop' ),
			'admin_label'     => true,
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-10",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Description Color', 'ciyashop' ),
			'param_name'      => 'intro_description_color',
			'description'     => esc_html__( 'Select description color.', 'ciyashop' ),
			'value'           => '#969696',
			'group'           => esc_html__( 'Content', 'ciyashop' ),
			"edit_field_class"=> "vc_col-md-2",
			'dependency'      => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			'type'       => 'checkbox',
			"heading"    => esc_html__("Enable Intro Link", 'ciyashop' ),
			'param_name' => 'enable_intro_link',
			'description'=> esc_html__( 'Enable this to display link in  Intro Content.', 'ciyashop' ),
			'group'      => esc_html__( 'Content', 'ciyashop' ),
			'admin_label'=> true,
			'dependency' => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		
		/* Link Settings */
		array(
			"type"      => "textfield",
			"heading"   => esc_html__( 'Link Title', 'ciyashop' ),
			"param_name"=> "link_title",
			'value'     => esc_html__('View All', 'ciyashop' ),
			'group'     => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'=> array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
		),
		array(
			'type'            => 'vc_link',
			'heading'         => esc_html__( 'Link', 'ciyashop' ),
			'param_name'      => 'intro_link',
			'description'     => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'ciyashop' ),
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Link Color', 'ciyashop' ),
			'param_name'      => 'intro_link_color',
			'description'     => esc_html__( 'Select link color.', 'ciyashop' ),
			'value'           => '#323232',
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"                    => "dropdown",
			"param_name"              => "intro_link_position",
			"heading"                 => esc_html__("Link Position", 'ciyashop' ),
			"description"             => esc_html__('Select link position. Note: This is applicable only when "Listing Type" is set to "Carousel". If "Listing Type" is set to grid, this will be set as "Below Description" by default.', 'ciyashop' ),
			'value'                   => array_flip( array(
				'below_desc'    => esc_html__('Below Description', 'ciyashop' ),
				'with_controls' => esc_html__('With Carousel Controls', 'ciyashop' ),
			) ),
			"std"             => "below_desc",
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		array(
			"type"            => "dropdown",
			"param_name"      => "intro_link_alignment",
			"heading"         => esc_html__("Link Alignment", 'ciyashop' ),
			"description"     => esc_html__("Select link alignment with carousel controls.", 'ciyashop' ),
			'value'           => array_flip( array(
				'left'  => esc_html__('Left', 'ciyashop' ),
				'right' => esc_html__('Right', 'ciyashop' ),
			) ),
			"std"             => "left",
			'group'           => esc_html__( 'Intro Link', 'ciyashop' ),
			'dependency'      => array(
				'element' => 'intro_link_position',
				'value'   => 'with_controls',
			),
			"edit_field_class"=> "vc_col-md-6",
		),
		
		/* Intro Design*/
		array(
			"type"                    => "dropdown",
			"param_name"              => "intro_position",
			"heading"                 => esc_html__("Intro Position", 'ciyashop' ),
			"description"             => esc_html__("Select intro position.", 'ciyashop' ),
			'value'                   => array_flip( array(
				'left'  => esc_html__('Left', 'ciyashop' ),
				'right' => esc_html__('Right', 'ciyashop' ),
			) ),
			"std"                     => "left",
			'admin_label'             => true,
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_content_alignment",
			"heading"    => esc_html__("Intro Content Alignment", 'ciyashop' ),
			"description"=> esc_html__("Select content alignment in Intro", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'left'  => esc_html__('Left','ciyashop' ),
				'right' => esc_html__('Right','ciyashop' ),
			) ),
			"std"        => "left",
			'group'      => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_type",
			"heading"    => esc_html__("Background Type", 'ciyashop' ),
			"description"=> esc_html__("Select intro background type.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				'color' => esc_html__('Color', 'ciyashop' ),
				'image' => esc_html__('Image', 'ciyashop' ),
				'none'  => esc_html__('None', 'ciyashop' ),
			) ),
			"std"                     => "color",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'enable_intro',
				'value'  => 'true',
			),
			'admin_label'             => true,
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Background Color', 'ciyashop' ),
			'param_name'      => 'intro_bg_color',
			'description'     => esc_html__( 'Select background color.', 'ciyashop' ),
			'value'           => '#f5f5f5',
			'group'           => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'color',
			),
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_position",
			"heading"    => esc_html__("Background Position", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image position.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''             => esc_html__('Select Background Position','ciyashop' ),
				'inherit'      => esc_html__('Inherit','ciyashop' ),
				'left top'     => esc_html__('Left Top','ciyashop' ),
				'left center'  => esc_html__('Left Center','ciyashop' ),
				'left bottom'  => esc_html__('Left Bottom','ciyashop' ),
				'right top'    => esc_html__('Right Top','ciyashop' ),
				'right center' => esc_html__('Right Center','ciyashop' ),
				'right bottom' => esc_html__('Right Bottom','ciyashop' ),
				'center top'   => esc_html__('Center Top','ciyashop' ),
				'center center'=> esc_html__('Center Center','ciyashop' ),
				'center bottom'=> esc_html__('Center Bottom','ciyashop' ),
			) ),
			"std"                     => "",
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_repeat",
			"heading"    => esc_html__("Background Repeat", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image repeat.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''         => esc_html__('Select Background Repeat','ciyashop' ),
				'inherit'  => esc_html__('Inherit','ciyashop' ),
				'repeat'   => esc_html__('Repeat','ciyashop' ),
				'repeat-x' => esc_html__('Repeat-X','ciyashop' ),
				'repeat-y' => esc_html__('Repeat-Y','ciyashop' ),
				'no-repeat'=> esc_html__('No-Repeat','ciyashop' ),
				'initial'  => esc_html__('Initial','ciyashop' ),
			) ),
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			"type"       => "dropdown",
			"param_name" => "intro_bg_image_background_size",
			"heading"    => esc_html__("Background Size", 'ciyashop' ),
			"description"=> esc_html__("Select intro background image size.", 'ciyashop' ),
			'save_always'=> true,
			'value'      => array_flip( array(
				''         => esc_html__('Select Background Size','ciyashop' ),
				'inherit'  => esc_html__('Inherit','ciyashop' ),
				'auto'     => esc_html__('Auto','ciyashop' ),
				'cover'    => esc_html__('Cover','ciyashop' ),
				'contain'  => esc_html__('Contain','ciyashop' ),
				'initial'  => esc_html__('Initial','ciyashop' ),
			) ),
			'group'                   => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
			"edit_field_class"=> "vc_col-md-4",
		),
		array(
			'type'            => 'colorpicker',
			'heading'         => esc_html__( 'Overlay Color', 'ciyashop' ),
			'param_name'      => 'intro_bg_image_ol_color',
			'description'     => esc_html__( 'Select overlay color for background image.', 'ciyashop' ),
			'value'           => 'rgba(0,0,0,0.6)',
			'group'           => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency'      => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
		),
		
		/* ---------Grid Settings ---------*/
		array(
			"type"            => "dropdown",
			"param_name"      => "grid_column_xl",
			"heading"         => esc_html__("Grid Columns - Extra large Devices (&ge;1200px)", 'ciyashop' ),
			"description"     => esc_html__("Select grid columns in extra large devices width &ge;1200px.", 'ciyashop' ),
			"value"           => array_flip( array(
				'2' => esc_html__( "2 Column", 'ciyashop' ),
				'3' => esc_html__( "3 Column", 'ciyashop' ),
				'4' => esc_html__( "4 Column", 'ciyashop' ),
			) ),
			'group'           => esc_html__( 'Grid Settings', 'ciyashop' ),
			'edit_field_class'=> 'vc_col-sm-4 vc_column',
			'dependency'      => array(
				'element' => 'listing_type',
				'value'   => 'grid',
			),
		),
		
		/* ---------Slider Settings ---------*/
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Extra large &ge;1200px', 'ciyashop' ),
			'param_name'              => 'carousel_items_xl',
			'value'                   => array_flip( array(
				'5' => '5',
				'4' => '4',
				'3' => '3',
				'2' => '2',
			) ),
			'std'                     => '4',
			'description'             => esc_html__( 'Select items per view.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'listing_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Large &ge;992px', 'ciyashop' ),
			'param_name'              => 'carousel_items_lg',
			'value'                   => array_flip( array(
				'5' => '5',
				'4' => '4',
				'3' => '3',
				'2' => '2',
			) ),
			'std'                     => '3',
			'description'             => esc_html__( 'Select items per view.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'listing_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Medium &ge;768px', 'ciyashop' ),
			'param_name'              => 'carousel_items_md',
			'value'                   => array_flip( array(
				'4'=> '4',
				'3'=> '3',
				'2'=> '2',
				'1'=> '1',
			) ),
			'std'                     => '2',
			'description'             => esc_html__( 'Select items per view.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'listing_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'                    => 'dropdown',
			'heading'                 => esc_html__( 'Small &ge;576px', 'ciyashop' ),
			'param_name'              => 'carousel_items_sm',
			'value'                   => array_flip( array(
				'3'=> '3',
				'2'=> '2',
				'1'=> '1',
			) ),
			'std'                     => '1',
			'description'             => esc_html__( 'Select items per view.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'listing_type',
				'value'  => 'carousel',
			),
			'group'                   => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		array(
			'type'            		 => 'pgscore_number_min_max',
			'heading'        		 => esc_html__('Margin','ciyashop' ),
			'param_name'             => 'carousel_margin',
			'min'             		 => '0',
			'max'             	     => '100',
			'value'                  => '15',
			'description'     		 => esc_html__( 'Enter margin, in pixels (px), between each item.', 'ciyashop' ),
			'dependency'              => array(
				'element'=> 'listing_type',
				'value'  => 'carousel',
			),
			'group'                  => esc_html__( 'Slider Settings', 'ciyashop' ),
		),
		
		/* ---------Post Settings ---------*/
		array(
			'type'       => 'pgscore_number_min_max',
			'heading'    => esc_html__( "Count", 'ciyashop' ),
			'param_name' => 'posts_per_page',
			'value'      => '',
			'min'        => '2',
			'max'        => '10',
			'description'=> esc_html__('Enter number of posts to display.','ciyashop' ),
			'group'      => esc_html__( 'Posts', 'ciyashop' ),
			'admin_label'=> true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__('Categories', 'ciyashop' ),
			'param_name' => 'categories',
			'description'=> esc_html__('Select categories to limit result from. To display result from all categories leave all categories unselected.', 'ciyashop' ),
			'value'      => $recent_post_categories,
			'group'      => esc_html__( 'Posts', 'ciyashop' ),
			'admin_label'=> true,
		),
		
		/* ---------Background Image ---------*/
		array(
			"type"       => "attach_image",
			"param_name" => "intro_bg_image",
			"heading"    => esc_html__("Background Image", 'ciyashop' ),
			"description"=> esc_html__("Upload intro background image", 'ciyashop' ),
			"holder"     => "img",
			'group'      => esc_html__( 'Intro Design', 'ciyashop' ),
			'dependency' => array(
				'element'=> 'intro_bg_type',
				'value'  => 'image',
			),
		),
	);

	$shortcode_fields = apply_filters( 'pgscore_shortcode_fields-'.$shortcode_tag, $shortcode_fields, $shortcode_tag );

	// Params
	$params = array(
		"name"                   => esc_html__( "Recent Posts", 'ciyashop' ),
		"description"            => esc_html__( "Display recent posts.", 'ciyashop' ),
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