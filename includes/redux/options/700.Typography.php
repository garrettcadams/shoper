<?php
return array(
	'title'           => esc_html__('Typography', 'ciyashop' ),
	'id'              => 'Typography_section',
	'customizer_width'=> '400px',
	'icon'            => 'el el-font',
	'fields'          => array(		
		array(
			'id'            => 'typography-body',
			'type'          => 'typography',
			'title'         => esc_html__( 'Body Font', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Specify the body font properties.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Lato',
				'font-backup' => 'sans-serif',
				'font-weight' => '400',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '15px',
				'line-height' => '26px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h1-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H1 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '36px',
				'line-height' => '44px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h2-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H2 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '30px',
				'line-height' => '38px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h3-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H3 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '26px',
				'line-height' => '34px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h4-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H4 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '22px',
				'line-height' => '30px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h5-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H5 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '20px',
				'line-height' => '28px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
		array(
			'id'            => 'h6-typography',
			'type'          => 'typography',
			'title'         => esc_html__( 'H6 Headers Typography', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Typography option with each property can be called individually.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => true,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Montserrat',
				'font-backup' => 'sans-serif',
				'font-weight' => '500',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '18px',
				'line-height' => '22px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
		),
	)
);