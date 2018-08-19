<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CiyaShop
 */
?>
			</div><!-- .container -->
		</div><!-- .content-wrapper -->
		
	</div><!-- #content .wrapper -->
	
	<?php do_action( 'ciyashop_before_footer' ); ?>
	
	<footer id="colophon" class="site-footer">
		<div class="<?php ciyashop_footer_wrapper_classes();?>">
		
			<?php
			/**
			 * Functions hooked in to ciyashop_footer action
			 *
			 * @hooked ciyashop_footer_main - 10
			 */
			do_action( 'ciyashop_footer' ); ?>
		
		</div>
	</footer><!-- #colophon -->
	
	<?php
	/**
	 * Functions hooked in to ciyashop_after_footer action
	 *
	 * @hooked ciyashop_bak_to_top - 10
	 */
	do_action( 'ciyashop_after_footer' ); ?>
	
</div><!-- #page -->

<?php
/**
 * Functions hooked in to ciyashop_after_page_wrapper action
 *
 * @hooked ciyashop_cookie_notice - 10
 */
do_action( 'ciyashop_after_page_wrapper' ); ?>

<?php wp_footer(); ?>
</body>
</html>