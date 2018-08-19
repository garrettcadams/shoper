<?php
$auth_token = Ciyashop_Theme_Activation::ciyashop_verify_theme();
$purchase_code = get_option('ciyashop_theme_purchase_key');

$notice = get_site_transient('ciyashop_auth_notice');

$icon = 'dashicons dashicons-admin-network';

$token_status = 'empty';
$token_status_class = 'btn btn-secondary';

if( empty($purchase_code) ){
	$token_status = 'empty';
	$token_status_class = 'btn btn-secondary';
	
	$alert_class = 'p-3 mb-2 bg-primary text-white';
	$alert_msg   = esc_html__( 'Please enter purchase key to activate theme.', 'ciyashop');
	
}elseif( !empty($notice) ){
	$token_status      = 'invalid';
	$token_status_class= 'btn btn-danger';
	$icon              = 'dashicons dashicons-no';
	
	$alert_class = 'p-3 mb-2 bg-danger text-white';
	$alert_msg   = $notice;
	
}elseif( !empty($purchase_code) && !empty($auth_token) ){
	$token_status      = 'valid';
	$token_status_class= 'btn btn-success';
	$icon              = 'dashicons dashicons-yes';
	
	$alert_class = '';
	$alert_msg   = '';
}

if( $token_status == 'valid' ) {
	?>
	<p><?php
	/* Translators: %1$s: Theme Name. */
	printf( esc_html__( '%1$s comes with six months of free support for every license you purchase. You can extend the support through subscriptions via ThemeForest.', 'ciyashop' ),
		'<strong>'.$this->theme_data['Name'].'</strong>'
	);
	?></p>
	<div class="support-columns mb-4">
		<div class="row">
			<div class="col-sm support-column support-column-ticket">
				<div class="support-column-inner">
					<img src="<?php echo esc_url(get_parent_theme_file_uri('/images/admin/cs-admin/ticket.png'));?>" />
					<h2><?php esc_html_e( 'Ticket System', 'ciyashop' ); ?></h2>
					<p><?php esc_html_e( 'We offer excellent support through our support system. Make sure to register your purchase first to access our support services and other resources.', 'ciyashop' ); ?></p>
					<a class="cs-btn" href="https://potezasupport.ticksy.com" rel="noopener" target="_blank">
						<?php esc_html_e( 'Submit a ticket', 'ciyashop' ); ?>
					</a>
				</div>
			</div>

			<div class="col-sm support-column support-column-documentation">
				<div class="support-column-inner">
					<img src="<?php echo esc_url(get_parent_theme_file_uri('/images/admin/cs-admin/documentation.png'));?>" />
					<h2><?php esc_html_e( 'Documentation', 'ciyashop' ); ?></h2>
					<p>
						<?php
						/* Translators: %1$s: Theme Name. */
						printf( esc_html__( 'Our online documentation is a useful resource for learning every aspect and features of %1$s.', 'ciyashop' ),
							$this->theme_data['Name']
						);
						?>
					</p>
					<a class="cs-btn" href="http://docs.potenzaglobalsolutions.com/docs/ciyashop-wp/" rel="noopener" target="_blank">
						<?php esc_html_e( 'Learn more', 'ciyashop' ); ?>
					</a>
				</div>
			</div>
			<div class="col-sm support-column support-column-video">
				<div class="support-column-inner">
					<img src="<?php echo esc_url(get_parent_theme_file_uri('/images/admin/cs-admin/video.png'));?>" />
					<h2><?php esc_html_e( 'Video Tutorials', 'ciyashop' ); ?></h2>
					<p><?php
						/* Translators: %1$s: Theme Name. */
						printf( esc_html__( 'We recommend you to watch video tutorials before you start the theme customization. Our video tutorials can teach you the different aspects of using %s.', 'ciyashop' ),
							$this->theme_data['Name']
						);
					?></p>
					<a class="cs-btn" href="http://docs.potenzaglobalsolutions.com/docs/ciyashop-wp/#videos" rel="noopener" target="_blank">
						<?php esc_html_e( 'Watch Videos', 'ciyashop' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php
}
if( !empty($alert_msg) ){
	?>
	<div class="<?php echo esc_attr($alert_class);?>">
		<h6 class="mb-0"><?php echo esc_html($alert_msg);?></h6>
	</div>
	<?php
}
?>
<div class="ciyashop-theme-activation-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm">
				<div class="ciyashop-theme-activation-main">
					<?php
					if( !empty($themes) and !empty($auth_token) ) {
						?>
						<div class="card mb-4 shadow-sm">
							<?php envato_market_themes_column( 'active' );?>
						</div>
						<?php
					}
					?>
					<form id="ciyashop_verify_theme" method="post" action="">
						<?php settings_fields( 'ciyashop_verify_theme' ); ?>
						<input type="hidden" name="ciyashop_activation_nonce" value="<?php echo wp_create_nonce('ciyashop_activation-verify-token');?>" />
						<div class="mb-3">
							<h6><?php esc_html_e('Purchase Code', 'ciyashop');?></h6>
							<div class="input-group mb-2 mr-sm-2 is-invalid">
								<?php
								$purchase_code_input_val  = (!empty($purchase_code)) ? $purchase_code : '';
								$purchase_code_input_type = (!empty($purchase_code)) ? 'text' : 'text';
								?>
								<input class="form-control" id="ciyashop-purchase_code" type="<?php echo esc_attr($purchase_code_input_type);?>" name="ciyashop_verify_theme[purchase_key]" value="<?php echo esc_attr($purchase_code_input_val);?>">
								<div class="input-group-prepend">
									<div class="<?php echo esc_attr($token_status_class);?>"><span class="<?php echo esc_attr($icon);?>"></span></div>
								</div>
							</div>
							<span id="ciyashop-purchase_code-help" class="form-text text-muted"><?php esc_html_e('Enter purchase code here.', 'ciyashop');?></span>
						</div>
						<?php submit_button( esc_attr__( 'Check', 'ciyashop' ), array( 'primary', 'large' ) ); ?>
					</form>
				</div>
			</div>
			<div class="col-sm">
				<div class="ciyashop-theme-activation-info">
					<h6><?php esc_html_e( 'Instructions to find the Purchase Code', 'ciyashop' ); ?></h6>
					<ol>
						<li><?php esc_html_e( 'Log into your Envato Market account.', 'ciyashop' );?></li>
						<li><?php esc_html_e( 'Hover the mouse over your username at the top of the screen.', 'ciyashop' )?></li>
						<li><?php esc_html_e( 'Click \'Downloads\' from the drop-down menu.', 'ciyashop' );?></li>
						<li><?php  
						printf(
							wp_kses( __( 'Click \'License certificate & purchase code\' (available as PDF or text file). For more information <a href="%1$s" target="_blank">click here</a>.', 'ciyashop' ),
								array(
									'br'    => array(),
									'strong'=> array(),
									'a'     => array(
										'href' => array(),
										'target' => array()
									)
								)
							),   
							'https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code',
							esc_html('CiyaShop', 'citashop')
						);?></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>