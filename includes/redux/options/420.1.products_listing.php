<?php

/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if (ciyashop_check_plugin_active('woocommerce/woocommerce.php')) {
    return array(
        'id' => 'products_listing',
        'title' => esc_html__('Products Listing', 'ciyashop' ),
        'customizer_width' => '400px',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'pro-col-sel',
                'type' => 'select',
                'title' => esc_html__('Product Listing Column', 'ciyashop' ),
                'subtitle' => esc_html__('Select number of column on listing page', 'ciyashop' ),
                'options' => array(
                    '3' => esc_html__('3 Column', 'ciyashop' ),
                    '4' => esc_html__('4 Column', 'ciyashop' ),
                    '5' => esc_html__('5 Column', 'ciyashop' ),
                ),
                'select2' => array(
                    'allowClear' => false,
                ),
                'default' => '3'
            ),
            array(
                'id' => 'shop_sidebar',
                'type' => 'select',
                'title' => esc_html__('Product Listing Sidebar', 'ciyashop' ),
                'subtitle' => esc_html__('Select sidebar on listing page', 'ciyashop' ),
                'options' => array(
                    'left' => esc_html__('Left Sidebar', 'ciyashop' ),
                    'right' => esc_html__('Right Sidebar', 'ciyashop' ),
                    'no' => esc_html__('No Sidebar', 'ciyashop' ),
                ),
                'select2' => array(
                    'allowClear' => false,
                ),
                'default' => 'left'
            ),
            array(
                'id' => 'shop-page-width',
                'type' => 'select',
                'title' => esc_html__('Page Width', 'ciyashop' ),
                'subtitle' => esc_html__('Select page width', 'ciyashop' ),
                'options' => array(
                    'fixed' => esc_html__('Fixed', 'ciyashop' ),
                    'wide' => esc_html__('Wide', 'ciyashop' ),
                ),
                'select2' => array(
                    'allowClear' => false,
                ),
                'default' => 'fixed'
            ),
            array(
                'id' => 'show_sidebar_on_mobile',
                'type' => 'switch',
                'title' => esc_html__('Show Sidebar on Mobile Devices', 'ciyashop' ),
                'subtitle' => esc_html__('Show Sidebar on mobile devices', 'ciyashop' ),
                'on' => esc_html__('Yes', 'ciyashop' ),
                'off' => esc_html__('No', 'ciyashop' ),
                'default' => true,
                'required' => array('shop_sidebar', '!=', 'no'),
            ),
            array(
                'id' => 'shop_sidebar_position_mobile',
                'type' => 'button_set',
                'title' => esc_html__('Sidebar position for mobile', 'ciyashop' ),
                'subtitle' => esc_html__('Set sidebar position on mobile.', 'ciyashop' ),
                'options' => array(
                    'top' => esc_html__('Top', 'ciyashop' ),
                    'bottom' => esc_html__('Bottom', 'ciyashop' ),
                ),
                'default' => 'bottom',
                'required' => array('show_sidebar_on_mobile', '=', true),
            ),
            /*             * ********************************************************************************* */
            array(
                'id' => 'product_hover_style_section-start',
                'type' => 'section',
                'title' => esc_html__('Product Hover Style Settings', 'ciyashop' ),
                'subtitle' => esc_html__('Here you set product hover style.', 'ciyashop' ),
                'indent' => true
            ),
            array(
                'id' => 'product_hover_style',
                'type' => 'select_image_new',
                'title' => esc_html__('Product Hover Style', 'ciyashop' ),
                'placeholder' => esc_html__('Select product hover style.', 'ciyashop' ),
                'select2' => array(
                    'allowClear' => 0,
                ),
                'options' => Array(
					'default' => array(
                        'alt' => esc_html__('Default', 'ciyashop' ),
                        'title' => esc_html__('Default', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/default.jpg')),
                    ),
                    'image-center' => array(
                        'alt' => esc_html__('Image Center', 'ciyashop' ),
                        'title' => esc_html__('Image Center', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/image-center.png')),
                    ),
                    'image-left' => array(
                        'alt' => esc_html__('Image Left', 'ciyashop' ),
                        'title' => esc_html__('Image Left', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/image-left.png')),
                    ),
                    'image-bottom' => array(
                        'alt' => esc_html__('Image Bottom', 'ciyashop' ),
                        'title' => esc_html__('Image Bottom', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/image-bottom.png')),
                    ),
                    'image-bottom-bar' => array(
                        'alt' => esc_html__('Image Bottom Bar', 'ciyashop' ),
                        'title' => esc_html__('Image Bottom Bar', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/image-bottom-bar.png')),
                    ),
                    'info-bottom' => array(
                        'alt' => esc_html__('Info Bottom', 'ciyashop' ),
                        'title' => esc_html__('Info Bottom', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/info-bottom.png')),
                    ),
                    'info-bottom-bar' => array(
                        'alt' => esc_html__('Info Bottom Bar', 'ciyashop' ),
                        'title' => esc_html__('Info Bottom Bar', 'ciyashop' ),
                        'img' => esc_url(get_parent_theme_file_uri('/images/options/product_hover_style/info-bottom-bar.png')),
                    ),
                ),
                'default' => 'image-center',
            ),
			array(
                'id' => 'product_title_length',
                'type' => 'button_set',
                'title' => esc_html__('Product Title Length', 'ciyashop' ),
                'options' => array(
                    'full' => esc_html__('Full', 'ciyashop' ),
                    'single_line' => esc_html__('Single Line', 'ciyashop' ),
                ),
                'default' => 'single_line',
            ),
            array(
                'id' => 'product_hover_button_shape',
                'type' => 'button_set',
                'title' => esc_html__('Button Shape', 'ciyashop' ),
                'options' => array(
                    'square' => esc_html__('Square', 'ciyashop' ),
                    'round' => esc_html__('Round', 'ciyashop' ),
                ),
                'default' => 'square',
                'required' => array('product_hover_style', '=', array('image-center', 'image-left', 'image-bottom', 'info-bottom')),
            ),
            array(
                'id' => 'product_hover_button_style',
                'type' => 'button_set',
                'title' => esc_html__('Button Style', 'ciyashop' ),
                'options' => array(
                    'flat' => esc_html__('Flat', 'ciyashop' ),
                    'border' => esc_html__('Border', 'ciyashop' ),
                ),
                'default' => 'flat',
                'required' => array('product_hover_style', '=', array('image-center', 'image-left', 'image-bottom')),
            ),
            array(
                'id' => 'product_hover_bar_style',
                'type' => 'button_set',
                'title' => esc_html__('Bar Style', 'ciyashop' ),
                'options' => array(
                    'flat' => esc_html__('Flat', 'ciyashop' ),
                    'border' => esc_html__('Border', 'ciyashop' ),
                ),
                'default' => 'flat',
                'required' => array('product_hover_style', '=', array('image-bottom-bar', 'info-bottom-bar')),
            ),
            array(
                'id' => 'product_hover_add_to_cart_position',
                'type' => 'button_set',
                'title' => esc_html__('"Add to Cart" Position', 'ciyashop' ),
                'options' => array(
                    'center' => esc_html__('Center', 'ciyashop' ),
                    'left' => esc_html__('Left', 'ciyashop' ),
                ),
                'default' => 'center',
                'required' => array('product_hover_style', '=', array('image-bottom-bar', 'info-bottom', 'info-bottom-bar')),
            ),
			array(
                'id' => 'product_hover_default_button_style',
                'type' => 'button_set',
                'title' => esc_html__('Button Style', 'ciyashop' ),
                'options' => array(
                    'dark' => esc_html__('Dark', 'ciyashop' ),
                    'light' => esc_html__('Light', 'ciyashop' ),
                ),
                'default' => 'dark',
                'required' => array('product_hover_style', '=', array('default')),
            ),
            array(
                'id' => 'product_hover_icon_type',
                'type' => 'button_set',
                'title' => esc_html__('Product Icons Type', 'ciyashop' ),
                'subtitle' => esc_html__('Overall Product Hover Icon Type.', 'ciyashop' ),
                'options' => array(
                    'fill-icon' => esc_html__('Flat Icons', 'ciyashop' ),
                    'line-icon' => esc_html__('Line Icons', 'ciyashop' ),
                ),
                'default' => 'fill-icon',
            ),
            array(
                'id' => 'product_hover_style_section-end',
                'type' => 'section',
                'indent' => false,
            ),
            /*             * ********************************************************************************* */
            array(
                'id' => 'product-out-of-stock-icon',
                'type' => 'switch',
                'title' => esc_html__('Display "Out of stock" Label', 'ciyashop' ),
                'default' => true,
                'on' => esc_html__('Yes', 'ciyashop' ),
                'off' => esc_html__('No', 'ciyashop' ),
            ),
			array(
                'id' => 'woocommerce_mobile_sticky_footer',
                'type' => 'switch',
                'title' => esc_html__('Sticky Footer For Mobile Device', 'ciyashop' ),
                'subtitle' => esc_html__('Show and hide the sticky footer for mobile device', 'ciyashop' ),
                'default' => true,
                'on' => esc_html__('Show', 'ciyashop' ),
                'off' => esc_html__('Hide', 'ciyashop' ),
            ),
            array(
                'id' => 'woocommerce_catalog_mode',
                'type' => 'switch',
                'title' => esc_html__('Just Catalog', 'ciyashop' ),
                'subtitle' => esc_html__('Disable "Add To Cart" button and shopping cart', 'ciyashop' ),
                'default' => false,
            ),
            array(
                'id' => 'woocommerce_price_hide',
                'type' => 'switch',
                'title' => esc_html__('Hide Price', 'ciyashop' ),
                'subtitle' => esc_html__('Hide product price on Product pages', 'ciyashop' ),
                'default' => false,
                'required' => array('woocommerce_catalog_mode', '=', true)
            ),
            array(
                'id' => 'shop_countdown',
                'type' => 'switch',
                'title' => esc_html__('Countdown Timer', 'ciyashop' ),
                'subtitle' => esc_html__('Show timer for products that have scheduled date for the sale price', 'ciyashop' ),
                'default' => false
            ),
            array(
                'id' => 'pro-shop-banner_show',
                'type' => 'switch',
                'title' => esc_html__('Shop Page Banner Display', 'ciyashop' ),
                'subtitle' => esc_html__('Show shop page banner at top of product listing.', 'ciyashop' ),
                'default' => '1'// 1    = on | 0= off
            ),
            array(
                'id' => 'pro-shop-banner',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('Shop Page Banner', 'ciyashop' ),
                'compiler' => 'true',
                'subtitle' => esc_html__('Upload any media using the WordPress native uploader', 'ciyashop' ),
                'default' => array('url' => esc_url(get_parent_theme_file_uri('/images/banner-lising.png'))),
                'required' => array('pro-shop-banner_show', '=', true)
            ),
            array(
                'id' => 'products_per_page',
                'type' => 'slider',
                'url' => true,
                'title' => esc_html__('Number of Products per Page', 'ciyashop' ),
                'compiler' => 'true',
                'subtitle' => esc_html__('Select number of products to display per page.', 'ciyashop' ),
                'default' => 12,
                'min' => 0,
                'step' => 1,
                'max' => 40,
                'display_value' => 'text'
            ),
        )
    );
}