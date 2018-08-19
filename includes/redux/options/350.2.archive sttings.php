<?php
return array(
	'title'           => esc_html__('Archive Settings', 'ciyashop' ),
	'id'              => 'archive_settings',
	'subsection'      => true,
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'     => 'archive_header',
			'type'   => 'checkbox',
			'title'  => esc_html__('Display Archive Header.', 'ciyashop' ),
			'desc'   => esc_html__('Select archive header to display on different archive pages.', 'ciyashop' ),
			'options'=> array(
				'author'  => esc_html__('Author Info', 'ciyashop' ),
				'category'=> esc_html__('Category Description', 'ciyashop' ),
				'tag'     => esc_html__('Tag Description', 'ciyashop' ),
			),
			'default'     => array(
				'author'  => '0',
				'category'=> '0',
				'tag'     => '0',
			)
		),
	)
);