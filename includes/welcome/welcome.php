<?php
include('class-ciyashop-theme-activation.php');

add_action( 'init', 'ciyashop_welcome_setup' );
function ciyashop_welcome_setup(){
	
	
	$args = array(
		'slug' => 'cs-welcome',
		'class_prefix' => 'ciyashop',
	);
	
	$sections = apply_filters( 'ciyashop_welcome_sections', array(
		array(
			'slug'       => 'support',
			'title'      => esc_html__('Support', 'ciyashop' ),
		),
		array(
			'slug'       => 'plugins',
			'title'      => esc_html__('Plugins', 'ciyashop' ),
			'link_type'  => 'custom',
			'link'       => admin_url( 'themes.php?page=theme-plugins' ),
		),
		array(
			'slug'       => 'install-demos',
			'title'      => esc_html__('Install Demos', 'ciyashop' ),
			'link_type'  => 'custom',
			'link'       => admin_url( 'themes.php?page=ciyashop-options&tab=34' ),
		),
		array(
			'slug'       => 'theme-options',
			'title'      => esc_html__('Theme Options', 'ciyashop' ),
			'link_type'  => 'custom',
			'link'       => admin_url( 'themes.php?page=ciyashop-options&tab=0' ),
		),
		array(
			'slug'       => 'system-status',
			'title'      => esc_html__('System Status', 'ciyashop' ),
		),
		array(
			'slug'       => 'ratings',
			'title'      => esc_html__('Ratings', 'ciyashop' ),
		),
	) );
	
	if( class_exists('Pgs_Core_Welcome') && is_admin() ) {
		new Pgs_Core_Welcome( $sections, $args );
	}
}