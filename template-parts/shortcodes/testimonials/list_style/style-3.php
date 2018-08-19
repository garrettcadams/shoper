<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_testimonials']);
extract($atts);

$arrow_id = 'testimonials-arrow-'.$index;

$owl_options_args = array(
	'items'             => 3,
	'loop'              => true,
	'margin' 			=> 20,
	'autoplay'          => true,
	'autoplayTimeout'   => (int)$carousel_speed,
	'autoplayHoverPause'=> true,
	'dots'              => false,
	'nav'               => true,
	'smartSpeed'        => 1000,
	'navText'           => array(
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>",
	),
	'responsive' => array(
		0 => array(
			'items' => 1,
		),
		600 => array(
			'items' => 2,
		),
		1000 => array(
			'items' => 3,
		),
	),
	'navContainer' => "#{$arrow_id}",
);

$owl_options = '';
if( is_array($owl_options_args) && !empty($owl_options_args) ){
	$owl_options = json_encode($owl_options_args);
}
?>
<div class="testimonials owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
	<?php
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		
		$testimonials_img_src = '';
		
		$author               = '';
		$content              = '';
		$designation          = '';
		
		$author     = get_post_meta( get_the_ID(), 'author', true);
		$content    = get_post_meta( get_the_ID(), 'content', true);
		$designation = get_post_meta( get_the_ID(), 'designation', true);
		
		$testimonials_img_alt = ( $author ) ? $author : esc_html__( 'Author', 'ciyashop' );
		
		if ( has_post_thumbnail() ) {
			$testimonials_thumbnail_id = get_post_thumbnail_id();
			$testimonials_img_data = wp_get_attachment_image_src($testimonials_thumbnail_id, 'thumbnail');
			
			if( isset($testimonials_img_data[0]) ){
				$testimonials_img_src = $testimonials_img_data[0];
			}
		}
		if( !empty($content) ){
			?>
			<div class="item">
				<div class="testimonial-item">
					<div class="testimonial-content"><?php echo wp_kses($content, array( 'p' => true ));?></div>
					<div class="testimonial-meta">
						<div class="client-image">
							<?php
							if( empty($testimonials_img_src) ){
								$testimonials_img_src = get_parent_theme_file_uri('/images/placeholder/testimonials/150x150.png');
							}
							?>
							<div>
								<div class="author-photo">
									<img class="img-responsive rounded-circle" src="<?php echo esc_url($testimonials_img_src);?>" alt="<?php echo esc_attr($testimonials_img_alt);?>" />
								</div>
							</div>
						</div>
						<div class="client-info">
							<?php
							if($author){
								?>
								<h5 class="author-name">- <?php echo esc_html($author); ?></h5>
								<?php
							}
							if($designation){
								?>
								<span><?php echo esc_html($designation);?></span>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
<div id="<?php echo esc_attr($arrow_id);?>" class="testimonials-carousel-nav"></div>