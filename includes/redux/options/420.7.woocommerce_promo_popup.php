<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if( ciyashop_check_plugin_active('woocommerce/woocommerce.php') ){

$popup_img     = 'https://via.placeholder.com/380x480/ccc/fff?text=CiyaShop';
$popup_img_alt = esc_attr__('CiyaShop', 'ciyashop' );
$popup_title   = esc_html__('Hello User', 'ciyashop' );
$popup_subtitle= esc_html__('Join Our Newsletter', 'ciyashop' );
$popup_desc    = esc_html__( 'Subscribe to the CiyaShop mailing list to receive updates on new arrivals, special offers and other discount information.', 'ciyashop' );

$popup_text_default = <<<EOT
<div class="row align-items-center">
	<div class="promo-image col-sm-6">
		<div class="vc_column-inner ">
			<figure>
				<img class="alignnone popup-image img-responsive" src="{$popup_img}" alt="{$popup_img_alt}" width="380" height="480" />
			</figure>
		</div>
	</div>
	<div class="promo-content col">
		<div class="promo-popup-info">
			<h5>{$popup_title}</h5>
			<h4 class="heading">{$popup_subtitle}</h4>
			<p>{$popup_desc}</p>
			[pgscore_newsletter mailchimp_id="demo_test" mailchimp_api_key="demo_test"]
		</div>
	</div>
</div>
EOT;

	return array(
		'id'              => 'woocommerce_promo_popup',
		'title'           => esc_html__('Promo Popup', 'ciyashop' ),
		'customizer_width'=> '400px',
		'subsection'      => true,
		'fields'          => array(
			array (
				'id'      => 'promo_popup',
				'type'    => 'switch',
				'title'   => esc_html__('Enable Promo Popup', 'ciyashop' ),
				'subtitle'=> esc_html__('Show promo popup to users when they enter the site.', 'ciyashop' ),
				'default' => 1
			),
			array (
				'id'      => 'popup_text',
				'type'    => 'editor',
				'title'   => esc_html__('Promo Popup Text', 'ciyashop' ),
				'subtitle'=> sprintf( wp_kses( __( 'Place here some promo text or use HTML block and place here it\'s shortcode, You can use this shortcode for not showing popup again:<br><span class="code">[pgscore-popup-close message="your message"]</span>', 'ciyashop' ), array(
					'span' => array(
						'class' => true
					),
					'br' => array()
				) ) ),
				'default' => $popup_text_default,
				'required'=> array( 'promo_popup', '=', 1 ),
            ),
			array (
				'id'      => 'popup-background',
				'type'    => 'background',
				'title'   => esc_html__('Popup Background', 'ciyashop' ),
				'subtitle'=> esc_html__('Set background image or color for promo popup', 'ciyashop' ),
				'output'  => array('.ciyashop-promo-popup'),
				'required'=> array( 'promo_popup', '=', 1 ),
			),
			array (
				'id'      => 'promo_popup_hide_mobile',
				'type'    => 'switch',
				'title'   => esc_html__('Hide for Mobile Devices', 'ciyashop' ),
				'default' => 1,
				'required'=> array( 'promo_popup', '=', 1 ),
            ),
		)
	);
}