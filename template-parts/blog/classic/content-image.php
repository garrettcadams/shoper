<?php
global $ciyashop_options;

$ciyashop_blog_layout = ( isset($ciyashop_options['blog_layout']) ) ? $ciyashop_options['blog_layout'] : 'classic';
$post_class = '';

if ( !has_post_thumbnail() ) {
	$post_class = 'post-no-image';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	
	<?php
	// check if the post has a Post Thumbnail assigned to it.
	if ( has_post_thumbnail() ) {
		?>
		<div class="blog-entry-image clearfix blog ">
			<div class="blog-item">
				<img src="<?php the_post_thumbnail_url('ciyashop-blog-thumb');?>" class="img-fluid" alt="<?php echo esc_attr(get_the_title());?>">
			</div>
		</div>
		<?php
	}
	?>
	
	<?php if( $ciyashop_blog_layout == 'classic' || is_single() || is_archive()):?>
		<div class="entry-header-section">
	<?php endif;?>
	
	<?php
	get_template_part( 'template-parts/entry_meta-date' );
	if(!is_single()){
		?>
		<div class="entry-title">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );?>
		</div>
		<?php
	}
	get_template_part( 'template-parts/entry_meta' );
	?>
	
	<?php if( $ciyashop_blog_layout == 'classic' || is_single() || is_archive()):?>
		</div>
	<?php endif;?>
	
	<div class="entry-content">
		<?php
		if( is_single() ){
			the_content();
		}else{
			the_excerpt();
		}
		
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'ciyashop' ) . ':</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
	</div>

	<?php get_template_part( 'template-parts/entry_footer' );?>

</article><!-- #post -->