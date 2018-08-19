<?php
global $ciyashop_options;
if( isset($ciyashop_options['site_phone']) && !empty($ciyashop_options['site_phone']) ){
	?>
	<div class="phone-number">
		<span><i class="fa fa-phone"></i> <?php echo esc_html($ciyashop_options['site_phone']);?></span>
	</div>
	<?php
}