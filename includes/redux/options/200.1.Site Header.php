<?php
return array(
	'title'           => esc_html__('Site Header', 'ciyashop' ),
	'id'              => 'appearance_subsection_site_header',
	'desc'            => esc_html__('You can manage site header settings here, like Header Type, Header Colors, Top Bar, Top bar Colors and other various settings.', 'ciyashop' ),
	'subsection'      => true,
	'customizer_width'=> '400px',	
	'fields'          => array(
		array(
			'id'         => 'header_type',
			'type'       => 'select_image_new',
			'title'      => esc_html__( 'Header Style', 'ciyashop' ),
			'placeholder'=> esc_html__( 'Select header style.', 'ciyashop' ),
			'select2'    => array(
				'allowClear' => 0,
			),
			'options'   => Array(
				'default'    => array(
					'alt'    => esc_html__( 'default', 'ciyashop' ),
					'title'  => esc_html__( 'Classic', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/default.png') ),
				),
				'logo-center'=> array(
					'alt'    => esc_html__( 'logo-center', 'ciyashop' ),
					'title'  => esc_html__( 'Logo Center', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/logo-center.png') ),
				),
				'menu-center'=> array(
					'alt'    => esc_html__( 'menu-center', 'ciyashop' ),
					'title'  => esc_html__( 'Menu Center', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/menu-center.png') ),
				),
				'menu-right'=> array(
					'alt'    => esc_html__( 'menu-right', 'ciyashop' ),
					'title'  => esc_html__( 'Menu Right', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/menu-right.png') ),
				),
				'topbar-with-main-header'=> array(
					'alt'    => esc_html__( 'topbar-with-main-header', 'ciyashop' ),
					'title'  => esc_html__( 'Topbar with Main Header', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/topbar-with-main-header.png') ),
				),
				'right-topbar-main'   => array(
					'alt'    => esc_html__( 'right-topbar-main', 'ciyashop' ),
					'title'  => esc_html__( 'Right Topbar & Main', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/header_type/right-topbar-main.png') ),
				),
			),
			'default'  => 'menu-center',
		),
		array(
			'id'         => 'header_width',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Header Width', 'ciyashop' ),
			'options'    => array(
				'full_width' => esc_html__( 'Full Width', 'ciyashop' ),
				'fixed_width'=> esc_html__( 'Fixed Width', 'ciyashop' ),
			),
			'default'    => 'full_width',
			'required'   => array(
				array( 'site_layout', '=', 'fullwidth' ),
				array( 'header_type', '=', array( 'menu-center', 'menu-right' ) ),
			),
		),
		array(
			'id'       => 'header_above_content',
			'type'     => 'switch',
			'title'    => esc_html__('Header above content?', 'ciyashop' ), 
			'desc'     => esc_html__('This will display the header above the page content. This is useful when displaying here or slider section below the header.', 'ciyashop' ),
			'default'  => '0', // 1 = on | 0 = off
			'on'       => 'Enabled',
			'off'      => 'Disabled',
			'required' => array('header_type', '=', array('menu-center', 'menu-right')),
		),
		array(
			'id'         => 'categories_menu_status',
			'type'       => 'button_set',
			'title'      => esc_html__('Categories Menu', 'ciyashop' ),
			'options'    => array(
				'enable' => esc_html__('Enable', 'ciyashop' ),
				'disable' => esc_html__('Disable', 'ciyashop' ),
			),
			'default'    => 'disable',
			'required' => array('header_type', '=', array('default', 'logo-center', 'topbar-with-main-header')),
		),
		array(
			'id'      => 'menu_font_style-start',
			'type'    => 'section',
			'title'   => esc_html__('Menu Fonts', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'    => 'menu_font_style_info',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'These fields will be applicable only when Mega menu not enabled for "Primary Menu".', 'ciyashop' ),
			'icon'  => 'el el-info-circle'
		),
		array(
			'id'       => 'menu_font_style_enable',
			'type'     => 'button_set',
			'title'    => esc_html__('Menu Fonts Style', 'ciyashop' ), 
			'desc'     => esc_html__('This will enable the custom font style for menu.', 'ciyashop' ),
			'options'    => array(
				'default' => esc_html__('Default', 'ciyashop' ),
				'custom' => esc_html__('Custom', 'ciyashop' ),
			),
			'default'  => 'default'
		),
		array(
			'id'            => 'menu_fonts',
			'type'          => 'typography',
			'title'         => esc_html__( 'Menu Fonts', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Specify menu font properties.', 'ciyashop' ),
			'google'        => true,
			'font-backup'   => false,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-family' => 'Lato',
				'font-weight' => '400',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '15px',
				'line-height' => '26px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
			'required' => array(
				array('menu_font_style_enable', '=', 'custom'),
			),
		),
		array(
			'id'            => 'sub_menu_fonts',
			'type'          => 'typography',
			'title'         => esc_html__( 'Sub Menu Fonts', 'ciyashop' ),
			'subtitle'      => esc_html__( 'Specify Sub menu font properties.', 'ciyashop' ),
			'google'        => true,
			'font-family'   => false,
			'font-backup'   => false,
			'all_styles'    => true,
			'letter-spacing'=> true,
			'text-align'    => false,
			'units'         => 'px',
			'color'         => false,
			'default'       => array(
				'font-weight' => '400',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '15px',
				'line-height' => '26px',
			),
			'fonts'    => ciyashop_redux_typography_font_backup(),
			'required' => array(
				array('menu_font_style_enable', '=', 'custom'),
			),
		),
		array(
			'id'      => 'menu_font_style-end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'      => 'woocommerce_icons-start',
			'type'    => 'section',
			'title'   => esc_html__('WooCommerce Icons', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'     => 'show_header_cart',
			'type'   => 'switch',
			'title'  => esc_html__('Show Cart Icon', 'ciyashop' ),
			'on'     => esc_html__('Yes', 'ciyashop' ),
			'off'    => esc_html__('No', 'ciyashop' ),
			'default'=> true, 
		),
		array(
			'id'       => 'shopping-cart-icon',
			'type'     => 'radio',
			'title'    => esc_html__('Cart Icon', 'ciyashop' ),
			'options'  => array(
				'fa fa-shopping-cart'                             => '<i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>',
				'fa fa-shopping-basket'                           => '<i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i>',
				'fa fa-shopping-bag'                              => '<i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-empty-shopping-cart'=> '<i class="glyph-icon pgsicon-ecommerce-empty-shopping-cart fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-shopping-cart-1'    => '<i class="glyph-icon pgsicon-ecommerce-shopping-cart-1 fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-shopping-bag-4'     => '<i class="glyph-icon pgsicon-ecommerce-shopping-bag-4 fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-commerce-1'         => '<i class="glyph-icon pgsicon-ecommerce-commerce-1 fa-2x" aria-hidden="true"></i>',
			),
			'default' => 'fa fa-shopping-cart',
			'class'   => 'cart-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array('show_header_cart', '=', 1),
			),
		),
		array(
			'id'     => 'show_header_compare',
			'type'   => 'switch',
			'title'  => esc_html__('Show Compare Icon', 'ciyashop' ),
			'on'     => esc_html__('Yes', 'ciyashop' ),
			'off'    => esc_html__('No', 'ciyashop' ),
			'default'=> true, 
		),
		array(
			'id'       => 'woocommerce_compare_icon',
			'type'     => 'radio',
			'title'    => esc_html__('Compare Icon', 'ciyashop' ),
			'options'  => array(
				'fa fa-compress'                       => '<i class="fa fa-compress fa-2x" aria-hidden="true"></i>',
				'fa fa-expand'                         => '<i class="fa fa-expand fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-arrows-9'=> '<i class="glyph-icon pgsicon-ecommerce-arrows-9 fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-repeat-2'=> '<i class="glyph-icon pgsicon-ecommerce-repeat-2 fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-shuffle' => '<i class="glyph-icon pgsicon-ecommerce-shuffle fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-arrows-7'=> '<i class="glyph-icon pgsicon-ecommerce-arrows-7 fa-2x" aria-hidden="true"></i>',
			),
			'default' => 'fa fa-compress',
			'class'   => 'compare-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array('show_header_compare', '=', 1),
			),
		),
		array(
			'id'     => 'show_header_wishlist',
			'type'   => 'switch',
			'title'  => esc_html__('Show Wishlist Icon', 'ciyashop' ),
			'on'     => esc_html__('Yes', 'ciyashop' ),
			'off'    => esc_html__('No', 'ciyashop' ),
			'default'=> true, 
		),
		array(
			'id'       => 'woocommerce_wishlist_icon',
			'type'     => 'radio',
			'title'    => esc_html__('Wishlist Icon', 'ciyashop' ),
			'options'  => array(
				'fa fa-heart'                          => '<i class="fa fa-heart fa-2x" aria-hidden="true"></i>',
				'fa fa-heart-o'                        => '<i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-heart'   => '<i class="glyph-icon pgsicon-ecommerce-heart fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-shapes-1'=> '<i class="glyph-icon pgsicon-ecommerce-shapes-1 fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-like'    => '<i class="glyph-icon pgsicon-ecommerce-like fa-2x" aria-hidden="true"></i>',
			),
			'default' => 'fa fa-heart',
			'class'   => 'wishlist-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array('show_header_wishlist', '=', 1),
			),
		),
		array(
			'id'      => 'woocommerce_icons-end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'   =>'divider_1',
			'type' => 'divide'
		),
		array( 
			'id'       => 'header_colors_info',
			'type'     => 'raw',
			'content'  => esc_html__('Here below you can customize and control colors of Topbar, Main Header, and Navigation section. These colors will be extension to colors set from Color Scheme theme options. So, some elements in these section will use default colors from Color Scheme theme options. ', 'ciyashop' ),
		),
		/******************************************************************* Topbar *******************************************************************/
		array(
			'id'    => 'header_nav_colors_info_header_type_menu_center',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'If header style is set to "Topbar with Main Header", the background color will not applicable, as because the topbar will be moved in default header area and use background color from there.', 'ciyashop' ),
			'icon'  => 'el el-info-circle',
			'required'   => array(
				array( 'header_type', '=', array( 'topbar-with-main-header' ) ),
			),
		),
		array(
			'id'      => 'topbar_colors-start',
			'type'    => 'section',
			'title'   => esc_html__('Topbar Colors', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'         => 'topbar_bg_type',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Background Color Type', 'ciyashop' ),
			'options'    => array(
				'default'    => esc_html__( 'Default', 'ciyashop' ),
				'custom'     => esc_html__( 'Custom', 'ciyashop' ),
			),
			'default'    => 'default',
		),
		array(
			'id'        => 'topbar_bg_color',
			'type'      => 'color_rgba',
			'title'      => esc_html__('Background Color', 'ciyashop' ),
			'default'   => array(
				'color'     => '#FFFFFF',
				'alpha'     => 1
			),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => true,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'choose_text'               => esc_html__('Choose', 'ciyashop' ),
				'cancel_text'               => esc_html__('Cancel', 'ciyashop' ),
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => esc_html__('Select Color', 'ciyashop' ),
			),
			'required'   => array(
				array('topbar_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'         => 'topbar_text_color',
			'type'       => 'color',
			'title'      => esc_html__('Text Color', 'ciyashop' ),
			'mode'       => 'background-color',
			'validate'   => 'color',
			'transparent'=> false,
			'default'    => '#323232',
			'required'   => array(
				array('topbar_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'     => 'topbar_link_color',
			'type'   => 'link_color',
			'title'  => esc_html__('Link Color', 'ciyashop' ),
			'regular'=> true,
			'hover'  => true,
			'active' => false,
			'visited'=> false,
			'default'=> array(
				'regular'  => '#323232',
				'hover'    => '#04d39f',
			),
			'required'   => array(
				array('topbar_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'      => 'topbar_colors-end',
			'type'   => 'section',
			'indent' => false,
		),
		/******************************************************************* Header (Main) *******************************************************************/
		array(
			'id'      => 'header_main_colors-start',
			'type'    => 'section',
			'title'   => esc_html__('Header (Main) Colors', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'         => 'header_main_bg_type',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Background Color Type', 'ciyashop' ),
			'options'    => array(
				'default'    => esc_html__( 'Default', 'ciyashop' ),
				'custom'     => esc_html__( 'Custom', 'ciyashop' ),
			),
			'default'    => 'default',
		),
		array(
			'id'         => 'header_main_bg_color',
			'type'      => 'color_rgba',
			'title'      => esc_html__('Background Color', 'ciyashop' ),
			'default'   => array(
				'color'     => '#FFFFFF',
				'alpha'     => 1
			),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => true,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'choose_text'               => esc_html__('Choose', 'ciyashop' ),
				'cancel_text'               => esc_html__('Cancel', 'ciyashop' ),
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => esc_html__('Select Color', 'ciyashop' ),
			),
			'required'   => array(
				array('header_main_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'         => 'header_main_text_color',
			'type'       => 'color',
			'title'      => esc_html__('Text Color', 'ciyashop' ),
			'mode'       => 'background-color',
			'validate'   => 'color',
			'transparent'=> false,
			'default'    => '#323232',
			'required'   => array(
				array('header_main_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'     => 'header_main_link_color',
			'type'   => 'link_color',
			'title'  => esc_html__('Link Color', 'ciyashop' ),
			'regular'=> true,
			'hover'  => true,
			'active' => false,
			'visited'=> false,
			'default'=> array(
				'regular'  => '#323232',
				'hover'    => '#04d39f',
			),
			'required'   => array(
				array('header_main_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'      => 'header_main_colors-end',
			'type'   => 'section',
			'indent' => false,
		),
		/******************************************************************* Header (Navigation) *******************************************************************/
		array(
			'id'      => 'header_nav_colors-start',
			'type'    => 'section',
			'title'   => esc_html__('Header (Navigation) Colors', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'    => 'header_nav_colors_info',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__('These colors, except Background Color, will be applicable only if the menu is a normal menu, instead of Mega Menu.', 'ciyashop' ),
			'icon'  => 'el el-info-circle',
		),
		array(
			'id'    => 'header_nav_colors_info_header_type_menu_center',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'If header style is set to "Menu Center", "Menu Right", or "Right Topbar & Main", the background color will not applicable, as because the menu will be moved in default header area and use background color from there.', 'ciyashop' ),
			'icon'  => 'el el-info-circle',
			'required'   => array(
				array( 'header_type', '=', array( 'menu-center', 'menu-right', 'right-topbar-main' ) ),
			),
		),
		array(
			'id'         => 'header_nav_bg_type',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Background Color Type', 'ciyashop' ),
			'options'    => array(
				'default'    => esc_html__( 'Default', 'ciyashop' ),
				'custom'     => esc_html__( 'Custom', 'ciyashop' ),
			),
			'default'    => 'default',
		),
		array(
			'id'         => 'header_nav_bg_color',
			'type'      => 'color_rgba',
			'title'      => esc_html__('Background Color', 'ciyashop' ),
			'default'   => array(
				'color'     => '#FFFFFF',
				'alpha'     => 1
			),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => true,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => true,
				'choose_text'               => esc_html__('Choose', 'ciyashop' ),
				'cancel_text'               => esc_html__('Cancel', 'ciyashop' ),
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => esc_html__('Select Color', 'ciyashop' ),
			),
			'required'   => array(
				array('header_nav_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'         => 'header_nav_text_color',
			'type'       => 'color',
			'title'      => esc_html__('Text Color', 'ciyashop' ),
			'mode'       => 'background-color',
			'validate'   => 'color',
			'transparent'=> false,
			'default'    => '#ffffff',
			'required'   => array(
				array('header_nav_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'     => 'header_nav_link_color',
			'type'   => 'link_color',
			'title'  => esc_html__('Link Color', 'ciyashop' ),
			'regular'=> true,
			'hover'  => true,
			'active' => false,
			'visited'=> false,
			'default'=> array(
				'regular'  => '#323232',
				'hover'    => '#04d39f',
			),
			'required'   => array(
				array('header_nav_bg_type', '=', array('custom') ),
			)
		),
		array(
			'id'      => 'header_nav_colors-end',
			'type'   => 'section',
			'indent' => false,
		),
	)
);