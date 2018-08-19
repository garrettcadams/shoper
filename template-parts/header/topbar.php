<?php
if( ciyashop_get_topbar('left') || ciyashop_get_topbar('right') ){

	do_action( 'ciyashop_before_topbar' );
	?>
	<div class="<?php echo esc_attr(ciyashop_topbar_classes());?>">
		<div class="topbar_wrapper">
		
			<div class="<?php echo esc_attr(ciyashop_topbar_container_classes());?>"><!-- .container/container-fluid -->
				<div class="row">
					<div class="col-lg-6 col-sm-12">
						<?php					
						if( ciyashop_get_topbar('left') ){
							?>
							<div class="topbar-left text-left">
								<div class="topbar-link">
									<ul>
										<?php echo ciyashop_get_topbar('left');?>
									</ul>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<div class="col-lg-6 col-sm-12">
						<?php					
						if( ciyashop_get_topbar('right') ){
							?>
							<div class="topbar-right text-right">
								<div class="topbar-link">
									<ul>
										<?php echo ciyashop_get_topbar('right');?>
									</ul>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div><!-- .container -->
			
		</div>
	</div>
	<?php
	do_action( 'ciyashop_after_topbar' );
}