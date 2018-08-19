<?php
/************************************************************************************
 * 
 * Loop Header
 * 
 ************************************************************************************/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_archive_description', 'ciyashop_custom_loop_header', 20 );

add_action( 'ciyashop_loop_header', 'ciyashop_loop_active_filters', 10 );
add_action( 'ciyashop_loop_header', 'ciyashop_loop_filters', 20 );
add_action( 'ciyashop_loop_header', 'ciyashop_loop_tools', 30 );

function ciyashop_custom_loop_header(){
	wc_get_template( 'loop/loop-header.php' );
}

function ciyashop_loop_active_filters(){
	wc_get_template( 'loop/loop-header-active-filters.php' );
}

function ciyashop_loop_filters(){
	wc_get_template( 'loop/loop-header-filters.php' );
}

function ciyashop_loop_tools(){
	wc_get_template( 'loop/loop-header-tools.php' );
}


/************************************************************************************
 * 
 * Active Filtes
 * 
 ************************************************************************************/
add_action( 'ciyashop_loop_active_filters', 'ciyashop_loop_active_filters_content' );
function ciyashop_loop_active_filters_content(){
	the_widget( 'PGS_Widget_Layered_Nav_Filters' );
}


/************************************************************************************
 * 
 * Filtes
 * 
 ************************************************************************************/

add_action( 'ciyashop_loop_filters', 'ciyashop_loop_filters_content' );
function ciyashop_loop_filters_content(){
	$shop_filters_widget_params = array(
		'title' => '',
	);
	the_widget( 'PGS_Shop_Filters_Widget', $shop_filters_widget_params );
}

/************************************************************************************
 * 
 * Tools
 * 
 ************************************************************************************/
add_action( 'ciyashop_loop_tools', 'ciyashop_loop_tools_content', 10 );
add_action( 'ciyashop_loop_tools', 'woocommerce_result_count', 20 );
add_action( 'ciyashop_loop_tools', 'ciyashop_gridlist', 30 );
add_action( 'ciyashop_loop_tools', 'woocommerce_catalog_ordering', 40 );

function ciyashop_loop_tools_content(){
	do_action( 'ciyashop_loop_tools_content' );
}

function ciyashop_gridlist(){
	
	/**
	 * ciyashop_gridlist_content hook.
	 *
	 * @hooked ciyashop_gridlist_toggle_button - 10
	 * @hooked woocommerce_result_count      - 20
	 * @hooked woocommerce_catalog_ordering  - 30
	 * @hooked ciyashop_gridlist           - 40
	 */
	do_action( 'ciyashop_gridlist_content' );
	
}

add_action( 'ciyashop_gridlist_content', 'ciyashop_gridlist_toggle_button', 10 );

function ciyashop_gridlist_toggle_button() {

	$grid_view = esc_html__( 'Grid view', 'ciyashop' );;
	$list_view = esc_html__( 'List view', 'ciyashop' );
	$gridlist_view = isset($_COOKIE['gridlist_view']) ? sanitize_text_field( wp_unslash( $_COOKIE['gridlist_view'] ) ) : 'grid';
	
	ob_start();
	?>
	<div class="gridlist-toggle-wrap">
		<div class="gridlist-label-wrap">
			<span class="gridlist-toggle-label"><?php echo esc_html__('View :', 'ciyashop' );?></span>
		</div>
		<div class="gridlist-button-wrap">
			<div class="gridlist-toggle">
				<a href="#" id="gridlist-toggle-grid" title="<?php echo esc_attr($grid_view);?>" class="gridlist-button<?php echo esc_attr( ( $gridlist_view == 'grid' ) ? ' active' : '' );?>">
					<i class="fa fa-th" aria-hidden="true"></i> <em><?php echo esc_html($grid_view);?></em>
				</a>
				<a href="#" id="gridlist-toggle-list" title="<?php echo esc_attr($list_view);?>" class="gridlist-button<?php echo esc_attr( ( $gridlist_view == 'list' ) ? ' active' : '' );?>">
					<i class="fa fa-list" aria-hidden="true"></i> <em><?php echo esc_html($list_view);?></em>
				</a>
			</div>
		</div>
	</div>
	<?php
	$output = ob_get_clean();

	$output = apply_filters( 'gridlist_toggle_button_output', $output, $grid_view, $list_view );
	echo wp_kses( $output, ciyashop_allowed_html(array('div','span','a','i','em'))); // variable/values escaped already
}

add_action( 'init', 'ciyashop_product_search_redirection' );
function ciyashop_product_search_redirection(){
	if( isset($_GET['filtering']) && $_GET['filtering'] == 1 ) {
		
		$current_url = add_query_arg( array() );
		
		$current_url_prased = wp_parse_url( $current_url );
		$current_url_path = ( isset($current_url_prased['path']) ) ? $current_url_prased['path'] : '';
		$current_url_query = ( isset($current_url_prased['query']) ) ? $current_url_prased['query'] : '';
		
		$url_query_array_new = array();
		if( $current_url_query != '' ){
			$current_query_args = explode('&', $current_url_query);
			foreach( $current_query_args as $current_query_arg ){
				if( strstr($current_query_arg,'=') !== false ){
					$current_query_arg_parts = explode('=', $current_query_arg);
					$url_query_array_new[$current_query_arg_parts[0]] = $current_query_arg_parts[1];
				}
			}
			$new_query_str = build_query( $url_query_array_new );
			unset($url_query_array_new['filtering']);
		}
		$new_url = add_query_arg( ( ($new_query_str != 'filtering=1') ? $url_query_array_new : array() ), $current_url_path );
		
		wp_safe_redirect($new_url);
		exit;
	}
}