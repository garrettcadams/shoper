<?php do_action( 'ciyashop_before_header_nav' );?>

<div class="<?php ciyashop_header_nav_classes('header-nav');?>">
	<div class="header-nav-wrapper">
		
		<?php
		/**
		 * Functions hooked into ciyashop_before_header_nav_content action
		 *
		 * @hooked ciyashop_before_header_nav_content_wrapper_start  - 10
		 */
		do_action( 'ciyashop_before_header_nav_content' );
		
		/**
		 * Functions hooked into ciyashop_header_nav_content action
		 *
		 * @hooked ciyashop_category_menu                 - 10
		 * @hooked ciyashop_catmenu_primenu_separator     - 15
		 * @hooked ciyashop_primary_menu                  - 20
		 */
		do_action( 'ciyashop_header_nav_content' );
		
		/**
		 * Functions hooked into ciyashop_after_header_nav_content action
		 *
		 * @hooked ciyashop_after_header_nav_content_wrapper_end  - 10
		 */
		do_action( 'ciyashop_after_header_nav_content' );
		?>
		
	</div>
</div>

<?php do_action( 'ciyashop_after_header_nav' );