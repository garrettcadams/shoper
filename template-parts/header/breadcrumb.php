<?php
global $ciyashop_options;
if( function_exists('bcn_display_list') && $ciyashop_options['display_breadcrumb'] == 1 && !is_front_page() ){
	?>
	<div class="breadcrumb-wrapper"><!-- .breadcrumb-wrapper -->
		
		<div class="container"><!-- .container -->
			<div class="row">
				<div class="col-lg-12">
					<?php do_action('ciyashop_before_breadcrumb');?>
					<ul class="page-breadcrumb">
						<?php bcn_display_list();?>
					</ul>
					<?php do_action('ciyashop_after_breadcrumb');?>
				</div>
			</div>
		</div><!-- .container -->
		
	</div><!-- .breadcrumb-wrapper -->
	<?php
}