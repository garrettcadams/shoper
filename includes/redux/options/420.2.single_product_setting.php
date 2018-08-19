<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
	return array(
		'id'              => 'single_product_setting',
		'title'           => esc_html__('Single Product', 'ciyashop' ),
		'customizer_width'=> '400px',
		'subsection'      => true,
		'fields'          => array(
			array(
				'id'      => 'product_page_style',
				'type'    => 'select',
				'title'   => esc_html__( 'Product Page Style', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Select product page style.', 'ciyashop' ),
				'options' => array(
					'classic'        => esc_html__('Classic', 'ciyashop' ),
					'sticky_gallery' => esc_html__('Sticky Gallery', 'ciyashop' ),
					'wide_gallery'   => esc_html__('Wide Gallery', 'ciyashop' ),
				),
				'select2'            => array(
					'allowClear' => false,
				),
				'default'      => 'classic'
			),
			array(
				'id'      => 'product_page_thumbnail_position',
				'type'    => 'select',
				'title'   => esc_html__( 'Thumbnail Position', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Select thumbnail position.', 'ciyashop' ),
				'options' => array(
					'bottom'=> esc_html__( 'Bottom', 'ciyashop' ),
					'left'  => esc_html__( 'Left', 'ciyashop' ),
					'right' => esc_html__( 'Right', 'ciyashop' ),
				),
				'select2'            => array(
					'allowClear' => false,
				),
				'default'      => 'bottom',
				'required'     => array( 'product_page_style', '=', array('classic', 'sticky_gallery') )
			),
			array(
				'id'      => 'product-page-sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Select sidebar layout', 'ciyashop' ),
				'options' => array(
					'left'        => esc_html__('Left Sidebar', 'ciyashop' ),
					'right'       => esc_html__('Right Sidebar', 'ciyashop' ),
					'no'          => esc_html__('No Sidebar', 'ciyashop' ),
				),
				'select2'            => array(
					'allowClear' => false,
				),
				'default'      => 'right'
			),
			array(
				'id'      => 'product-page-width',
				'type'    => 'select',
				'title'   => esc_html__( 'Page Width', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Select page width', 'ciyashop' ),
				'options' => array(
					'fixed'        => esc_html__('Fixed', 'ciyashop' ),
					'wide'       => esc_html__('Wide', 'ciyashop' ),
				),
				'select2'            => array(
					'allowClear' => false,
				),
				'default'      => 'fixed'
			),
			array(
				'id'      => 'product-tab-layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Tab Layout', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Select product tab layout.', 'ciyashop' ),
				'options' => array(
					'default'       => esc_html__('Default', 'ciyashop' ),
					'default_center'=> esc_html__('Default (Center Aligned)', 'ciyashop' ),
					'left'          => esc_html__('Left', 'ciyashop' ),
					'accordion'     => esc_html__('Accordion', 'ciyashop' ),
				),
				'select2'            => array(
					'allowClear' => false,
				),
				'default'      => 'default'
			),
			array (
				'id'           => 'product_countdown',
				'type'         => 'switch',
				'title'        => esc_html__('Countdown Timer', 'ciyashop' ),
				'subtitle'     => esc_html__('Show timer if product is scheduled for the sale on a specific date', 'ciyashop' ),
				'default'      => false
			),
			array(
				'id'           => 'product_countdown_title',
				'type'         => 'text',
				'title'        => esc_html__('Countdown Title', 'ciyashop' ),
				'default'      => esc_html__('Limited time offer', 'ciyashop' ),
				'required'     => array(
					array( 'product_countdown', '=', true ),
				),
			),
			array (
				'id'           => 'product_sticky_content',
				'type'         => 'switch',
				'title'        => esc_html__('Sticky Title', 'ciyashop' ),
				'default'      => false
			),
			array(
				'id'           => 'product-navigation',
				'type'         => 'switch',
				'title'        => esc_html__('Next/Previous Product Navigation', 'ciyashop' ),
				'default'      => true,
				'on'           => esc_html__('Yes', 'ciyashop' ),
				'off'          => esc_html__('No', 'ciyashop' ),
			),
			array(
				'id'           => 'product-share-buttons',
				'type'         => 'switch',
				'title'        => esc_html__('Show Share Buttons', 'ciyashop' ),
				'default'      => true,
				'on'           => esc_html__('Yes', 'ciyashop' ),
				'off'          => esc_html__('No', 'ciyashop' ),
			),
			array(
				'id'           => 'product-short-description',
				'type'         => 'switch',
				'title'        => esc_html__('Show Short Description', 'ciyashop' ),
				'default'      => true,
				'on'           => esc_html__('Yes', 'ciyashop' ),
				'off'          => esc_html__('No', 'ciyashop' ),
			),
			
			/**********************************************************************************************/
			array(
				'id'      => 'hot_label_section-start',
				'type'    => 'section',
				'title'   => esc_html__('"Hot" Label', 'ciyashop' ),
				'indent'  => true
			),
			array(
				'id'           => 'product-hot',
				'type'         => 'switch',
				'title'        => esc_html__('Show "Hot" Label', 'ciyashop' ),
				'subtitle'     => esc_html__('Will be show in the featured product.', 'ciyashop' ),
				'default'      => true,
				'on'           => esc_html__('Yes', 'ciyashop' ),
				'off'          => esc_html__('No', 'ciyashop' ),
			),
			array(
				'id'           => 'product-hot-label',
				'type'         => 'text',
				'title'        => esc_html__('"Hot" Text', 'ciyashop' ),
				'default'      => esc_html__('Hot', 'ciyashop' ),
				'required'     => array('product-hot','equals',true),
			),
			array(
				'id'     => 'hot_label_section-end',
				'type'   => 'section',
				'indent' => false,
			),
			
			/**********************************************************************************************/
			array(
				'id'      => 'product_sale_section-start',
				'type'    => 'section',
				'title'   => esc_html__('"Sale" Label', 'ciyashop' ),
				'indent'  => true
			),
			array(
				'id'           => 'product-sale',
				'type'         => 'switch',
				'title'        => esc_html__('Show "Sale" Label', 'ciyashop' ),
				'default'      => true,
				'on'           => esc_html__('Yes', 'ciyashop' ),
				'off'          => esc_html__('No', 'ciyashop' ),
			),
			array(
				'id'       => 'product_sale_textperc',
				'type'     => 'button_set',
				'title'    => esc_html__('Label Type', 'ciyashop' ),
				'subtitle' => esc_html__('Select "Sale" label type.', 'ciyashop' ),
				'options' => array(
					'text' => esc_html__('Text', 'ciyashop' ),
					'percent' => esc_html__('Percent', 'ciyashop' ),
				 ),
				'default' => 'text',
				'required'=> array('product-sale', '=', true),
			),
			array(
				'id'           => 'product-sale-label',
				'type'         => 'text',
				'title'        => esc_html__('"Sale" Text', 'ciyashop' ),
				'default'      => esc_html__('Sale', 'ciyashop' ),
				'required'     => array(
					array( 'product-sale', '=', true ),
					array( 'product_sale_textperc', '=', 'text' ),
				),
			),
			array(
				'id'     => 'product_sale_section-end',
				'type'   => 'section',
				'indent' => false,
			),
			/**********************************************************************************************/
			array(
				'id'      => 'related_products_section-start',
				'type'    => 'section',
				'title'   => esc_html__('Related Products', 'ciyashop' ),
				'indent'  => true
			),
			array(
				'id'           => 'show_related_products',
				'type'         => 'switch',
				'url'          => true,
				'title'        => esc_html__('Show Related Products', 'ciyashop' ),
				'compiler'     => 'true',
				'subtitle'     => esc_html__('Show related products on the product page.', 'ciyashop' ),
				'default'      => '1'// 1= on | 0= off
			),
			array(
				'id'           => 'related_products_per_page',
				'type'         => 'slider',
				'url'          => true,
				'title'        => esc_html__('Number of Related Products per Page', 'ciyashop' ),
				'compiler'     => 'true',
				'subtitle'     => esc_html__('Select the number of related products to display.', 'ciyashop' ),
				'default'      => 6,
				'min'          => 3,
				'step'         => 1,
				'max'          => 12,
				'display_value'=> 'text',
				'required'     => array('show_related_products', '=', true)
			),
			array(
				'id'     => 'related_products_section-end',
				'type'   => 'section',
				'indent' => false,
			),
			
			/**********************************************************************************************/
			array(
				'id'      => 'up_sells_section-start',
				'type'    => 'section',
				'title'   => esc_html__('Up Sells', 'ciyashop' ),
				'indent'  => true
			),
			array(
				'id'           => 'show_up_sells',
				'type'         => 'switch',
				'url'          => true,
				'title'        => esc_html__('Show UP Sells', 'ciyashop' ),
				'compiler'     => 'true',
				'subtitle'     => esc_html__('Show UP Sells products.', 'ciyashop' ),
				'default'      => '1'// 1= on | 0= off
			),
			array(
				'id'           => 'up_sells_products_per_page',
				'type'         => 'slider',
				'url'          => true,
				'title'        => esc_html__('Number of UP Sells Products per Page', 'ciyashop' ),
				'compiler'     => 'true',
				'subtitle'     => esc_html__('Select the number of UP Sells products to display.', 'ciyashop' ),
				'default'      => 6,
				'min'          => 3,
				'step'         => 1,
				'max'          => 12,
				'display_value'=> 'text',
				'required'     => array('show_up_sells', '=', true)
			),
			array(
				'id'     => 'up_sells_section-end',
				'type'   => 'section',
				'indent' => false,
			),
			/**********************************************************************************************/
		)
	);
}