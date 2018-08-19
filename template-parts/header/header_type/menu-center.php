<?php
/****************************************************
 * 
 * Topbar
 * 
 ****************************************************/
if( ciyashop_topbar_enable() == 'enable' ){
	get_template_part( 'template-parts/header/topbar' );
}

/****************************************************
 * 
 * Header Main
 * 
 ****************************************************/
do_action( 'ciyashop_before_header_main' );?>

<div class="<?php ciyashop_header_main_classes('header-main');?>">
	<div class="header-main-wrapper">
		<div class="<?php echo esc_attr(ciyashop_header_main_container_classes());?>">
			<div class="row">
				<div class="col-lg-12">
					
					<?php do_action( 'ciyashop_before_header_main_content' );?>
					
					<div class="row align-items-center justify-content-md-center">
						<div class="col-xl-2 col-lg-2 col-md-3 col-sm-3">
							<?php get_template_part( 'template-parts/header/header-elements/site_title' );?>
						</div>
						<div class="col">
							<div class="row justify-content-center">
								<?php ciyashop_primary_menu();?>
							</div>
						</div>
						<div class="col-xl-2 col-lg-2 col-md-3 col-sm-3">
							<div class="header-nav-right">
							<?php ciyashop_wootools();?>
							<?php
							$show_search = ciyashop_show_search();
							if( $show_search ){
								get_template_part( 'template-parts/header/header-elements/search' );
							}
							?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php
do_action( 'ciyashop_after_header_main' );


/****************************************************
 * 
 * Header Mobile
 * 
 ****************************************************/
get_template_part( 'template-parts/header/header_mobile' );


/****************************************************
 * 
 * Header Sticky
 * 
 ****************************************************/
get_template_part( 'template-parts/header/header_sticky' );