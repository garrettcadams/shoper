<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if( is_object($prev_post) || is_object($next_post) ){
	?>
	<div class="product-navigation">
		<div class="product-navigation-wrapper">
			<?php
			if( !empty($prev_post) ) {
				global $product;
				$product = wc_get_product( $prev_post );
				$prev_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'shop_thumbnail' );
				?>
				<div class="product-nav-btn product-nav-btn-prev">
					<a href="<?php echo esc_url(get_the_permalink($prev_post->ID));?>" >
						<div class="product-nav-btn-wrapper <?php echo ( has_post_thumbnail() ? 'product-nav-with-thumb' : 'product-nav-without-thumb' );?>">
							<div class="product-nav-item product-nav-arrow"><i class="fa fa-angle-left"></i></div>
							<div class="product-nav-btn-inner-wrapper">
								<div class="product-nav-item product-nav-content">
									<div class="product-nav-content-title">
										<h2 class="product_nav_title"><?php echo esc_html(get_the_title( $prev_post->ID ));?></h2>
									</div>
									<div class="product-nav-content-rating">
										<?php
										$rating_count = $product->get_rating_count();
										if ( $rating_count > 0 ){
											wc_get_template( 'loop/rating.php' );
										}else{
											?>
											<div class="star-rating"><span class="star-rating-inner"><?php esc_html_e( 'Rated 0 out of 5', 'ciyashop' );?></span></div>
											<?php
										}
										?>
									</div>
									<div class="product-nav-content-price">
										<?php wc_get_template( 'loop/price.php' );?>
									</div>
								</div>
								<?php
								if( has_post_thumbnail() ){
									?>
									<div class="product-nav-item product-nav-image">
										<img class="product_img" src="<?php echo esc_url($prev_post_image[0]);?>" alt="<?php echo esc_attr(get_the_title($prev_post->ID));?>" width="70">
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</a>
				</div>
				<?php
			}
			if( !empty($next_post) ) {
				global $product;
				$product = wc_get_product( $next_post );
				$next_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'shop_thumbnail' );
				?>
				<div class="product-nav-btn product-nav-btn-next">
					<a href="<?php echo esc_url(get_the_permalink($next_post->ID));?>" >
						<div class="product-nav-btn-wrapper <?php echo ( has_post_thumbnail() ? 'product-nav-with-thumb' : 'product-nav-without-thumb' );?>">
							<div class="product-nav-item product-nav-arrow"><i class="fa fa-angle-right"></i></div>
							<div class="product-nav-btn-inner-wrapper">
								<?php
								if( has_post_thumbnail() ){
									?>
									<div class="product-nav-item product-nav-image">
										<img class="product_img" src="<?php echo esc_url($next_post_image[0]);?>" alt="<?php echo esc_attr(get_the_title($next_post->ID));?>" width="70">
									</div>
									<?php
								}
								?>
								<div class="product-nav-item product-nav-content">
									<div class="product-nav-content-title">
										<h2 class="product_nav_title"><?php echo esc_html(get_the_title( $next_post->ID ));?></h2>
									</div>
									<div class="product-nav-content-rating">
										<?php
										$rating_count = $product->get_rating_count();
										if ( $rating_count > 0 ){
											wc_get_template( 'loop/rating.php' );
										}else{
											?>
											<div class="star-rating"><span class="star-rating-inner"><?php esc_html_e( 'Rated 0 out of 5', 'ciyashop' );?></span></div>
											<?php
										}
										?>
									</div>
									<div class="product-nav-content-price">
										<?php wc_get_template( 'loop/price.php' );?>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}