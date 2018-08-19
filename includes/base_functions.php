<?php
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 */
function ciyashop_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'ciyashop_post_thumbnail_sizes_attr', 10 , 3 );

/****************************************************
 *
 * Layout
 *
 ****************************************************/
function ciyashop_site_layout(){
	global $ciyashop_options;

	$site_layout = 'fullwidth';

	if( isset($ciyashop_options['site_layout']) && !empty($ciyashop_options['site_layout']) ){
		$site_layout = $ciyashop_options['site_layout'];
	}

	/**
	 * Filter site_layout.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ciyashop_site_layout width of header.
	 */
	$site_layout = apply_filters( 'ciyashop_site_layout', $site_layout );

	return $site_layout;
}

/****************************************************
 *
 * Logo Settings
 *
 ****************************************************/
function ciyashop_logo_type(){
	global $ciyashop_options;

	$logo_type = 'image';
	if( isset($ciyashop_options['logo_type']) && $ciyashop_options['logo_type'] != '' ){
		$logo_type = $ciyashop_options['logo_type'];
	}

	$logo_type = apply_filters( 'ciyashop_logo_type', $logo_type, $ciyashop_options );

	return $logo_type;
}

function ciyashop_logo_url(){
	global $ciyashop_options;

	$logo_url = get_parent_theme_file_uri('/images/logo.png');

	if( isset($ciyashop_options['site-logo']) && !empty($ciyashop_options['site-logo']['url']) ){
		$logo_url = $ciyashop_options['site-logo']['url'];
	}

	// Replace with Mobile log if on mobile device.
	if ( wp_is_mobile() && ciyashop_mobile_logo_url() ) {
		$logo_url = ciyashop_mobile_logo_url();
	}

	$logo_url = apply_filters( 'ciyashop_logo_url', $logo_url, $ciyashop_options );

	return $logo_url;
}

function ciyashop_sticky_logo_url(){
	global $ciyashop_options;

	$logo_url = get_parent_theme_file_uri('/images/logo-sticky.png');

	if( isset($ciyashop_options['sticky-logo']) && !empty($ciyashop_options['sticky-logo']['url']) ){
		$logo_url = $ciyashop_options['sticky-logo']['url'];
	}

	$logo_url = apply_filters( 'ciyashop_sticky_logo_url', $logo_url, $ciyashop_options );

	return $logo_url;
}

function ciyashop_mobile_logo_url(){
	global $ciyashop_options;

	$logo_url = false;

	if( isset($ciyashop_options['mobile-logo']) && !empty($ciyashop_options['mobile-logo']['url']) ){
		$logo_url = $ciyashop_options['mobile-logo']['url'];
	}

	$logo_url = apply_filters( 'ciyashop_mobile_logo_url', $logo_url, $ciyashop_options );

	return $logo_url;
}

//site Mobile logo settings
if( !function_exists('ciyashop_get_site_mobile_logo') ):
function ciyashop_get_site_mobile_logo(){
	global $ciyashop_options;
	
	if(isset($ciyashop_options['logo_type']) && $ciyashop_options['logo_type']=='image' && isset($ciyashop_options['mobile-logo']) && isset($ciyashop_options['mobile-logo']['url']) ){
		return $ciyashop_options['mobile-logo']['url'];
	}
	
	return false;
}
endif;

//site sticky logo settings
if( !function_exists('ciyashop_get_site_sticky_logo') ):
function ciyashop_get_site_sticky_logo(){
	global $ciyashop_options;

	if(isset($ciyashop_options['logo_type']) && $ciyashop_options['logo_type']=='image' &&  isset($ciyashop_options['sticky-logo']) && isset($ciyashop_options['sticky-logo']['url']) ){
		return $ciyashop_options['sticky-logo']['url'];
	}
	
	return false;
}
endif;

/**
 * site multi lang settings
 */
function ciyashop_get_multi_lang(){
	global $ciyashop_options;

	/*Checl WPML sitepress multilingual plugin activate */
	if( ciyashop_check_plugin_active('sitepress-multilingual-cms/sitepress.php') && function_exists('icl_get_languages') ){
		$ls_settings = get_option('icl_sitepress_settings');
		$languages = icl_get_languages();

		if(!empty($languages)){
			?>
			<div class="language" id="drop">
				<?php
				/* Display Current language */
				foreach($languages as $k => $al ){
					if ( $al[ 'active' ] == 1 ) {
						?>
						<a href="#">
							<?php
							if($al['country_flag_url'] && ( isset($ls_settings['icl_lso_flags']) && $ls_settings['icl_lso_flags']==1 ) ){
								?>
								<img src="<?php echo esc_url($al['country_flag_url']);?>" height="12" alt="<?php echo esc_attr($al['language_code']);?>" width="18" />&nbsp;
								<?php
							}
							echo icl_disp_language($al['native_name'], $al['translated_name']). '&nbsp;<i class="fa fa-angle-down">&nbsp;</i>';
							?>
						</a>
						<?php
						unset( $languages[ $k ] );
						break;
					}
				}
				?>
				<ul class="drop-content">
					<?php
					foreach($languages as $l){
						if(!$l['active']){
							?>
							<li>
								<a href="<?php echo esc_url($l['url']);?>">
									<?php
									if($l['country_flag_url'] && $ls_settings['icl_lso_flags']==1){
										?>
										<img src="<?php echo esc_url($l['country_flag_url']);?>" height="12" alt="<?php echo esc_attr($l['language_code']);?>" width="18" />
										<?php
									}
									if($ls_settings['icl_lso_native_lang']==1){
										echo icl_disp_language($l['native_name'], $l['translated_name']);
									}else{
										echo icl_disp_language($l['native_name']);
									}
									?>
								</a>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<?php
		}
	}
}

/**
 * site login options settings
 */
function ciyashop_get_login_options($items, $args){
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		if (!is_user_logged_in() && $args->theme_location == 'top_menu') {
			$items .= '<li><a href="javascript:void(0);" data-toggle="modal" data-target="#pgs_login_form"><i class="fa fa-sign-in">&nbsp;</i> '.esc_html__('Login', 'ciyashop' ).'</a></li>';
		} elseif (is_user_logged_in() && $args->theme_location == 'top_menu') {
			$items .= '<li><a href="' . esc_url( wp_logout_url( home_url()) ) . '" title="'.esc_attr__('Logout', 'ciyashop' ).'" class="logout"><i class="fa fa-sign-out">&nbsp;</i>  '.esc_html__('Logout', 'ciyashop' ).'</a></li>';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'ciyashop_get_login_options', 10, 2 );

function ciyashop_footer_copyright(){
	global $ciyashop_options;

	$allowed_tags = wp_kses_allowed_html('post');

	$footer_copyright = sprintf( esc_html__( 'Copyright', 'ciyashop' ).' &copy; <span class="copy_year">%1$s</span>, <a href="%2$s" title="%3$s">%4$s</a> '.esc_html__( 'All Rights Reserved.', 'ciyashop' ),
		date('Y'),
		esc_url( home_url( '/' ) ),
		esc_attr( get_bloginfo( 'name', 'display' ) ),
		esc_html( get_bloginfo( 'name', 'display' ) )
	);

	if( isset( $ciyashop_options['footer_copyright'] ) && !empty( $ciyashop_options['footer_copyright'] ) ){
		$footer_copyright = $ciyashop_options['footer_copyright'];
		$footer_copyright = do_shortcode( $footer_copyright );
	}

	// Filter copyright content
	$footer_copyright = apply_filters( 'ciyashop_footer_copyright', $footer_copyright );

	// Filter before copyright content
	$footer_copyright_before = apply_filters( 'ciyashop_footer_copyright_before', '' );

	// Filter after copyright content
	$footer_copyright_after = apply_filters( 'ciyashop_footer_copyright_after', '' );

	$footer_copyright = $footer_copyright_before . $footer_copyright . $footer_copyright_after;

	echo wp_kses($footer_copyright, array(
		'a'     => $allowed_tags['a'],
		'br'    => $allowed_tags['br'],
		'em'    => $allowed_tags['em'],
		'strong'=> $allowed_tags['strong'],
		'span'  => $allowed_tags['span'],
		'div'   => $allowed_tags['div'],
	));
}

function ciyashop_footer_credits(){
	global $ciyashop_options;

	$ciyashop_credits = sprintf(
		// Translators: %s is the theme credit link.
		esc_html__( 'Developed and designed by %s', 'ciyashop' ),
		'<a href="http://www.potenzaglobalsolutions.com/">' . esc_html__( 'Potenza Global Solutions', 'ciyashop' ) . '</a>'
	);

	if( isset($ciyashop_options['develop_by']) && !empty($ciyashop_options['develop_by']) ){
		$ciyashop_credits = $ciyashop_options['develop_by'];
	}

	// Filter copyright content
	$ciyashop_credits = apply_filters( 'ciyashop_credits', $ciyashop_credits );

	echo wp_kses( $ciyashop_credits, ciyashop_allowed_html( array('i','a','span', 'div', 'ul', 'ol', 'li')) );
}

/**
 * Get product listing page sidebar settings.
 */
function ciyashop_shop_page_sidebar(){
	global $ciyashop_options;

	if( !isset($ciyashop_options) || empty($ciyashop_options) ) return 'left';

	$shop_sidebar = ( isset($ciyashop_options['shop_sidebar']) && !empty($ciyashop_options['shop_sidebar']) ) ? $ciyashop_options['shop_sidebar'] : 'left';

	return $shop_sidebar;
}

function ciyashop_product_page_sidebar(){
	global $ciyashop_options;

	if( !isset($ciyashop_options) || empty($ciyashop_options) ) return 'left';

	$product_sidebar = ( isset($ciyashop_options['product-page-sidebar']) && !empty($ciyashop_options['product-page-sidebar']) ) ? $ciyashop_options['product-page-sidebar'] : 'left';

	return $product_sidebar;
}

function ciyashop_show_sidebar_on_mobile(){
	global $ciyashop_options;

	if( isset($ciyashop_options['show_sidebar_on_mobile']) && $ciyashop_options['show_sidebar_on_mobile'] != '' ){
		return $ciyashop_options['show_sidebar_on_mobile'];
	}
	
	return 'on';
}

function ciyashop_mobile_sidebar_position(){
	global $ciyashop_options;

	if( isset($ciyashop_options['shop_sidebar_position_mobile']) && !empty($ciyashop_options['shop_sidebar_position_mobile']) ){
		return $ciyashop_options['shop_sidebar_position_mobile'];
	}
	
	return 'bottom';
}

function ciyashop_device_type(){
	return wp_is_mobile() ? 'mobile' : 'desktop';
}

/**
 * This function use for search woocommerce category based filtering
 */
add_action( 'pre_get_posts','ciyashop_product_cat_search' );
function ciyashop_product_cat_search($query){
	global $wp_the_query;

	if ( $query->is_main_query() && !empty( $wp_the_query->query_vars['wc_query'] ) && isset($_GET['search_category']) && $_GET['search_category'] != '' ){

		$product_tax_query = array(
			array(
				'taxonomy'=> 'product_cat',
				'field'   => 'id',
				'terms'   => sanitize_text_field( wp_unslash( $_GET['search_category'] ) ),
			)
		);
		$query->set( 'tax_query', $product_tax_query );
	}
}

/*
 * Remove pre get pots action for search product category base search
 */
add_action('wp_head','ciyashop_remove_pre_get_posts');
function ciyashop_remove_pre_get_posts(){
	global $wp_the_query;
	if ( !empty( $wp_the_query->query_vars['wc_query'] ) && isset($_GET['search_category']) && $_GET['search_category'] != '' ){
		remove_action( 'pre_get_posts','ciyashop_product_cat_search' );
	}
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'ciyashop_loop_columns');
if (!function_exists('ciyashop_loop_columns')) {
	function ciyashop_loop_columns() {
		global $ciyashop_options;
		$pro_col_sel = 4;
		if(isset($ciyashop_options['pro-col-sel']) && !empty($ciyashop_options['pro-col-sel'])){
			$pro_col_sel = $ciyashop_options['pro-col-sel'];
		}
		return $pro_col_sel; // 3 products per row
	}
}

function ciyashop_is_plugin_installed($search){
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	$plugins = array_filter( array_keys($plugins), function($k){
		if( strpos($k, '/') !== false ) return true;
	});
	$plugins_stat = function($plugins, $search){
		$new_plugins = array();
		foreach($plugins as $plugin){
			$new_plugins_data = explode('/', $plugin);
			$new_plugins[] = $new_plugins_data[0];
		}
		return in_array($search, $new_plugins);
	};
	return $plugins_stat($plugins, $search);
}

/* Change site name to home in breadcrumb */
add_filter('bcn_breadcrumb_title','ciyashop_bcn_breadcrumb_title',10,3);
function ciyashop_bcn_breadcrumb_title($title, $type, $id){
	if($type[0]=='home'){
		$title=esc_html__('Home', 'ciyashop' );
	}
	return $title;
}

function ciyashop_class_builder( $class = '' ){
	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}
	$classes = array_map( 'esc_attr', $classes );

	return implode( ' ', array_filter( array_unique( $classes ) ) );
}

function ciyashop_header_type(){

	global $ciyashop_options;
	
	$ciyashop_header_type = (!empty($ciyashop_options['header_type'])) ? $ciyashop_options['header_type'] : 'menu-center';

	/**
	 * Filter header_type.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ciyashop_header_type type of header.
	 */
	$ciyashop_header_type = apply_filters( 'ciyashop_header_type', $ciyashop_header_type );

	return $ciyashop_header_type;
}

function ciyashop_categories_menu_status(){

	global $ciyashop_options;

	if( isset($ciyashop_options['categories_menu_status']) && !empty($ciyashop_options['categories_menu_status']) ){
		$ciyashop_header_type = ciyashop_header_type();
		$categories_menu_status = in_array( $ciyashop_header_type, array('default', 'logo-center', 'topbar-with-main-header') ) ? $ciyashop_options['categories_menu_status'] : 'disable';
	}else{
		$categories_menu_status = 'disable';
	}

	/**
	 * Filter ciyashop_categories_menu_status.
	 *
	 * @since 1.0.0
	 *
	 * @param array $categories_menu_status type of header.
	 */
	$categories_menu_status = apply_filters( 'ciyashop_categories_menu_status', $categories_menu_status );

	return $categories_menu_status;
}

function ciyashop_topbar_enable(){

	global $ciyashop_options;

	$topbar_enable_stat = ( isset($ciyashop_options['topbar_enable']) && $ciyashop_options['topbar_enable'] != '' ) ? $ciyashop_options['topbar_enable'] : true;
	
	if( $topbar_enable_stat ){
		$topbar_enable = 'enable';
	}else{
		$topbar_enable = 'disable';
	}

	/**
	 * Filter header_type.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ciyashop_header_type type of header.
	 */
	$topbar_enable = apply_filters( 'ciyashop_topbar_enable', $topbar_enable );

	return $topbar_enable;
}

function ciyashop_topbar_mobile_enable(){

	global $ciyashop_options;

	$topbar_mobile_enable_stat = ( isset($ciyashop_options['topbar_mobile_enable']) && $ciyashop_options['topbar_mobile_enable'] != '' ) ? $ciyashop_options['topbar_mobile_enable'] : true;

	if( $topbar_mobile_enable_stat && ciyashop_topbar_enable() == 'enable' ){
		$topbar_mobile_enable = 'enable';
	}else{
		$topbar_mobile_enable = 'disable';
	}

	/**
	 * Filter header_type.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ciyashop_header_type type of header.
	 */
	$topbar_mobile_enable = apply_filters( 'ciyashop_topbar_mobile_enable', $topbar_mobile_enable );

	return $topbar_mobile_enable;
}

function ciyashop_social_profiles(){
	global $ciyashop_options;
	$social_profiles = apply_filters('ciyashop_social_profiles',array(
		'facebook' => array(
			'key'      => 'facebook',
			'name'     => esc_html__('Facebook', 'ciyashop' ),
			'icon'     => '<i class="fa fa-facebook"></i>',
		),
		'twitter'  => array(
			'key'          => 'twitter',
			'name'         => esc_html__('Twitter', 'ciyashop' ),
			'icon'         => '<i class="fa fa-twitter"></i>',
		),
		'googleplus'  => array(
			'key'          => 'googleplus',
			'name'         => esc_html__('Google+', 'ciyashop' ),
			'icon'         => '<i class="fa fa-google-plus"></i>',
		),
		'dribbble'  => array(
			'key'          => 'Dribbble',
			'name'         => esc_html__('Dribbble', 'ciyashop' ),
			'icon'         => '<i class="fa fa-dribbble"></i>',
		),
		'vimeo'    => array(
			'key'          => 'vimeo',
			'name'         => esc_html__('Vimeo', 'ciyashop' ),
			'icon'         => '<i class="fa fa-vimeo"></i>',
		),
		'pinterest'=> array(
			'key'          => 'pinterest',
			'name'         => esc_html__('Pinterest', 'ciyashop' ),
			'icon'         => '<i class="fa fa-pinterest"></i>',
		),
		'behance'  => array(
			'key'          => 'behance',
			'name'         => esc_html__('Behance', 'ciyashop' ),
			'icon'         => '<i class="fa fa-behance"></i>',
		),
		'linkedin' => array(
			'key'          => 'linkedin',
			'name'         => esc_html__('Linkedin', 'ciyashop' ),
			'icon'         => '<i class="fa fa-linkedin"></i>',
		),
		'youtube' => array(
			'key'          => 'youtube',
			'name'         => esc_html__('YouTube', 'ciyashop' ),
			'icon'         => '<i class="fa fa-youtube-play"></i>',
		),
		'instagram' =>array(
			'key'          => 'instagram',
			'name'         => esc_html__('instagram', 'ciyashop' ),
			'icon'         => '<i class="fa fa-instagram"></i>',
		),
	));

	if( !isset($ciyashop_options['social_media_icons']) || $ciyashop_options['social_media_icons'] == '' ){
		return '';
	}
	$total_social_icon = count( $ciyashop_options['social_media_icons']['redux_repeater_data'] );
	
	$social_profiles_data = array();
	for( $i=0; $i<$total_social_icon; $i++ ){
		if($ciyashop_options['social_media_icons']['social_media_type'][$i]=='custom'){
			$social_icon_href = $ciyashop_options['social_media_icons']['social_media_url'][$i];
			$social_icon      = $ciyashop_options['social_media_icons']['custom_soical_icon'][$i];
			$social_title     = $ciyashop_options['social_media_icons']['custom_social_title'][$i];

			if( !empty($social_icon_href) && !empty($social_icon) ){
				$social_profiles_data[] = array(
					'link'  => esc_url($social_icon_href),
					'icon'  => '<i class="'.esc_attr('fa '.$social_icon).'"></i>',
					'title' => esc_attr($social_title),
				);
			}
		}else{
			$social_icon_href = $ciyashop_options['social_media_icons']['social_media_url'][$i];
			$social_icon      = $ciyashop_options['social_media_icons']['social_media_type'][$i];
			$social_title     = ucfirst($ciyashop_options['social_media_icons']['social_media_type'][$i]);

			if( !empty($social_icon_href) ){
				$social_profiles_data[] = array(
					'link'  => esc_url($social_icon_href),
					'icon'  => $social_profiles[$social_icon]['icon'],
					'title' => esc_attr($social_title),
				);
			}
		}
	}
	return $social_profiles_data;
}


function ciyashop_opening_hours(){
	global $ciyashop_options;

	$ciyashop_opening_hours_data =  array(

		esc_html__( 'Monday', 'ciyashop' )    => isset( $ciyashop_options['mon_time']) ? $ciyashop_options['mon_time'] : '',
		esc_html__( 'Tuesday', 'ciyashop' )   => isset( $ciyashop_options['tue_time']) ? $ciyashop_options['tue_time'] : '',
		esc_html__( 'Wednesday', 'ciyashop' ) => isset( $ciyashop_options['wed_time']) ? $ciyashop_options['wed_time'] : '',
		esc_html__( 'Thursday', 'ciyashop' )  => isset( $ciyashop_options['thu_time']) ? $ciyashop_options['thu_time'] : '',
		esc_html__( 'Friday', 'ciyashop' )    => isset( $ciyashop_options['fri_time']) ? $ciyashop_options['fri_time'] : '',
		esc_html__( 'Saturday', 'ciyashop' )  => isset( $ciyashop_options['sat_time']) ? $ciyashop_options['sat_time'] : '',
		esc_html__( 'Sunday', 'ciyashop' )    => isset( $ciyashop_options['sun_time']) ? $ciyashop_options['sun_time'] : '',

	);
	return $ciyashop_opening_hours_data;
}

/*
 * Return whether Visual Composer is enabled on a page/post or not.
 *
 * $post_id = numeric post_id
 * return true/false
 */
function ciyashop_is_vc_enabled( $post_id = '' ){
	global $post;

	if( is_search() || is_404() || empty($post)  ) return;

	if( empty( $post_id ) ){
		$post_id = $post->ID;
	}
	$vc_enabled = get_post_meta( $post_id, '_wpb_vc_js_status', true );
	return ($vc_enabled=='true')? true : false;
}

/**
 * Converts a multidimensional array of CSS rules into a CSS string.
 *
 * @param array $rules
 *   An array of CSS rules in the form of:
 *   array('selector'=>array('property' => 'value')). Also supports selector
 *   nesting, e.g.,
 *   array('selector' => array('selector'=>array('property' => 'value'))).
 *
 * @return string
 *   A CSS string of rules. This is not wrapped in style tags.
 *
 * source : http://www.grasmash.com/article/convert-nested-php-array-css-string
 */
function ciyashop_generate_css_properties($rules, $indent = 0) {
	$css = '';
	$prefix = str_repeat('  ', $indent);
	foreach ($rules as $key => $value) {
		if (is_array($value)) {
			$selector = $key;
			$properties = $value;

			$css .= $prefix . "$selector {\n";
			$css .= $prefix .ciyashop_generate_css_properties($properties, $indent + 1);
			$css .= $prefix . "}\n";
		}
		else {
			$property = $key;
			$css .= $prefix . "$property: $value;\n";
		}
	}
	return $css;
}

function ciyashop_get_file_list( $extensions = '', $path = '' ){

	// Return if any paramater is blank
	if( empty($extensions) || empty($path) ){
		return false;
	}

	// Convert to array if string is provided
	if( !is_array($extensions) ){
		$extensions = array_filter( explode(',', $extensions) );
	}

	// Fix trailing slash if not provided.
	$path = rtrim( $path, '/\\' ) . '/';

	if ( defined( 'GLOB_BRACE' ) ){
		if( count($extensions) == 1 && $extensions[0] == '*' ){
			$files_with_glob = glob( $path."*", GLOB_BRACE );
		}else{
			$extensions_with_glob_brace = "{". implode(',', $extensions)."}"; // file extensions pattern
			$files_with_glob = glob( $path."*.$extensions_with_glob_brace", GLOB_BRACE );
		}

		return $files_with_glob;
	}else{
		if( count($extensions) == 1 && $extensions[0] == '*' ){
			$files_without_glob = glob( $path."*" );
		}else{
			$extensions_without_glob = implode('|', $extensions); // file extensions pattern


			$files_without_glob_all = glob( $path.'*.*' ); // Get all files


			$files_without_glob = array_values( preg_grep("~\.($extensions_without_glob)$~", $files_without_glob_all) ); // Filter files with pattern
		}
		return $files_without_glob;
	}

	return $files;
}

add_action('wp_footer','ciyashop_promo_popup');
function ciyashop_promo_popup(){
	global $ciyashop_options;
	$content_css   = '';

	if(isset($ciyashop_options['promo_popup']) && $ciyashop_options['promo_popup']){

		$content_style = array();

		// Background
		if( isset($ciyashop_options['popup-background']['background-color']) && !empty($ciyashop_options['popup-background']['background-color']) && $ciyashop_options['popup-background']['background-color'] != 'transparent' ){
			$content_style['background-color'] = 'background-color:'.$ciyashop_options['popup-background']['background-color'];
		}
		if( isset($ciyashop_options['popup-background']['background-repeat']) && !empty($ciyashop_options['popup-background']['background-repeat']) ){
			$content_style['background-repeat'] = 'background-repeat:'.$ciyashop_options['popup-background']['background-repeat'];
		}
		if( isset($ciyashop_options['popup-background']['background-size']) && !empty($ciyashop_options['popup-background']['background-size']) ){
			$content_style['background-size'] = 'background-size:'.$ciyashop_options['popup-background']['background-size'];
		}
		if( isset($ciyashop_options['popup-background']['background-attachment']) && !empty($ciyashop_options['popup-background']['background-attachment']) ){
			$content_style['background-attachment'] = 'background-attachment:'.$ciyashop_options['popup-background']['background-attachment'];
		}
		if( isset($ciyashop_options['popup-background']['background-position']) && !empty($ciyashop_options['popup-background']['background-position']) ){
			$content_style['background-position'] = 'background-position:'.$ciyashop_options['popup-background']['background-position'];
		}
		if( isset($ciyashop_options['popup-background']['background-image']) && !empty($ciyashop_options['popup-background']['background-image']) ){
			$content_style['background-image'] = 'background-image:url('.$ciyashop_options['popup-background']['background-image'].')';
		}

		if( $content_style && is_array($content_style) && !empty($content_style) ){
			$content_css = implode( ';', array_filter( array_unique( $content_style ) ) );
		}

		?>
		<div class="ciyashop-promo-popup mfp-hide">
			<div class="ciyashop-popup-inner" style="<?php echo esc_attr($content_css);?>">
				<?php echo do_shortcode( $ciyashop_options['popup_text']); ?>
			</div>
		</div>
		<?php
	}
}

// Convert hexdec color string to rgb(a) string
// Source : https://support.advancedcustomfields.com/forums/topic/color-picker-values/
function ciyashop_hex2rgba($color = '', $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color)) return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",", $rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",", $rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

function ciyashop_hex2rgb( $color ) {
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	if (strlen($color) == 6) {
		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif (strlen($color) == 3) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}

	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	return array( 'r' => $r, 'g' => $g, 'b' => $b );
}

function ciyashop_sticky_header(){
	global $ciyashop_options;

	$sticky_header = isset($ciyashop_options['sticky_header']) ? $ciyashop_options['sticky_header'] : true;

	$sticky_header = apply_filters( 'ciyashop_sticky_header', $sticky_header, $ciyashop_options );

	return $sticky_header;
}

function ciyashop_mobile_sticky_header(){
	global $ciyashop_options;

	$ciyashop_sticky_header = ciyashop_sticky_header();

	if( !$ciyashop_sticky_header ) return false;

	$mobile_sticky_header = isset($ciyashop_options['mobile_sticky_header']) ? $ciyashop_options['mobile_sticky_header'] : true;

	$mobile_sticky_header = apply_filters( 'ciyashop_mobile_sticky_header', $mobile_sticky_header, $ciyashop_options );

	return $mobile_sticky_header;
}

/*
 * Display Related Post in single blog post
 */
function ciyashop_related_posts(){
	global $ciyashop_options;

	$related_posts = ( isset($ciyashop_options['related_posts']) ) ? $ciyashop_options['related_posts'] : false;

	if( $related_posts == 0 ){
		return;
	}

	$category_terms = wp_get_post_terms( get_the_ID(), 'category');
	$cat_id=array();
	if(!empty($category_terms)){
		foreach($category_terms as $value){
			$cat_id[]=$value->term_id;
		}
	}
	$args = array(
		'post_type'     => 'post',
		'posts_per_page'=> 10,
		'post__not_in'  => array(get_the_ID()),
		'tax_query'     => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $cat_id,
			),
		),
	);
	$portfolio_query = new WP_Query( $args );

	$owl_options_args = array(
		'items'             => 3,
		'loop'              => false,
		'dots'              => false,
		'nav'               => true,
		'margin'            => 10,
		'autoplay'          => true,
		'autoplayHoverPause'=> true,
		'smartSpeed'        => 1000,
		'responsive'        => array(
			0    => array(
				'items'=> 1,
			),
			480  => array(
				'items'=> 1,
			),
			577 => array(
				'items' => 2,
			),
			980 => array(
				'items' => 3,
			),
			1200 => array(
				'items' => 3,
			),
		),
		'navText' => array(
			"<i class='fa fa-angle-left fa-2x'>&nbsp;</i>",
			"<i class='fa fa-angle-right fa-2x'>&nbsp;</i>",
		),
	);

	$owl_options = '';
	if( is_array($owl_options_args) && !empty($owl_options_args) ){
		$owl_options = json_encode($owl_options_args);
	}
	?>
	<div class="related-posts">
		<h3 class="title"><?php esc_html_e('Related Posts','ciyashop' );?></h3>
		<div class="related-posts-section">
			<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
			<?php
			if($portfolio_query->have_posts()){
				while($portfolio_query->have_posts()){ $portfolio_query->the_post(); ?>
					<div class="item">
						<div class="related-post-info">
							<div class="post-image clearfix<?php echo ( !has_post_thumbnail() ) ? ' no-post-image' : '';?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'ciyashop-recent-post', array('img-fluid') );
								}
								?>
							</div>
							<span class="post-<?php echo ( !has_post_thumbnail() ) ? 'no-image-text' : 'image-text';?>">
								<?php the_title( '<h5 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
							</span>
						</div>
					</div>
				<?php }
			}
			wp_reset_postdata();
			?>
			</div>
		</div>
	</div>
	<?php
}

/*
 * Display Author box in single blog post
 */
function ciyashop_authorbox(){
	global $ciyashop_options;

	$author_details = ( isset($ciyashop_options['author_details']) ) ? $ciyashop_options['author_details'] : true;

	if( $author_details == 0 )
		return;

	if ( is_singular() && get_the_author_meta( 'description' ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
		<div class="author-info">
			<div class="author-avatar media-left">
				<?php
				/** This filter is documented in author.php */
				$author_bio_avatar_size = apply_filters( 'ciyashop_author_bio_avatar_size', 68 );
				echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
				?>
			</div><!-- .author-avatar -->
			<div class="author-description media-body">
				<h5 class="title author-title"><?php printf( esc_html__( 'About %s', 'ciyashop' ), get_the_author() ); ?></h5>
				<p><?php the_author_meta( 'description' ); ?></p>
			</div><!-- .author-description -->
		</div><!-- .author-info -->
		<?php
	endif;
}

/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function ciyashop_shorten_string($string = '', $maxLength, $addEllipsis = true, $wordsafe = false){
	if( empty($string) ){
		$string;
	}
	$ellipsis = '';
	$maxLength = max($maxLength, 0);
	if (mb_strlen($string) <= $maxLength) {
		return $string;
	}
	if ($addEllipsis) {
		$ellipsis = mb_substr('...', 0, $maxLength);
		$maxLength -= mb_strlen($ellipsis);
		$maxLength = max($maxLength, 0);
	}
	if ($wordsafe) {
		$string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $maxLength));
	} else {
		$string = mb_substr($string, 0, $maxLength);
	}
	if ($addEllipsis) {
		$string .= $ellipsis;
	}

	return $string;
}

function ciyashop_get_excerpt_max_charlength($charlength, $excerpt = null) {
	if( empty($excerpt) ){
		$excerpt = get_the_excerpt();
	}
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

		$new_excerpt = '';
		if ( $excut < 0 ) {
			$new_excerpt = mb_substr( $subex, 0, $excut );
		} else {
			$new_excerpt = $subex;
		}
		$new_excerpt .= '[...]';
		return $new_excerpt;
	}
	
	return $excerpt;
}
function ciyashop_the_excerpt_max_charlength($charlength, $excerpt = null) {
	echo ciyashop_get_excerpt_max_charlength($charlength, $excerpt);
}

function ciyashop_validate_css_unit( $str = '', $units = array() ){

	// bail early if any param is empty
	if( !is_string($str) || $str == '' || !is_array($units) || empty($units) ) return false;

	// prepare units string
	$units_str = implode('|',$units);

	// prepare regex
	$reg_ex = '/^(auto|0)$|^[+-]?[0-9]+.?([0-9]+)?('.$units_str.')$/';

	// check match
	preg_match_all($reg_ex, $str, $matches, PREG_SET_ORDER, 0);

	// check if matched found.
	if( count($matches) > 0 ) return true;

	return false;
}

/*
 * Update Theme option favicon icon from customizer site icon
 */
add_action('customize_save_response', 'ciyashop_customize_save_response', 10, 2);
function ciyashop_customize_save_response($response, $data){
	global $ciyashop_globals;

	if( isset($_POST['customized']) ){
		$post_values = json_decode( sanitize_text_field( wp_unslash( $_POST['customized'] ) ), true );

		if( isset($post_values['site_icon']) && $post_values['site_icon'] != '' ){
			$opt_name         = $ciyashop_globals['theme_option'];
			$ciyashop_options= get_option( $opt_name );
			$site_icon        = $post_values['site_icon'];
			$img              = wp_get_attachment_image_src( $site_icon, 'full' );
			$thumbnail        = wp_get_attachment_image_src( $site_icon, 'thumbnail' );

			$ciyashop_options['favicon_icon']['url']      = $img[0];
			$ciyashop_options['favicon_icon']['id']       = $site_icon;
			$ciyashop_options['favicon_icon']['width']    = $img[1];
			$ciyashop_options['favicon_icon']['height']   = $img[2];
			$ciyashop_options['favicon_icon']['thumbnail']= $thumbnail[0];
			update_option( $opt_name, $ciyashop_options );
		}
	}

	return $response;
}

/*
 * Update customizer site icon from theme option favicon icon
 */
add_filter( "redux/options/ciyashop_options/ajax_save/response", 'ciyashop_option_save' );
function ciyashop_option_save( $response ){
	if( isset($response['options']['favicon_icon']) && !empty($response['options']['favicon_icon']) ){
		$site_icon = get_option( 'site_icon' );
		$favicon_icon = $response['options']['favicon_icon']['id'];
		if( $favicon_icon != $site_icon){
			update_option( 'site_icon', $favicon_icon);
		}
	}

	return $response;
}

function ciyashop_get_product_categories(){
	$cat_titles = array();

	if( is_admin() ){
		$args = array(
			'type'        => 'post',
			'orderby'     => 'id',
			'order'       => 'DESC',
			'hide_empty'  => false,
			'hierarchical'=> 1,
			'taxonomy'    => 'product_cat',
			'pad_counts'  => false,
		);

		$post_categories = get_categories($args);


		foreach( $post_categories as $cat ) {
			$cat_titles[$cat->term_id] = $cat->name;
		}
	}
	return $cat_titles;
}

if ( ! function_exists( 'ciyashop_array_unshift_assoc' ) ) {
	function ciyashop_array_unshift_assoc( &$arr, $key, $val ) {
		$arr        = array_reverse( $arr, true );
		$arr[ $key ]= $val;
		$arr        = array_reverse( $arr, true );
	}
}

function ciyashop_allowed_html( $allowed_els = '' ){

	// bail early if parameter is empty
	if( empty($allowed_els) ) return array();

	if( is_string($allowed_els) ){
		$allowed_els = explode(',', $allowed_els);
	}

	$allowed_html = array();

	$allowed_tags = wp_kses_allowed_html('post');

	foreach( $allowed_els as $el ){
		$el = trim($el);
		if( array_key_exists($el, $allowed_tags) ){
			$allowed_html[$el] = $allowed_tags[$el];
		}
	}

	return $allowed_html;
}

//ciyashop_auto_complate_search
add_action('wp_ajax_ciyashop_auto_complete_search','ciyashop_auto_complete_search');
add_action('wp_ajax_nopriv_ciyashop_auto_complete_search','ciyashop_auto_complete_search');

function ciyashop_auto_complete_search(){
	global $ciyashop_options, $post;

	$search_keyword   = isset( $_POST['search_keyword'] ) ? sanitize_text_field( wp_unslash( $_POST['search_keyword'] ) ) : '';
	$search_category  = isset( $_POST['search_category'] ) ? sanitize_text_field( wp_unslash( $_POST['search_category'] ) ) : '';

	$post_titles = array();

	$taxonomy = ($ciyashop_options['search_content_type']=='product') ? 'product_cat' : 'category';
	$post_type = (!empty($ciyashop_options['search_content_type'])) ? $ciyashop_options['search_content_type'] : 'post';

	if($post_type == 'all'){
		$post_type = 'any';
	}

	$args = array(
		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);

	if( !empty($search_keyword) ){
		$args['s'] = $search_keyword;
	}

	if(!empty($search_category)){
		$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'id',
			'terms'    => $search_category,
		 );
	}

	$posts = new WP_Query( $args );

	while ( $posts->have_posts() ) : $posts->the_post();
		$img = get_the_post_thumbnail($posts->ID,'pgscore-50x50');
		$data[] = array(
			'post_title' => $post->post_title,
			'post_img' => $img,
			'post_link' => get_the_permalink( $post->ID )
		);
    endwhile;
	wp_reset_query();

	echo json_encode($data);
    exit();
}

//function to convert google font field values in valid formate and enqueue style
function ciyashop_get_google_fonts_css( $google_fonts, $enqueue_google_font = true ){

	//default value for font fields value
	$fields = array();
	$text_style = array();

	$google_fonts_data = ciyashop_parse_multi_attribute( $google_fonts, array(
		'font_style' => isset( $fields['font_style'] ) ? $fields['font_style'] : '',
		'font_family' => isset( $fields['font_family'] ) ? $fields['font_family'] : '',
	) );

	//convert values in to the valid array
	if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data, $google_fonts_data['font_family'], $google_fonts_data['font_style'] ) ) {
		$google_fonts_family = explode( ':', $google_fonts_data['font_family'] );
		$text_style['font-family'] = 'font-family:' . $google_fonts_family[0].';';
		$google_fonts_styles = explode( ':', $google_fonts_data['font_style']);
		$text_style['font-weight'] = 'font-weight:' . $google_fonts_styles[1].';';
		$text_style['font-style'] = 'font-style:' . $google_fonts_styles[2].';';
	}

	if( isset( $google_fonts_data['font_family'] ) ){
		$google_font_style ='vc_google_fonts_' . ciyashop_build_safe_css_class( $google_fonts_data['font_family']);
	}

	//check if already enqueued style
	if ( isset($google_font_style) && !wp_style_is( $google_font_style ) && $enqueue_google_font ) {
		wp_enqueue_style( $google_font_style, '//fonts.googleapis.com/css?family=' . $google_fonts_data['font_family'] );
	}

	return $text_style;
}

// Show product listing on mini cart for cart and check-out page
add_filter( 'woocommerce_widget_cart_is_hidden', 'ciyashop_widget_cart_is_hidden' ) ;
function ciyashop_widget_cart_is_hidden(){
	return false;
}

function ciyashop_check_plugin_active( $plugin = '' ) {

	if( empty($plugin) ) return false;

	return ( in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || ( function_exists('is_plugin_active_for_network') && is_plugin_active_for_network($plugin) ) );
}

add_action('ciyashop_before_footer', 'ciyashop_sticky_footer_mobile_device');
function ciyashop_sticky_footer_mobile_device() {
	global $ciyashop_options;
		
	if ( ( isset($ciyashop_options['woocommerce_mobile_sticky_footer']) && $ciyashop_options['woocommerce_mobile_sticky_footer'] ) && ( function_exists('is_product') && !is_product() ) && wp_is_mobile() ) {
		get_template_part( 'template-parts/footer/sticky-footer-mobile' );
	}
}