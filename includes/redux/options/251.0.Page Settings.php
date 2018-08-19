<?php 
return array(
	'title'           => esc_html__('Page Settings', 'ciyashop' ),
	'id'              => 'page_settings',
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'      => 'page_sidebar',
			'type'    => 'image_select',
			'title'   => esc_html__('Default Page Sidebar', 'ciyashop' ),
			'subtitle'=> esc_html__('Select page sidebar alignment.', 'ciyashop' ),
			'options' => array(
				'full_width' => array(
					'alt' => esc_html__('Full Width', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/full_width.png')
				),
				'left_sidebar' => array(
					'alt' => esc_html__('Left Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/left_sidebar.png')
				),
				'right_sidebar' => array(
					'alt' => esc_html__('Right Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/right_sidebar.png')
				),
			),
			'default' => 'right_sidebar'
		),
		array(
			'id'      => 'search_page_sidebar',
			'type'    => 'image_select',
			'title'   => esc_html__('Search Page Sidebar', 'ciyashop' ),
			'subtitle'=> esc_html__('Select page sidebar alignment.', 'ciyashop' ),
			'options' => array(
				'full_width' => array(
					'alt' => esc_html__('Full Width', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/full_width.png')
				),
				'left_sidebar' => array(
					'alt' => esc_html__('Left Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/left_sidebar.png')
				),
				'right_sidebar' => array(
					'alt' => esc_html__('Right Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/page_sidebar/right_sidebar.png')
				),
			),
			'default' => 'right_sidebar'
		),
	)
);