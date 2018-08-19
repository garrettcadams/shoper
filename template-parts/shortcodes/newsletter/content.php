<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_newsletter']);
extract($atts);

$form_id = uniqid('pgscore_newsletter_form_');

$newsletter_classes [] = 'newsletter-wrapper';
$newsletter_classes [] = 'newsletter-'.$style;

if($style == 'style-1'){
	$newsletter_classes [] = 'newsletter-'.$newsletter_design;
}else if($style == 'style-2'){
	$newsletter_classes [] = 'pgscore_newsletter-content-alignment-'.$content_alignment;
	$newsletter_classes [] = 'newsletter-bg-type-'.$bg_type;
}

$newsletter_classes = implode( ' ', array_filter( array_unique( $newsletter_classes ) ) );
?>
<div class="<?php echo esc_attr($newsletter_classes)?>">
	<?php
	if($style == 'style-1' || $style == 'style-2'){
		if( !empty($title) ){
			?>
			<h4 class="newsletter-title"><?php echo esc_html($title)?></h4>
			<?php
		}
		?>
		<div class="newsletter">        
			<?php
			if( !empty($description) ){
				?>
				<p><?php echo esc_html($description)?></p>        
				<?php
			}
			?>
			<div class="section-field">
				<div class="field-widget clearfix">
					<form class="newsletter_form" id="<?php echo esc_attr($form_id)?>">
						<div class="input-area">
							<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr__('Enter your email', 'ciyashop' )?>">
						</div>
						<div class="button-area">		
							<span class="input-group-btn">
								<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr($form_id)?>"><?php echo esc_html__('Subscribe', 'ciyashop' );?></button>
							</span>
							<span class="newsletter-spinner spinimg-<?php echo esc_attr($form_id)?>"></span>        
						</div>
						<p class="newsletter-msg"></p>
					</form>
				</div>
			</div>
		</div>
		<?php
	}elseif($style == 'style-3'){
		?>
		<div class="row align-items-center">
			<div class="col-md-6">
				<div class="newslatter-text">
					<?php
					if( !empty($title) ){
						?>
						<h4 class="newsletter-title"><?php echo esc_html($title)?></h4>
						<?php
					}
					if( !empty($description) ){
						?>
						<p><?php echo esc_html($description)?></p>        
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="newslatter-form">
					<form class="newsletter_form" id="<?php echo esc_attr($form_id)?>">
						<div class="input-area">
							<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr__('Enter your email', 'ciyashop' )?>">
						</div>
						<div class="button-area">		
							<span class="input-group-btn">
								<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr($form_id)?>"><?php echo esc_html__('Subscribe', 'ciyashop' );?></button>
							</span>
							<span class="newsletter-spinner spinimg-<?php echo esc_attr($form_id)?>"></span>        
						</div>
						<p class="newsletter-msg"></p>
					</form>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>