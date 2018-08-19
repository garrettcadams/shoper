<?php
/*
 * Add ACF "Page Settings" to other Custom Post Types, like Portfolio, Team, WooCommerce Products, BBPress Forums/Topics
 */
add_filter( 'page_settings_group_57501ad11cf25', 'ciyashop_page_settings_group_fields' );
function ciyashop_page_settings_group_fields($page_setting_field_data){
	
	// CPT Portolfio
	if( current_theme_supports('pgs_portfolio') ){
		$page_setting_field_data['location'][] = array (
			array (
				'param'   => 'post_type',
				'operator'=> '==',
				'value'   => 'portfolio',
			),
		);
	}
	
	// CPT Teams
	if( current_theme_supports('pgs_teams') ){
		$page_setting_field_data['location'][] = array (
			array (
				'param'   => 'post_type',
				'operator'=> '==',
				'value'   => 'teams',
			),
		);
	}
		
	// BBPress
	if( ciyashop_check_plugin_active('bbpress/bbpress.php') ){
		$page_setting_field_data['location'][] = array (
			array (
				'param'   => 'post_type',
				'operator'=> '==',
				'value'   => 'forum',
			),
		);
		$page_setting_field_data['location'][] = array (
			array (
				'param'   => 'post_type',
				'operator'=> '==',
				'value'   => 'topic',
			),
		);
	}
	
	return $page_setting_field_data;
}

add_filter('acf/get_field_groups','ciyashop_woocommerece_page_settings_group_fields', 20, 1);
function ciyashop_woocommerece_page_settings_group_fields($field_groups) {
	
	global $post;
	
	if( !$post ) return $field_groups;
	
	$new_field_groups = array();
	$wc_page_ids = array();
	$pages = array('myaccount', 'shop', 'cart', 'checkout', 'terms' );
	
	if(function_exists('wc_get_page_id')){
		foreach($pages as $page){
			$wc_page_ids[] = wc_get_page_id( $page );
		}
		
		if( has_shortcode( $post->post_content, 'yith_wcwl_wishlist') ) {
			$wc_page_ids[] = $post->ID;
		}
	}
	if(in_array($post->ID, $wc_page_ids)){
		foreach($field_groups as $key => $field_group){
			if($field_group['key'] != 'group_57501ad11cf25'){
				$new_field_groups[] = $field_group;
			}
		}
		return $new_field_groups;
	}
	
	return $field_groups;
}
