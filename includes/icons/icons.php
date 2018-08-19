<?php
add_action( 'init', 'ciyashop_vc_fonticons_loaders' );
function ciyashop_vc_fonticons_loaders(){
	
	global $ciyashop_icons_data, $ciyashop_icons_value;
	
	$ciyashop_icons_data = ciyashop_icon_loaders();
	add_filter( 'pgscore_icon_types', 'ciyashop_vc_fonticons' ); // Insert icons in Icon Library dropdown
	add_filter( 'pgscore_vc_iconpicker', 'ciyashop_add_vc_iconpickers', 10, 2 ); // Insert iconpicker fields
	
	global $icons_array;
	
	// prepapre data for iconpicker fields
	if( !empty($ciyashop_icons_data) ){
		foreach( $ciyashop_icons_data as $icons_k => $icons_d ){
			
			// Reset font icons holder array, before loading new icons
			$icons_array = array();
			
			if ( count($icons_d) == 1 ){
				$icons_array = $icons_d[0]['icons'];
				$icon_type=$icons_d[0]['icon_type'];
				$ciyashop_icons_value[$icon_type]=$icons_d[0]['icons'][0];
			}else if ( count($icons_d) > 1 ){
				foreach( $icons_d as $temp_icon_d ){
					$icon_group = ( isset($temp_icon_d['icon_group']) && !empty($temp_icon_d['icon_group']) ) ? $temp_icon_d['icon_group'] : $temp_icon_d['icon_slug'];
					$icons_array[$icon_group] = $temp_icon_d['icons'];
					$icon_type=$temp_icon_d['icon_type'];
					$ciyashop_icons_value[$icon_type]=$temp_icon_d['icons'][0];
				}
			}
			
			add_filter( 'vc_iconpicker-type-'.$icons_k, 'ciyashop_load_vc_fonticons' );
			
			// Reset font icons holder array, after returning new icons
			$icons_array = array();
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'ciyashop_load_addtional_fonticon_css' );
	add_action( 'wp_enqueue_scripts', 'ciyashop_load_addtional_fonticon_css' );
}

function ciyashop_load_vc_fonticons( $icons ){
	global $icons_array;
	
	return $icons_array;
}

function ciyashop_load_addtional_fonticon_css(){
	global $ciyashop_icons_data;
	
	if( !empty($ciyashop_icons_data) ){
		foreach( $ciyashop_icons_data as $icons_k => $icons_v ){
			foreach( $icons_v as $icon_group_k => $icon_group_v ){
				wp_enqueue_style( $icon_group_v['css_handle'], $icon_group_v['icon_css'] );
			}
		}
	}
}

function ciyashop_vc_fonticons( $icon_type_data ){
	
	global $ciyashop_icons_data;
	
	if( !empty($ciyashop_icons_data) ){
		foreach( $ciyashop_icons_data as $icons_k => $icons_d ){
			$icon_type_data[$icons_k] = $icons_k;
		}
	}
	return $icon_type_data;
}

function ciyashop_add_vc_iconpickers( $fonts, $param_name_prefix ){
	global $ciyashop_icons_data,$ciyashop_icons_value;
	
	$ciyashop_fonts = array();
	
	if( !empty($ciyashop_icons_data) ){
		foreach( $ciyashop_icons_data as $icons_k => $icons_d ){
			
			foreach($ciyashop_icons_value[$icons_k] as $key=>$value){
				$icon_value=$key;
			}
			
			$ciyashop_fonts[$icons_k] = array(
				'slug'      => $icons_k,
				'name'      => $icons_k,
				'field-data'=> array(
					'type'            => 'iconpicker',
					'heading'         => esc_html__( 'Icon', 'ciyashop' ),
					'param_name'      => $param_name_prefix.$icons_k,
					'description'     => esc_html__( 'Select icon from library.', 'ciyashop' ),
					'value'			  => $icon_value,
					'settings'        => array(
						'emptyIcon'   => false,
						'type'        => $icons_k,
						'iconsPerPage'=> 400,
					),
				),
			);
		}
	}	
	$fonts = array_merge( $fonts, $ciyashop_fonts );	
	return $fonts;
}

function ciyashop_icon_loaders( $css_loader = false ){
	
	$icon_loader_data = $ciyashop_icons_data = $css_handles = array();
	
	if ( WP_DEBUG || false === ( $icon_loader_data = get_transient( 'ciyashop_icon_loader_data' ) ) ) {
		
		$icons_path = get_parent_theme_file_path('/includes/icons');
		$icons_url = get_parent_theme_file_uri('/includes/icons');
		
		if ( is_dir( $icons_path ) ) {
			
			// Check transient
			if ( WP_DEBUG || false === ( $icon_folders = get_transient( 'ciyashop_icons_path' ) ) ) {
				
				$icon_folders = scandir($icons_path);
				
				// Set transient
				set_transient( 'ciyashop_icons_path', $icon_folders, 12 * HOUR_IN_SECONDS );
			}
			
			if( !empty($icon_folders) ){
				foreach ( $icon_folders as $icon_folder ) {
					if( $icon_folder == '.' || $icon_folder == '..' || $icon_folder == 'nppBackup' ) continue;
					
					$icon_path = trailingslashit($icons_path).$icon_folder;
					$icon_file = trailingslashit($icon_path).$icon_folder.'.php';
					$icon_css  = trailingslashit($icons_url).$icon_folder.'/'.$icon_folder.'.css';
					
					if( is_dir($icon_path) && file_exists($icon_file) ){
						$icon_details = include($icon_file);
						if( is_array($icon_details) && ( isset($icon_details['icon_type']) && !empty($icon_details['icon_type']) ) && ( isset($icon_details['icons']) && !empty($icon_details['icons']) ) ){
							
							if( !isset($icon_details['css_handle']) || empty($icon_details['css_handle']) ){
								$icon_details['css_handle'] = $icon_details['icon_type'].'-'.$icon_folder;
							}
						
							$icon_temp_data = array_merge( $icon_details, array(
								'icon_slug' => $icon_folder,
								'icon_path' => $icon_path,
								'icon_file' => $icon_file,
								'icon_css' => $icon_css,
							));
							
							if( $css_loader ){
								// 
								$icons_set = $icon_details['icons'];
								foreach( $icons_set as $icon_set ){
									foreach( $icon_set as $icon_set_k => $icon_set_v ){
										if( !isset($css_handles[$icon_set_k]) ){
											$css_handles[$icon_set_k] = $icon_details['css_handle'];
										}
									}
								}
							}
							
							$ciyashop_icons_data[$icon_details['icon_type']][] = $icon_temp_data;
						}
					}
				}
			}
		}
		
		$icon_loader_data['css_handles'] = $css_handles;
		$icon_loader_data['icons_data'] = $ciyashop_icons_data;
		
		// Set transient
		set_transient( 'ciyashop_icon_loader_data', $icon_loader_data, 12 * HOUR_IN_SECONDS );
	}
	
	if( $css_loader ){
		return $icon_loader_data['css_handles'];
	}else{
		return $icon_loader_data['icons_data'];
	}
}