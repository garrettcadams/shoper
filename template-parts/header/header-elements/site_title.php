<?php
global $ciyashop_options;

$site_title_el    = is_front_page() ? 'h1' : 'div';
$site_title_class = is_front_page() ? 'site-title' : 'site-title';
$site_title_class = apply_filters( 'ciyashop_site_title_class', $site_title_class );
?>

<?php do_action( 'ciyashop_before_site_title_wrapper_start' ); ?>

<div class="site-title-wrapper">
	
	<?php do_action( 'ciyashop_after_site_title_wrapper_start' ); ?>
	
	<<?php echo esc_attr($site_title_el);?> class="<?php echo esc_attr($site_title_class);?>">
		
		<?php do_action( 'ciyashop_before_site_title_link' ); ?>
		
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			
			<?php do_action( 'ciyashop_before_site_title' ); ?>
			
			<?php
			/**
			 * Functions hooked in to ciyashop_page_after action
			 *
			 * @hooked ciyashop_logo - 10
			 */
			do_action( 'ciyashop_site_title' ); ?>
			
			<?php do_action( 'ciyashop_after_site_title' ); ?>
			
		</a>
		
		<?php do_action( 'ciyashop_after_site_title_link' ); ?>
		
	</<?php echo esc_attr($site_title_el);?>>
	
	<?php
	/**
	 * Functions hooked in to ciyashop_before_site_title_wrapper_end action
	 *
	 * @hooked ciyashop_site_description - 10
	 */
	do_action( 'ciyashop_before_site_title_wrapper_end' ); ?>
	
</div>

<?php do_action( 'ciyashop_after_site_title_wrapper_end' );