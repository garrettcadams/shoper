<?php
function ciyashop_product_types( $args = array() ){
	$product_types = array(
		'new_arrivals' => esc_html__('Newest', 'ciyashop' ),
		'featured'     => esc_html__('Featured', 'ciyashop' ),
		'best_sellers' => esc_html__('Best Sellers', 'ciyashop' ),
		'on_sale'      => esc_html__('On sale', 'ciyashop' ),
		'cheapest'     => esc_html__('Cheapest', 'ciyashop' ),
	);
	
	$product_types = apply_filters( 'ciyashop_product_types', $product_types );
	
	if( isset($args['array_flip']) && $args['array_flip'] ){
		$product_types = array_flip( $product_types );
	}
	
	return $product_types;
}