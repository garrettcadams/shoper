<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_recent_posts']);
extract($pgscore_shortcodes['pgscore_recent_posts']['atts']);
$loop = $pgscore_shortcodes['pgscore_recent_posts']['loop'];
$owl_options_args = array();

$owl_options_args = array (
	'items'             => 3,
	'responsive'        => array (
		0 => array (
			'items' => 1,
		),
		576 => array (
			'items' => ( $carousel_items_sm ) ? (int)$carousel_items_sm : 1,
		),
		768 => array (
			'items' => ( $carousel_items_md ) ? (int)$carousel_items_md : 1,
		),
		992 => array (
			'items' => ( $carousel_items_lg ) ? (int)$carousel_items_lg : 2,
		),
		1200 => array (
			'items' => ( $carousel_items_xl ) ? (int)$carousel_items_xl : 2,
		),
	),
	'margin'            => ( $carousel_margin ) ? (int)$carousel_margin : 15,
	'dots'              => false,
	'nav'              	=> true,
	'loop'              => true,
	'autoplay'          => true,
	'autoplayHoverPause'=> true,
	'autoplayTimeout'   => 3100,
	'smartSpeed'        => 1000,
	'navText'           => array (
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>",
	),
);

if( $enable_intro == 'true' ){
	$owl_options_args['navContainer'] = ".latest-post-control.latest-post-control-{$index} .latest-post-nav";
}

$owl_options = '';
if( is_array($owl_options_args) && !empty($owl_options_args) ){
	$owl_options = json_encode($owl_options_args);
}
?>
<div class="carousel-wrapper">
	<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
		<?php
		while ( $loop->have_posts() ) {
			$loop->the_post();
			global $post;
			?>
			<div class="item">
				<?php pgscore_get_shortcode_templates('recent_posts/loop/content');?>
			</div>
			<?php
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		?>
	</div>
</div>