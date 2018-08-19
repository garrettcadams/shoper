<div class="team-social-icon pgscore-social-icons pgssi-shape-Round pgssi-effect-color-hover pgssi-size-small">
	<?php
	if( function_exists('have_rows') ){
		if( have_rows('social_profiles') ){
			?>
			<ul>
				<?php
				while ( have_rows('social_profiles') ) {
					the_row();
					$social_title = get_sub_field('social_title');
					$social_icon  = get_sub_field('social_icon');
					$social_url   = get_sub_field('social_url');
					if( $social_title && $social_icon && $social_url ){
						$icon_classes = array();
						$icon_classes[] = 'pgssi-item';
						$icon_classes[] = 'pgssi-color-'.sanitize_title($social_title);
						$icon_classes = ciyashop_class_builder($icon_classes);
						?>
						<li class="<?php echo esc_attr($icon_classes);?>">
							<a href="<?php echo esc_url($social_url);?>" title="<?php echo esc_attr( ($social_title) ? $social_title : '');?>">
								<i class="fa <?php echo esc_attr($social_icon['value']);?>"></i>
							</a>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
		}
	}
	?>
</div>