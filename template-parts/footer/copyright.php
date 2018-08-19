<?php global $ciyashop_options;
if( isset($ciyashop_options['enable_copyright_footer']) && $ciyashop_options['enable_copyright_footer']=='no') {
	return;
}
?>
<div class="site-info">
	<div class="footer-widget"><!-- .footer-widget -->
		
		<div class="container"><!-- .container -->
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-6 pull-left">
					<?php
						if(isset($ciyashop_options['footer_text_left']) && $ciyashop_options['footer_text_left']){
							echo do_shortcode($ciyashop_options['footer_text_left']);
						}else{
							ciyashop_footer_copyright();
						}
				   ?>			
				</div>
				<div class="col-lg-6 col-md-6 pull-right">
					<div class="text-right">
						<?php
							if(isset($ciyashop_options['footer_text_right']) && $ciyashop_options['footer_text_right']!=''){
								echo do_shortcode($ciyashop_options['footer_text_right']);
							}else{
								ciyashop_footer_credits();
							}
						?>				
					</div>
				</div>
			</div>
		</div><!-- .container -->
		
	</div><!-- .footer-widget -->
</div><!-- .site-info -->