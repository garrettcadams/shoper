<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CiyaShop
 */

$post_class = '';
 if ( !has_post_thumbnail() ) {
	$post_class = 'post-no-image';
}
 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	
    <div class="blog-image">
    	<?php the_post_thumbnail('full',array('class'=>'img-fluid'));?>
    </div>

    <header class="entry-header">
		<div class="entry-header-section">
		<?php
		get_template_part( 'template-parts/entry_meta-date' );
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : 
		get_template_part( 'template-parts/entry_meta' );
		endif; ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if(is_single()){
			the_content( sprintf(
			/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ciyashop' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		} else {
			the_excerpt();
		}

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'ciyashop' ) . ':</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );

		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
        if(is_single()){
			ciyashop_entry_footer();
        }else{
            ?>
            <a href="<?php echo esc_url(get_the_permalink());?>" class="readmore"><?php esc_html_e('Read More', 'ciyashop' );?></a>
            <div class="entry-social share pull-right">
				<a href="javascript:void(0)" class="share-button">
					<i class="fa fa-share-alt"></i>
				</a>
                <ul class="single-share-box mk-box-to-trigger">
                    <?php
                    global $ciyashop_options;
					
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
									<a href="#" class="<?php echo esc_attr($social_share_d['class']);?>-share" data-title="<?php echo esc_attr(get_the_title());?>" data-url="<?php echo esc_url(get_permalink());?>" data-image="<?php echo esc_url(ciyashop_logo_url());?>">
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
        }?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->