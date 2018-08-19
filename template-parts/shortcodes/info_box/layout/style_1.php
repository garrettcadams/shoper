<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_info_box']);
extract($atts);
?>
<div class="pgscore_info_box-inner clearfix">
	<?php
	if( $icon_html ){
		?>
		<div class="pgscore_info_box-icon">
			<div class="pgscore_info_box-icon-wrap">
				<?php pgscore_get_shortcode_templates('info_box/content-parts/icon' );?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="pgscore_info_box-content">
		<div class="pgscore_info_box-content-wrap">
			<div class="pgscore_info_box-content-inner">
				<?php
				pgscore_get_shortcode_templates('info_box/content-parts/title' );
				pgscore_get_shortcode_templates('info_box/content-parts/description' );
				?>
			</div>
		</div>
	</div>
</div>