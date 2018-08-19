<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CiyaShop
 */	
global $ciyashop_options;

$footer_cols = 1;
$classes = array('col-lg-12 col-md-12 col-sm-12');
$footer_widget_columns_alignment = array();

$footer_widget_columns = ( isset($ciyashop_options['footer_widget_columns']) && $ciyashop_options['footer_widget_columns'] != '' ) ? $ciyashop_options['footer_widget_columns'] : 'four-columns';

if( isset($ciyashop_options['footer_one_alignment']) && $ciyashop_options['footer_one_alignment'] != '' )
	$footer_widget_columns_alignment[] = 'footer-align-'.$ciyashop_options['footer_one_alignment'];

if( isset($ciyashop_options['footer_two_alignment']) && $ciyashop_options['footer_two_alignment'] != '' )
	$footer_widget_columns_alignment[] = 'footer-align-'.$ciyashop_options['footer_two_alignment'];

if( isset($ciyashop_options['footer_three_alignment']) && $ciyashop_options['footer_three_alignment'] != '' )
	$footer_widget_columns_alignment[] = 'footer-align-'.$ciyashop_options['footer_three_alignment'];

if( isset($ciyashop_options['footer_four_alignment']) && $ciyashop_options['footer_four_alignment'] != '' )
	$footer_widget_columns_alignment[] = 'footer-align-'.$ciyashop_options['footer_four_alignment'];


$footer_widget_columns = apply_filters( 'ciyashop_footer_widget_columns', $footer_widget_columns );
$footer_widget_columns_alignment = apply_filters( 'ciyashop_footer_widget_columns_alignment', $footer_widget_columns_alignment );

if( isset($ciyashop_options['footer_widget_columns']) ) {
	switch( $ciyashop_options['footer_widget_columns'] ) {
		case 'two-columns':
			$footer_cols = 2;
			$classes = array('col-lg-6 col-md-6');
		break;
		case 'three-columns':
			$footer_cols = 3;
			$classes = array('col-lg-4 col-md-4');
		break;
		case 'four-columns':
			$footer_cols = 4;
			$classes = array('col-lg-3 col-md-6');
		break;
		case '8-4-columns':
			$footer_cols = 2;
			$classes = array('col-lg-8 col-md-6', 'col-lg-4 col-md-6');
		break;
		case '4-8-columns':
			$footer_cols = 2;
			$classes = array('col-lg-4 col-md-6', 'col-lg-8 col-md-6');
		break;
		case '6-3-3-columns':
			$footer_cols = 3;
			$classes = array('col-lg-6 col-md-4', 'col-lg-3 col-md-4', 'col-lg-3 col-md-4');
		break;
		case '3-3-6-columns':
			$footer_cols = 3;
			$classes = array('col-lg-3 col-md-4', 'col-lg-3 col-md-4', 'col-lg-6 col-md-4');
		break;
		case '8-2-2-columns':
			$footer_cols = 3;
			$classes = array('col-xl-8 col-lg-6 col-md-4', 'col-xl-2 col-lg-3 col-md-4', 'col-xl-2 col-lg-3 col-md-4');
		break;
		case '2-2-8-columns':
			$footer_cols = 3;
			$classes = array('col-xl-2 col-lg-3 col-md-4', 'col-xl-2 col-lg-3 col-md-4', 'col-xl-8 col-lg-6 col-md-4');
		break;
		case '6-2-2-2-columns':
			$footer_cols = 4;
			$classes = array('col-xl-6 col-lg-3 col-md-6 col-sm-12', 'col-xl-2 col-lg-3 col-md-6 col-sm-12', 'col-xl-2 col-lg-3 col-md-6 col-sm-12', 'col-xl-2 col-lg-3 col-md-6 col-sm-12');
		break;
		case '2-2-2-6-columns':
			$footer_cols = 4;
			$classes = array('col-xl-2 col-lg-3 col-md-6 col-sm-12', 'col-xl-2 col-lg-3 col-md-6 col-sm-12', 'col-xl-2 col-lg-3 col-md-6 col-sm-12', 'col-xl-6 col-lg-3 col-md-6 col-sm-12');
		break;
	}
}
$sidebar_content = 0;
for( $col = 1; $col <= $footer_cols; $col++ ) {
	if(is_active_sidebar('sidebar-footer-'.$col)) {
		$sidebar_content++;
	}
}
if ( $sidebar_content > 0  ) {
	?>
	<div class="footer-widgets-wrapper">
		<div class="footer"><!-- .footer -->
			<div class="container"><!-- .container -->
		
				<div class="footer-widgets">
					<div class="row">
						<?php
						for( $col = 1; $col <= $footer_cols; $col++ ) {
							if(is_active_sidebar('sidebar-footer-'.$col)) {
								if(!isset($classes[$col - 1])){
									$classes[$col - 1] = $classes[0];
								}
								?>
								<div class="<?php echo esc_attr($classes[$col - 1].' '.$footer_widget_columns_alignment[$col - 1]);?>">
									<?php dynamic_sidebar('sidebar-footer-'.$col); ?>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div><!-- .container -->
		</div><!-- .footer -->
	</div>
	<?php
	if( (isset($ciyashop_options['footer_bottom']) && $ciyashop_options['footer_bottom'] == 'show') && (isset($ciyashop_options['footer_bottom_content']) && $ciyashop_options['footer_bottom_content'] != '') ){
		?>
		<div class="footer-bottom-wrapper">
			<div class="container"><!-- .container -->
				<div class="row">
					<div class="col-12">
					
						<div class="footer-bottom">
							<?php echo do_shortcode($ciyashop_options['footer_bottom_content']);?>
						</div><!-- .footer-bottom -->
						
					</div>
				</div>
			</div>
		</div><!-- .footer-bottom-wrapper -->
		<?php
	}
}