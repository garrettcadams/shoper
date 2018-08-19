<?php do_action( 'ciyashop_before_sticky_site_title_wrapper_start' ); ?>

<div class="sticky-site-title-wrapper">
	
	<?php do_action( 'ciyashop_after_sticky_site_title_wrapper_start' ); ?>
	
	<div class="sticky-site-title h1">
		
		<?php do_action( 'ciyashop_before_sticky_site_title_link' ); ?>
		
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			
			<?php do_action( 'ciyashop_before_sticky_site_title' ); ?>
			
			<?php
			/**
			 * Functions hooked in to ciyashop_page_after action
			 *
			 * @hooked ciyashop_sticky_logo - 10
			 */
			do_action( 'ciyashop_sticky_site_title' ); ?>
			
			<?php do_action( 'ciyashop_after_sticky_site_title' ); ?>
			
		</a>
		
		<?php do_action( 'ciyashop_after_sticky_site_title_link' ); ?>
		
	</div>
	
	<?php
	/**
	 * Functions hooked in to ciyashop_before_sticky_site_title_wrapper_end action
	 *
	 * @hooked ciyashop_site_description - 10
	 */
	do_action( 'ciyashop_before_sticky_site_title_wrapper_end' ); ?>
	
</div>

<?php do_action( 'ciyashop_after_sticky_site_title_wrapper_end' );