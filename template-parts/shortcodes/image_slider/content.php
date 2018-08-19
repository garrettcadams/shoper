<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_image_slider']);
extract($atts);

//style
$image_slider_class = '';
if( !empty($style)){
	$image_slider_class = 'image_slider-'.$style;
}

$owl_options_args = array(
	'nav'       => ( !empty($show_prev_next_buttons) && $show_prev_next_buttons  == 'yes' ) ? true : false, // Arrow
	'dots'      => ( !empty($show_pagination_control) && $show_pagination_control== 'yes' ) ? true : false, // Pagination
	'loop'      => ( !empty($enable_infinity_loop) && $enable_infinity_loop      == 'yes' ) ? true : false,// Loop
	'items'     => ( !empty($slides_per_view) ) ? $slides_per_view : 3, // Data Items
	'smartSpeed'        => 1000,
	'responsive'=> array(
		1200 => array(
			'items' => ( !empty($slides_per_view) )    ? $slides_per_view    : 3,
		),
		992 => array(
			'items' => ( !empty($slides_per_view_md) ) ? $slides_per_view_md : 3,
		),
		768 => array(
			'items' => ( !empty($slides_per_view_sm) ) ? $slides_per_view_sm : 2,
		),
		480 => array(
			'items' => ( !empty($slides_per_view_xs) ) ? $slides_per_view_xs : 1,
		),
		0 => array(
			'items' => ( !empty($slides_per_view_xx) ) ? $slides_per_view_xx : 1,
		),
	),
	'navText' => array(
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>",
	),
	'margin' => ( !empty($slide_margin) ) ? (int)$slide_margin : 0,
);

$owl_options = '';
if( is_array($owl_options_args) && !empty($owl_options_args) ){
	$owl_options = json_encode($owl_options_args);
}
?>
<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
	<?php
	foreach( $slides_data as $slide ){
		?>
		<div class="item">
			<div class="about pro-deta <?php echo esc_attr($image_slider_class);?>">
				<div class="about-image clearfix">
					<?php
					$link_stat = false;
					if( $slide['onclick'] != 'link_no' ){
						$link = '';
						if( $slide['onclick'] == 'link_image' ){
							$link =  $slide['image_url'];
							$link_stat = true;
							?>
							<a href="<?php echo esc_url($link);?>" class="slider-popup">
							<?php
						}elseif( $slide['onclick'] == 'custom_link' ){
							$custom_link = $slide['custom_link'];
							$link_class = array();
							$link_attr = '';
							if( !empty($custom_link) ){
								$link_attr = pgscore_vc_link_attr( $custom_link, $link_class );
							}
							if( !empty($link_attr) ){
								$link_stat = true;
								echo wp_kses('<a '.$link_attr.'>', ciyashop_allowed_html( array('a')));
							}
						}
					}
					?>
					<img class="img-fluid" src="<?php echo esc_url($slide['image_thumbnail']);?>" width="<?php echo esc_attr($slide['image_thumbnail_width']);?>" height="<?php echo esc_attr($slide['image_thumbnail_height']);?>" alt="<?php echo ( isset($slide['title']) && !empty($slide['title']) ) ? esc_attr($slide['title']) : '';?>">
					<?php
					if( $slide['onclick'] != 'link_no' && $link_stat ){
						?>
						</a>
						<?php
					}
					?>
				</div>
				<?php
				if( $enable_caption ){
					?>
					<div class="about-details">
						<?php
						if( !empty($slide['subtitle']) ){
							?>
							<div class="about-des"><?php echo esc_html($slide['subtitle']);?></div>
							<?php
						}
						if( !empty($slide['title']) ){
							?>
							<h5 class="title"><?php echo esc_html($slide['title']);?></h5>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
</div>