<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_recent_posts']);
extract($atts);
?>
<div class="latest-post-link">
	<?php
	if( !empty($link_title) && !empty($link_attr) ){
		echo wp_kses( '<a '.$link_attr.'>'.esc_html($link_title).'</a>', ciyashop_allowed_html('a') );
	}
	?>
</div>