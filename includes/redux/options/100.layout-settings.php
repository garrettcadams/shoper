<?php
return array(
	'title'           => esc_html__('Layout Settings', 'ciyashop' ),
	'id'              => 'layout_settings',
	'desc'            => esc_html__('Specify theme pages layout, color and background.', 'ciyashop' ),
	'customizer_width'=> '400px',
	'icon'            => 'el el-website icon-large',
	'fields'          => array(
		array(
			'id'       => 'site_layout',
			'type'     => 'radio',
			'title'    => esc_html__('Site Layout', 'ciyashop' ),
			'desc'     => esc_html__('Select layout of site.', 'ciyashop' ),
			'options'  => array(
				'fullwidth'          => esc_html__('Full Width', 'ciyashop' ),
				'boxed'              => esc_html__('Boxed', 'ciyashop' ),
				'framed'             => esc_html__('Framed', 'ciyashop' ),
				'rounded'            => esc_html__('Rounded', 'ciyashop' ),
			),
			'default'  => 'fullwidth',
		),
		array(
			'id'                 => 'body_background',
			'type'               => 'background',
			'title'              => esc_html__('Background', 'ciyashop' ),
			'desc'               => esc_html__('Set site background. This is applicable for fixed width layouts ("Boxed", "Framed" and "Rounded" ) only.', 'ciyashop' ),
			'preview_media'      => true,
			'transparent'        => false,
			'default'            => array(
				'background-image' => '',
			),
			'required'   => array(
				array('site_layout', '!=', 'fullwidth'),
			)
		),
	)
);