<div class="loop-header-filters">
	
	<?php do_action( 'ciyashop_before_loop_filters_wrapper' );?>
	
	<div class="loop-header-filters-wrapper">
		
		<form class="loop-header-filters-form" method="get">
		
			<div class="row">
				<div class="col">
					
					<?php do_action( 'ciyashop_before_loop_filters' );?>
					
					<?php
					/**
					 * ciyashop_loop_filters hook.
					 *
					 * @hooked ciyashop_loop_filters_content - 10
					 */
					do_action( 'ciyashop_loop_filters' );?>
					
					<?php do_action( 'ciyashop_after_loop_filters' );?>
					
				</div>
			</div>
		
		</form>
		
	</div>
	
	<?php do_action( 'ciyashop_after_loop_filters_wrapper' );?>
	
</div>