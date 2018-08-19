<?php
add_filter( 'pgscore_reduxframework_data', 'ciyashop_redux_options_loader' );
function ciyashop_redux_options_loader( $reduxframework_data ){
	
	$options_path = realpath( get_parent_theme_file_path('includes/redux/options/') );
	if( file_exists($options_path) && is_dir($options_path) ){
		
		$option_files = scandir( $options_path );
		
		natsort($option_files); // Sort in natural order.
		$option_files = array_values($option_files);
		
		foreach ( $option_files as $option_file ) {
			
			if ( $option_file === '.' || $option_file === '..' || is_dir( $options_path . '/' . $option_file ) ) {
				continue;
			}
			
			// In case you wanted override your override, hah.
			$option_file_path = $options_path . '/' . $option_file;
			if ( $option_file_path ) {
				$option_file_path_info = pathinfo($option_file_path);
				if( $option_file_path_info['extension'] == 'php' ){
					if (strpos( strtolower($option_file), 'separator') !== false) {
						$reduxframework_data['sections'][] = array(
							'type' => 'divide',
						);
					}else{
						$option_data = include( $option_file_path );
						if( $option_data && is_array($option_data) ){
							$reduxframework_data['sections'][] = $option_data;
						}
					}
				}
			}
		}
	}
	
	return $reduxframework_data;
}

add_filter( 'pgscore_sample_data_requirements', 'ciyashop_sample_data_requirements' );
function ciyashop_sample_data_requirements( $requirements ){
	
	$new_requirements = array(
		'memory_limit'       => esc_html__( 'Memory Limit: 128 MB', 'ciyashop' ),
		'max_execution_time' => esc_html__( 'Max Execution Time: 180 Seconds', 'ciyashop' ),
		'max_input_time'     => esc_html__( 'Max Input Time: 600 Seconds', 'ciyashop' ),
		'upload_max_filesize'=> esc_html__( 'Maximum Upload Size: 32 MB', 'ciyashop' ),
		'post_max_size'      => esc_html__( 'Post Maximum Size: 128 MB', 'ciyashop' ),
	);
	
	return $new_requirements;
}