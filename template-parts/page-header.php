<?php
global $ciyashop_options;

$page_id = get_the_ID();

if( function_exists('is_shop') && is_shop() ) {
	$page_id = get_option( 'woocommerce_shop_page_id' );
}elseif( is_home() && get_option('page_for_posts') ) {
	$page_id = get_option( 'page_for_posts' );
}

$show_header = ciyashop_show_header();

if( empty( $show_header ) && ( is_search() ) ){
	$show_header = true;
}

// Return if page banner is set to hide.
if( $show_header == 0 && $show_header != '' ){
	return;
}

// Row Classes
$row_classes = ciyashop_page_header_row_classes( 'row intro-title align-items-center' );

// Container Class
$enable_full_width = ( isset( $ciyashop_options['enable_full_width'] ) )? $ciyashop_options['enable_full_width']: false;
// Enable full width
if( $enable_full_width == 1 ){
	$container_classes['container'] = 'container-fluid';
}else{
	$container_classes['container'] = 'container';
}
$container_classes = ciyashop_page_header_container_classes( $container_classes );

$banner_type      = ( isset( $ciyashop_options['banner_type'] ) )      ? $ciyashop_options['banner_type']      : 'image';
$video_type       = ( isset( $ciyashop_options['video_type'] ) )       ? $ciyashop_options['video_type']       : 'youtube';

$youtube_video    = ( isset( $ciyashop_options['youtube_video'] ) )    ? $ciyashop_options['youtube_video']    : '';
$vimeo_video      = ( isset( $ciyashop_options['vimeo_video'] ) )      ? $ciyashop_options['vimeo_video']      : '';

$video_link       = ( $video_type == 'youtube' )                         ? $youtube_video                          : $vimeo_video;
$titlebar_view    = ( isset( $ciyashop_options['titlebar_view'] ) )    ? $ciyashop_options['titlebar_view']    : 'default';

// Custom page header settings
$header_settings_source = get_post_meta($page_id,'header_settings_source',true);
if( $header_settings_source == 'custom' ){
	$banner_type = get_post_meta( $page_id, 'banner_type', true );
	if( $banner_type == 'video' ){
		$video_type = get_post_meta($page_id,'banner_video_source',true);
		$video_link = ($video_type == 'youtube' ) ? get_post_meta( $page_id, 'banner_video_source_youtube', true ) : get_post_meta( $page_id, 'banner_video_source_vimeo', true );
	}
	$titlebar_view = get_post_meta( $page_id, 'titlebar_text_align', true );
	
}

// Enqueue script for youtube api
if( $banner_type == 'video' && $video_type == 'youtube' ){
	if(ciyashop_check_plugin_active('js_composer/js_composer.php')){
		wp_enqueue_script( 'vc_youtube_iframe_api_js' );
	}else{
		wp_enqueue_script( 'youtube_iframe_api_js' );
	}
}

if( function_exists('is_product') && is_product()){
	$woo_intro_class = 'col-md-12';
}else{
	$woo_intro_class = 'col-md-6 text-right';
}

if( function_exists('ciyashop_is_woocommerce_page') && ciyashop_is_woocommerce_page() ){
	?>
	<div class="woocommerce_inner-intro inner-intro">
		<div class="container">
			<div class="row woocommerce_intro-title intro-title align-items-center">
				<?php do_action( 'ciyashop_before_title' );?>
				
				<?php
				if( !is_product() ){?>
					<div class="col-md-6 text-left">
						<?php get_template_part('template-parts/page-header/title');?>
					</div><?php
				}	
				?>
				<div class="<?php echo esc_attr($woo_intro_class);?>">
					<?php get_template_part('template-parts/page-header/breadcrumb');?>
				</div> 
				
			</div>
		</div>
	</div>
	<?php
}else{
	?>
	<div class="<?php ciyashop_page_header_classes('inner-intro header_intro');?>">
		<?php
		// Only Vimeo video
		if( $banner_type == 'video' && ( $video_type == 'vimeo' || $video_type == 'youtube' ) ){
			$video_bg_classes = array(
				'intro_header_video-bg',
				'intro_header_video-'.$video_type,
				'd-none',
				'd-sm-block',
			);
			$video_bg_classes = ciyashop_class_builder($video_bg_classes);
			?>
			<div class="<?php echo esc_attr($video_bg_classes);?>" data-video_type="<?php echo esc_attr($video_type);?>" data-video_link="<?php echo esc_url($video_link);?>">
				<?php
				$header_bg_video = wp_oembed_get( $video_link, array(
					'width' => '500',
					'height'=> '280',
				) );
				$header_bg_video = str_replace('<iframe ', '<iframe id="header_bg_video" ', $header_bg_video);
				echo wp_kses( $header_bg_video, array(
					'iframe' => array(
						'id'             => true,
						'src'            => true,
						'allow'          => true,
						'allowfullscreen'=> true,
						'style'          => true,
						'width'          => true,
						'height'         => true,
						'frameborder'    => true,
					),
				) );
				?>
			</div>
			<?php
		}
		?>
		<div class="<?php echo esc_attr( $container_classes );?>">
			<div class="<?php echo esc_attr( $row_classes );?>">
				
				<?php do_action( 'ciyashop_before_title' );?>
				
				<?php
				if( $titlebar_view == 'left' ){
					?>
					<div class="col-md-6 text-left">
						<?php get_template_part('template-parts/page-header/title');?>
					</div>
					<div class="col-md-6 text-right">
						<?php get_template_part('template-parts/page-header/breadcrumb');?>
					</div>
					<?php
				}elseif( $titlebar_view == 'right' ){
					?>
					<div class="col-md-6 text-left">
						<?php get_template_part('template-parts/page-header/breadcrumb');?>
					</div>
					<div class="col-md-6 text-right">
						<?php get_template_part('template-parts/page-header/title');?>
					</div>					
					<?php
				}else{
					?>
					<div class="col">
						<?php
						get_template_part('template-parts/page-header/title');
						get_template_part('template-parts/page-header/breadcrumb');
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}