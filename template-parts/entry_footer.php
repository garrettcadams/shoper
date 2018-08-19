<footer class="entry-footer clearfix">
	<?php
	global $ciyashop_options;
	if( !is_single() ){
		?>
		<a href="<?php echo esc_url(get_the_permalink());?>" class="readmore"><?php esc_html_e('Read More', 'ciyashop' );?></a>
		<?php
	}
	$facebook_share   = ( isset($ciyashop_options['facebook_share']) )   ? $ciyashop_options['facebook_share']   : true;
	$twitter_share    = ( isset($ciyashop_options['twitter_share']) )    ? $ciyashop_options['twitter_share']    : true;
	$linkedin_share   = ( isset($ciyashop_options['linkedin_share']) )   ? $ciyashop_options['linkedin_share']   : true;
	$google_plus_share= ( isset($ciyashop_options['google_plus_share']) )? $ciyashop_options['google_plus_share']: true;
	$pinterest_share  = ( isset($ciyashop_options['pinterest_share']) )  ? $ciyashop_options['pinterest_share']  : true;
	
	if( !empty($ciyashop_options['facebook_share']) || !empty($ciyashop_options['twitter_share']) || !empty($ciyashop_options['linkedin_share']) || !empty($ciyashop_options['google_plus_share']) || !empty($ciyashop_options['pinterest_share']) ){
		?>
		<div class="entry-social share pull-right">
			<a href="javascript:void(0)" class="share-button">
				<i class="fa fa-share-alt"></i>
			</a>
			<ul class="single-share-box mk-box-to-trigger">
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
		<?php
	}
	?>
</footer><!-- .entry-footer -->