<?php do_action( 'ciyashop_before_header_mobile' );?>

<div class="header-mobile">
	<div class="header-mobile-wrapper">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-6">
					<?php get_template_part( 'template-parts/header/header-elements/site_title' );?>
					<div class="clearfix"></div>
				</div>
				<div class="col-6">
					<div class="mobile-icons">
						<?php
						ciyashop_wootools();
						
						$show_search = ciyashop_show_search();
						
						if( $show_search ){
						?>
						<div class="mobile-butoon mobile-butoon-search">
							<a class="mobile-search-trigger" href="javascript:void(0);">
								<?php ciyashop_search_icon(); ?>
							</a>
						</div>
						<?php
						}
						?>
						<div class="mobile-butoon mobile-butoon-menu">
							<a class="mobile-menu-trigger" href="javascript:void(0)">
								<span></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-search-wrap">
			<div class="header-search-wrap">
				<?php
				do_action( 'ciyashop_before_header_search' );
				
				get_template_part( 'template-parts/header/header-elements/search-form' );
				
				do_action( 'ciyashop_after_header_search' );
				?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'ciyashop_after_header_mobile' );