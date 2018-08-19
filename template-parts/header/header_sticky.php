<?php do_action( 'ciyashop_before_header_sticky' );?>

<div id="header-sticky" class="<?php echo ciyashop_header_sticky_classes();?>">
	<div class="header-sticky-inner">
		
		<div class="container">
			<div class="row align-items-center">
				
				<div class="col-lg-3 col-md-3 col-sm-3">
					<?php get_template_part( 'template-parts/header/header-elements/sticky-site_title' );?>
				</div>
				
				<div class="col-lg-9 col-md-9 col-sm-9">
					<?php
					do_action( 'ciyashop_before_sticky_nav_content' );
					
					/**
					 * Functions hooked into ciyashop_sticky_nav_content action
					 *
					 * @hooked ciyashop_sticky_nav                  - 10
					 */
					do_action( 'ciyashop_sticky_nav_content' );
					
					do_action( 'ciyashop_after_sticky_nav_content' );?>
				</div>
			</div>
		</div>
		
	</div><!-- #header-sticky -->
</div>

<?php do_action( 'ciyashop_after_header_sticky' );?>