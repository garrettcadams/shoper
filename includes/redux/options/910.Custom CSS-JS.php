<?php
return array(
	'title' => esc_html__('Custom CSS/JS', 'ciyashop' ),
	'id'    => 'editor-ace',
	'icon'  => 'fa fa-code',
	'fields'=> array(
		array(
			'id'      => 'custom_css',
			'type'    => 'ace_editor',
			'title'   => esc_html__('Custom CSS', 'ciyashop' ),
			'mode'    => 'css',
			'theme'   => 'chrome',
			'subtitle'=> esc_html__('Add your CSS code here.', 'ciyashop' ),
		),
		array(
			'id'      => 'custom_js',
			'type'    => 'ace_editor',
			'title'   => esc_html__('Custom JS', 'ciyashop' ),
			'mode'    => 'javascript',
			'theme'   => 'chrome',
			'subtitle'=> esc_html__('Add your JS code here.', 'ciyashop' ),
			'default' => "jQuery(document).ready(function($){\n\n});"
		)
	)
);