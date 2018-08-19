<?php
require get_parent_theme_file_path('/includes/widgets/pgs_contactus_widgets.php');
require get_parent_theme_file_path('/includes/widgets/pgs_newsletter_widgets.php');
require get_parent_theme_file_path('/includes/widgets/pgs_social_widgets.php');
require get_parent_theme_file_path('/includes/widgets/pgs_bestseller_product.php');
require get_parent_theme_file_path('/includes/widgets/pgs_featured_product.php');
require get_parent_theme_file_path('/includes/widgets/pgs_related_product.php');
require get_parent_theme_file_path('/includes/widgets/pgs_testimonials_widgets.php');
require get_parent_theme_file_path('/includes/widgets/pgs_instagram_widgets.php');
require get_parent_theme_file_path('/includes/widgets/pgs_shop_flters.php');
require get_parent_theme_file_path('/includes/widgets/pgs_opening_hours.php');
require get_parent_theme_file_path('/includes/widgets/pgs_brand_flters.php');

function ciyashop_register_widgets(){
	
	/*WooCommerce Plugin is active then woocommerce relatred widget register */
	if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){
		register_widget( 'pgs_bestseller_widget' );
		register_widget( 'pgs_related_widget' );
		register_widget( 'pgs_featured_products_widget' );
		register_widget( 'PGS_Shop_Filters_Widget' );
		if( ciyashop_check_plugin_active('yith-woocommerce-brands-add-on/init.php') ){
			register_widget( 'pgs_brand_filters_widget' );
		}
	}
	
	register_widget( 'pgs_contact_widget' );
	register_widget( 'pgs_opening_widget' );	
	register_widget( 'pgs_newsletter_widget' );	
	register_widget( 'pgs_social_widget' );
	register_widget( 'pgs_testimonials_widget' );
	register_widget( 'pgs_instagram_widget' );
}
add_action( 'widgets_init', 'ciyashop_register_widgets' );

add_action( 'widgets_init', 'ciyashop_override_woocommerce_widgets', 15 );
 
function ciyashop_override_woocommerce_widgets() {
	// Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
	if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
		unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
 
		require get_parent_theme_file_path('/includes/widgets/pgs_layered_nav_filters.php');
 
		register_widget( 'PGS_Widget_Layered_Nav_Filters' );
	}
}