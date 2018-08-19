<?php
return array(
	'title'           => esc_html__('Site Contacts', 'ciyashop' ),
	'id'              => 'site_contacts',
	'customizer_width'=> '400px',
	'subsection'      => true,
	'icon'            => 'el el-envelope',
	'fields'          => array(
		array(
			'id'      => 'site_email',
			'type'    => 'text',
			'title'   => esc_html__('Email', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter email address.', 'ciyashop' ),
			'default' => 'info@example.com',
			'validate'=> 'email',
			'msg'     => 'Please enter valid email.',
		),
		array(
			'id'      => 'site_phone',
			'type'    => 'text',
			'title'   => esc_html__('Phone Number', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter phone number.', 'ciyashop' ),
			'default' => '(007) 123 456 7890',
		),
	)
);