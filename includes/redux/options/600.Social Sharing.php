<?php
return array(
	'title'           => esc_html__('Social Sharing', 'ciyashop' ),
	'id'              => 'social_sharing_settings',
	'desc'            => esc_html__('Enable/disable sharing functionality.', 'ciyashop' ),
	'customizer_width'=> '400px',
	'icon'            => 'fa fa-share-alt',
	'fields'          => array(
		array(
			'id'      => 'facebook_share',
			'type'    => 'switch',
			'title'   => esc_html__('Facebook Share', 'ciyashop' ),
			'subtitle'=> esc_html__('You can share post with facebook.', 'ciyashop' ),
			'default' => '1'
		),
		array(
			'id'      => 'twitter_share',
			'type'    => 'switch',
			'title'   => esc_html__('Twitter Share', 'ciyashop' ),
			'subtitle'=> esc_html__('You can share post with twitter', 'ciyashop' ),
			'default' => '1'
		),
		array(
			'id'      => 'linkedin_share',
			'type'    => 'switch',
			'title'   => esc_html__('Linkedin Share', 'ciyashop' ),
			'subtitle'=> esc_html__('You can share post with linkedin', 'ciyashop' ),
			'default' => '1'
		),
		array(
			'id'      => 'google_plus_share',
			'type'    => 'switch',
			'title'   => esc_html__('Google Plus Share', 'ciyashop' ),
			'subtitle'=> esc_html__('You can share post with google plus', 'ciyashop' ),
			'default' => '1'
		),
		array(
			'id'      => 'pinterest_share',
			'type'    => 'switch',
			'title'   => esc_html__('Pinterest Share', 'ciyashop' ),
			'subtitle'=> esc_html__('You can share post with pinterest', 'ciyashop' ),
			'default' => '1'
		),
	)
);