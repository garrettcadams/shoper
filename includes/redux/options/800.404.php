<?php
$exclude_pages = array();

// Exclude Home and Blog pages.
$show_on_front = get_option('show_on_front');
if( $show_on_front == 'page' ){
	
	$page_on_front = get_option('page_on_front');
	$page_for_posts = get_option('page_for_posts');
	
	if( isset($page_on_front) && $page_on_front != '0' ){
		$exclude_pages[] = $page_on_front;
	}
	
	if( isset($page_for_posts) && $page_for_posts != '0' ){
		$exclude_pages[] = $page_for_posts;
	}
}

// Exclude WooCommerce pages
if ( class_exists( 'WooCommerce' ) && is_admin() ) {
	$woocommerce_pages = array(
		'woocommerce_shop_page_id',
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_pay_page_id',
		'woocommerce_thanks_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_edit_address_page_id',
		'woocommerce_view_order_page_id',
		'woocommerce_terms_page_id',
	);
	foreach( $woocommerce_pages as $woocommerce_page ){
		$woocommerce_page_id = get_option($woocommerce_page);
		if( $woocommerce_page_id ){
			$exclude_pages[] = $woocommerce_page_id;
		}
	}
}

return array(
	'title'           => esc_html__('404 Page', 'ciyashop' ),
	'id'              => 'fourofour_section',
	'customizer_width'=> '400px',
	'icon'            => 'fa fa-exclamation-triangle',
	'desc'            => esc_html__('Set 404 page title and content.', 'ciyashop' ),
	'fields'          => array(
		// Page Title
		array(
			'id'      => 'fourofour_title_section-start',
			'type'    => 'section',
			'title'   => esc_html__('Page Title', 'ciyashop' ),
			'subtitle'=> esc_html__('Here you can manage 404 page title.', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'       => 'fourofour_page_title_source',
			'type'     => 'button_set',
			'title'    => esc_html__('Page Title Source', 'ciyashop' ),
			'options'  => array(
				'default'=> esc_html__('Default', 'ciyashop' ),
				'custom' => esc_html__('Custom', 'ciyashop' ),
			),
			'default'      => 'default',
		),
		array(
			'id'           => 'fourofour_page_title',
			'type'         => 'text',
			'title'        => esc_html__('Page Title', 'ciyashop' ),
			'desc'         => esc_html__('Enter custom 404 page title.', 'ciyashop' ),
			'default'      => esc_html__('404 error', 'ciyashop' ),
			'required'     => array( 'fourofour_page_title_source', '=', 'custom' ),
		),
		array(
			'id'      => 'fourofour_title_section-end',
			'type'   => 'section',
			'indent' => false,
		),
		
		// Page Content
		array(
			'id'      => 'fourofour_content_section-start',
			'type'    => 'section',
			'title'   => esc_html__('Page Content', 'ciyashop' ),
			'subtitle'=> esc_html__('Here you can manage 404 page content.', 'ciyashop' ),
			'indent'  => true
		),
		array(
			'id'       => 'fourofour_page_content_source',
			'type'     => 'button_set',
			'title'    => esc_html__('Page Content Type', 'ciyashop' ),
			'options'  => array(
				'default'=> esc_html__('Default', 'ciyashop' ),
				'page'   => esc_html__('Page', 'ciyashop' ),
			),
			'default'      => 'default',
		),
		array(
			'id'           => 'fourofour_page_content_title',
			'type'         => 'text',
			'title'        => esc_html__('Content Title', 'ciyashop' ),
			'desc'         => esc_html__('Enter custom 404 content title.', 'ciyashop' ),
			'default'      => esc_html__('404', 'ciyashop' ),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'           => 'fourofour_page_content_subtitle',
			'type'         => 'text',
			'title'        => esc_html__('Content Subitle', 'ciyashop' ),
			'desc'         => esc_html__('Enter custom 404 content subtitle.', 'ciyashop' ),
			'default'      => esc_html__("Oops ! Sorry We Can't Find That Page.", 'ciyashop' ),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'           => 'fourofour_page_content_description',
			'type'         => 'textarea',
			'title'        => esc_html__('Content Description', 'ciyashop' ),
			'desc'         => esc_html__('Enter custom 404 content description.', 'ciyashop' ),
			'validate' => 'html_custom',
			'default' => sprintf( wp_kses( __( "Can't find what you looking for? Take a moment and do a search below or start from our <a class='error-search-box-description-link' href='%s'>Home Page</a>", 'ciyashop' ),
					array(
						'a' => array(
							'class' => array(),
							'href'  => array(),
						),
					)
				),
				esc_url( home_url( '/' ) )
			),
			'allowed_html' => array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'       => 'fourofour_page_content_image',
			'type'     => 'media',
			'url'      => true,
			'compiler' => 'true',
			'title'    => esc_html__('Content Image', 'ciyashop' ),
			'desc'     => esc_html__('Set content image.', 'ciyashop' ),
			'default'  => array('url'=> get_parent_theme_file_uri('/images/error-404-image.png')),
			'required' => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'             => 'fourofour_page_content_padding',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units'          => array('px', 'em'),
			'units_extended' => 'false',
			'title'          => esc_html__('Content Padding', 'ciyashop' ),
			'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'ciyashop' ),
			'default'            => array(
				'units'          => 'px',
			),
			'select2'            => array(
				'allowClear' => false,
			),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'             => 'fourofour_page_content_margin',
			'type'           => 'spacing',
			'mode'           => 'margin',
			'units'          => array('px', 'em'),
			'units_extended' => 'false',
			'title'          => esc_html__('Content Margin', 'ciyashop' ),
			'desc'           => esc_html__('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'ciyashop' ),
			'default'            => array(
				'units'          => 'px',
			),
			'select2'            => array(
				'allowClear' => false,
			),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'      => 'fourofour_page_content_page',
			'type'    => 'select',
			'title'   => esc_html__('Page', 'ciyashop' ),
			'desc'    => esc_html__('Select page to display as 404 page.', 'ciyashop' ),
			'data'    => 'pages',
			'args' => array(
				'exclude' => $exclude_pages,
			),
			'required'=> array( 'fourofour_page_content_source', '=', 'page' ),
		),
		array(
			'id'     => 'fourofour_content_section-end',
			'type'   => 'section',
			'indent' => false,
		),
	)
);