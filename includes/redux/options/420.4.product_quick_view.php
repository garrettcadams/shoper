<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
	return array(
		'id'              => 'product_quick_view',
		'title'           => esc_html__('Quick View', 'ciyashop' ),
		'customizer_width'=> '400px',
		'subsection'      => true,
		'fields'          => array(
			array (
				'id'      => 'quick_view',
				'type'    => 'switch',
				'title'   => esc_html__('Quick View', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable product quick view. If this is enabled, on clicking "Quick View" button, it will display a popup with product details.', 'ciyashop' ),
				'default' => true
			),
			array (
				'id'      => 'quick_view_product_name',
				'type'    => 'switch',
				'title'   => esc_html__('Product Name', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product name in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_link',
				'type'    => 'switch',
				'title'   => esc_html__('Product link', 'ciyashop' ),
				'subtitle'=> esc_html__('Set product link on product name', 'ciyashop' ),
				'default' => true,
				'required'=> array(
					array('quick_view','=',true),
					array('quick_view_product_name','=',true),
				),
			),
			array (
				'id'      => 'quick_view_product_categories',
				'type'    => 'switch',
				'title'   => esc_html__('Product Categories', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product categories in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_price',
				'type'    => 'switch',
				'title'   => esc_html__('Product Price', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product price in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_star_rating',
				'type'    => 'switch',
				'title'   => esc_html__('Product Star Rating', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product star rating in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_short_description',
				'type'    => 'switch',
				'title'   => esc_html__('Product Short Description', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product short description in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_add_to_cart',
				'type'    => 'switch',
				'title'   => esc_html__('Product Add to Cart', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product "Add to Cart" button in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
			array (
				'id'      => 'quick_view_product_share_icon',
				'type'    => 'switch',
				'title'   => esc_html__('Product Share Icon', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable this to display product share icons in quick view popup.', 'ciyashop' ),
				'default' => true,
				'required'=> array('quick_view','=',true),
			),
		)
	);
}