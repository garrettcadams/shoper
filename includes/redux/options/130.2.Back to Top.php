<?php
return array(
	'title'           => esc_html__('Back to Top', 'ciyashop' ),
	'id'              => 'main_back_to_top',	
	'customizer_width'=> '400px',
	'icon'            => 'el el-circle-arrow-up',
	'fields'          => array(
		array(
			'id'      => 'back_to_top',
			'type'    => 'switch',
			'title'   => esc_html__('Back to Top', 'ciyashop' ),
			'subtitle'=> esc_html__('Enable/disable back to top button.', 'ciyashop' ),
			'default' => true,
		),
		array(
			'id'      => 'back_to_top_mobile',
			'type'    => 'switch',
			'title'   => esc_html__('Back to Top For Mobile', 'ciyashop' ),
			'subtitle'=> esc_html__('Enable/disable back to top button for mobile device.', 'ciyashop' ),
			'default' => true,
		),
	)
);