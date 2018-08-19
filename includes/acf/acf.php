<?php
require_once get_parent_theme_file_path('/includes/acf/extra-page-settings.php');
require_once get_parent_theme_file_path('/includes/acf/team-settings.php');
require_once get_parent_theme_file_path('/includes/acf/product-video.php');
require_once get_parent_theme_file_path('/includes/acf/product-size-guide.php');
require_once get_parent_theme_file_path('/includes/acf/product-custom-tab.php');

add_action('wp_ajax_acf/fields/oembed/search', 'ciyashop_banner_video_oembed');
add_action('wp_ajax_nopriv_acf/fields/oembed/search', 'ciyashop_banner_video_oembed');
function ciyashop_banner_video_oembed(){

	// validate
	if( !acf_verify_ajax() ) die();

	$args = $_POST;

	// defaults
	$args = acf_parse_args($args, array(
		's'				=> '',
		'field_key'		=> '',
	));

	// load field
	$field = acf_get_field( $args['field_key'] );
	if( !$field ) return false;

	if( $field['name'] == 'banner_video_source_youtube' || $field['name'] == 'banner_video_source_vimeo' ){

		// Parse the url
		$parse = parse_url( $args['s'] );

		$response = $error = false;
		$msg = '';

		if( $field['name'] == 'banner_video_source_youtube' ){
			$youtube_domains = array(
				'youtube.be',
				'www.youtube.be',
				'youtube.fr',
				'www.youtube.fr',
				'youtu.be',
				'www.youtu.be',
				'youtube.com',
				'www.youtube.com',
				'youtube-nocookie.com',
				'www.youtube-nocookie.com',
			);

			if(  !in_array( $parse['host'], $youtube_domains ) ){
				$error = true;
				$msg   = esc_html__( 'Enter valid YouTube URL.', 'ciyashop' );
			}

		}else if( $field['name'] == 'banner_video_source_vimeo' ){
			$vimeo_domain = array(
				'vimeo.com',
				'www.vimeo.com',
				'player.vimeo.com',
			);

			if(  !in_array( $parse['host'], $vimeo_domain ) ){
				$error = true;
				$msg   = esc_html__( 'Enter valid Vimeo URL.', 'ciyashop' );
			}
		}

		// return
		if( $error ){
			$response = array(
				'url'	=> $args['s'],
				'html'	=> <<<CONTENT
<div class="banner-video-source-notice"><div class="banner-video-source-notice-inner">{$msg}</div></div>
CONTENT
			);
			wp_send_json( $response );
		}
	}

	return;
}