<?php
function ciyashop_product_content_class( $classes = array() ){
	$sidebar_layout= ciyashop_product_page_sidebar();
	$sidebar_id    = 'sidebar-product';
	
	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	
	if( is_active_sidebar($sidebar_id) && $sidebar_layout == 'left' ){
		$classes[] = 'col-xl-9 col-lg-8 order-xl-2 order-lg-2';
	}elseif( is_active_sidebar($sidebar_id) && $sidebar_layout == 'right' ){
		$classes[] = 'col-xl-9 col-lg-8';
	}else{
		$classes[] = 'col-xl-12';
	}
	
	$classes = ciyashop_class_builder($classes);
	return $classes;
}

function ciyashop_product_sidebar_class( $classes = array() ){
	$sidebar_layout = ciyashop_product_page_sidebar();
	$sidebar_id     = 'sidebar-product';

	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	if( is_active_sidebar($sidebar_id) && $sidebar_layout == 'left' ){
		$classes[] = 'sidebar col-xl-3 col-lg-4 order-xl-1 order-lg-1';
	}elseif( is_active_sidebar($sidebar_id) && $sidebar_layout == 'right' ){
		$classes[] = 'sidebar col-xl-3 col-lg-4';
	}
	
	$classes = ciyashop_class_builder($classes);
	$classes = apply_filters( 'ciyashop_product_page_sidebar_classes', $classes, $sidebar_layout, $sidebar_id);
	
	return $classes;
}

function ciyashop_shop_content_class( $classes = array() ){
	$sidebar_layout         = ciyashop_shop_page_sidebar();
	$show_sidebar_on_mobile = ciyashop_show_sidebar_on_mobile();
	$mobile_sidebar_position= ciyashop_mobile_sidebar_position();
	$device_type            = ciyashop_device_type();
	$sidebar_id             = 'sidebar-shop';
	
	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	$classes_new = array();
	
	if( !is_active_sidebar($sidebar_id) || $sidebar_layout == 'no' ){
		$classes_new[] = 'col-sm-12';
	}else{
		if( $sidebar_layout == 'left' ){
			if( $mobile_sidebar_position == 'bottom' ){
				$classes_new[] = 'col-xl-9 col-lg-8 order-xl-2 order-lg-2';
			}else{
				$classes_new[] = 'col-xl-9 col-lg-8';
			}
		}elseif( $sidebar_layout == 'right' ){
			if( $mobile_sidebar_position == 'top' ){
				$classes_new[] = 'col-xl-9 col-lg-8 order-xl-1 order-lg-1';
			}else{
				$classes_new[] = 'col-xl-9 col-lg-8';
			}
		}else{
			$classes_new[] = 'col-xl-9 col-lg-8';
		}
	}
	
	$classes = array_merge( $classes, $classes_new );
	
	$classes = ciyashop_class_builder($classes);
	return $classes;
}

function ciyashop_shop_sidebar_class( $classes = array() ){
	$sidebar_layout         = ciyashop_shop_page_sidebar();
	$show_sidebar_on_mobile = ciyashop_show_sidebar_on_mobile();
	$mobile_sidebar_position= ciyashop_mobile_sidebar_position();
	$device_type            = ciyashop_device_type();
	$sidebar_id             = 'sidebar-shop';

	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	$classes_new = array();
	
	if( $sidebar_layout == 'left' ){
		if( $mobile_sidebar_position == 'bottom' ){
			$classes_new[] = 'col-xl-3 col-lg-4 order-xl-1 order-lg-1';
		}else{
			$classes_new[] = 'col-xl-3 col-lg-4';
		}
	}elseif( $sidebar_layout == 'right' ){
		if( $mobile_sidebar_position == 'top' ){
			$classes_new[] = 'col-xl-3 col-lg-4 order-xl-2 order-lg-2';
		}else{
			$classes_new[] = 'col-xl-3 col-lg-4';
			
		}
	}else{
		$classes_new[] = 'col-xl-3 col-lg-4';
	}
	
	
	$classes_new[] = $device_type;
	
	if( $show_sidebar_on_mobile == '0' && $device_type != 'mobile' ){
		$classes_new[] = 'd-none d-md-block d-lg-block d-xl-block';
	}
	
	$classes = array_merge( $classes, $classes_new );
	
	$classes = ciyashop_class_builder($classes);
	return $classes;
}

function ciyashop_wc_wrapper_class( $class = '' ){
	if( is_product() ){
		$content_class = ciyashop_product_content_class( $class );
	}else{
		$content_class = ciyashop_shop_content_class( $class );
	}
	
	return apply_filters( 'ciyashop_wc_wrapper_class', $content_class );
}

function ciyashop_product_top_left_classes( $classes = array() ){
	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	$product_page_width = ciyashop_product_page_width();
	$sidebar_layout     = ciyashop_product_page_sidebar();
	$sidebar_id         = 'sidebar-product';
	
	$classes_new = array();
	
	if( $product_page_width == 'wide' && ( $sidebar_layout == 'no' || !is_active_sidebar($sidebar_id) )	){
		$classes_new[] = 'col-xl-4';
	}else{
		$classes_new[] = 'col-xl-5';
		$classes_new[] = 'col-lg-6';
	}
	
	$classes = array_merge( $classes, $classes_new );
	
	$classes = ciyashop_class_builder($classes);
	
	echo esc_attr($classes);
}

function ciyashop_product_top_right_classes( $classes = array() ){
	if( !empty($classes) && !is_array($classes) ){
		$classes = explode(' ', $classes);
	}
	
	$product_page_width = ciyashop_product_page_width();
	$sidebar_layout     = ciyashop_shop_page_sidebar();
	$sidebar_id         = 'sidebar-product';
	
	$classes_new = array();
	
	if( $product_page_width == 'wide' && ( $sidebar_layout == 'no' || !is_active_sidebar($sidebar_id) )	){
		$classes_new[] = 'col-xl-8';
	}else{
		$classes_new[] = 'col-xl-7';
		$classes_new[] = 'col-lg-6';
	}
	
	$classes = array_merge( $classes, $classes_new );
	
	$classes = ciyashop_class_builder($classes);
	
	echo esc_attr($classes);
}