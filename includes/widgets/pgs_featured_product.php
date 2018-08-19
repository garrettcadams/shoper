<?php
/**
 * Adds PGS Feature widget.
 * @package CiyaShop
 */
class PGS_Featured_Products_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'PGS_Featured_Products_Widget', // Base ID
			esc_html__( 'PGS Featured Products', 'ciyashop' ), // Name
			array( 'description' => esc_html__( 'A Feature Products Sidebar Widget', 'ciyashop' ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$allowed_tags = wp_kses_allowed_html('post');
		
		$posts_per_page = isset( $instance['num_of_item'] )                         ? $instance['num_of_item'] : 8;
		$title          = isset( $instance['title'] ) && !empty($instance['title']) ? $instance['title']       : esc_html__( 'Featured Products', 'ciyashop' );
		
		$title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		// Get Featured IDs
		$featured_product_ids = apply_filters( 'pgs_featured_products_widget_ids', wc_get_featured_product_ids() );
		
		// Return if no featured product found.
		if ( sizeof( $featured_product_ids ) == 0 ) return;
		
		// Query args
		$query_args = apply_filters( 'pgs_featured_products_widget_args', array(
			'post_type'          => 'product',
			'post_status'        => 'publish',
			'ignore_sticky_posts'=> 1,
			'no_found_rows'      => 1,
			'posts_per_page'     => $posts_per_page,
			'orderby'            => 'rand',
			'order'              => 'desc',
			'post__in'           => $featured_product_ids,
		) );

		$products = new WP_Query( $query_args );
		
		if ( $products->have_posts() ) {
			
			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			
			$owl_options_args = array(
					'items'             => 1,
					'autoplay'          => true,
					'loop'          	=> true,
					'autoplayTimeout'   => 3000,
					'autoplayHoverPause'=> true,
					'dots'              => false,
					'nav'               => true,
					'smartSpeed'        => 1000,
					'navText'           => array(
						"<i class='fa fa-angle-left fa-2x'></i>",
						"<i class='fa fa-angle-right fa-2x'></i>"
					),
				'responsive'=> array(
					0    => array(
						'items'=> 1,
					),
					600  => array(
						'items'=> 1,
					),
					1000 => array(
						'items' => 1,
					)
				)
			);
			$owl_options = '';
			if( is_array($owl_options_args) && !empty($owl_options_args) ){
				$owl_options = json_encode($owl_options_args);
			}
			?>
			<div class="pgs-featured-product">
				<div class="all-blocks">
					<div class="title-block"><?php
						echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						?>
					</div>
					<div class="block-content">
						<div class="owl-carousel carousel owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
							<?php
							$product_sr = 0;
							while ( $products->have_posts() ) {
								$products->the_post();
								
								global $product, $post;
								
								$product_sr++;
								
								if( $product_sr % 4 == 1 ){
									?>
									<div class="item">
									<?php
								}
								?>
								<div class="sellers-row clearfix">
									<div class="item-img">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
											<?php if( has_post_thumbnail() ){
												echo get_the_post_thumbnail( $product->get_id(), 'shop_thumbnail', array('class'=>"img-fluid") );
											}else{
												?>
												<img class="img-fluid" src="<?php echo esc_url( get_parent_theme_file_uri('/assets/img/placeholder/shop_thumbnail.png') );?>" alt="<?php esc_attr_e( 'No thumb', 'ciyashop' );?>"/>
												<?php
											}
											?>
										</a>
									</div>
									<div class="item-detail">
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>" class="featured-product-title"><?php the_title(); ?></a></h4>
										<p><?php echo wp_kses( $product->get_price_html(), array(
											'span' => array_merge( $allowed_tags['span'], array( 'data-product-id' => true ) ),
											'del' => $allowed_tags['del'],
											'ins' => $allowed_tags['ins'],
										) );?></p>
										<?php
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
										if ( $rating_count > 0 ) {
											?>
											<div class="woocommerce-product-rating">
												<div class="star-rating">
													<span style="width:<?php echo esc_attr( ( $average / 5 ) * 100 ); ?>%">
														<?php
														/* translators: 1: average rating 2: max rating (i.e. 5) */
														printf(
															esc_html__( '%1$s out of %2$s', 'ciyashop' ),
															'<strong class="rating">' . esc_html( $average ) . '</strong>',
															'<span>5</span>'
														);
														
														/* translators: %s: rating count */
														printf(
															esc_html( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'ciyashop' ) ),
															'<span class="rating">' . esc_html( $rating_count ) . '</span>'
														);
														?>
													</span>
												</div>
											</div>
											<?php
											if ( comments_open() ) {
												?>
												<a href="<?php the_permalink(); ?>#reviews" class="woocommerce-review-link" rel="nofollow">
													<?php
													printf(
														esc_html( _n( '%s review', '%s reviews', $review_count, 'ciyashop' ) ),
														'<span class="count">' . esc_html( $review_count ) . '</span>'
													);
													?>
												</a>
												<?php
											}
										}
										?>
									</div>
								</div>
								<?php
								if( $product_sr % 4 == 0 ){
									?></div><?php
								}
							}
							
							if( $product_sr % 4 != 0 ){
								?></div><?php
							}
							
							/* Restore original Post Data */
							wp_reset_postdata();
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		
		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title       = ! empty( $instance['title'] )       ? $instance['title']       : esc_html__( 'Featured Products', 'ciyashop' );
		$num_of_item = ! empty( $instance['num_of_item'] ) ? $instance['num_of_item'] : 8;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'ciyashop' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'num_of_item' )); ?>"><?php esc_html_e('Number of item:', 'ciyashop' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'num_of_item' ));?>"  type="number" name="<?php echo esc_attr($this->get_field_name( 'num_of_item' ));?>" value="<?php echo esc_attr($num_of_item);?>"/>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_of_item'] = strip_tags( $new_instance['num_of_item'] );
		
		return $instance;
	}
}