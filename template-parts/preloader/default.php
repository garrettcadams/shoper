<?php
global $ciyashop_options;

$preloader             = ( isset( $ciyashop_options['preloader']) )            ? $ciyashop_options['preloader']             : 0;
$preloader_source      = ( isset($ciyashop_options['preloader_source']) )      ? $ciyashop_options['preloader_source']      : 'default';
$preloader_image       = ( isset($ciyashop_options['preloader_image']) )       ? $ciyashop_options['preloader_image']       : '';
$predefine_loader_image= ( isset($ciyashop_options['predefine_loader_image']) )? $ciyashop_options['predefine_loader_image']: '';

if( $preloader ){
	if( $preloader_source == 'custom' && !empty($preloader_image['url']) ){
		?>
		<div id="preloader" class="preloader-type-custom">
			<div id="loading-center">
				<img src="<?php echo esc_url($preloader_image['url']);?>" alt="<?php esc_attr_e( 'Loading...', 'ciyashop' );?>">
			</div>
		</div>
		<?php
	}elseif($preloader_source=='predefine_loader' && $predefine_loader_image!=''){
		
		$preloader_image = get_parent_theme_file_path('/images/loader/'.$predefine_loader_image.'.gif');
		if(file_exists($preloader_image)){
			$preloader_image= get_parent_theme_file_uri('/images/loader/'.$predefine_loader_image.'.gif');
		}else {
			$preloader_image= get_parent_theme_file_uri('/images/loader/'.$predefine_loader_image.'.svg');
		}
		?>
		<div id="preloader" class="preloader-type-custom">
			<div id="loading-center">
				<img src="<?php echo esc_url($preloader_image);?>" alt="<?php esc_attr_e( 'Loading...', 'ciyashop' );?>">
			</div>
		</div>
		<?php
	}else{
		$preloader_image= get_parent_theme_file_uri('/images/loader/loader19.svg');
		?>
		<div id="preloader" class="preloader-type-default">
			<div class="clear-loading loading-effect">
				<img src="<?php echo esc_url($preloader_image);?>" alt="<?php esc_attr_e( 'Loading...', 'ciyashop' );?>">
			</div>
		</div>
		<?php
	}
}