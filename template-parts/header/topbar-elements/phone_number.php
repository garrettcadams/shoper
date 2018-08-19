<?php
global $ciyashop_options;

$site_phone = ( isset($ciyashop_options['site_phone']) && !empty($ciyashop_options['site_phone']) ) ? $ciyashop_options['site_phone'] : false;
if( $site_phone ){
	?>
	<a href="<?php echo esc_url( 'tel:' . $site_phone );?>"><i class="fa fa-phone">&nbsp;</i><?php echo esc_html($site_phone);?></a>
	<?php
}