<div class="woo-tools">
	<div class="woo-tools-wrapper">
		<ul class="woo-tools-actions">
			<?php
			do_action( 'ciyashop_before_header_wootools' );

			/**
			 * Functions hooked into ciyashop_header_wootools action
			 *
			 * @hooked ciyashop_header_wootools_cart                     - 10
			 * @hooked ciyashop_header_wootools_compare                  - 20
			 * @hooked ciyashop_header_wootools_wishlist                 - 30
			 */
			do_action( 'ciyashop_header_wootools' );

			do_action( 'ciyashop_after_header_wootools' );
			?>
		</ul>
	</div>
</div>