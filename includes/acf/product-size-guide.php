<?php
if( function_exists('acf_add_local_field_group') ){
	acf_add_local_field_group( apply_filters( 'product_size_guide_group_5a1e62ed6b6ca', array (
		'key' => 'group_5a1e62ed6b6ca',
		'title' => esc_html__( 'Size Guide Image', 'ciyashop' ),
		'fields' => array (
			array (
				'key' => 'field_5a1e6310237da',
				'label' => esc_html__( 'Size Guide Image', 'ciyashop' ),
				'name' => 'size_guide_image',
				'type' => 'image',
				'instructions' => 'This image will visible as size guide for product.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'full',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	) ) );
}