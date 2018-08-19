<?php
global $pgscore_shortcodes, $product;
extract($pgscore_shortcodes['pgscore_single_post']);
extract($atts);

$post_object = get_post( $post_id );
$post_title  = $post_object->post_title;
$post_date   = $post_object->post_date;
$author_id   = $post_object->post_author;
$excerpt     = $post_object->post_content;

// return if no post found
if( !$post_object ) return;
?>
<div class="latest-post-item single-post">
	<div class="latest-post-item-inner">
		<?php
		global $ciyashop_options;
		$latest_post_img_src = '';
		$post_thumb_alt = $post_title;
		if ( has_post_thumbnail($post_id)) {
			$latest_post_thumbnail_id = get_post_thumbnail_id($post_id);
			$latest_post_img_data = wp_get_attachment_image_src($latest_post_thumbnail_id, $thumb_size);
			
			if( isset($latest_post_img_data[0]) ){
				$latest_post_img_src = $latest_post_img_data[0];
			}
		}
		?>
		<div class="latest-post-image">
			<div class="post-date">
				<div class="post-date-inner">
					<?php
					/* translators: %1$s: Day of Month, %2$s: Month */
					printf( '%1$s<span>%2$s</span>',
						esc_attr( get_the_date('d', $post_object) ),
						esc_html( get_the_date('M', $post_object) )
					);
					?>	
				</div>
			</div>
			<?php 
			if( !empty($latest_post_img_src) ){
				?>
				<img class="img-fluid" src="<?php echo esc_url($latest_post_img_src);?>" alt="<?php esc_attr($post_title);?>">
				<?php
			}else{
				if( $thumb_size == 'full' ){
					$thumb_size_w = '150';
					$thumb_size_h = '150';
				}
				?>
				<img src="<?php echo ciyashop_dynamic_image( $thumb_size, $thumb_size_w, $thumb_size_h, '#BFBFBF' );?>" alt="<?php esc_attr_e('No image found', 'ciyashop' );?>">
				<?php
			}
			?>
		</div>
		<div class="latest-post-content">		
			<h3 class="blog-title">
				<a href="<?php echo esc_url(get_permalink($post_id));?>"><?php echo esc_html($post_title);?></a>
			</h3>
			<div class="latest-post-meta">
				<ul>
					<?php
					if (get_comments_number($post_id) && comments_open($post_id)){
						?>
						<li>
							<a href="<?php echo esc_url(get_comments_link($post_id ));?>">
								<i class="fa fa-comments-o"></i>
								<?php echo esc_html(wp_count_comments($post_id)->total_comments);?>
							</a>
						</li>
						<?php
					}
					?>
					<li><a href="<?php echo esc_url(get_author_posts_url($author_id));?>"><i class="fa fa fa-user"></i><?php echo esc_html(get_the_author_meta('display_name', $author_id ));?></a></li>
					<?php
					if( $show_categories ){
						?>
						<li>
							<?php 
							$categories_list = get_the_category_list( ', ', '', $post_id );
							if ( $categories_list && ciyashop_categorized_blog() ) {
								/* translators: %1$s: Categories List */
								printf( '<i class="fa fa-folder-open"></i> %1$s',
									$categories_list
								);
							}
							?>
						</li>
						<?php
					}
					?>
				</ul> 
			</div>
			<?php
			if( $show_excerpt ){
				$excerpt = pgscore_shortenString( $excerpt, $excerpt_length, true, true );
				?>
				<div class="latest-post-excerpt"><p><?php echo esc_html($excerpt);?></p></div>
				<?php
			}
			?>
			<div class="latest-post-entry-footer">
				<a href="<?php echo esc_url(get_permalink($post_id));?>"><?php esc_html_e('Read More...', 'ciyashop' );?></a>
				<?php
				if( $show_social_sharing ){
					?>
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
											<a href="#" class="<?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr($post_title);?>" data-url="<?php echo esc_url(get_permalink($post_id));?>" data-image="<?php echo esc_url(get_the_post_thumbnail_url());?>">
												<i class="<?php echo esc_attr($social_share_d['icon_class']);?>"></i>
											</a>
											<?php
										}else{
											?>
											<a href="#" class="<?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr($post_title);?>" data-url="<?php echo esc_url(get_permalink($post_id));?>">
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
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>