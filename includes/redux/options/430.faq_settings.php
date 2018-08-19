<?php
return array(
	'title'           => esc_html__('FAQ Settings', 'ciyashop' ),
	'id'              => 'faq_settings',
	'customizer_width'=> '450px',
	'icon'            => 'fa fa-question-circle',
	'fields'          => array(
		array(
			'id'      => 'faq_layout',
			'type'    => 'image_select',
			'title'   => esc_html__('FAQ Layout', 'ciyashop' ),
			'subtitle'=> esc_html__('Select FAQ page layout.', 'ciyashop' ),
			'options' => array(
				'layout_1' => array(
					'alt' => esc_html__('Layout 1', 'ciyashop' ),
					'img' => esc_url( get_parent_theme_file_uri('/images/options/faq_layout/layout_1.png') )
				),
				'layout_2' => array(
					'alt' => esc_html__('Layout 2', 'ciyashop' ),
					'img' => esc_url( get_parent_theme_file_uri('/images/options/faq_layout/layout_2.png') )
				),
			),
			'default' => 'layout_1'
		),
		array(
			'id'       => 'layout_1_cat_source',
			'type'     => 'radio',
			'title'    => esc_html__('Category Source', 'ciyashop' ),
			'subtitle'     => esc_html__('Select which categories do you want to display.', 'ciyashop' ),
			'options'  => array(
				'all'     => esc_html__('All', 'ciyashop' ),
				'selected'=> esc_html__('Selected', 'ciyashop' ),
			),
			'default'  => 'all',
			'required' => array( 'faq_layout', '=', 'layout_1' ),
		),
		array(
			'id'       => 'layout_1_categories',
			'type'     => 'select',
			'title'    => esc_html__('Categories', 'ciyashop' ),
			'data'     => 'terms',
			'args'     => array(
				'taxonomies' => 'faq-category',
				'hide_empty' => true,
			),
			'multi'    => true,
			'sortable' => true,
			'select2'  => array(
				'allowClear' => false,
				'placeholder' => "Select categories",
			),
			'subtitle' => esc_html__('Select categories to display posts from.', 'ciyashop' ),
			'required' => array(
				array( 'faq_layout', '=', 'layout_1' ),
				array( 'layout_1_cat_source', '=', 'selected' ),
			),
		),
		array(
			'id'       => 'layout_2_category',
			'type'     => 'select',
			'title'    => esc_html__('Category', 'ciyashop' ),
			'data'     => 'terms',
			'args'     => array(
				'taxonomies' => 'faq-category',
				'hide_empty' => true,
			),
			'sortable' => false,
			'select2'  => array(
				'allowClear' => true,
				'placeholder' => "Select a category",
			),
			'subtitle' => esc_html__('Select category to display posts from.', 'ciyashop' ),
			'required' => array( 'faq_layout', '=', 'layout_2' ),
		),
	)
);