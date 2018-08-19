<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
	return array(
		'title'           => esc_html__('WooCommerce', 'ciyashop' ),
		'id'              => 'woocommerce_section',
		'customizer_width'=> '400px',
		'icon'            => 'el el-shopping-cart icon-large',
	);
}