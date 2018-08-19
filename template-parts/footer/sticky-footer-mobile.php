<div class="footer-mobile-device">
	<div class="footer-mobile-device-wrapper">
		<div class="footer-mobile-device-actions">
			<?php
			do_action( 'ciyashop_before_sticky_footer_mobile_device' );

			/**
			 * Functions hooked into ciyashop_sticky_footer_mobile_device action
			 *
			 * @hooked ciyashop_footer_mobile_home                     - 10
			 * @hooked ciyashop_footer_mobile_wishlist                 - 20
			 * @hooked ciyashop_footer_mobile_myaccount                - 30
			 * @hooked ciyashop_footer_mobile_cart		                - 40
			 */
			do_action( 'ciyashop_sticky_footer_mobile_device' );

			do_action( 'ciyashop_after_sticky_footer_mobile_device' );
			?>
		</div>
	</div>
</div>