<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
	return array(
		'id'              => 'woocommerce_cookie_law_info',
		'title'           => esc_html__('Cookie Law Info', 'ciyashop' ),
		'customizer_width'=> '400px',
		'subsection'      => true,
		'fields'          => array(
			array (
				'id'      => 'cookies_info',
				'type'    => 'switch',
				'title'   => esc_html__('Show Cookies Info', 'ciyashop' ),
				'subtitle'=> esc_html__('Under EU privacy regulations, websites must make it clear to visitors what information about them is being stored. This specifically includes cookies. Turn on this option and user will see info box at the bottom of the page that your web-site is using cookies.', 'ciyashop' ),
				'default' => true
			),
			array (
				'id'      => 'cookies_text',
				'type'    => 'editor',
				'title'   => esc_html__('Popup Text', 'ciyashop' ),
				'subtitle'=> esc_html__('Place here some information about cookies usage that will be shown in the popup.', 'ciyashop' ),
				'default' => esc_html__('We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.', 'ciyashop' ),
				'required' => array( 'cookies_info', '=', 1 ),
			),
			array (
				'id'      => 'cookies_policy_page',
				'type'    => 'select',
				'title'   => esc_html__('Page with Details', 'ciyashop' ),
				'subtitle'=> esc_html__('Choose page that will contain detailed information about your Privacy Policy', 'ciyashop' ),
				'data'    => 'pages',
				'required' => array( 'cookies_info', '=', 1 ),
			),
		)
	);
}