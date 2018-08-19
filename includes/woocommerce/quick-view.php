<?php
/********************************************************************
 * 
 * Product Loop
 * 
 ********************************************************************/
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_actions_add_quick_view_link', 17 );
function ciyashop_product_actions_add_quick_view_link(){
	global $post, $ciyashop_options;
	
	if(!$ciyashop_options['quick_view']){
		return;
	}
	?>
	<div class="product-action product-action-quick-view">
		<a href="<?php echo esc_url( get_the_permalink($post->ID) ); ?>" class="open-quick-view" data-id="<?php echo esc_attr( $post->ID ); ?>" data-toggle='tooltip' data-original-title="<?php esc_attr_e( 'Quick view', 'ciyashop' );?>" data-placement='right'>
			<?php esc_html_e('Quick View', 'ciyashop' ); ?>
		</a>
	</div>
	<?php
}

function ciyashop_woocommerce_template_single_title(){
	the_title( sprintf( '<h2 class="product_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
}