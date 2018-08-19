<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_clients']);
extract($atts);

$owl_options_args = array(
	'items'             => 5,
	'loop'              => true,
	'dots'              => $slider_elements != 'none' && ($slider_elements== 'both' || $slider_elements== 'pagination'),
	'nav'               => $slider_elements != 'none' && ($slider_elements== 'both' || $slider_elements== 'prevnext'),
	'margin'            => 30,
	'autoplay'          => true,
	'autoplayHoverPause'=> true,
	'smartSpeed'        => 1000,
	'responsive'        => array(
		'0' => array(
			'items' => 1,
		),
		'480' => array(
			'items' => 2,
		),
		'768' => array(
			'items' => 3,
		),
		'980' => array(
			'items' => 4,
		),
		'1200' => array(
			'items' => 5,
		),
	),
	'navText' => array(
		"<i class='fa fa-angle-left fa-2x'></i>",
		"<i class='fa fa-angle-right fa-2x'></i>",
	),
);
$owl_options = '';
if( is_array($owl_options_args) && !empty($owl_options_args) ){
	$owl_options = json_encode($owl_options_args);
}
?>
<div class="our-clients owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr($owl_options);?>">
	<?php
	foreach( $slides_data as $slide ){
		$link_attr = $img_src = '';
		if( !empty($slide['image_link']) ){
			$link_attr = pgscore_vc_link_attr( $slide['image_link'] );
		}
		if(!empty($slide['slide_image'])){
			$img_src = wp_get_attachment_image_src($slide['slide_image'], $thumb_size);
		}
		if( $img_src && isset($img_src[0]) ){
			?>
			<div class="item">
				<?php
				if( $link_attr != '' ){
					echo wp_kses( '<a '.$link_attr.'>', ciyashop_allowed_html('a') );
				}
				?>
				<img class="img-fluid center-block" src="<?php echo esc_url($img_src[0]);?>" width="<?php echo esc_attr($img_src[1]);?>" height="<?php echo esc_attr($img_src[2]);?>" alt="<?php echo esc_attr( isset($slide['title']) ? $slide['title'] : '' );?>">
				<?php
				if( $link_attr != '' ){
					?>
					</a>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
	?>
</div>