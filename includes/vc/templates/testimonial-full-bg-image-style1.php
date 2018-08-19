<?php
//About Banner
return array(
	'name'             => esc_html__( 'Full BG with Style 1', 'ciyashop' ),
	'template_category'=> esc_html__( 'Testimonial', 'ciyashop' ),
	'disabled'         => true,                                        // Disable it to not show in the default tab
	'content'          => <<<CONTENT
[vc_row full_width="stretch_row" pgscore_background_position="center-center" enable_first_overlay="true" first_overlay_opacity="50" first_background_color="#ffffff" pgscore_enable_responsive_settings="true" el_id="1519108931736-de79774a-7223" css=".vc_custom_1519449111881{padding-top: 80px !important;padding-bottom: 80px !important;background-image: url(http://ciyashop.potenzaglobalsolutions.com/flower/wp-content/uploads/sites/4/2018/02/testimonial-bg.jpg?id=516) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" element_css_md=".vc_custom_1519449111887{padding-top: 60px !important;padding-bottom: 60px !important;}" element_css_sm=".vc_custom_1519449111892{padding-top: 50px !important;padding-bottom: 50px !important;}" element_css_xs=".vc_custom_1519449111897{padding-top: 40px !important;padding-bottom: 40px !important;}"][vc_column offset="vc_col-lg-offset-2 vc_col-lg-8 vc_col-md-offset-1 vc_col-md-10" css=".vc_custom_1519110610806{padding-top: 0px !important;}"][vc_custom_heading text="What Customers say about" font_container="tag:h2|text_align:center|color:%23ae4b5c" use_theme_fonts="yes" font_weight="500" css=".vc_custom_1519126497588{margin-bottom: 30px !important;}"][pgscore_testimonials posts_per_page="6"][/vc_column][/vc_row]
CONTENT
);