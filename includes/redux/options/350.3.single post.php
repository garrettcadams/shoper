<?php 
return array(
	'title'           => esc_html__('Single Post', 'ciyashop' ),
	'id'              => 'single_settings',
	'subsection'      => true,
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'      => 'single_metas',
			'type'    => 'checkbox',
			'title'   => esc_html__('Display Meta Items', 'ciyashop' ),
			'subtitle'=> esc_html__('Select and reorder meta items to display', 'ciyashop' ),
			'options' => array(
				'author'    => esc_html__('Author', 'ciyashop' ),
				'categories'=> esc_html__('Categories', 'ciyashop' ),
				'tags'		=> esc_html__('Tags', 'ciyashop' ),
				'comments'  => esc_html__('Comments', 'ciyashop' ),
			),
			'default' => array(
				'date'      => '1',
				'author'    => '1',
				'categories'=> '1',
				'tags'=> '1',
				'comments'  => '1',
			)
		),
		array(
			'id'     => 'related_posts',
			'type'   => 'switch',
			'title'  => esc_html__('Related Posts', 'ciyashop' ),
			'desc'   => esc_html__('Show/hide related posts.', 'ciyashop' ),
			'default'=> true,
		),
		array(
			'id'     => 'author_details',
			'type'   => 'switch',
			'title'  => esc_html__('Author Details', 'ciyashop' ),
			'desc'   => esc_html__('Show/hide author details.', 'ciyashop' ),
			'default'=> true,
		),
		array(
			'id'     => 'post_nav',
			'type'   => 'switch',
			'title'  => esc_html__('Post Navigation', 'ciyashop' ),
			'desc'   => esc_html__('Show/hide previous-next post links.', 'ciyashop' ),
			'default'=> true,
		),
	)
);