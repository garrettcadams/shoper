<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_product_slider']);
extract($atts);

$owl_options_args = array(
	'items'             => ( isset($slider_items) && !empty($slider_items) ) ? $slider_items : 6,
	'loop'              => true,
	'margin'            => 15,
	'autoplay'          => true,
	'autoplayTimeout'   => 3000,
	'autoplayHoverPause'=> true,
	'dots'              => false,
	'nav'               => true,
	'smartSpeed'        => 1000,
	'navText'           => array(
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>"
	),
);

// Responsice Items
$owl_options_args['responsive'][1200]['items'] = ( !empty($slider_items) )       ? $slider_items       : 6;
$owl_options_args['responsive'][992]['items']  = ( !empty($slides_per_view_md) ) ? $slides_per_view_md : 4;
$owl_options_args['responsive'][768]['items']  = ( !empty($slides_per_view_sm) ) ? $slides_per_view_sm : 3;
$owl_options_args['responsive'][480]['items']  = ( !empty($slides_per_view_xs) ) ? $slides_per_view_xs : 2;
$owl_options_args['responsive'][0]['items']    = ( !empty($slides_per_view_xx) ) ? $slides_per_view_xx : 1;

$owl_options = '';
if( is_array($owl_options_args) && !empty($owl_options_args) ){
	$owl_options = json_encode($owl_options_args);
}
?>
<div class="new-arrivals woocommerce">
	<div class="product-slider-title">
		<h4><?php if( !empty($add_icon) && !empty($icon) ){ ?><i class="<?php echo esc_attr($icon);?>"></i><?php } ?><?php echo esc_html($custom_title)?></h4>
	</div>
	<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
		<?php
		while ( $loop->have_posts() ) {
			$loop->the_post();
			?>
			<div class="item product-wrapper match-height">
				<div class="product">
					<?php
					do_action( 'woocommerce_before_shop_loop_item' );
					?>
					<div class="product-thumbnail">
						<?php
						do_action( 'woocommerce_before_shop_loop_item_title' );
						?>
					</div>
					<?php
					do_action( 'woocommerce_shop_loop_item_title' );
					do_action( 'woocommerce_after_shop_loop_item_title' );
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
		?>
	</div>
</div><!-- product carousel -->