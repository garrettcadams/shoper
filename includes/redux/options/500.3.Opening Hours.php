<?php
return array(
	'title'           => esc_html__('Opening Hours', 'ciyashop' ),
	'id'              => 'opening_hours',
	'customizer_width'=> '400px',
	'subsection'      => true,
	'icon'            => 'el el-hourglass',
	'fields'          => array(
		array(
			'id'      => 'mon_time',
			'type'    => 'text',
			'title'   => esc_html__('Monday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Monday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'tue_time',
			'type'    => 'text',
			'title'   => esc_html__('Tuesday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Tuesday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'wed_time',
			'type'    => 'text',
			'title'   => esc_html__('Wednesday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Wednesday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'thu_time',
			'type'    => 'text',
			'title'   => esc_html__('Thursday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Thursday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'fri_time',
			'type'    => 'text',
			'title'   => esc_html__('Friday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Friday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'sat_time',
			'type'    => 'text',
			'title'   => esc_html__('Saturday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Saturday.', 'ciyashop' ),
			'default'=> esc_html__('9:00 - 21:00', 'ciyashop' ),
		),
		array(
			'id'      => 'sun_time',
			'type'    => 'text',
			'title'   => esc_html__('Sunday', 'ciyashop' ),
			'subtitle'=> esc_html__('Enter timing for Sunday.', 'ciyashop' ),
			'default'=> esc_html__('Closed', 'ciyashop' ),
		),
	)
);
