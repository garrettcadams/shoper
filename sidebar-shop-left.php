<?php
if( !is_product() ){
	global $ciyashop_options;
	
	$sidebar_layout = ciyashop_shop_page_sidebar();
	$sidebar_class  = ciyashop_shop_sidebar_class('sidebar');
	$sidebar_id     = 'sidebar-shop';
	
	$show_sidebar_on_mobile = ciyashop_show_sidebar_on_mobile();
	$mobile_sidebar_position = ciyashop_mobile_sidebar_position();
	
	if(
		( wp_is_mobile()  && is_active_sidebar($sidebar_id) && $sidebar_layout != 'no' && $mobile_sidebar_position == 'top' && $show_sidebar_on_mobile == '1' )
		||
		( !wp_is_mobile() && is_active_sidebar($sidebar_id) && $sidebar_layout != 'no' && $mobile_sidebar_position == 'top' )
	){
		?>
		<aside id="<?php echo esc_attr($sidebar_layout);?>" class="<?php echo esc_attr($sidebar_class);?>">
			<?php dynamic_sidebar($sidebar_id); ?>
		</aside>
		<?php
	}
}