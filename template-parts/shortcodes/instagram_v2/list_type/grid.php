<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_instagram_v2']);
extract($atts);

$meta = false;
if( ( $show_likes && $show_likes == 'true' ) || ( $show_comments && $show_comments == 'true' ) ){
	$meta = true;
}
$insta_items_classes = array(
	'insta_v2_items',
	'insta_v2_style--'. ( $meta ? 'with_meta' : 'without_meta' ),
);

if( $image_display_target == 'popup' ){
	$insta_items_classes[] = 'insta_v2_img_popup';
}

$insta_items_classes = implode( ' ', array_filter( array_unique( $insta_items_classes ) ) );
?>
<div class="<?php echo esc_attr($insta_items_classes);?>">
	<div class="row">
		<?php
		$grid_classes = array(
			"col-xl-" . 12/$grid_col_xl,
			"col-lg-" . 12/$grid_col_lg,
			"col-md-" . 12/$grid_col_md,
			"col-sm-" . 12/$grid_col_sm,
			"col-" . 12/$grid_col_xs,
		);
		$grid_classes = implode( ' ', array_filter( array_unique( $grid_classes ) ) );
		foreach( $images as $image ){
			if( $image_display_target == 'popup' ){
				$image_link = $image['original'];
			}else{
				$image_link = $image['link'];
			}
			?>
			<div class="<?php echo esc_attr($grid_classes);?>">
				<div class="insta_v2_item">
					<a href="<?php echo esc_url($image_link);?>" class="insta_v2_item--link" target="_blank">
						<div class="insta_v2_item--content">
							<img class="insta_v2_item--img img-responsive" src="<?php echo esc_url($image[$image_size]);?>" width="<?php echo esc_attr($image[$image_size.'_w']);?>" height="<?php echo esc_attr($image[$image_size.'_h']);?>" alt="<?php echo esc_attr($image['description']);?>">
						</div>
						<?php
						if( ( $show_likes && $show_likes == 'true' ) || ( $show_comments && $show_comments == 'true' ) ){
							?>
							<div class="insta_v2_item--meta">
								<div class="insta_v2_item--meta_items">
									<?php
									if( $show_likes && $show_likes == 'true' ){
										?>
										<div class="insta_v2_item--meta_item insta_v2_item--meta_item_likes">
											<span class="insta_v2_item--meta_item_likes_icon"><i class="fa fa-heart"></i></span>
											<span class="insta_v2_item--meta_item_likes_count"><?php echo esc_attr($image['likes']);?></span>
										</div>
										<?php
									}
									if( $show_comments && $show_comments == 'true' ){
										?>
										<div class="insta_v2_item--meta_item insta_v2_item--meta_item_comments">
											<span class="insta_v2_item--meta_item_comments_icon"><i class="fa fa-comment"></i></span>
											<span class="insta_v2_item--meta_item_comments_count"><?php echo esc_attr($image['comments']);?></span>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</a>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>