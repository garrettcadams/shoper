<?php
function ciyashop_product_hover_style(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_style'] ) && !empty($ciyashop_options['product_hover_style']) ){
		$option_data = $ciyashop_options['product_hover_style'];
	}else{
		$option_data = 'image-center';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_style', $option_data, $ciyashop_options );
	
	return $option_data;
}

function ciyashop_product_hover_button_shape(){
	global $ciyashop_options;

	if( isset( $ciyashop_options['product_hover_button_shape'] ) && !empty($ciyashop_options['product_hover_button_shape']) ){
		$option_data = $ciyashop_options['product_hover_button_shape'];
	}else{
		$option_data = 'square';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_button_shape', $option_data, $ciyashop_options );
	
	return $option_data;
}

function ciyashop_product_hover_button_style(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_button_style'] ) && !empty($ciyashop_options['product_hover_button_style']) ){
		$option_data = $ciyashop_options['product_hover_button_style'];
	}else{
		$option_data = 'flat';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_button_style', $option_data, $ciyashop_options );
	
	return $option_data;
}

function ciyashop_product_hover_default_button_style(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_default_button_style'] ) && !empty($ciyashop_options['product_hover_default_button_style']) ){
		$option_data = $ciyashop_options['product_hover_default_button_style'];
	}else{
		$option_data = 'dark';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_default_button_style', $option_data, $ciyashop_options );
	
	return $option_data;
	
}

function ciyashop_product_hover_bar_style(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_bar_style'] ) && !empty($ciyashop_options['product_hover_bar_style']) ){
		$option_data = $ciyashop_options['product_hover_bar_style'];
	}else{
		$option_data = 'flat';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_bar_style', $option_data, $ciyashop_options );
	
	return $option_data;
}
function ciyashop_product_hover_add_to_cart_position(){
	global $ciyashop_options;
	
	if( isset( $ciyashop_options['product_hover_add_to_cart_position'] ) && !empty($ciyashop_options['product_hover_add_to_cart_position']) ){
		$option_data = $ciyashop_options['product_hover_add_to_cart_position'];
	}else{
		$option_data = 'center';
	}
	
	$option_data = apply_filters( 'ciyashop_product_hover_add_to_cart_position', $option_data, $ciyashop_options );
	
	return $option_data;
}