<?php
return array(
	'id'              => 'site_info_section_social_profiles',
	'title'           => esc_html__('Social Profiles', 'ciyashop' ),
	'heading'         => esc_html__('Social Profiles', 'ciyashop' ),
	'customizer_width'=> '400px',
	'subsection'      => true,
	'icon'            => 'el el-user',
	'fields'          => array(
		array(
			'id'          => 'social_media_icons',
			'type'        => 'pgs_repeater',
			'title'       => esc_html__( 'Social Profiles', 'ciyashop' ),
			'subtitle'    => esc_html__( 'Social profiles is a repeater field which allow to add one profile per row. Click the "Add" button to add additional fields.', 'ciyashop' ),
			'group_values'=> true, // Group all fields below within the repeater ID
			'sortable'    => true, // Allow the users to sort the repeater blocks or not
			'full_width'  => true,
			'fields'      => array(
				array(
					'id'         => 'social_media_type',
					'type'       => 'select',
					'title'      => esc_html__( 'Social Profile', 'ciyashop' ),
					'desc'       => esc_html__( 'Select social profile. If you want to add custom social profile, then select "Custom".', 'ciyashop' ),
					'options'    => ciyashop_social_media_lists(true),
					'placeholder'=> esc_html__( 'Listing Field', 'ciyashop' ),
				),
				array(
					'id'         => 'social_media_url',
					'type'       => 'text',
					'title'      => esc_html__( 'Link (URL)', 'ciyashop' ),
				),
				array(
					'id'         => 'custom_social_title',
					'type'       => 'text',
					'title'      => esc_html__( 'Title', 'ciyashop' ),
					'desc'   => esc_html__( 'Insert your custom social title here', 'ciyashop' ),
					'required'   => array('select_field', '=', array('custom')),
				),
				array(
					'id'         => 'custom_soical_icon',
					'type'       => 'text',
					'title'      => esc_html__( 'Font Awesome Icon Class', 'ciyashop' ),
					'desc'   => sprintf( wp_kses( __( 'Insert <strong>Font Awesome</strong> class here i.e.<code>fa-link</code>. For list of <strong>Font Awesome</strong> classes click <a href="%s" target="_blank">here</a>.', 'ciyashop' ), array(
							'code'  => true,
							'strong'=> true,
							'a'     => array(
								'href'   => true,
								'target' => true,
							),
						) ),
						'https://fontawesome.com/v4.7.0/icons/#brand'
					),
					'required'   => array('select_field', '=', array('custom')),
				),
			)
		)
	)
);