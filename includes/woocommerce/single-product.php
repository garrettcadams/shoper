<?php
add_action( 'woocommerce_before_single_product', 'ciyashop_woocommerce_init_single_product' );
function ciyashop_woocommerce_init_single_product(){
	global $ciyashop_options;
	
	// Show Hide Short Descriptions
	if( isset($ciyashop_options['product-short-description']) && $ciyashop_options['product-short-description'] == 0 ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	}
	
	// Show Hide Hot
	if( isset($ciyashop_options['product-short-description']) && $ciyashop_options['product-short-description'] == 0 ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	}
}

// Show Size Guide Image for product
add_action( 'woocommerce_single_product_summary', 'ciyashop_product_size_guide', 25 );
function ciyashop_product_size_guide(){
	$size_guide_image_data ='';
	
	if(function_exists('get_field')){
		$size_guide_image_data = get_field('size_guide_image');
	}
	
	$mfp_options_args = array(
		'type' => 'image',
	);
	
	$mfp_options = '';
	if( is_array($mfp_options_args) && !empty($mfp_options_args) ){
		$mfp_options = json_encode($mfp_options_args);
	}
	
	if(!empty($size_guide_image_data)){
		?>
		<div class="product-size-guide">
			<a class="open-product-size-guide mfp-popup-link" href="<?php echo esc_url($size_guide_image_data['url']);?>" data-mfp_options=<?php echo esc_attr($mfp_options); ?>>
				<?php esc_html_e('Size Guide', 'ciyashop' ); ?>
			</a>
		</div>
		<?php
	}
}

// Add sticky content on product single page
add_action( 'woocommerce_single_product_summary', 'ciyashop_product_sticky_content', 31 );
function ciyashop_product_sticky_content(){
	global $product, $ciyashop_options;
	
	if( !$ciyashop_options['product_sticky_content'] ){
		return;
	}
	
	if($product->is_type( 'variable' ) || $product->is_type( 'grouped' )){
		return;
	}
	
	?>
	<div class="woo-product-sticky-content">
		<div class="woo-product-title_sticky">
			<h5 class="woo-product_title"><?php the_title();?></h5>
		</div>		
		<div class="woo-product-cart_sticky">
		<?php woocommerce_template_loop_add_to_cart();?>
		</div>
	</div>
	<?php
}

/**********************************************************
 * 
 * Single Product Container Width
 * 
 **********************************************************/
add_filter( 'ciyashop_content_container_classes', 'ciyashop_product_page_width_class' );

/**********************************************************
 * 
 * Previous/Next Links
 * 
 **********************************************************/
add_action('woocommerce_after_main_content','ciyashop_single_product_nav');


/**********************************************************
 * 
 * Product Page Style
 * 
 **********************************************************/
add_filter( 'wc_get_template_part', 'ciyashop_single_product_style_template', 10, 3 );
add_filter( 'post_class', 'ciyashop_single_product_style_class', 99, 3 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'ciyashop_show_product_images', 20 );
add_action( 'ciyashop_content_top', 'ciyashop_single_product_style_wide_image_gallery', 30 );
add_filter( 'wp_get_attachment_image_attributes', 'ciyashop_single_product_images_srcset', 10, 3 );
add_filter( 'ciyashop_product_images_wrapper_classes', 'ciyashop_single_product_image_gallery_classes' );
add_filter( 'ciyashop_product_image_gallery_wrapper_classes', 'ciyashop_single_product_image_gallery_wrapper_classes' );

/**********************************************************
 * 
 * Single Product Actions
 * 
 **********************************************************/
add_action( 'woocommerce_single_product_summary','ciyashop_product_summary_actions_start', 30 );
add_action( 'woocommerce_single_product_summary', 'ciyashop_product_summary_actions_end', 36 );

/**********************************************************
 * 
 * Tabs Customization
 * 
 **********************************************************/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_before_single_product', 'ciyashop_product_tabs_position', 9 );

	
function ciyashop_product_tabs_position(){
	
	$style = ciyashop_single_product_style();
	
	if( $style == 'sticky_gallery' ){
		add_action( 'ciyashop_after_single_product_summary', 'ciyashop_product_tabs_output', 10 );
	}else{
		add_action( 'woocommerce_after_single_product_summary', 'ciyashop_product_tabs_output', 10 );
	}
}

/**********************************************************
 * 
 * Product Video
 * 
 **********************************************************/
add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_zoom', 10 );
add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_video', 20 );
add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_360degree', 30 );

/**********************************************************
 * 
 * Product Video
 * 
 **********************************************************/
add_action( 'woocommerce_after_main_content', 'ciyashop_product_360_gallery_output', 5 );


/**********************************************************
 * 
 * Related Products
 * 
 **********************************************************/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'ciyashop_woocommerce_output_related_products', 20 );
add_filter( 'woocommerce_output_related_products_args', 'ciyashop_woocommerce_output_related_products_args' );

/**********************************************************
 * 
 * Cross Sells Products
 * 
 **********************************************************/
// show_up_sells
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'ciyashop_woocommerce_upsell_display', 15 );
add_filter( 'woocommerce_upsells_total', 'ciyashop_woocommerce_upsells_total' );

/**********************************************************
 * 
 * Mix
 * 
 **********************************************************/
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'ciyashop_before_product_gallery_wrapper', 'woocommerce_show_product_sale_flash', 10 );

add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_zoom', 10 );
add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_zoom', 10 );
add_action( 'ciyashop_product_gallery_buttons', 'ciyashop_product_gallery_button_zoom', 10 );


function ciyashop_product_summary_actions_start(){
	?><div class="product-summary-actions"><?php
}
function ciyashop_product_summary_actions_end(){
	?></div><?php
}

function ciyashop_product_tabs_output(){
	
	$product_tab_layout = ciyashop_product_tab_layout();
	
	if( $product_tab_layout == 'accordion' ){
		add_action( 'ciyashop_product_tabs_content', 'ciyashop_product_tabs_accordion', 10 );
	}else{
		add_action( 'ciyashop_product_tabs_content', 'ciyashop_product_tabs', 10 );
	}
	
	$tabs_args = array(
		'tab_layout' => $product_tab_layout,
		'tab_layout_class' => ( $product_tab_layout == 'default_center' ) ? 'default tab-align-center' : false,
	);
	
	do_action( 'ciyashop_product_tabs_content', $tabs_args );
}

if ( ! function_exists( 'ciyashop_product_tabs' ) ) {

	/**
	 * Output the product tabs (classic).
	 *
	 * @subpackage	Product/Tabs
	 */
	function ciyashop_product_tabs( $tabs_args ) {
		wc_get_template( 'single-product/tabs/tabs.php', $tabs_args );
	}
}

if ( ! function_exists( 'ciyashop_product_tabs_accordion' ) ) {

	/**
	 * Output the product tabs (classic).
	 *
	 * @subpackage	Product/Tabs
	 */
	function ciyashop_product_tabs_accordion( $tabs_args ) {
		wc_get_template( 'single-product/tabs/tabs-accordion.php', $tabs_args );
	}
}

function ciyashop_product_page_width_class( $classes ){
	
	if( is_product() ){
		$product_page_width = ciyashop_product_page_width();

		// Unset 'container-fluid' class
		$cf_index = array_search('container-fluid', $classes);
		if( $cf_index ) unset($classes[$cf_index]);
		
		// Unset 'container' class
		$c_index = array_search('container', $classes); // $key = 2;
		if( $c_index ) unset($classes[$c_index]);
		
		if( $product_page_width == 'wide' ){
			$classes = array('container-fluid');
		}else{
			$classes = array('container');
		}
	}
	
	return $classes;
}

function ciyashop_single_product_style_template( $template, $slug, $name ){
	
	if( $slug == 'content' && $name == 'single-product' ){
		global $ciyashop_options;
		
		$product_page_style = ciyashop_single_product_style();
		
		if( $product_page_style != 'classic' ) $name = 'single-product-'.$product_page_style;
		
		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
		if ( $name && ! WC_TEMPLATE_DEBUG_MODE ) {
			$template = locate_template( array( "{$slug}-{$name}.php", WC()->template_path() . "{$slug}-{$name}.php" ) );
		}

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( WC()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
			$template = WC()->plugin_path() . "/templates/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
		if ( ! $template && ! WC_TEMPLATE_DEBUG_MODE ) {
			$template = locate_template( array( "{$slug}.php", WC()->template_path() . "{$slug}.php" ) );
		}
	}
	
	return $template;
}

// Product Page Style
function ciyashop_single_product_style_class( $classes, $class, $post_id ) {
	global $post, $product, $ciyashop_options;
	
	if( !is_product() ) return $classes;
	
	$product_page_style = ciyashop_single_product_style();
	
	$product_page_style_class = 'product_page_style-'.$product_page_style;
	
	$product_page_style_class = apply_filters( 'ciyashop_single_product_style_class', $product_page_style_class, $classes, $class, $post_id );
	
	$classes[] = $product_page_style_class;
	
	return $classes;
}

if ( ! function_exists( 'ciyashop_show_product_images' ) ) {

	/**
	 * Output the product image before the single product summary.
	 *
	 * @subpackage	Product
	 */
	function ciyashop_show_product_images() {
		
		wc_get_template( 'single-product/product-image.php' );
		
	}
}

function ciyashop_single_product_style_wide_image_gallery(){
	$style = ciyashop_single_product_style();
	
	// Show Hide Sale
	add_filter( 'woocommerce_sale_flash', 'ciyashop_sale_flash_label', 10, 3 );
	
	// Show Hide Featured
	add_filter( 'ciyashop_featured', 'ciyashop_featured_label', 10, 3 );
	
	if( $style == 'wide_gallery' && is_product()){
		add_action( 'ciyashop_content_top', 'ciyashop_show_product_images', 35 );
	}
}

function ciyashop_single_product_images_srcset( $attr, $attachment, $size ){
	
	if ( is_singular('product') ) {
		unset( $attr['srcset'] );
		unset( $attr['sizes'] );
	}
	
	return $attr;
}

function ciyashop_single_product_image_gallery_classes( $classes ){
	
	$style = ciyashop_single_product_style();
	$thumbnail_position = ciyashop_single_product_thumbnail_position();
	
	if( $style == 'wide_gallery' ){
		$classes[] = "ciyashop-gallery-style-wide_gallery";
	}else{
		$classes[] = "ciyashop-gallery-style-default";
		$classes[] = "ciyashop-gallery-thumb_position-$thumbnail_position";
		$classes[] = "ciyashop-gallery-thumb_vh-".( $thumbnail_position == 'bottom' ? 'horizontal' : 'vertical' );
	}
	
	return $classes;
}

function ciyashop_single_product_image_gallery_wrapper_classes( $classes ){
	
	$style = ciyashop_single_product_style();
	
	if( $style == 'wide_gallery' ){
		$classes[] = "owl-carousel";
		$classes[] = "owl-theme";
	}

	return $classes;
}

function ciyashop_woocommerce_output_related_products(){
	
	global $ciyashop_options;
	
	$related_products_stat = false;
	
	if( empty($ciyashop_options) ){
		$related_products_stat = true;
	}else if( isset($ciyashop_options['show_related_products']) && $ciyashop_options['show_related_products'] == 1 ){
		$related_products_stat = true;
	}
	if( $related_products_stat ){
		woocommerce_output_related_products();
	}
}

function ciyashop_woocommerce_output_related_products_args( $args ){
	global $ciyashop_options;
	
	$related_products_per_page = isset($ciyashop_options['related_products_per_page']) && !empty($ciyashop_options['related_products_per_page']) ? $ciyashop_options['related_products_per_page'] : 6;
	
	$args['posts_per_page'] = $related_products_per_page;
	
	return $args;
}

function ciyashop_woocommerce_upsell_display(){
	global $ciyashop_options;
	
	$woocommerce_upsell_display = false;
	
	if( empty($ciyashop_options) ){
		$woocommerce_upsell_display = true;
	}else if( isset($ciyashop_options['show_up_sells']) && $ciyashop_options['show_up_sells'] == 1  ){
		$woocommerce_upsell_display = true;
	}
	if( $woocommerce_upsell_display ){
		woocommerce_upsell_display();
	}
}

function ciyashop_woocommerce_upsells_total( $posts_per_page ){
	global $ciyashop_options;
	
	$up_sells_products_per_page = isset($ciyashop_options['up_sells_products_per_page']) && !empty($ciyashop_options['up_sells_products_per_page']) ? $ciyashop_options['up_sells_products_per_page'] : 6;

	$posts_per_page = $up_sells_products_per_page;
	
	return $posts_per_page;
}

function ciyashop_product_gallery_button_zoom(){
	
	$link_html_prefix = '<div class="ciyashop-product-gallery_button ciyashop-product-gallery_button-zoom">';
	$link_html        = '<a href="#" class="ciyashop-product-gallery_button-link-zoom">'.'<i class="fa fa-arrows-alt"></i>'.'</a>';
	$link_html_suffix = '</div>';
	
	$link_html = $link_html_prefix . apply_filters( 'ciyashop_product_gallery_button_zoom', $link_html, $link_html_prefix, $link_html_suffix ) . $link_html_suffix;
	
	echo wp_kses( $link_html, ciyashop_allowed_html(array('a','div','i')) );
}

function ciyashop_product_gallery_button_video(){
	global $post;
	
	$link_html = '';
	
	$product_video = ciyashop_get_product_video();
	
	
	if( $product_video ){
		$link_html .= '<div class="ciyashop-product-gallery_button ciyashop-product-gallery_button-video">';
		$link_html .= '<a href="'.esc_url($product_video['video_link']).'" class="ciyashop-product-gallery_button-link-video '.esc_attr($product_video['video_classes']).'">'.'<i class="fa fa-video-camera"></i>'.'</a>';
		$link_html .= '</div>';
	}
	
	$link_html = apply_filters( 'ciyashop_product_gallery_button_video', $link_html, $post );
	
	if( $link_html != '' ){
		echo wp_kses( $link_html, ciyashop_allowed_html(array('a','div','i')) );
	}
}

function ciyashop_product_gallery_button_360degree(){
	global $post;
	
	$link_html = '';
	
	$product_360_data = ciyashop_get_product_360();
	if( $product_360_data ){
		$link_html .= '<div class="ciyashop-product-gallery_button ciyashop-product-gallery_button-360degree">';
		$link_html .= '<a id="'.esc_attr($product_360_data['id']).'" href="'.esc_url($product_360_data['link']).'" class="ciyashop-product-gallery_button-link-360degree">'.'<i class="fa fa-repeat"></i>'.'</a>';
		$link_html .= '</div>';
		
	}
	$link_html = apply_filters( 'ciyashop_product_gallery_button_360degree', $link_html, $post );
	
	if( $link_html != '' ){
		echo wp_kses( $link_html, ciyashop_allowed_html(array('a','div','i')) );
	}
}

function ciyashop_product_360_gallery_output(){
	
	$product_360_data = ciyashop_get_product_360();
	
	if( $product_360_data ){
		?>
		<div class="ciyashop-threesixty-wrapper">
			<?php wc_get_template( 'custom/threesixtyslider.php' ); ?>
		</div>
		<?php
	}
}

function ciyashop_get_product_360(){
	global $post;
	
	if( ! $post ) return false;
	
	if( ! is_product() ) return false;
	
	global $smart_product;
	$smart_product = get_post_meta( $post->ID, "smart_product_meta", true );
	
	if( !$smart_product ) return;
	
	$smart_product['fullscreen'] = true;
	$smart_product['show']       = false;
	$smart_product['360id']      = $post->ID.'_'.$smart_product['id'];
	
	if( $smart_product['color'] == 'color-ciyashop' ){
		$smart_product['style'] = 'style-none';
	}
	
	$product_360_data = false;
	
	if ( isset( $smart_product['id'] ) && $smart_product['id'] != "" ){
		
		if( !class_exists('ThreeSixtySlider') ) return $product_360_data;
		
		global $threesixtyslider;
		$threesixtyslider = new ThreeSixtySlider( $smart_product );
		
		if( $threesixtyslider->imagesCount > 0 ){
			ob_start();
			wc_get_template( 'custom/threesixtyslider.php' );
			$product_360_content = ob_get_clean();
			ob_start();
			$threesixtyslider->ID();
			$threesixty_id = ob_get_clean();
			$product_360_data = array(
				'content'=> $product_360_content,
				'id'     => 'threesixty-anchor-'.$smart_product['360id'],
				'link'   => '#threesixty-slider-'.$smart_product['360id'],
			);
		}
	}
	
	return $product_360_data;
}

function ciyashop_get_product_video(){
	global $post;
	
	if( ! $post ) return false;
	
	if( ! is_product() ) return false;
	
	$video_stat         = false;
	$video_link         = '';
	$video_popup_classes= array(
		'product-video-popup-link'
	);
	
	if( !function_exists('get_field')){
		return;
	}
	$video_source   = get_field('product_video_source', $post->ID);
	if( $video_source && $video_source == 'internal' ){
		$video_internal = get_field('product_video_internal', $post->ID);
		if( $video_internal ){
			$video_stat = true;
			$video_link = $video_internal['url'];
			$video_popup_classes[] = 'product-video-popup-link-html5';
		}
	}elseif( $video_source && $video_source == 'external' ){
		$ext_video_html = get_field('product_video_external', $post->ID);
		if( $ext_video_html ){
			$ext_video_url  = get_field('product_video_external', $post->ID, false);
			$ext_video_data = ciyashop_get_oembed_data($ext_video_url);
			$video_stat     = true;
			
			// add extra params to iframe src
			$params = array(
				'controls'=> 0,
				'hd'      => 1,
				'autohide'=> 1
			);
			
			if( is_object($ext_video_data) && ($ext_video_data->provider_name == 'YouTube' || $ext_video_data->provider_name == 'Vimeo') ){
				$video_link = $ext_video_url;
			}else{
				if( $ext_video_data->provider_name == 'Facebook' ){
					$ext_video_src = 'https://www.facebook.com/plugins/video.php';
					$params = array(
						'href'           => urlencode($ext_video_data->url),
						'autoplay'       => 1,
						'show_text'      => 0,
						'allowfullscreen'=> 1
					);
				}else{
					// use preg_match to find iframe src
					preg_match('/src="(.+?)"/', $ext_video_html, $ext_video_matches);
					$ext_video_src = $ext_video_matches[1];
				}
				if( $ext_video_data->provider_name == 'Dailymotion' ){
					$params = array(
						'autoplay'        => 1,
						'endscreen-enable'=> 0,
					);
				}
				
				$ext_video_src_new= add_query_arg($params, $ext_video_src);
				$video_link       = $ext_video_src_new;
			}
			
			$video_popup_classes[] = 'product-video-popup-link-oembed';
			$video_popup_classes[] = 'product-video-popup-link-oembed-'.sanitize_title($ext_video_data->provider_name);
		}
	}
	
	$video_popup_classes = ciyashop_class_builder($video_popup_classes);
	
	if( $video_stat ){
		$video_data = array(
			'video_link'   => $video_link,
			'video_classes' => $video_popup_classes,
		);
	}else{
		$video_data = false;
	}
	
	$video_data = apply_filters( 'ciyashop_product_video', $video_data, $post );
	
	return $video_data;
}

function ciyashop_get_oembed_data( $url = '' ){
	
	if( $url == '' ) return;
	
	$oembed = new WP_oEmbed();
	$oembed_data = $oembed->get_data( $url );
	
	return $oembed_data;
}

add_filter( 'threesixty_image_option_color', 'ciyashop_extend_threesixty_image_option_color', 10, 2 );
function ciyashop_extend_threesixty_image_option_color( $html, $active_color ){
	
	$colors = array(
		'color-ciyashop' => esc_html__( 'CiyaShop', 'ciyashop' ),
	);
	
	foreach( $colors as $color_k => $color_v ){
		$html .= '<option '.selected($color_k,	esc_attr( $active_color )).' value="'.$color_k.'">' . $color_v . '</option>';
	}
	
	return $html;
}

add_filter( 'threesixty_image_option_color_notice', 'ciyashop_extend_threesixty_image_option_color_notice', 10, 2 );
function ciyashop_extend_threesixty_image_option_color_notice( $html, $active_color ){
	
	$html .= esc_html__('Note: If "Color" is set to "CiyaShop", "Style" will not be applicable.', 'ciyashop' );
	
	return $html;
}


/**
 * Add a custom product data tab
 * @param array $tabs
 */
add_filter('woocommerce_product_tabs', 'ciyashop_new_product_tab');

if (!function_exists('ciyashop_new_product_tab')) {

    function ciyashop_new_product_tab($tabs) {
        // Adds the new tab
        $custom_tab_title = $custom_tab_content = '';
        if (function_exists('get_field')) {
            $custom_tab_title = get_field('custom_tab_title');
        }
        if (function_exists('get_field')) {
            $custom_tab_content = get_field('custom_tab_content');
        }
        $custom_tab_title = ($custom_tab_title != '') ? $custom_tab_title : __('Custom Tab', 'ciyashop' );

        if ($custom_tab_content != '') {
            $tabs['test_tab'] = array(
                'title' => $custom_tab_title,
                'priority' => 50,
                'callback' => 'ciyashop_new_product_tab_content'
            );
        }

        return $tabs;
    }

}

if (!function_exists('ciyashop_new_product_tab_content')) {

    function ciyashop_new_product_tab_content() {
        $custom_tab_content = '';
        if ( function_exists('get_field') && function_exists('the_field') ) {
            $custom_tab_content = get_field('custom_tab_content');
			if( $custom_tab_content ){
				the_field('custom_tab_content');
			}
        }
    }

}