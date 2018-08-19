<?php
//About Banner
return array(
	'name'             => esc_html__( 'Dark BG with Style 1', 'ciyashop' ),
	'template_category'=> esc_html__( 'Testimonial', 'ciyashop' ),
	'disabled'         => true,                                        // Disable it to not show in the default tab
	'content'          => <<<CONTENT
[vc_row pgscore_bg_type="row-background-dark" pgscore_background_position="center-center" enable_first_overlay="true" first_overlay_opacity="70" first_background_color="#000000" pgscore_enable_responsive_settings="true" el_id="1520316827584-77bdc432-c8b4" css=".vc_custom_1524658022964{margin-right: 0px !important;margin-left: 0px !important;padding-top: 80px !important;padding-bottom: 80px !important;background-image: url(http://ciyashop.potenzaglobalsolutions.com/suite/wp-content/uploads/sites/6/2018/03/testimonial-bg3.jpg?id=757) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" element_css_md=".vc_custom_1524658022969{padding-top: 60px !important;padding-bottom: 60px !important;}" element_css_sm=".vc_custom_1524658022973{padding-top: 50px !important;padding-bottom: 50px !important;}" element_css_xs=".vc_custom_1524658022977{padding-top: 40px !important;padding-bottom: 40px !important;}"][vc_column offset="vc_col-lg-offset-1 vc_col-lg-10 vc_col-md-offset-1 vc_col-md-10" css=".vc_custom_1520318174432{padding-top: 0px !important;}"][pgscore_testimonials posts_per_page="6"][/vc_column][/vc_row]
CONTENT
);