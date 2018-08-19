<?php
global $ciyashop_options;

do_action( 'faq_layout_1_init' );

if( !ciyashop_check_plugin_active('pgs-core/pgs-core.php') ){
	return;
}

$faq_page_tabs_data = $faq_categories = $faq_categories_selected = array();

$faq_page_query_base = array(
	'post_type'      => 'faqs',
	'posts_per_page' => -1
);

$layout_1_cat_source = 'all';

$layout_1_cat_source_option = $ciyashop_options['layout_1_cat_source'];
if( !empty($layout_1_cat_source_option) ){
	$layout_1_cat_source = $layout_1_cat_source_option;
}

$faq_categories_all = get_terms( array(
	'taxonomy'  => 'faq-category',
	'hide_empty'=> true,
	'fields'    => 'ids',
));

if( $layout_1_cat_source != 'all' ){
	$layout_1_categories_option = $ciyashop_options['layout_1_categories'];
	
	// Update Query
	if( is_array($layout_1_categories_option) && !empty($layout_1_categories_option) ){
		$faq_categories_selected = $layout_1_categories_option;
	}
}

$faq_categories = ( $layout_1_cat_source == 'all' ? $faq_categories_all : $faq_categories_selected );

$faq_page_query_all_tab_taxquery = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'faq-category',
			'field'    => 'term_id',
			'terms'    => $faq_categories,
		),
	)
);

$faq_page_tabs_data_all_tab_query = array_merge($faq_page_query_base, $faq_page_query_all_tab_taxquery);
$faq_page_tabs_data[] = array(
	'slug'  => 'all',
	'title' => 'All',
	'query' => $faq_page_tabs_data_all_tab_query,
);

$faq_page_query_term_taxquery = array();
foreach( $faq_categories as $faq_category ){
	$faq_category_data = get_term_by( 'id', $faq_category, 'faq-category' );
	
	$faq_page_query_term_taxquery = array(
		'tax_query' => array(
			array(
				'taxonomy' => 'faq-category',
				'field'    => 'term_id',
				'terms'    => array($faq_category_data->term_id),
			),
		)
	);
	
	$faq_page_tabs_data[] = array(
		'slug'  => 'term_'.$faq_category_data->term_id,
		'title' => $faq_category_data->name,
		'query' => array_merge($faq_page_query_base, $faq_page_query_term_taxquery)
	);
}
?>
<div id="tabs" class="tabs_wrapper">
	<ul class="tabs">
		<?php
		$faq_page_query_tab_sr = 1;
		foreach( $faq_page_tabs_data as $faq_page_query ){
			?>
			<li data-tabs="tab_<?php echo esc_attr($faq_page_query['slug']);?>" class="<?php echo esc_attr( $faq_page_query_tab_sr == 1 ? 'active' : '' );?>"><?php echo esc_html($faq_page_query['title']);?></li>
			<?php
			$faq_page_query_tab_sr++;
		}
		?>
	</ul>
	<?php
	$faq_page_query_tab_content_sr = 1;
	foreach( $faq_page_tabs_data as $faq_page_query ){
		?>
		<div id="tab_<?php echo esc_attr($faq_page_query['slug']);?>" class="tabcontent <?php echo esc_attr( $faq_page_query_tab_content_sr == 1 ? 'active' : '' );?>">
			<?php
			query_posts( $faq_page_query['query'] );
			if ( have_posts() ) {
				?>
				<div class="accordion">
					<?php
					while ( have_posts() ) {
						the_post();
						?>
						<div class="accordion-title">
							<a href="#"><?php the_title(); ?></a>
						</div>
						<div class="accordion-content"> 
							<?php the_content(); ?>							
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			wp_reset_query();
			?>
		</div>
		<?php
		$faq_page_query_tab_content_sr++;
	}
	?>
</div>