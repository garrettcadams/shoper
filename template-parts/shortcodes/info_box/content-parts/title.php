<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_info_box']);
extract($atts);

if( isset($title) && !empty($title) ){
	if( isset($title_color) && !empty($title_color) ){
		$style = "color:$title_color;";
	}
	?>
	<<?php echo esc_attr($title_el);?> class="pgscore_info_box-title" style="<?php echo esc_attr($style);?>">
		<?php echo esc_html($title);?>
	</<?php echo esc_attr($title_el);?>>
	<?php
}