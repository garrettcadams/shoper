<?php 
global $ciyashop_options;

$post_class = '';
if ( !has_post_thumbnail() ) {
	$post_class = 'post-no-image';
}

$blog_layout = 'classic';
if( isset($ciyashop_options['blog_layout']) && !empty( $ciyashop_options['blog_layout'] ) ){
	$blog_layout = $ciyashop_options['blog_layout'];
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<?php if ( has_post_thumbnail() ) {
		?>
		<div class="post-entry-image clearfix">
			<img src="<?php the_post_thumbnail_url('ciyashop-blog-thumb');?>" class="img-fluid" alt="<?php echo esc_attr(get_the_title());?>">
		</div>
	<?php }	?>
	
	<?php
	if( $blog_layout == 'classic'|| is_archive()){
		?>
		<div class="entry-header-section">
		<?php
	}
	?>
	
	<?php get_template_part( 'template-parts/entry_meta-date' ); ?>
	
	<?php if(!is_single()):?>
	<div class="entry-title">
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );?>
	</div>
	<?php endif;?>
	
	<?php get_template_part( 'template-parts/entry_meta' );?>
	
	<?php 
	if( $blog_layout == 'classic' || is_archive()){
		?>
		</div>
		<?php
	}
	?>
	
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
	
</article><!-- #post-## -->