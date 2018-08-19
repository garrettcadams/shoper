<?php
return array(
	'title'           => esc_html__('Site Preloader Option', 'ciyashop' ),
	'id'              => 'main_preloader_option',	
	'customizer_width'=> '400px',
	'icon'            => 'fa fa-spinner',
	'fields'          => array(
		array(
			'id'      => 'preloader',
			'type'    => 'switch',
			'title'   => esc_html__('Preloader', 'ciyashop' ),
			'subtitle'=> esc_html__('Enable/disable preloader animation.', 'ciyashop' ),
			'default' => true,
		),
		array(
			'id'      => 'preloader_background_color',
			'type'    => 'color',
			'title'   => esc_html__('Preloader Background Color', 'ciyashop' ),
			'subtitle'=> esc_html__('Set preloader background color.', 'ciyashop' ),
			'default'    => '#ffffff',
			'transparent'=> false,
			'required' => array( 'preloader', '=', 1 ),
		),
		array(
			'id'      => 'preloader_source',
			'type'    => 'button_set',
			'title'   => esc_html__('Preloader Source', 'ciyashop' ),
			'subtitle'=> esc_html__('Set preloader type as per your need.', 'ciyashop' ),
			'options' => array(
				'default'         => esc_html__('Default', 'ciyashop' ),
				'predefine_loader'=> esc_html__('Predefined Loader', 'ciyashop' ),
				'custom'          => esc_html__('Custom', 'ciyashop' ),
			),
			'default' => 'default',
			'required' => array( 'preloader', '=', 1 ),
		),
		array(
			'id'    => 'predefine_loader_image_info',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'The .svg file for the "Preloader Image" will not work in "Internet Explorer".', 'ciyashop' ),
			'icon'  => 'el el-info-circle',
			'required'   => array(
				array( 'preloader', '=', 1 ),
				array( 'preloader_source', '!=', 'default' ),
			),
		),
		array(
			'id'       => 'predefine_loader_image',
			'type'     => 'image_select',
			'title'    => esc_html__('Preloader Image', 'ciyashop' ),
			'subtitle' => esc_html__('Please select site preloader image.', 'ciyashop' ),			
			'options'  => array(
				'default' => array (
					'alt'  => esc_html__('Loader 1', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/default.gif'),
				),
				'loader1' => array (
					'alt'  => esc_html__('Loader 1', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader1.gif'),
				),
				'loader2' => array (
					'alt'  => esc_html__('Loader 2', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader2.gif')
				),
				'loader3' => array (
					'alt'  => esc_html__('Loader 3', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader3.gif')
				),
				'loader4' => array (
					'alt'  => esc_html__('Loader 4', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader4.gif')
				),
				'loader5' => array (
					'alt'  => esc_html__('Loader 5', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader5.gif')
				),
				'loader6' => array (
					'alt'  => esc_html__('Loader 6', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader6.gif')
				),
				'loader7' => array (
					'alt'  => esc_html__('Loader 7', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader7.gif')
				),
				'loader8' => array (
					'alt'  => esc_html__('Loader 8', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader8.gif')
				),
				'loader9' => array (
					'alt'  => esc_html__('Loader 9', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader9.gif')
				),
				'loader10' => array (
					'alt'  => esc_html__('Loader 10', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader10.gif')
				),
				'loader11' => array (
					'alt'  => esc_html__('Loader 11', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader11.gif')
				),
				'loader12' => array (
					'alt'  => esc_html__('Loader 12', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader12.gif')
				),
				'loader13' => array (
					'alt'  => esc_html__('Loader 13', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader13.gif')
				),
				'loader14' => array (
					'alt'  => esc_html__('Loader 14', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader14.gif')
				),
				'loader15' => array (
					'alt'  => esc_html__('Loader 15', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader15.gif')
				),
				'loader16' => array (
					'alt'  => esc_html__('Loader 16', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader16.gif')
				),
				'loader17' => array (
					'alt'  => esc_html__('Loader 17', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader17.svg')
				),
				'loader18' => array (
					'alt'  => esc_html__('Loader 18', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader18.svg')
				),
				'loader19' => array (
					'alt'  => esc_html__('Loader 19', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader19.svg')
				),
				'loader20' => array (
					'alt'  => esc_html__('Loader 20', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader20.svg')
				),
				'loader21' => array (
					'alt'  => esc_html__('Loader 21', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader21.svg')
				),
				'loader22' => array (
					'alt'  => esc_html__('Loader 22', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader22.svg')
				),
				'loader23' => array (
					'alt'  => esc_html__('Loader 23', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader23.svg')
				),
				'loader24' => array (
					'alt'  => esc_html__('Loader 24', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader24.svg')
				),
				'loader25' => array (
					'alt'  => esc_html__('Loader 25', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader25.svg')
				),
				'loader26' => array (
					'alt'  => esc_html__('Loader 26', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader26.gif')
				),
				'loader27' => array (
					'alt'  => esc_html__('Loader 27', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader27.gif')
				),
				'loader28' => array (
					'alt'  => esc_html__('Loader 28', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader28.gif')
				),
				'loader29' => array (
					'alt'  => esc_html__('Loader 29', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader29.svg')
				),
				'loader30' => array (
					'alt'  => esc_html__('Loader 30', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader30.svg')
				),
				'loader31' => array (
					'alt'  => esc_html__('Loader 31', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader31.svg')
				),
				'loader32' => array (
					'alt'  => esc_html__('Loader 32', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader32.svg')
				),
				'loader33' => array (
					'alt'  => esc_html__('Loader 33', 'ciyashop' ),
					'img'  => get_parent_theme_file_uri('/images/loader/loader33.svg')
				),
			),
			'default'  => 'default',
			'required' => array(				
				array('preloader_source', '=', 'predefine_loader'),
			)
		),
		array(
			'id'      => 'preloader_image',
			'type'    => 'media',
			'url'     => true,
			'title'   => esc_html__('Preloader Image', 'ciyashop' ),   
			'subtitle'=> esc_html__('Select preloader image.', 'ciyashop' ),
			'default' => array(
				'url'       => get_parent_theme_file_uri('/images/loader/loader19.svg')
			),
			'library_filter'=> array('gif','jpg','jpeg','png'),
			'required'      => array( 'preloader_source', '=', 'custom' ),
		),
	)
);