<?php
add_filter( 'pgscore_theme_sample_datas', 'ciyashop_extend_sample_datas' );
function ciyashop_extend_sample_datas( $sample_data ){
	return array_merge( $sample_data, ciyashop_theme_sample_datas() );
}

// Prepare Sample Data folder details
function ciyashop_theme_sample_datas(){
	$ciyashop_sample_datas = array();
	
	if ( WP_DEBUG || false === ( $ciyashop_sample_datas = get_transient( 'ciyashop_sample_datas' ) ) ) {
		
		$data_dir_path = get_parent_theme_file_path('/includes/sample_data/');
		
		if ( is_dir( $data_dir_path ) ) {
			$data_dirs = ciyashop_get_file_list( '*', $data_dir_path );
			if( !empty($data_dirs) && is_array($data_dirs) ){
				foreach($data_dirs as $data_dir){
					if( !is_dir($data_dir) ){
						continue;
					}
					
					$data_dir = trailingslashit( str_replace( '\\', '/', $data_dir ) );
					$data_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $data_dir ) );
					
					$path_parts = pathinfo($data_dir);
					extract($path_parts);
					
					$excluded_dirs = array(
						'nppBackup',
					);
					
					apply_filters('ciyashop_sample_data_excluded_dirs', $excluded_dirs);
					
					if( !in_array($basename, $excluded_dirs) ){
						
						$default_headers = array(
							'name'     => 'Name',
							'menus'    => 'Menus',
							'demo_url' => 'Demo URL',
							'home_page'=> 'Home Page',
							'blog_page'=> 'Blog Page',
							'message'  => 'Message',
							'preview_url'  => 'Preview URL',
						);
						
						if( file_exists($data_dir.'sample_data.ini') ){
							$sample_details = get_file_data( $data_dir.'sample_data.ini', $default_headers, 'sample_data' );
						}else{
							$sample_details = array();
						}
						
						// Name
						$sample_name = ( !empty($sample_details['name']) ) ? $sample_details['name'] : ucwords(str_replace('_', ' ', $basename));
						
						// Menus
						$sample_menu = array(); // Define default array
						
						if( !empty($sample_details['menus']) ){
							$menus_raw = array_filter(explode('|',$sample_details['menus']));
							
							$menus_array = array();
							if( !empty($menus_raw) && is_array($menus_raw) ){
								foreach( $menus_raw as $menus_raw_item ){
									
									$menus_raw_item = array_filter(explode(':',$menus_raw_item, 2));
									if( count($menus_raw_item) == 2 ){
										$menus_array[$menus_raw_item[0]] = $menus_raw_item[1];
									}
								}
							}
							if( !empty($menus_array) ){
								$sample_menu = $menus_array;
							}
						}
						
						$ciyashop_sample_datas[$basename] = array(
							'id'         => $basename,
							'name'       => $sample_name,
							'menus'      => $sample_menu,
							'demo_url'   => isset($sample_details['demo_url']) ? $sample_details['demo_url'] : '',
							'home_page'  => isset($sample_details['home_page']) ? $sample_details['home_page'] : '',
							'blog_page'  => isset($sample_details['blog_page']) ? $sample_details['blog_page'] : '',
							'message'    => isset($sample_details['message']) ? $sample_details['message'] : '',
							'preview_url'=> isset($sample_details['preview_url']) ? $sample_details['preview_url'] : '',
							'data_dir'   => $data_dir,
							'data_url'   => $data_url,
							'parent_dir' => $dirname,
						);
					}
				}
			}
		}
		
		$ciyashop_sample_datas_default_sorted = array();
		if( isset($ciyashop_sample_datas['default']) ){
			$ciyashop_sample_datas_default_sorted['default'] = $ciyashop_sample_datas['default'];
			unset($ciyashop_sample_datas['default']);
			$ciyashop_sample_datas = array_merge( $ciyashop_sample_datas_default_sorted, $ciyashop_sample_datas );
		}
		
		// Set Sample Data Transient
		set_transient( "ciyashop_sample_datas", $ciyashop_sample_datas, 3600 );
	}
	
	return $ciyashop_sample_datas;
}

add_filter( 'pgscore_sample_data_description', 'ciyashop_sample_data_descriptions' );
function ciyashop_sample_data_descriptions( $description ){
	
	$description .= '<p>' . wp_kses( __( 'You can import pre-defined sample data, as shown on our demo site, from here.', 'ciyashop' ),
		array(
			'br'    => array(),
			'strong'=> array(
				'style' => array(),
			),
		)
	) . '</p>';
	
	return $description;
}