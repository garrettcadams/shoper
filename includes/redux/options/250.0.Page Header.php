<?php
$breadcrumb_fields_info = $breadcrumb_fields = array();
$breadcrumb_fields[] = array(
	'id'         => 'breadcrumb_section_start',
	'type'       => 'section',
	'title'      => esc_html__( 'Breadcrumb Settings', 'ciyashop' ),
	'indent'     => true,
);
if( function_exists('ciyashop_is_plugin_installed') && ciyashop_is_plugin_installed('breadcrumb-navxt')){
	if (  ciyashop_check_plugin_active( 'breadcrumb-navxt/breadcrumb-navxt.php' ) ) {
		
		$breadcrumb_navxt_settings_link = add_query_arg(array('page' => 'breadcrumb-navxt'),admin_url( 'options-general.php' ));
		
		$breadcrumb_fields[] = array(
			'id'         => 'display_breadcrumb',
			'type'       => 'switch',
			'title'      => esc_html__('Display Breadcrumb', 'ciyashop' ),
			'default'    => 0,
			'on'         => esc_html__( 'On', 'ciyashop' ),
			'off'        => esc_html__( 'Off', 'ciyashop' ),
		);
		$breadcrumb_fields[] = array(
			'id'       => 'hide_breadcrumb_mobile',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display Breadcrumb on Mobile', 'ciyashop' ),			
			'default'    => 0,
			'on'         => esc_html__( 'On', 'ciyashop' ),
			'off'        => esc_html__( 'Off', 'ciyashop' ),
			'required' => array(
				array('display_breadcrumb', '=', 1)
			)
		);
		$breadcrumb_fields[] = array(
			'id'   => 'breadcrumb_navxt_settings',
			'type' => 'info',
			'style'=> 'info',
			'title'=> esc_html__('Breadcrumb NavXT Settings', 'ciyashop' ),
			'desc' => sprintf( wp_kses( __( 'Click <a href="%1$s">here</a> for more settings.', 'ciyashop' ), array(
					'a' => array(
						'href' => true,
					)
				) ),
				$breadcrumb_navxt_settings_link
			),
			'required' => array(
				array('display_breadcrumb', '=', 1)
			)
		);
	}else{
		$breadcrumb_navxt_activate_link = add_query_arg(array('s' => 'breadcrumb-navxt'),admin_url( 'plugins.php' )	);
		$breadcrumb_fields[] = array(
			'id'     => 'breadcrumb_navxt_inactive',
			'type'   => 'info',
			'notice' => false,
			'style'  => 'info',
			'title'  => wp_kses(__('<strong>Breadcrumb NavXT</strong> Inactive', 'ciyashop' ), array(
				'strong' => array(
				'style'  => true,
			) ) ),
			'desc'   => sprintf( wp_kses( __('Please activate Breadcrumb NavXT to enable breadcrumb options. Click <a href="%1$s">here</a> to activate.', 'ciyashop' ), array(
					'a' => array(
						'href' => true,
					)
				) ),
				$breadcrumb_navxt_activate_link
			),
		);
	}
}else{
	$breadcrumb_navxt_install_link = add_query_arg(array('tab' => 'search','s' => 'breadcrumb-navxt'),admin_url( 'plugin-install.php' ));
	$breadcrumb_fields[] = array(
		'id'     => 'breadcrumb_navxt_not_found',
		'type'   => 'info',
		'notice' => false,
		'style'  => 'info',
		'title'  => wp_kses( __('<strong>Breadcrumb NavXT</strong> Not Installed', 'ciyashop' ), array(
			'strong' => array(
				'style' => true,
			)
		) ),
		'desc'   => sprintf( wp_kses(__('Please install Breadcrumb NavXT to enable breadcrumb options. Click <a href="%1$s">here</a> to install.', 'ciyashop' ), array(
			'a' => array(
				'href' => true,
			)
		) ),
		$breadcrumb_navxt_install_link ),
	);
}
$breadcrumb_fields[] = array(
	'id'         => 'breadcrumb_section_end',
	'type'       => 'section',
	'indent'     => false,
);

return array(
	'title'           => esc_html__('Page Header', 'ciyashop' ),
	'id'              => 'page_header_section',
	'desc'            => esc_html__('You can manage page header settings here, like Page Header Type, Breadcrumb, Page Header Height and other various settings.', 'ciyashop' ),
	'customizer_width'=> '450px',
	'fields'          => array_merge( array(
		array(
			'id'         => 'titlebar_view',
			'type'       => 'select_image_new',
			'title'      => esc_html__( 'Page Header Layout', 'ciyashop' ),
			'placeholder'=> esc_html__( 'Select page header layout.', 'ciyashop' ),
			'select2'    => array(
				'allowClear' => 0,
			),
			'options'   => Array(
				'default'    => array(
					'alt'    => esc_html__( 'Default', 'ciyashop' ),
					'title'  => esc_html__( 'Default', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/titlebar_view/default.png') ),
				),
				'allleft'=> array(
					'alt'    => esc_html__( 'All Left', 'ciyashop' ),
					'title'  => esc_html__( 'All Left', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/titlebar_view/allleft.png') ),
				),
				'allright'=> array(
					'alt'    => esc_html__( 'All Right', 'ciyashop' ),
					'title'  => esc_html__( 'All Right', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/titlebar_view/allright.png') ),
				),
				'left'=> array(
					'alt'    => esc_html__( 'Title Left / Breadcrumb Right', 'ciyashop' ),
					'title'  => esc_html__( 'Title Left / Breadcrumb Right', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/titlebar_view/left.png') ),
				),
				'right'=> array(
					'alt'    => esc_html__( 'Title Right / Breadcrumb Left', 'ciyashop' ),
					'title'  => esc_html__( 'Title Right / Breadcrumb Left', 'ciyashop' ),
					'img'    => esc_url( get_parent_theme_file_uri('/images/options/titlebar_view/right.png') ),
				),
			),
			'default'  => 'default',
		),
		array(
			'id'            => 'pageheader_height',
			'type'          => 'slider',
			'title'         => esc_html__( 'Page Header Height', 'ciyashop' ),
			'desc'          => esc_html__( 'Set height of the Page Header.', 'ciyashop' ),
			'default'       => 150,
			'min'           => 150,
			'step'          => 1,
			'max'           => 600,
			'display_value' => 'text',
		),
		array(
			'id'     => 'enable_full_width',
			'type'   => 'switch',
			'title'  => esc_html__('Enable Full Width', 'ciyashop' ), 
			'desc'   => esc_html__( 'Enable/disable full width page header area', 'ciyashop' ),   
			'default'=> false,
		),
		array(
			'id'         => 'page_header_style_section_start',
			'type'       => 'section',
			'title'      => esc_html__( 'Page Header - Background Settings', 'ciyashop' ),
			'indent'     => true,
		),
		array(
			'id'         => 'banner_type',
			'type'       => 'button_set',
			'title'      => esc_html__('Background Type', 'ciyashop' ),
			'options'    => array(
				'color' => '<i class="fa fa-paint-brush" aria-hidden="true"></i> '.esc_html__( 'Color', 'ciyashop' ),
				'image' => '<i class="fa fa-picture-o" aria-hidden="true"></i> '.esc_html__( 'Image', 'ciyashop' ),
				'video' => '<i class="fa fa-video-camera" aria-hidden="true"></i> '.esc_html__( 'Video', 'ciyashop' ),
			),
			'default' => 'image'
		),
		array(
			'id'              => 'banner_image',
			'type'            => 'background',
			'title'           => esc_html__('Background', 'ciyashop' ),
			'desc'            => esc_html__('Set page header background image.', 'ciyashop' ),
			'background-color'=> false,
			'preview_media'   => true,
			'default'         => array(
				'background-image' => get_parent_theme_file_uri('/images/page-header.jpg'),
			),
			'required'   => array(
				array('banner_type', '=', 'image'),				
			)
		),
		array(
			'id'     => 'video_type',
			'title'  => 'Video Source',
			'desc'   => 'Video source from where to play video in header background.',
			'type'   => 'button_set',
			'options'=> array(
				'youtube'=> '<i class="fa fa-youtube" aria-hidden="true"></i> ' . esc_html__('Youtube', 'ciyashop' ),
				'vimeo'  => '<i class="fa fa-vimeo" aria-hidden="true"></i> ' . esc_html__('Vimeo', 'ciyashop' ),
			),
			'select2'  => array(
				'allowClear' => 0,
			),
			'default' => 'youtube',
			'required'   => array(
				array('banner_type', '=', 'video'),				
			)
		),
		array(
			'id'      => 'youtube_video',
			'title'   => esc_html__('Youtube Video Link', 'ciyashop' ),
			'desc'    => esc_html__('Youtube Video Link of video to play in background', 'ciyashop' ),
			'type'    => 'text',
			'default' => 'https://www.youtube.com/watch?v=D2EvaSgi3UQ',
			'required'=> array(
				array('banner_type', '=', 'video'),
				array('video_type', '=', 'youtube')
			)			
		),
		array(
			'id'      => 'vimeo_video',
			'title'   => esc_html__('Vimeo Video Link', 'ciyashop' ),
			'desc'    => esc_html__('Vimeo Video Link of video to play in background', 'ciyashop' ),
			'type'    => 'text',
			'default' => 'https://vimeo.com/134399785',
			'required'=> array(
				array('banner_type', '=', 'video'),
				array('video_type', '=', 'vimeo')
			)			
		),		
		array(
			'id'         => 'banner_image_opacity',
			'type'       => 'button_set',
			'presets'    => true,
			'title'      => esc_html__('Background Opacity Color', 'ciyashop' ),
			'required'   => array(
				array('banner_type', '=', array('image','video')),
				
			),
			'options'    => array(
				'none'  => esc_html__('None', 'ciyashop' ),
				'black' => esc_html__('Black', 'ciyashop' ),
				'custom'=> esc_html__('Custom', 'ciyashop' ),
			),
			'default' => 'black',
		),
		array(
			'id' => 'banner_image_opacity_custom_color',
			'type' => 'color_rgba',
			'title' => esc_html__('Background Opacity Color (Custom)', 'ciyashop' ),
			'default' => array(
				'color' => '#7e33dd',
				'alpha' => '.8'
			),
			'mode' => 'background-color',
			'required' => array(
				array('banner_type', '=', array('image','video')),
				array('banner_image_opacity', '=', 'custom'),
			),
		),
		array(
			'id'         => 'banner_image_color',
			'type'       => 'color',
			'title'      => esc_html__('Background Color', 'ciyashop' ),
			'transparent'=> false,
			'default'    => '#191919',
			'validate'   => 'color',
			'mode'       => 'background',
			'required'   => array('banner_type', '=', 'color'),
		),
		array(
			'id'         => 'page_header_style_section_end',
			'type'       => 'section',
			'indent'     => false,
			'required'   => array('sticky_header', '=', true),
		),
	), $breadcrumb_fields )
);