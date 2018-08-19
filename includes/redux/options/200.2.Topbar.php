<?php
return array(
	'title'           => esc_html__('Topbar', 'ciyashop' ),
	'id'              => 'appearance_subsection_topbar',
	'subsection'      => true,
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'      => 'topbar_enable',
			'type'    => 'switch',
			'title'   => esc_html__('Topbar', 'ciyashop' ),
			'default' => true,
		),
		array(
			'id'      => 'topbar_mobile_enable',
			'type'    => 'switch',
			'title'   => esc_html__('Topbar Mobile', 'ciyashop' ),
			'default' => true,
			'required' => array(
				array('topbar_enable', '=', 1),
			),
		),
		array(
			'id'         => 'topbar_layout',
			'type'       => 'sorter',
			'title'      => 'Layout',
			'subtitle'   => 'Select layout contents.',
			'description'=> '<p>'
				. '<strong>' . esc_html__( 'Notes', 'ciyashop' ) .':</strong>'
				. '<ol>'
				. '<li>'. sprintf( wp_kses( __('<strong>Language</strong>: This content is <a href="%1$s" target="_blank">WPML</a> dependant and it will be available only if <a href="%1$s" target="_blank">WPML</a> is installed.', 'ciyashop' ),
						array(
							'a' => array(
								'href'   => true,
								'target' => true,
							),
							'strong' => true,
						)
					),
					'https://wpml.org/'
				) . '</li>'
				. '<li>'. sprintf( wp_kses( __('<strong>Currency</strong>: This content is <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> dependant and it will be available only if <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> is installed.', 'ciyashop' ),
						array(
							'a' => array(
								'href'   => true,
								'target' => true,
							),
							'strong' => true
						)
					),
					'https://wordpress.org/plugins/woocommerce-currency-switcher/'
				) . '</li>'
				. '<li>'. wp_kses( __('<strong>Phone Number/Email</strong>: You can manage phone number and email in <strong>"Site Info"</strong> tab in <strong>CiyaShop Theme Settings</strong>.', 'ciyashop' ),
					array(
						'strong' => array()
					)
				) . '</li>'
				. '<li>'. wp_kses( __('<strong>Topbar Menu</strong>: You can manage topbar menu from <strong>Appearance > Menus</strong>.', 'ciyashop' ),
					array(
						'strong' => array()
					)
				) . '</li>'
				,
			'options'    => array(
				'Left'                => array(
					'language'        => esc_html__('Language', 'ciyashop' ),
					'currency'        => esc_html__('Currency', 'ciyashop' ),
					'phone_number'    => esc_html__('Phone Number', 'ciyashop' ),
				),
				'Right'               => array(
					'topbar_menu'     => esc_html__('Topbar Menu', 'ciyashop' ),
				),
				'Available Items'     => array(
					'email'           => esc_html__('Email', 'ciyashop' ),
					'social_profiles'=> esc_html__('Social Profiles', 'ciyashop' ),
				),
			),
			'limits'   => array(
			),
			'required' => array(
				array('topbar_enable', '=', 1),
			),
		),
	)
);