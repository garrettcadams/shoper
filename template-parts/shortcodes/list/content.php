<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_list']);
extract($atts);

$icon_html   = $pgscore_shortcodes['pgscore_list']['icon_html'];
$list_items  = $pgscore_shortcodes['pgscore_list']['list_items'];
$list_classes= $pgscore_shortcodes['pgscore_list']['list_classes'];
?>
<ul class="<?php echo esc_attr($list_classes);?>">
	<?php
	foreach( $list_items as $list_item ){
		if( isset($list_item['content']) && !empty($list_item['content']) ){
			
			$link_attr = '';
			
			if( !empty($list_item['content_link']) ){
				$link_attr = pgscore_vc_link_attr( $list_item['content_link'] );
			}
			?>
			<li>
				<?php echo ( !empty($add_icon) && $add_icon == 'true' && !empty($icon_html) ) ? wp_kses( $icon_html, ciyashop_allowed_html( array('i','span') ) ).' ' : '';?>
				<span class="pgscore-list-info">
				<?php
				if( $link_attr != '' ){
					echo wp_kses( '<a '.$link_attr.'>', ciyashop_allowed_html('a') );
				}
				
				echo esc_html($list_item['content']);
				
				if( $link_attr != '' ){
					?>
					</a>
					<?php
				}
				?>
				</span>
			</li>
			<?php
		}
	}
	?>
</ul>