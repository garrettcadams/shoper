<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
	return array(
		'id'              => 'woocommerce_my_account',
		'title'           => esc_html__('My Account', 'ciyashop' ),
		'customizer_width'=> '400px',
		'subsection'      => true,
		'fields'          => array(
			array (
				'id'      => 'enable_registration_text',
				'type'    => 'switch',
				'title'   => esc_html__('Display Registration Text', 'ciyashop' ),
				'subtitle'=> esc_html__('Enable registration information text', 'ciyashop' ),
				'default' => 1
			),
			array (
				'id'      => 'registration_text',
				'type'    => 'editor',
				'title'   => esc_html__( 'Registration Text', 'ciyashop' ),
				'subtitle'=> esc_html__( 'Show some information about registration on your web-site', 'ciyashop' ),
				'default' => esc_html__( 'Registering for this site allows you to access your order status and history. Just fill in the fields below, and we will get a new account set up for you in no time. We will only ask you for information necessary to make the purchase process faster and easier.', 'ciyashop' ),
				'required'=> array('enable_registration_text','equals',true),
			),
		)
	);
}