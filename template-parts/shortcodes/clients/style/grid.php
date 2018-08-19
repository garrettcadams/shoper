<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_clients']);
extract($atts);
?>
<div class="our-clients boxed-list box-<?php echo esc_attr($grid_elements);?>">
	<ul class="list-inline clearfix">
		<?php
		foreach( $slides_data as $slide ){
			$link_attr = '';
			if( !empty($slide['image_link']) ){
				$link_attr = pgscore_vc_link_attr( $slide['image_link'] );
			}
			if( !empty($slide['slide_image']) ){
				$img_src = wp_get_attachment_image_src($slide['slide_image'], $thumb_size);
			}
			
			if( $img_src && isset($img_src[0]) ){
				?>
				<li>
					<?php
					if( !empty($link_attr) ){
						echo wp_kses( '<a '.$link_attr.'>', ciyashop_allowed_html( array('a') ));
					}
					?>
						<img class="img-fluid center-block" src="<?php echo esc_url($img_src[0]);?>" width="<?php echo esc_attr($img_src[1]);?>" height="<?php echo esc_attr($img_src[2]);?>" alt="<?php echo ( !empty($slide['title']) ) ? esc_attr($slide['title']) : '';?>">
						<?php
					if( !empty($link_attr) ){
						?>
						</a>
						<?php
					}
					?>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>