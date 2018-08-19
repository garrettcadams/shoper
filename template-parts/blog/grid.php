<?php
global $ciyashop_options, $ciyashop_blog_layout;
$layout_size = $layout_sr = 0;

$grid_size = ( !empty($ciyashop_options['grid_size']) ) ? $ciyashop_options['grid_size'] : 2 ;
$ciyashop_blog_sidebar = ( !empty($ciyashop_options['blog_sidebar']) ) ? $ciyashop_options['blog_sidebar'] : 'right_sidebar' ;
if( $ciyashop_blog_sidebar != 'full_width' ){
	$grid_size = 2;
}
$post_count=$wp_query->post_count;

// Start the loop.

while ( have_posts() ){
	the_post();
	
	$layout_sr++;
	$layout_size++;
	if($grid_size==3){
		if($layout_size==1){
			?><div class="row"><?php
		}
	}else{
		if(($layout_sr % 2) != 0){
			?><div class="row"><?php
		}
	}
	?>
	<div class="col-md-<?php echo esc_attr(12/$grid_size);?>">
		<?php
		$part_1 = "template-parts/blog/$ciyashop_blog_layout/content";
		$part_2 = get_post_format();
		if( ($part_2 && locate_template("$part_1-$part_2.php") != '') || (locate_template("$part_1.php") != '') ) {
			get_template_part( $part_1, $part_2 );
		}else{
			get_template_part( "template-parts/blog/classic/content", get_post_format() );
		}
		?>
	</div>
	<?php
	if($grid_size==3){
		if($layout_size==3 || $layout_sr==$post_count){
			$layout_size=0;
			?></div><?php
		}
	}else{
		if(($layout_sr % 2) == 0 || $layout_sr==$post_count){
			?></div><?php
		}
	}
}
// End the loop.