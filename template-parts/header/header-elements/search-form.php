<?php
global $ciyashop_options, $header_el_search_form_index;

if ( empty( $header_el_search_form_index ) ) {
	$header_el_search_form_index = 0;
}

$search_form_id = 'header-el-search-' . $header_el_search_form_index++;

$search_placeholder_text = ( isset($ciyashop_options['search_placeholder_text']) && $ciyashop_options['search_placeholder_text'] != '' ) ? $ciyashop_options['search_placeholder_text'] : esc_html__( 'Enter Search Keyword...', 'ciyashop' );
$search_form_classes = array();

$search_form_classes[] = 'search_form-inner';

if(isset($ciyashop_options['search_background_type']) && $ciyashop_options['search_background_type']){	
	$search_form_classes[] = $ciyashop_options['search_background_type'];
}

$search_form_classes = implode( ' ', $search_form_classes );
?>
<div class="search_form-wrap">
	<div class="<?php echo esc_attr($search_form_classes);?>">
		<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<?php
			if ( ( isset($ciyashop_options['search_content_type']) && ($ciyashop_options['search_content_type'] =='post' || $ciyashop_options['search_content_type'] =='product') )
				&& ( isset($ciyashop_options['show_categories']) && $ciyashop_options['show_categories'] )
			) {
				
				$taxonomy = ($ciyashop_options['search_content_type']=='product') ? 'product_cat' : 'category';
				?>
				<div class="search_form-category-wrap">
					<?php
					$search_category='';
					if( isset($_GET['search_category']) && $_GET['search_category']!='' ){
						$search_category = sanitize_text_field( wp_unslash( $_GET['search_category'] ) );
					}
					$args = array(
						'type'        => 'post',
						'child_of'    => 0,
						'parent'      => '',
						'orderby'     => 'id',
						'order'       => 'ASC',
						'hide_empty'  => false,
						'hierarchical'=> 1,
						'exclude'     => '',
						'include'     => '',
						'number'      => '',
						'taxonomy'    => $taxonomy,
						'pad_counts'  => false,            
					);
					$product_categories = get_categories($args);
					if( count( $product_categories ) > 0 ){
						?>                
						<select name="search_category" class="search_form-category">
							<option value='' selected><?php esc_html_e( 'All Categories', 'ciyashop' );?></option>
							<?php
							foreach( $product_categories as $cat ) {
								?>
								<option value="<?php echo esc_attr( $cat-> term_id );?>" <?php echo selected( esc_attr( $cat-> term_id ), $search_category );?>>
									<?php echo esc_html($cat->name);?>
								</option>
								<?php
							}
							?>
						</select>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
			<div class="search_form-input-wrap">
				<?php		
				if( isset($ciyashop_options['search_content_type']) && $ciyashop_options['search_content_type'] != 'all' ){
					?>
					<input type="hidden" name="post_type" value="<?php echo esc_attr($ciyashop_options['search_content_type']);?>"/>
					<?php
				}
				?>
				<label class="screen-reader-text" for="<?php echo esc_attr($search_form_id);?>"><?php esc_html_e( 'Search for:', 'ciyashop' );?></label>
				<div class="search_form-search-field">
					<input type="text" id="<?php echo esc_attr($search_form_id);?>" class="form-control search-form" value="<?php echo esc_attr(get_search_query());?>" name="s" placeholder="<?php echo esc_attr($search_placeholder_text);?>" />
				</div>
				<div class="search_form-search-button">
					<input value="" type="submit">
				</div>				
			</div>			
			<div class="ciyashop-auto-compalte-default ciyashop-empty"><ul class="ui-front ui-menu ui-widget ui-widget-content search_form-autocomplete"></ul></div>
		</form>		
	</div>
	<?php
	if( ( isset($ciyashop_options['show_search_keywords']) && $ciyashop_options['show_search_keywords'] ) && $ciyashop_options['header_type'] != 'default' && $ciyashop_options['search_content_type'] == 'product' ){
		if(!empty($ciyashop_options['search_keywords_title']) && !empty($ciyashop_options['search_keywords'])){	
			
			$category_ids = $ciyashop_options['search_keywords'];
			$product_categories = $terms = get_terms( 'product_cat', array(
				'include' => $category_ids,
				'orderby' => 'include',
			) );
			
			if ( !is_wp_error( $product_categories ) ) {
				?>
				<div class="search_form-keywords-wrap">
					<div class="search_form-keywords-title">
						<?php echo esc_html($ciyashop_options['search_keywords_title']);?>
					</div>
					<div class="search_form-keywords">
						<ul class="search_form-keywords-list">
						<?php 
						foreach($product_categories as $product_category){
							?>
							<li class="search_form-keyword-single">
								<a href="<?php echo esc_url(get_term_link($product_category -> term_id))?>" class="search-keyword" ><?php echo esc_html($product_category -> name);?></a>
							</li>
							<?php
						}
						?>
						</ul>
					</div>
				</div>
				<?php
			}
		}
	}
	?>
</div>