<?php
global $ciyashop_options, $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_recent_posts']);
extract($pgscore_shortcodes['pgscore_recent_posts']['atts']);
?>
<div class="latest-post-item">
	<div class="latest-post-item-inner">
		<?php
		$ciyashop_latest_post_thumbnail = 'ciyashop-latest-post-thumbnail2';
		$default_thumb = array(
			get_parent_theme_file_uri('/images/placeholder/recent_post/500x375.jpg'),
			500,
			375
		);
		
		if( $style == 'style-1'){
			$ciyashop_latest_post_thumbnail = 'ciyashop-latest-post-thumbnail';
			$default_thumb = array(
				get_parent_theme_file_uri('/images/placeholder/recent_post/330x460.jpg'),
				330,
				460,
			);
		}
		?>
		<div class="latest-post-image">
			<?php 
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( $ciyashop_latest_post_thumbnail );
			}else{
				?>
				<img src="<?php echo esc_url($default_thumb[0]);?>" width="<?php echo esc_attr($default_thumb[1]);?>" height="<?php echo esc_attr($default_thumb[2]);?>" alt="<?php echo esc_attr(get_the_title());?>">
				<?php
			}
			?>
		</div>
		
		<div class="latest-post-content">
			<div class="post-date">
				<div class="post-date-inner">
					<?php
					/* translators: %1$s: Day of Month, %2$s: Month */
					printf( '%1$s<span>%2$s</span>',
						esc_attr( get_the_date('d') ),
						esc_html( get_the_date('M') )
					);
					?>	
				</div>
			</div>
			<?php
			if( $style != 'style-1' ){
				?>
				<h3 class="blog-title">
					<a href="<?php echo esc_url(get_permalink());?>"><?php the_title();?></a>
				</h3>
				<?php
			}
			?>
			<div class="latest-post-meta">
				<ul>
					<?php
					if (get_comments_number() && comments_open() ){
						?>
						<li><?php comments_popup_link('<i class="fa fa-comments-o"></i> 0','<i class="fa fa-comments-o"></i> 1','<i class="fa fa-comments-o"></i>' .wp_count_comments(get_the_ID())->total_comments,'');?></li>
						<?php
					}
					?>
					<li><a href="<?php echo esc_url(get_permalink());?>"><i class="fa fa fa-user"></i><?php echo esc_html( get_the_author() );?></a></li>
					<?php
					$categories_list = get_the_category_list( ', ' );
					if ( $categories_list && ciyashop_categorized_blog() ) {
						?>
						<li>
							<?php
							/* translators: %1$s: Categories List */
							printf( '<i class="fa fa-folder-open"></i> %1$s',
								$categories_list
							);
							?>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
			if( $style == 'style-1' ){
				?>
				<h3 class="blog-title">
					<a href="<?php echo esc_url(get_permalink());?>"><?php the_title();?></a>
				</h3>
				<?php
			}
			
			$excerpt = get_the_excerpt();
			$excerpt = pgscore_shortenString( $excerpt, 80, true, true );
			?>
			<div class="latest-post-excerpt"><p><?php echo esc_html($excerpt)?></p></div>
			<div class="latest-post-entry-footer">
				<a href="<?php echo esc_url(get_permalink());?>"><?php echo esc_html__('Read More...', 'ciyashop' );?></a>
				<div class="latest-post-social-share">
					<ul>
						<?php
						$social_shares = array(
							'facebook' => array(
								'class'     => 'facebook',
								'icon_class'=> 'fa fa-facebook',
							),
							'twitter' => array(
								'class'     => 'twitter',
								'icon_class'=> 'fa fa-twitter',
							),
							'linkedin' => array(
								'class'     => 'linkedin',
								'icon_class'=> 'fa fa-linkedin',
							),
							'google_plus' => array(
								'class'     => 'googleplus',
								'icon_class'=> 'fa fa-google-plus',
							),
							'pinterest' => array(
								'class'     => 'pinterest',
								'icon_class'=> 'fa fa-pinterest',
							),
						);
						
						foreach( $social_shares as $social_share_k => $social_share_d ){
							$social_share_stat = isset($ciyashop_options[$social_share_k.'_share']) ? $ciyashop_options[$social_share_k.'_share'] : 1;
							if( $social_share_stat ){
								?>
								<li>
									<?php
									if( $social_share_k == 'pinterest' ){
										?>
										<a href="#" class="<?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr(get_the_title());?>" data-url="<?php echo esc_url(get_permalink());?>" data-image="<?php echo esc_url(get_the_post_thumbnail_url());?>">
											<i class="<?php echo esc_attr($social_share_d['icon_class']);?>"></i>
										</a>
										<?php
									}else{
										?>
										<a href="#" class="<?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr(get_the_title());?>" data-url="<?php echo esc_url(get_permalink());?>">
											<i class="<?php echo esc_attr($social_share_d['icon_class']);?>"></i>
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
			</div>
		</div>
	</div>
</div>