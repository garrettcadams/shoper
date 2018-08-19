<?php
return array(
	'title'           => esc_html__('Search', 'ciyashop' ),
	'id'              => 'search_section',
	'subsection'      => true,
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'     => 'show_search',
			'type'   => 'switch',
			'title'  => esc_html__('Enable Search', 'ciyashop' ),
			'on'     => esc_html__('Yes', 'ciyashop' ),
			'off'    => esc_html__('No', 'ciyashop' ),
			'default'=> true,
		),
		array(
			'id'         => 'search_background_type',
			'type'       => 'button_set',
			'title'      => esc_html__('Search Background Type', 'ciyashop' ),
			'options'    => array(
				'search-bg-white' => esc_html__('White', 'ciyashop' ),
				'search-bg-light' => esc_html__('Light', 'ciyashop' ),
				'search-bg-dark'  => esc_html__('Dark', 'ciyashop' ),
			),
			'description' => esc_html__('Select color type of header background, behind the search box.', 'ciyashop' ),
			'default' => 'search-bg-white',
			'required'=> array(
				array('show_search', '=', 1),
				array( 'header_type', '=', 'default' ),
			)
		),
		array(
			'id'         => 'search_box_shape',
			'type'       => 'button_set',
			'title'      => esc_html__('Search Box Shape', 'ciyashop' ),
			'options'    => array(
				'square'    => esc_html__('Square', 'ciyashop' ),
				'rounded'   => esc_html__('Rounded', 'ciyashop' ),
			),
			'desc'    => esc_html__('Note: This field is applicable only, when "Header Style" is set to "Default".', 'ciyashop' ),
			'default' => 'square',
			'required'=> array(
				array( 'show_search', '=', 1 ),
				array( 'header_type', '=', 'default' ),
			)
		),
		array(
			'id'         => 'search_placeholder_text',
			'type'       => 'text',
			'title'      => esc_html__('Search Input Placeholder', 'ciyashop' ),
			'default' => esc_html__('Enter Search Keyword...', 'ciyashop' ),	
			'required'=> array(
				array('show_search', '=', 1),
			)
		),
		array(
			'id'         => 'search_content_type',
			'type'       => 'button_set',
			'title'      => esc_html__('Search Content Type', 'ciyashop' ),
			'options'    => array(
				'all'    => esc_html__('All', 'ciyashop' ),
				'post'   => esc_html__('post', 'ciyashop' ),
				'product'=> esc_html__('Product', 'ciyashop' ),
				'page'   => esc_html__('page', 'ciyashop' ),
			),
			'default' => 'all',
			'required'=> array(
				array('show_search', '=', 1),
			)
		),
		array(
			'id'      => 'show_categories',
			'type'    => 'switch',
			'title'   => esc_html__('Show Categories', 'ciyashop' ),
			'on'      => esc_html__('Yes', 'ciyashop' ),
			'off'     => esc_html__('No', 'ciyashop' ),
			'default' => true,
			'required'=> array(
				array('search_content_type', '=', array('post', 'product') ),
			)
		),
		
		array(
			'id'    => 'search_keywords_start_info',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'These fields will be applicable only when, "Header Style" is set to "Logo Center", "Menu Center", "Menu Right", "Topbar with Main Header", or "Right Topbar & Main".', 'ciyashop' ),
			'icon'  => 'el el-info-circle',
			'required'   => array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array('product') ),
				array( 'header_type', '!=', array('default') ),
			),
		),
		
		array(
			'id'       => 'site_search_icon',
			'type'     => 'radio',
			'title'    => esc_html__('Search Icon', 'ciyashop' ),
			'options'  => array(
				'fa fa-search'                                   => '<i class="fa fa-search fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-search'            => '<i class="glyph-icon pgsicon-ecommerce-search fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-magnifying-glass'  => '<i class="glyph-icon pgsicon-ecommerce-magnifying-glass fa-2x" aria-hidden="true"></i>',
				'glyph-icon pgsicon-ecommerce-magnifying-glass-1'=> '<i class="glyph-icon pgsicon-ecommerce-magnifying-glass-1 fa-2x" aria-hidden="true"></i>',
			),
			'default' => 'fa fa-search',
			'class'   => 'wishlist-icon-large radio-icon-selector-horizontal',
			'desc'    => esc_html__('These search icons will be applicable, when search icon is displaying only in header section, instead of full search field.', 'ciyashop' ),
			'required'=> array(
				array( 'show_search', '=', 1 ),
				array( 'header_type', '!=', array('default') ),
			)
		),
		
		/* ------------------------------------------------- Search Keyword ------------------------------------------------- */
		array(
			'id'      => 'search_keywords_start',
			'type'    => 'section',
			'title'   => esc_html__('Search Keyword', 'ciyashop' ),
			'indent'  => true,
			'required'=> array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array('product') ),
				array( 'header_type', '!=', array('default') ),
			)
		),
		
		array(
			'id'      => 'show_search_keywords',
			'type'    => 'switch',
			'title'   => esc_html__('Show Keywords', 'ciyashop' ),
			'on'      => esc_html__('Yes', 'ciyashop' ),
			'off'     => esc_html__('No', 'ciyashop' ),
			'default' => true,
			'required'=> array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array('product') ),
				array( 'header_type', '!=', array('default') ),
			)
		),
		array(
			'id'         => 'search_keywords_title',
			'type'       => 'text',
			'title'      => esc_html__('Search Keyword Title', 'ciyashop' ),
			'default' => esc_html__('Popular Search', 'ciyashop' ),	
			'required'=> array(
				array( 'show_search_keywords', '=', true ),
			)
		),
		array(
			'id'       => 'search_keywords',
			'type'     => 'select',
			'multi'    => true,
			'title'    => esc_html__('Keywords', 'ciyashop' ), 
			'desc'     => esc_html__('This keywords will display on search Popup', 'ciyashop' ),
			'sortable' => true,
			'options'  => ciyashop_get_product_categories(),
			'required'=> array(
				array( 'show_search_keywords', '=', true ),
			)
		),
		array(
			'id'     => 'search_keywords_end',
			'type'   => 'section',
			'indent' => false,
			'required'=> array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array('product') ),
				array( 'header_type', '!=', array('default') ),
			)
		),
	)
);