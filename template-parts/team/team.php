<?php
do_action( 'team_init' );

$team_page_query_base = array(
	'post_type'      => 'teams',
	'posts_per_page' => -1
);

$the_query = new WP_Query( $team_page_query_base );

$count = 0;
$team_count = 0;
$total_count = $the_query->post_count;

if ( $the_query -> have_posts() ) :
	?>
	<div class="container">
		<?php
		while ( $the_query -> have_posts() ) : $the_query -> the_post();
			
			$count++;
			$team_count++;
			
			if($team_count == 1 ){
				?>
				<div class="row">
				<?php
			}
			?>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<?php
				if( function_exists('get_field') ){
					$designation      = get_field('designation');
					$short_description= get_field('short_description');
				}
				?>
				<div class="team shadow">
					<div class="team-images">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'ciyashop-team-member-thumbnail-v', array(
								'class' => "img-fluid",
							) );
						}else{
							$member_img = array();
							$member_img[] = get_parent_theme_file_uri('/images/placeholder/team_members/259x482.png');
							$member_img[] = 259;
							$member_img[] = 482;
							?>
							<img class="img-fluid" src="<?php echo esc_url($member_img[0]);?>" width="<?php echo esc_attr($member_img[1]);?>" height="<?php echo esc_attr($member_img[2]);?>" alt="<?php echo esc_attr(get_the_title());?>">
							<?php
						}
						?>
					</div>
					<div class="team-info">
						<div class="team-description">
							<h4><?php echo esc_html(get_the_title());?></h4>
							<?php
							if( isset($designation) && $designation ){
								?>
								<span><?php echo esc_html($designation);?></span>
								<?php
							}
							if( isset($short_description) && $short_description ){
								?>
								<p><?php echo esc_html($short_description);?></p>
								<?php
							}
							?>
						</div>
						<div class="team-social-icon pgssi-style-border pgscore-social-icons pgssi-shape-Round pgssi-effect-color-hover pgssi-size-small">
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
												
												$social_title = ($social_title) ? $social_title : '';
												?>
												<li class="<?php echo esc_attr($icon_classes);?>">
													<a href="<?php echo esc_url($social_url);?>" title="<?php echo esc_attr($social_title);?>">
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
					</div>
				</div>
			</div>
			<?php
			if( $team_count == 4 || $total_count == $count){
				?>
				</div>
				<?php
				$team_count = 0;
			}
			
		endwhile;
		?>
	</div>
	<?php
endif;