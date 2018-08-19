<?php
return array(
	'title'           => esc_html__('Footer', 'ciyashop' ),
	'id'              => 'footer_section',
	'customizer_width'=> '400px',
	'icon'            => 'el el-arrow-down',
	'fields'          => array(
		array(
			'id'         => 'footer_widget_columns',
			'type'       => 'image_select',
			'title'      => esc_html__('Footer Column Layout', 'ciyashop' ),
			'options'    => array(
				'one-column' => array(
					'alt'=> esc_html__('One Column', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/one-column.png')
				),
				'two-columns' => array(
					'alt'=> esc_html__('Two Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/two-columns.png')
				),
				'three-columns' => array(
					'alt'=> esc_html__('Three Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/three-columns.png')
				),
				'four-columns' => array(
					'alt'=> esc_html__('Four Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/four-columns.png')
				),
				'8-4-columns' => array(
					'alt'=> esc_html__('8 + 4 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/8-4-columns.png')
				),
				'4-8-columns' => array(
					'alt'=> esc_html__('4 + 8 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/4-8-columns.png')
				),
				'6-3-3-columns' => array(
					'alt'=> esc_html__('6 + 3 + 3 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/6-3-3-columns.png')
				),
				'3-3-6-columns' => array(
					'alt'=> esc_html__('3 + 3 + 6 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/3-3-6-columns.png')
				),
				'8-2-2-columns' => array(
					'alt'=> esc_html__('8 + 2 + 2 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/8-2-2-columns.png')
				),
				'2-2-8-columns' => array(
					'alt'=> esc_html__('2 + 2 + 8 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/2-2-8-columns.png')
				),
				'6-2-2-2-columns' => array(
					'alt'=> esc_html__('6 + 2 + 2 + 2 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/6-2-2-2-columns.png')
				),
				'2-2-2-6-columns' => array(
					'alt'=> esc_html__('2 + 2 + 2 + 6 Columns', 'ciyashop' ),
					'img'=> get_parent_theme_file_uri('/images/footer_layout/2-2-2-6-columns.png')
				),
			),
			'default' => 'four-columns',
		),
		array(
			'id'      => 'footer_one_alignment',
			'type'    => 'select',
			'title'   => esc_html__('First Footer Alighnment', 'ciyashop' ),
			'subtitle'=> esc_html__('Select footer alighnment', 'ciyashop' ),
			'options'   => array(
				'left'  => esc_html__( 'Left', 'ciyashop' ),
				'center'  => esc_html__( 'Center', 'ciyashop' ),
				'right'  => esc_html__( 'Right', 'ciyashop' ),
			),
			'default'  => 'left',
		),
		array(
			'id'      => 'footer_two_alignment',
			'type'    => 'select',
			'title'   => esc_html__('Second Footer Alighnment', 'ciyashop' ),
			'subtitle'=> esc_html__('Select footer alighnment', 'ciyashop' ),
			'options'   => array(
				'left'  => esc_html__( 'Left', 'ciyashop' ),
				'center'  => esc_html__( 'Center', 'ciyashop' ),
				'right'  => esc_html__( 'Right', 'ciyashop' ),
			),
			'default'  => 'left',
			'required'=> array(
				array( 'footer_widget_columns', '=', array('two-columns', 'three-columns', 'four-columns', '8-4-columns', '4-8-columns', '6-3-3-columns', '3-3-6-columns', '8-2-2-columns', '2-2-8-columns', '6-2-2-2-columns', '2-2-2-6-columns') )
			),
		),
		array(
			'id'      => 'footer_three_alignment',
			'type'    => 'select',
			'title'   => esc_html__('Third Footer Alighnment', 'ciyashop' ),
			'subtitle'=> esc_html__('Select footer alighnment', 'ciyashop' ),
			'options'   => array(
				'left'  => esc_html__( 'Left', 'ciyashop' ),
				'center'  => esc_html__( 'Center', 'ciyashop' ),
				'right'  => esc_html__( 'Right', 'ciyashop' ),
			),
			'default'  => 'left',
			'required'=> array(
				array( 'footer_widget_columns', '=', array('three-columns', 'four-columns', '6-3-3-columns', '3-3-6-columns', '8-2-2-columns', '2-2-8-columns', '6-2-2-2-columns', '2-2-2-6-columns') ),
			)
		),
		array(
			'id'      => 'footer_four_alignment',
			'type'    => 'select',
			'title'   => esc_html__('Fourth Footer Alighnment', 'ciyashop' ),
			'subtitle'=> esc_html__('Select footer alighnment', 'ciyashop' ),
			'options'   => array(
				'left'  => esc_html__( 'Left', 'ciyashop' ),
				'center'  => esc_html__( 'Center', 'ciyashop' ),
				'right'  => esc_html__( 'Right', 'ciyashop' ),
			),
			'default'  => 'left',
			'required'=> array(
				array( 'footer_widget_columns', '=', array('four-columns', '6-2-2-2-columns', '2-2-2-6-columns') ),
			)
		),
		array(
			'id'      => 'footer_background_type',
			'type'    => 'button_set',
			'title'   => esc_html__('Footer Background Type', 'ciyashop' ),
			'subtitle'=> esc_html__('Set footer background type(Image/color)', 'ciyashop' ),
			'options' => array(
				'image' => esc_html__('Image', 'ciyashop' ),
				'color' => esc_html__('color', 'ciyashop' ),				
			),
			'default'    => 'color',
		),
		array(
			'id'                 => 'footer_background_image',
			'type'               => 'background',
			'title'              => esc_html__('Footer Background', 'ciyashop' ),
			'subtitle'           => esc_html__('Footer Backgrund Image.', 'ciyashop' ),
			'background-color'   => false,
			'background-position'=> true,
			'transparent'        => false,
			'background-size'    => true,
			'compiler'           => true,
			'default'            => array(
				'background-color' => '#ffffff',
				'background-image' => get_parent_theme_file_uri('/images/footer-pattern.jpg'),
			),
			'required'   => array(
				array('footer_background_type', '=', 'image')
			)
		),
		array(
			'id'         => 'footer_background_opacity',
			'type'       => 'button_set',
			'presets'    => true,
			'title'      => esc_html__('Background Opacity Color', 'ciyashop' ),
			'required'   => array('footer_background_type', '=', 'image'),
			'options'    => array(
				'none'  => esc_html__('None', 'ciyashop' ),			
				'custom'=> esc_html__('Custom', 'ciyashop' ),
			),
			'default' => 'none',
		),
		array(
			'id'         => 'footer_background_overlay',
			'type'       => 'color_rgba',
			'title'      => esc_html__('Footer Background Overlay', 'ciyashop' ),
			'default'    => array(
				'color'     => '#000000',
				'alpha'     => 0.8,
			),
			'transparent'=> false,
			'required'   => array(
				array('footer_background_opacity', '=', 'custom'),
			),
		),		
		array(
			'id'         => 'footer_background_color',
			'type'       => 'color',
			'title'      => esc_html__('Footer Background Color', 'ciyashop' ),
			'default'    => '#f5f5f5',
			'transparent'=> false,
			'required'   => array('footer_background_type', '=', 'color'),
		),
		array(
			'id'         => 'footer_heading_color',
			'type'       => 'color',
			'title'      => esc_html__('Footer Heading Color', 'ciyashop' ),
			'default'    => '#323232',
			'transparent'=> false,   
		),
		array(
			'id'         => 'footer_text_color',
			'type'       => 'color',
			'title'      => esc_html__('Footer Text Color', 'ciyashop' ),
			'default'    => '#323232',
			'transparent'=> false,   
		),
		array(
			'id'         => 'footer_link_color',
			'type'       => 'color',
			'title'      => esc_html__('Footer Link Color', 'ciyashop' ),
			'default'    => '#04d39f',
			'transparent'=> false,   
		),
		array(
			'id'         => 'copyright_section_start',
			'type'       => 'section',
			'title'      => 'Copyright Section',
			'indent'     => true
		),
		array(
			'id'         => 'enable_copyright_footer',
			'type'       => 'button_set',
			'title'      => esc_html__('Show Copyright Text', 'ciyashop' ),
			'options'    => array(
				'yes' => esc_html__('Yes', 'ciyashop' ),
				'no' => esc_html__('No', 'ciyashop' ),
			),
			'default' => 'yes',
		),
		array(
			'id'         => 'copyright_back_color',
			'type'       => 'color_rgba',
			'title'      => esc_html__('Copyright Background Color', 'ciyashop' ),
			'subtitle'   => esc_html__('Custom color for copyright section background', 'ciyashop' ),
			'transparent'=> false,
			'default'    => array(
				'color'     => '#f5f5f5',
				'alpha'     => 1
			),			
			'required' => array('enable_copyright_footer', '=', 'yes')
		),		
		array(
			'id'         => 'copyright_text_color',
			'type'       => 'color',
			'title'      => esc_html__('Text Color', 'ciyashop' ),
			'subtitle'   => esc_html__('Custom color for copyright section font color', 'ciyashop' ),
			'transparent'=> false,
			'default'    => '#323232',
			'validate'   => 'color',
			'required'   => array('enable_copyright_footer', '=', 'yes')
		),
		array(
			'id'         => 'copyright_link_color',
			'type'       => 'color',
			'title'      => esc_html__('Link Color', 'ciyashop' ),
			'desc'       => esc_html__('Custom color for copyright section font link color', 'ciyashop' ),
			'transparent'=> false,
			'default'    => '#04d39f',
			'validate'   => 'color',
			'required'   => array('enable_copyright_footer', '=', 'yes')
		),
		array(
			'id'         => 'footer_text_left',
			'type'       => 'editor',
			'title'      => esc_html__('Footer Text Left', 'ciyashop' ),
			'subtitle'   => sprintf( wp_kses( __( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'ciyashop' ), array(
				'span' => array(
					'class' => true
				),
				'br' => array()
			) ) ),
			'args'  => array(
				'media_buttons' => false,
			),
			'default'  => esc_html__('&copy; Copyright [pgscore-year] [pgscore-site-title] All Rights Reserved.', 'ciyashop' ),
            'required' => array('enable_copyright_footer', '=', 'yes'),
		),
		array(
			'id'         => 'footer_text_right',
			'type'       => 'editor',
			'title'      => esc_html__('Footer Text Right', 'ciyashop' ),
			'subtitle'      => sprintf( wp_kses( __( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'ciyashop' ), array(
					'span' => array(
						'class' => true
					),
					'br' => array()
				) )
			),
			'args'  =>array(
				'media_buttons' => false,
			),
			'default' => sprintf( wp_kses( __( 'Develop and design by <a href="%1$s">%2$s</a>', 'ciyashop' ), array(
					'a' => array(
						'href'   => true,
						'target' => true,
					),
				) ),
				'http://www.potenzaglobalsolutions.com/',
				esc_html__('Potenza Global Solutions', 'ciyashop' )
			),
			'required'=> array('enable_copyright_footer', '=', 'yes'),
		),
		array(
			'id'         => 'footer_bottom',
			'type'       => 'button_set',
			'title'      => esc_html__('Footer Bottom', 'ciyashop' ),
			'options'    => array(
				'show' => esc_html__('Show', 'ciyashop' ),
				'hide' => esc_html__('hide', 'ciyashop' ),
			),
			'default' => 'hide',
		),
		array(
			'id'         => 'footer_bottom_content',
			'type'       => 'editor',
			'title'      => esc_html__('Footer Bottom Content', 'ciyashop' ),
			'desc'       => esc_html__( 'You can use this field to add bottom content in footer area. You can use child-theme CSS or Theme Option > Custom CSS to format content in this field. Also, you can use shortcode to insert your desired contents.', 'ciyashop' ),
			'args'       => array(
				'media_buttons' => true,
			),
			'required'=> array('footer_bottom', '=', 'show'),
		),
		array(
			'id'      => 'copyright_section_end',
			'type'    => 'section',
			'indent'  => false,
		),
	)
);