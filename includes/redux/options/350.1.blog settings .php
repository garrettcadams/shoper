<?php 
return array(
	'title'           => esc_html__('Blog Settings', 'ciyashop' ),
	'id'              => 'blog_settings',
	'subsection'      => true,
	'customizer_width'=> '450px',
	'fields'          => array(
		array(
			'id'      => 'blog_sidebar',
			'type'    => 'image_select',
			'title'   => esc_html__('Blog Sidebar', 'ciyashop' ),
			'subtitle'=> esc_html__('Select blog sidebar alignment.', 'ciyashop' ),
			'options' => array(
				'full_width' => array(
					'alt' => esc_html__('Full Width', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_sidebar/full_width.png')
				),
				'left_sidebar' => array(
					'alt' => esc_html__('Left Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_sidebar/left_sidebar.png')
				),
				'right_sidebar' => array(
					'alt' => esc_html__('Right Sidebar', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_sidebar/right_sidebar.png')
				),
			),
			'default' => 'right_sidebar'
		),
		array(
			'id'      => 'blog_layout',
			'type'    => 'image_select',
			'title'   => esc_html__('Blog Layout', 'ciyashop' ),
			'subtitle'=> esc_html__('Select blog style.', 'ciyashop' ),
			'options' => array(
				'classic' => array(
					'alt' => esc_html__('Classic', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_layout/classic.png')
				),
				'grid' => array(
					'alt' => esc_html__('Grid', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_layout/grid.png')
				),
				'masonry' => array(
					'alt' => esc_html__('Masonry', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_layout/masonry.png')
				),
				'timeline' => array(
					'alt' => esc_html__('Timeline', 'ciyashop' ),
					'img' => get_parent_theme_file_uri('/images/options/blog_layout/timeline.png')
				),
			),
			'default' => 'classic'
		),
		array(
			'id'     => 'grid_size',
			'type'   => 'button_set',
			'title'  => esc_html__('Grid Column Size', 'ciyashop' ),
			'options'=> array(
				'2' => esc_html__('2 Column', 'ciyashop' ),
				'3' => esc_html__('3 Column', 'ciyashop' ),
			),
			'default' => '2',
			'required' => array(
				array('blog_sidebar', 'equals', 'full_width'),
				array('blog_layout', '=', 'grid')
			)
		),
		array(
			'id'      => 'grid_size_info',
			'type'    => 'info',
			'title'   => esc_html__('Grid Size!', 'ciyashop' ),
			'style'   => 'warning',
			'icon'    => 'el-icon-info-sign',
			'desc'    => esc_html__('If sidebar is active grid size will be set to 2 columns by default.', 'ciyashop' ),
			'required'=> array(
				array('blog_sidebar', '!=', 'full_width'),
				array('blog_layout', '=', 'grid')
			)
		),
		array(
			'id'     => 'masonry_size',
			'type'   => 'button_set',
			'title'  => esc_html__('Masonry Column Size', 'ciyashop' ),
			'options'=> array(
				'2' => esc_html__('2 Column', 'ciyashop' ),
				'3' => esc_html__('3 Column', 'ciyashop' ),
			),
			'default' => '2',
			'required' => array(
				array('blog_sidebar', 'equals', 'full_width'),
				array('blog_layout', '=', 'masonry')
			)
		),
		array(
			'id'      => 'masonry_size_info',
			'type'    => 'info',
			'title'   => esc_html__('Masonry Size!', 'ciyashop' ),
			'style'   => 'warning',
			'icon'    => 'el-icon-info-sign',
			'desc'    => esc_html__('If sidebar is active masonry size will be set to 2 columns by default.', 'ciyashop' ),
			'required'=> array(
				array('blog_sidebar', '!=', 'full_width'),
				array('blog_layout', '=', 'masonry')
			)
		),
		array(
			'id'      => 'blog_metas',
			'type'    => 'checkbox',
			'title'   => esc_html__('Display Meta Items', 'ciyashop' ),
			'subtitle'=> esc_html__('Select and reorder meta items to display', 'ciyashop' ),
			'options' => array(
				'author'    => esc_html__('Author', 'ciyashop' ),
				'categories'=> esc_html__('Categories', 'ciyashop' ),
				'tags'      => esc_html__('Tags', 'ciyashop' ),
				'comments'  => esc_html__('Comments', 'ciyashop' ),
			),
			'default' => array(
				'date'      => '1',
				'author'    => '1',
				'categories'=> '1',
				'tags'      => '1',
				'comments'  => '1',
			)
		),
	)
);