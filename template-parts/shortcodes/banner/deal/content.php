<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_banner']);
extract($atts);

$counter_data = array(
	'expiremsg'      => $expire_message,
	'weeks'          => esc_html__("Week", 'ciyashop' ),
	'days'           => esc_html__("Day", 'ciyashop' ),
	'hours'          => esc_html__("Hrs", 'ciyashop' ),
	'minutes'        => esc_html__("Min", 'ciyashop' ),
	'seconds'        => esc_html__("Sec", 'ciyashop' ),
	'on_expire_btn'  => $on_expire_btn,
);
$counter_data = json_encode($counter_data);

$deal_counter_wrapper_classes = array(
	'deal-counter-wrapper',
	"counter-size-{$counter_size}",
);
if( $style == 'deal-1' ){
	$deal_counter_wrapper_classes[] = "counter-style-{$counter_style}";
}

if( function_exists('vc_shortcode_custom_css_class') ){
	$deal_counter_wrapper_classes[] = vc_shortcode_custom_css_class( $deal_css, ' ' );
}

$deal_counter_wrapper_classes = implode( ' ', array_filter( array_unique( $deal_counter_wrapper_classes ) ) );
?>
<div class="<?php echo esc_attr($deal_counter_wrapper_classes);?>">
	<div class="deal-counter" data-countdown-date="<?php echo esc_attr($deal_date);?>" data-counter_data="<?php echo esc_attr($counter_data);?>"></div>
</div>