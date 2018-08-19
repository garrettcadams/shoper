<?php
//display loader
function ciyashop_preloader(){
	
	do_action( 'ciyashop_before_preloader' );
		
	get_template_part( 'template-parts/preloader/default' );
	
	do_action( 'ciyashop_after_preloader' );
}

function ciyashop_header_style_settings(){
	global $ciyashop_options;
	
	$ciyashop_header_type = ciyashop_header_type();
	
	if( $ciyashop_header_type == 'topbar-with-main-header' ){
		add_action( 'ciyashop_header_nav_content', 'ciyashop_header_nav_right_wrapper_start', 30 );
		add_action( 'ciyashop_header_nav_content', 'ciyashop_wootools', 31 );
		
		$show_search = ciyashop_show_search();
		if( $show_search ){
			add_action( 'ciyashop_header_nav_content', 'ciyashop_header_search_content', 32 );
		}
		add_action( 'ciyashop_header_nav_content', 'ciyashop_header_nav_right_wrapper_end', 33 );
		add_filter( 'ciyashop_site_title_class', 'ciyashop_topbar_with_main_header_title_class' );
	
	}elseif( $ciyashop_header_type == 'right-topbar-main' ){
		remove_action( 'ciyashop_before_header_nav_content', 'ciyashop_before_header_nav_content_wrapper_start', 10 );
		remove_action( 'ciyashop_after_header_nav_content', 'ciyashop_after_header_nav_content_wrapper_end', 10 );
	}
}

function ciyashop_header_nav_right_wrapper_start(){
	?>
	<div class="header-nav-right">
	<?php
}
function ciyashop_header_nav_right_wrapper_end(){
	?>
	</div>
	<?php
}

function ciyashop_logo(){
    global $ciyashop_options;
	
	$site_logo = ciyashop_logo_url();
	$logo_type = ciyashop_logo_type();
	$logo_text = ( isset($ciyashop_options['logo_text']) && $ciyashop_options['logo_text'] != '' ) ? $ciyashop_options['logo_text'] : false;

    if( $logo_type == 'image' && $site_logo !='' ){
		?>
		<img class="img-fluid" src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
		<?php
	}elseif( $logo_type == 'text' && $logo_text ){
		?>
		<span class="logo-text"><?php echo esc_html($logo_text);?></span>
		<?php
	}else{
		?>
		<span class="logo-text"><?php bloginfo( 'name' ); ?></span>
		<?php
	}
}

function ciyashop_sticky_logo(){
    global $ciyashop_options;
	
	$site_logo = ciyashop_sticky_logo_url();
	$logo_type = ciyashop_logo_type();
	$logo_text = ( isset($ciyashop_options['logo_text']) && $ciyashop_options['logo_text'] != '' ) ? $ciyashop_options['logo_text'] : false;

    if( $logo_type == 'image' && $site_logo !='' ){
		?>
		<img class="img-fluid" src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
		<?php
	}elseif( $logo_type == 'text' && $logo_text ){
		?>
		<span class="logo-text"><?php echo esc_html($logo_text);?></span>
		<?php
	}else{
		?>
		<span class="logo-text"><?php bloginfo( 'name' ); ?></span>
		<?php
	}
}

function ciyashop_sticky_nav(){
	get_template_part( 'template-parts/header/header-elements/sticky-nav' );
}

function ciyashop_site_description(){
	global $ciyashop_options;
	
	$description = get_bloginfo( 'description', 'display' );
	$site_description = isset($ciyashop_options['site_description']) ? $ciyashop_options['site_description'] : false;
	
	if ( ( $site_description && $description) || is_customize_preview() ) {
		?>
		<p class="site-description"><?php echo esc_attr($description); /* WPCS: xss ok. */ ?></p>
		<?php
	}
}

function ciyashop_before_header_nav_content_wrapper_start(){
	?>
	<div class="container">
		<div class="row">
			<?php
			if ( has_nav_menu( 'categories_menu' ) && ciyashop_categories_menu_status() == 'enable' ) {
				?>
				<div class="col-lg-3 col-md-3 col-sm-3 category-col">
				<?php
			}else{
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 navigation-col">
				<?php
			}
}

function ciyashop_category_menu(){
	if ( has_nav_menu( 'categories_menu' ) && ciyashop_categories_menu_status() == 'enable' ) {
		?>
		<div class="category-nav">
		
			<?php do_action( 'ciyashop_before_category_menu_wrapper' );?>
			
			<div class="category-nav-wrapper">
				<div class="category-nav-title">
					<i class="fa fa-bars"></i> <?php esc_html_e('Categories', 'ciyashop' );?> <span class="arrow"><i class="fa fa-angle-down fa-indicator"></i></span>
				</div>
				<div class="category-nav-content">
					<?php
					do_action( 'ciyashop_before_category_menu' );
					
					get_template_part( 'template-parts/header/header-elements/categories-menu' );
					
					do_action( 'ciyashop_after_category_menu' );
					?>
				</div>
			</div>
			
			<?php do_action( 'ciyashop_after_category_menu_wrapper' );?>
			
		</div>
		<?php
	}
}
function ciyashop_catmenu_primenu_separator(){
	if ( has_nav_menu( 'categories_menu' ) && ciyashop_categories_menu_status() == 'enable' ) {
		?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 navigation-col">
		<?php
	}
}

function ciyashop_primary_menu(){
	?>
	<div class="primary-nav">
		
		<?php do_action( 'ciyashop_before_primary_menu_wrapper' );?>
		
		<div class="primary-nav-wrapper">
			<?php
			do_action( 'ciyashop_before_primary_menu' );
			
			get_template_part( 'template-parts/header/header-elements/primary-menu' );
			
			do_action( 'ciyashop_before_primary_menu' );
			?>
		</div>
		
		<?php do_action( 'ciyashop_after_primary_menu_wrapper' );?>
		
	</div>
	<?php
}

function ciyashop_after_header_nav_content_wrapper_end(){
	?>
			</div>
		</div>
	</div>
	<?php
}

function ciyashop_topbar_with_main_header_title_class( $site_title_class ){
	return $site_title_class.' text-center';
}

function ciyashop_wootools(){
	get_template_part( 'template-parts/header/header-elements/woo-tools' );
}

function ciyashop_header_wootools_cart(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_header_cart']) && $ciyashop_options['show_header_cart'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-cart' );
	}
}

function ciyashop_header_wootools_compare(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_header_compare']) && $ciyashop_options['show_header_compare'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-compare' );
	}
}

function ciyashop_header_wootools_wishlist(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_header_wishlist']) && $ciyashop_options['show_header_wishlist'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-wishlist' );
	}
}

function ciyashop_sticky_wootools(){
	get_template_part( 'template-parts/header/header-elements/sticky-woo-tools' );
}

function ciyashop_sticky_header_wootools_cart(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_sticky_header_cart']) && $ciyashop_options['show_sticky_header_cart'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-cart' );
	}
}

function ciyashop_sticky_header_wootools_compare(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_sticky_header_compare']) && $ciyashop_options['show_sticky_header_compare'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-compare' );
	}
}

function ciyashop_sticky_header_wootools_wishlist(){
	global $ciyashop_options;
	
	if( isset($ciyashop_options['show_sticky_header_wishlist']) && $ciyashop_options['show_sticky_header_wishlist'] ){
		get_template_part( 'template-parts/header/header-elements/woo-tools-wishlist' );
	}
}


function ciyashop_sticky_footer_mobile_home(){
	get_template_part( 'template-parts/footer/sticky-footer-elements/sticky_footer-home' );
}

function ciyashop_sticky_footer_mobile_wishlist(){
	get_template_part( 'template-parts/footer/sticky-footer-elements/sticky_footer-wishlist' );
}

function ciyashop_sticky_footer_mobile_account(){
	get_template_part( 'template-parts/footer/sticky-footer-elements/sticky_footer-account' );
}

function ciyashop_sticky_footer_mobile_cart(){
	get_template_part( 'template-parts/footer/sticky-footer-elements/sticky_footer-cart' );
}



function ciyashop_search_form(){
	get_template_part( 'template-parts/header/header-elements/search-form' );
}

function ciyashop_header_search_content(){
	$ciyashop_header_type = ciyashop_header_type();
	
	if( $ciyashop_header_type == 'default' ){
		get_template_part( 'template-parts/header/header-elements/search-form' );
	}else{
		get_template_part( 'template-parts/header/header-elements/search-button' );
		add_action( 'wp_footer', 'ciyashop_search_popup' );
	}
}

function ciyashop_search_popup(){
	?>
	<div id="search_popup" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-content-inner">
					
					<?php do_action( 'ciyashop_before_search_popup_content' ); ?>
					
					<?php
					/**
					 * Functions hooked into ciyashop_search_popup_content action
					 *
					 * @hooked ciyashop_search_form                  - 10
					 */
					do_action( 'ciyashop_search_popup_content' ); ?>
					
					<?php do_action( 'ciyashop_after_search_popup_content' ); ?>
					
				</div>
			</div>
		</div>
	</div>
	<?php
}

function ciyashop_page_header(){
	if( !is_front_page() ){
		get_template_part('template-parts/page-header');
	}
}

function ciyashop_footer_main(){
	get_template_part('template-parts/footer/footer');
}

function ciyashop_bak_to_top(){
	global $ciyashop_options;
	
	$back_to_top       = isset($ciyashop_options['back_to_top'])        ? $ciyashop_options['back_to_top']        : true;
	$back_to_top_mobile= isset($ciyashop_options['back_to_top_mobile']) ? $ciyashop_options['back_to_top_mobile'] : true;
	
	if ( function_exists('wp_is_mobile') &&  wp_is_mobile() && $back_to_top_mobile){?>
		<div id="back-to-top">
			<a class="top arrow" href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
		<?php
	}elseif( function_exists('wp_is_mobile') &&  !wp_is_mobile() && $back_to_top){
		?>
		<div id="back-to-top">
			<a class="top arrow" href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
		<?php
	}
}

function ciyashop_cookie_notice(){
	get_template_part('template-parts/footer/cookies_info');
}

if ( ! function_exists( 'ciyashop_display_comments' ) ) {
	/**
	 * CiyaShop display comments
	 *
	 * @since  1.0.0
	 */
	function ciyashop_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
		comments_template();
		endif;
	}
}

function ciyashop_login_form(){
	get_template_part('woocommerce/custom/login-form');// popup login form
}

function ciyashop_show_header(){
	$page_id = get_the_ID();
	
	if( function_exists('is_shop') && is_shop() ) {
		$page_id = get_option( 'woocommerce_shop_page_id' );
	}elseif( is_home() && get_option('page_for_posts') ) {
		$page_id = get_option( 'page_for_posts' );
	}elseif( is_search() ) {
		$page_id = 0;
	}
	
	$show_header = get_post_meta( $page_id, 'show_header', true );
	
	$show_header = apply_filters( 'ciyashop_show_header', $show_header, $page_id );
	
	if ( $show_header == '' ) {
		$show_header = 1;
	}
	
	return $show_header;
}

function ciyashop_primary_nav_menu(){
	if( has_nav_menu('primary') ){
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_class'     => 'menu primary-menu',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'container_id'   => 'menu-wrap-primary',
			'container_class'=> 'menu-wrap',
		) );
	}else{
		wp_page_menu( array(
			'theme_location'=> 'primary',
			'menu_id'       => false,
			'menu_class'    => 'menu primary-menu',
			'container'     => 'div',
			'before'        => '<ul id="primary-menu" class="menu primary-menu nav-menu">',
			'after'         => '</ul>',
			'walker'       => new CiyaShop_Page_Nav_Walker() // use Walker here
		) );
	}
}

/**
 * Get full list of currency codes.
 *
 * @return array
 */
function ciyashop_get_currencies() {
	return array_unique(
		apply_filters( 'ciyashop_currencies',
			array(
				'AED' => esc_html__( 'United Arab Emirates dirham', 'ciyashop' ),
				'AFN' => esc_html__( 'Afghan afghani', 'ciyashop' ),
				'ALL' => esc_html__( 'Albanian lek', 'ciyashop' ),
				'AMD' => esc_html__( 'Armenian dram', 'ciyashop' ),
				'ANG' => esc_html__( 'Netherlands Antillean guilder', 'ciyashop' ),
				'AOA' => esc_html__( 'Angolan kwanza', 'ciyashop' ),
				'ARS' => esc_html__( 'Argentine peso', 'ciyashop' ),
				'AUD' => esc_html__( 'Australian dollar', 'ciyashop' ),
				'AWG' => esc_html__( 'Aruban florin', 'ciyashop' ),
				'AZN' => esc_html__( 'Azerbaijani manat', 'ciyashop' ),
				'BAM' => esc_html__( 'Bosnia and Herzegovina convertible mark', 'ciyashop' ),
				'BBD' => esc_html__( 'Barbadian dollar', 'ciyashop' ),
				'BDT' => esc_html__( 'Bangladeshi taka', 'ciyashop' ),
				'BGN' => esc_html__( 'Bulgarian lev', 'ciyashop' ),
				'BHD' => esc_html__( 'Bahraini dinar', 'ciyashop' ),
				'BIF' => esc_html__( 'Burundian franc', 'ciyashop' ),
				'BMD' => esc_html__( 'Bermudian dollar', 'ciyashop' ),
				'BND' => esc_html__( 'Brunei dollar', 'ciyashop' ),
				'BOB' => esc_html__( 'Bolivian boliviano', 'ciyashop' ),
				'BRL' => esc_html__( 'Brazilian real', 'ciyashop' ),
				'BSD' => esc_html__( 'Bahamian dollar', 'ciyashop' ),
				'BTC' => esc_html__( 'Bitcoin', 'ciyashop' ),
				'BTN' => esc_html__( 'Bhutanese ngultrum', 'ciyashop' ),
				'BWP' => esc_html__( 'Botswana pula', 'ciyashop' ),
				'BYR' => esc_html__( 'Belarusian ruble', 'ciyashop' ),
				'BZD' => esc_html__( 'Belize dollar', 'ciyashop' ),
				'CAD' => esc_html__( 'Canadian dollar', 'ciyashop' ),
				'CDF' => esc_html__( 'Congolese franc', 'ciyashop' ),
				'CHF' => esc_html__( 'Swiss franc', 'ciyashop' ),
				'CLP' => esc_html__( 'Chilean peso', 'ciyashop' ),
				'CNY' => esc_html__( 'Chinese yuan', 'ciyashop' ),
				'COP' => esc_html__( 'Colombian peso', 'ciyashop' ),
				'CRC' => esc_html__( 'Costa Rican col&oacute;n', 'ciyashop' ),
				'CUC' => esc_html__( 'Cuban convertible peso', 'ciyashop' ),
				'CUP' => esc_html__( 'Cuban peso', 'ciyashop' ),
				'CVE' => esc_html__( 'Cape Verdean escudo', 'ciyashop' ),
				'CZK' => esc_html__( 'Czech koruna', 'ciyashop' ),
				'DJF' => esc_html__( 'Djiboutian franc', 'ciyashop' ),
				'DKK' => esc_html__( 'Danish krone', 'ciyashop' ),
				'DOP' => esc_html__( 'Dominican peso', 'ciyashop' ),
				'DZD' => esc_html__( 'Algerian dinar', 'ciyashop' ),
				'EGP' => esc_html__( 'Egyptian pound', 'ciyashop' ),
				'ERN' => esc_html__( 'Eritrean nakfa', 'ciyashop' ),
				'ETB' => esc_html__( 'Ethiopian birr', 'ciyashop' ),
				'EUR' => esc_html__( 'Euro', 'ciyashop' ),
				'FJD' => esc_html__( 'Fijian dollar', 'ciyashop' ),
				'FKP' => esc_html__( 'Falkland Islands pound', 'ciyashop' ),
				'GBP' => esc_html__( 'Pound sterling', 'ciyashop' ),
				'GEL' => esc_html__( 'Georgian lari', 'ciyashop' ),
				'GGP' => esc_html__( 'Guernsey pound', 'ciyashop' ),
				'GHS' => esc_html__( 'Ghana cedi', 'ciyashop' ),
				'GIP' => esc_html__( 'Gibraltar pound', 'ciyashop' ),
				'GMD' => esc_html__( 'Gambian dalasi', 'ciyashop' ),
				'GNF' => esc_html__( 'Guinean franc', 'ciyashop' ),
				'GTQ' => esc_html__( 'Guatemalan quetzal', 'ciyashop' ),
				'GYD' => esc_html__( 'Guyanese dollar', 'ciyashop' ),
				'HKD' => esc_html__( 'Hong Kong dollar', 'ciyashop' ),
				'HNL' => esc_html__( 'Honduran lempira', 'ciyashop' ),
				'HRK' => esc_html__( 'Croatian kuna', 'ciyashop' ),
				'HTG' => esc_html__( 'Haitian gourde', 'ciyashop' ),
				'HUF' => esc_html__( 'Hungarian forint', 'ciyashop' ),
				'IDR' => esc_html__( 'Indonesian rupiah', 'ciyashop' ),
				'ILS' => esc_html__( 'Israeli new shekel', 'ciyashop' ),
				'IMP' => esc_html__( 'Manx pound', 'ciyashop' ),
				'INR' => esc_html__( 'Indian rupee', 'ciyashop' ),
				'IQD' => esc_html__( 'Iraqi dinar', 'ciyashop' ),
				'IRR' => esc_html__( 'Iranian rial', 'ciyashop' ),
				'IRT' => esc_html__( 'Iranian toman', 'ciyashop' ),
				'ISK' => esc_html__( 'Icelandic kr&oacute;na', 'ciyashop' ),
				'JEP' => esc_html__( 'Jersey pound', 'ciyashop' ),
				'JMD' => esc_html__( 'Jamaican dollar', 'ciyashop' ),
				'JOD' => esc_html__( 'Jordanian dinar', 'ciyashop' ),
				'JPY' => esc_html__( 'Japanese yen', 'ciyashop' ),
				'KES' => esc_html__( 'Kenyan shilling', 'ciyashop' ),
				'KGS' => esc_html__( 'Kyrgyzstani som', 'ciyashop' ),
				'KHR' => esc_html__( 'Cambodian riel', 'ciyashop' ),
				'KMF' => esc_html__( 'Comorian franc', 'ciyashop' ),
				'KPW' => esc_html__( 'North Korean won', 'ciyashop' ),
				'KRW' => esc_html__( 'South Korean won', 'ciyashop' ),
				'KWD' => esc_html__( 'Kuwaiti dinar', 'ciyashop' ),
				'KYD' => esc_html__( 'Cayman Islands dollar', 'ciyashop' ),
				'KZT' => esc_html__( 'Kazakhstani tenge', 'ciyashop' ),
				'LAK' => esc_html__( 'Lao kip', 'ciyashop' ),
				'LBP' => esc_html__( 'Lebanese pound', 'ciyashop' ),
				'LKR' => esc_html__( 'Sri Lankan rupee', 'ciyashop' ),
				'LRD' => esc_html__( 'Liberian dollar', 'ciyashop' ),
				'LSL' => esc_html__( 'Lesotho loti', 'ciyashop' ),
				'LYD' => esc_html__( 'Libyan dinar', 'ciyashop' ),
				'MAD' => esc_html__( 'Moroccan dirham', 'ciyashop' ),
				'MDL' => esc_html__( 'Moldovan leu', 'ciyashop' ),
				'MGA' => esc_html__( 'Malagasy ariary', 'ciyashop' ),
				'MKD' => esc_html__( 'Macedonian denar', 'ciyashop' ),
				'MMK' => esc_html__( 'Burmese kyat', 'ciyashop' ),
				'MNT' => esc_html__( 'Mongolian t&ouml;gr&ouml;g', 'ciyashop' ),
				'MOP' => esc_html__( 'Macanese pataca', 'ciyashop' ),
				'MRO' => esc_html__( 'Mauritanian ouguiya', 'ciyashop' ),
				'MUR' => esc_html__( 'Mauritian rupee', 'ciyashop' ),
				'MVR' => esc_html__( 'Maldivian rufiyaa', 'ciyashop' ),
				'MWK' => esc_html__( 'Malawian kwacha', 'ciyashop' ),
				'MXN' => esc_html__( 'Mexican peso', 'ciyashop' ),
				'MYR' => esc_html__( 'Malaysian ringgit', 'ciyashop' ),
				'MZN' => esc_html__( 'Mozambican metical', 'ciyashop' ),
				'NAD' => esc_html__( 'Namibian dollar', 'ciyashop' ),
				'NGN' => esc_html__( 'Nigerian naira', 'ciyashop' ),
				'NIO' => esc_html__( 'Nicaraguan c&oacute;rdoba', 'ciyashop' ),
				'NOK' => esc_html__( 'Norwegian krone', 'ciyashop' ),
				'NPR' => esc_html__( 'Nepalese rupee', 'ciyashop' ),
				'NZD' => esc_html__( 'New Zealand dollar', 'ciyashop' ),
				'OMR' => esc_html__( 'Omani rial', 'ciyashop' ),
				'PAB' => esc_html__( 'Panamanian balboa', 'ciyashop' ),
				'PEN' => esc_html__( 'Peruvian nuevo sol', 'ciyashop' ),
				'PGK' => esc_html__( 'Papua New Guinean kina', 'ciyashop' ),
				'PHP' => esc_html__( 'Philippine peso', 'ciyashop' ),
				'PKR' => esc_html__( 'Pakistani rupee', 'ciyashop' ),
				'PLN' => esc_html__( 'Polish z&#322;oty', 'ciyashop' ),
				'PRB' => esc_html__( 'Transnistrian ruble', 'ciyashop' ),
				'PYG' => esc_html__( 'Paraguayan guaran&iacute;', 'ciyashop' ),
				'QAR' => esc_html__( 'Qatari riyal', 'ciyashop' ),
				'RON' => esc_html__( 'Romanian leu', 'ciyashop' ),
				'RSD' => esc_html__( 'Serbian dinar', 'ciyashop' ),
				'RUB' => esc_html__( 'Russian ruble', 'ciyashop' ),
				'RWF' => esc_html__( 'Rwandan franc', 'ciyashop' ),
				'SAR' => esc_html__( 'Saudi riyal', 'ciyashop' ),
				'SBD' => esc_html__( 'Solomon Islands dollar', 'ciyashop' ),
				'SCR' => esc_html__( 'Seychellois rupee', 'ciyashop' ),
				'SDG' => esc_html__( 'Sudanese pound', 'ciyashop' ),
				'SEK' => esc_html__( 'Swedish krona', 'ciyashop' ),
				'SGD' => esc_html__( 'Singapore dollar', 'ciyashop' ),
				'SHP' => esc_html__( 'Saint Helena pound', 'ciyashop' ),
				'SLL' => esc_html__( 'Sierra Leonean leone', 'ciyashop' ),
				'SOS' => esc_html__( 'Somali shilling', 'ciyashop' ),
				'SRD' => esc_html__( 'Surinamese dollar', 'ciyashop' ),
				'SSP' => esc_html__( 'South Sudanese pound', 'ciyashop' ),
				'STD' => esc_html__( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'ciyashop' ),
				'SYP' => esc_html__( 'Syrian pound', 'ciyashop' ),
				'SZL' => esc_html__( 'Swazi lilangeni', 'ciyashop' ),
				'THB' => esc_html__( 'Thai baht', 'ciyashop' ),
				'TJS' => esc_html__( 'Tajikistani somoni', 'ciyashop' ),
				'TMT' => esc_html__( 'Turkmenistan manat', 'ciyashop' ),
				'TND' => esc_html__( 'Tunisian dinar', 'ciyashop' ),
				'TOP' => esc_html__( 'Tongan pa&#699;anga', 'ciyashop' ),
				'TRY' => esc_html__( 'Turkish lira', 'ciyashop' ),
				'TTD' => esc_html__( 'Trinidad and Tobago dollar', 'ciyashop' ),
				'TWD' => esc_html__( 'New Taiwan dollar', 'ciyashop' ),
				'TZS' => esc_html__( 'Tanzanian shilling', 'ciyashop' ),
				'UAH' => esc_html__( 'Ukrainian hryvnia', 'ciyashop' ),
				'UGX' => esc_html__( 'Ugandan shilling', 'ciyashop' ),
				'USD' => esc_html__( 'United States dollar', 'ciyashop' ),
				'UYU' => esc_html__( 'Uruguayan peso', 'ciyashop' ),
				'UZS' => esc_html__( 'Uzbekistani som', 'ciyashop' ),
				'VEF' => esc_html__( 'Venezuelan bol&iacute;var', 'ciyashop' ),
				'VND' => esc_html__( 'Vietnamese &#273;&#7891;ng', 'ciyashop' ),
				'VUV' => esc_html__( 'Vanuatu vatu', 'ciyashop' ),
				'WST' => esc_html__( 'Samoan t&#257;l&#257;', 'ciyashop' ),
				'XAF' => esc_html__( 'Central African CFA franc', 'ciyashop' ),
				'XCD' => esc_html__( 'East Caribbean dollar', 'ciyashop' ),
				'XOF' => esc_html__( 'West African CFA franc', 'ciyashop' ),
				'XPF' => esc_html__( 'CFP franc', 'ciyashop' ),
				'YER' => esc_html__( 'Yemeni rial', 'ciyashop' ),
				'ZAR' => esc_html__( 'South African rand', 'ciyashop' ),
				'ZMW' => esc_html__( 'Zambian kwacha', 'ciyashop' ),
			)
		)
	);
}

/**
 * Get Currency symbol.
 *
 * @param string $currency (default: '')
 * @return string
 */
function ciyashop_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = 'USD';
	}

	$symbols = apply_filters( 'ciyashop_currency_symbols', array(
		'AED' => '&#x62f;.&#x625;',
		'AFN' => '&#x60b;',
		'ALL' => 'L',
		'AMD' => 'AMD',
		'ANG' => '&fnof;',
		'AOA' => 'Kz',
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => 'Afl.',
		'AZN' => 'AZN',
		'BAM' => 'KM',
		'BBD' => '&#36;',
		'BDT' => '&#2547;&nbsp;',
		'BGN' => '&#1083;&#1074;.',
		'BHD' => '.&#x62f;.&#x628;',
		'BIF' => 'Fr',
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => 'Bs.',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTC' => '&#3647;',
		'BTN' => 'Nu.',
		'BWP' => 'P',
		'BYR' => 'Br',
		'BZD' => '&#36;',
		'CAD' => '&#36;',
		'CDF' => 'Fr',
		'CHF' => '&#67;&#72;&#70;',
		'CLP' => '&#36;',
		'CNY' => '&yen;',
		'COP' => '&#36;',
		'CRC' => '&#x20a1;',
		'CUC' => '&#36;',
		'CUP' => '&#36;',
		'CVE' => '&#36;',
		'CZK' => '&#75;&#269;',
		'DJF' => 'Fr',
		'DKK' => 'DKK',
		'DOP' => 'RD&#36;',
		'DZD' => '&#x62f;.&#x62c;',
		'EGP' => 'EGP',
		'ERN' => 'Nfk',
		'ETB' => 'Br',
		'EUR' => '&euro;',
		'FJD' => '&#36;',
		'FKP' => '&pound;',
		'GBP' => '&pound;',
		'GEL' => '&#x10da;',
		'GGP' => '&pound;',
		'GHS' => '&#x20b5;',
		'GIP' => '&pound;',
		'GMD' => 'D',
		'GNF' => 'Fr',
		'GTQ' => 'Q',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => 'L',
		'HRK' => 'Kn',
		'HTG' => 'G',
		'HUF' => '&#70;&#116;',
		'IDR' => 'Rp',
		'ILS' => '&#8362;',
		'IMP' => '&pound;',
		'INR' => '&#8377;',
		'IQD' => '&#x639;.&#x62f;',
		'IRR' => '&#xfdfc;',
		'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
		'ISK' => 'kr.',
		'JEP' => '&pound;',
		'JMD' => '&#36;',
		'JOD' => '&#x62f;.&#x627;',
		'JPY' => '&yen;',
		'KES' => 'KSh',
		'KGS' => '&#x441;&#x43e;&#x43c;',
		'KHR' => '&#x17db;',
		'KMF' => 'Fr',
		'KPW' => '&#x20a9;',
		'KRW' => '&#8361;',
		'KWD' => '&#x62f;.&#x643;',
		'KYD' => '&#36;',
		'KZT' => 'KZT',
		'LAK' => '&#8365;',
		'LBP' => '&#x644;.&#x644;',
		'LKR' => '&#xdbb;&#xdd4;',
		'LRD' => '&#36;',
		'LSL' => 'L',
		'LYD' => '&#x644;.&#x62f;',
		'MAD' => '&#x62f;.&#x645;.',
		'MDL' => 'MDL',
		'MGA' => 'Ar',
		'MKD' => '&#x434;&#x435;&#x43d;',
		'MMK' => 'Ks',
		'MNT' => '&#x20ae;',
		'MOP' => 'P',
		'MRO' => 'UM',
		'MUR' => '&#x20a8;',
		'MVR' => '.&#x783;',
		'MWK' => 'MK',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => 'MT',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => 'C&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#x631;.&#x639;.',
		'PAB' => 'B/.',
		'PEN' => 'S/.',
		'PGK' => 'K',
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PRB' => '&#x440;.',
		'PYG' => '&#8370;',
		'QAR' => '&#x631;.&#x642;',
		'RMB' => '&yen;',
		'RON' => 'lei',
		'RSD' => '&#x434;&#x438;&#x43d;.',
		'RUB' => '&#8381;',
		'RWF' => 'Fr',
		'SAR' => '&#x631;.&#x633;',
		'SBD' => '&#36;',
		'SCR' => '&#x20a8;',
		'SDG' => '&#x62c;.&#x633;.',
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&pound;',
		'SLL' => 'Le',
		'SOS' => 'Sh',
		'SRD' => '&#36;',
		'SSP' => '&pound;',
		'STD' => 'Db',
		'SYP' => '&#x644;.&#x633;',
		'SZL' => 'L',
		'THB' => '&#3647;',
		'TJS' => '&#x405;&#x41c;',
		'TMT' => 'm',
		'TND' => '&#x62f;.&#x62a;',
		'TOP' => 'T&#36;',
		'TRY' => '&#8378;',
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => 'Sh',
		'UAH' => '&#8372;',
		'UGX' => 'UGX',
		'USD' => '&#36;',
		'UYU' => '&#36;',
		'UZS' => 'UZS',
		'VEF' => 'Bs F',
		'VND' => '&#8363;',
		'VUV' => 'Vt',
		'WST' => 'T',
		'XAF' => 'Fr',
		'XCD' => '&#36;',
		'XOF' => 'Fr',
		'XPF' => 'Fr',
		'YER' => '&#xfdfc;',
		'ZAR' => '&#82;',
		'ZMW' => 'ZK',
	) );

	$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

	return apply_filters( 'ciyashop_currency_symbol', $currency_symbol, $currency );
}

// based on https://gist.github.com/cosmocatalano/4544576
function ciyashop_scrape_instagram( $username = '', $count = 9 ) {
	
	// bail early if no username provided
	if( $username == '' ) return false;
	
	$username = trim( strtolower( $username ) );

	switch ( substr( $username, 0, 1 ) ) {
		case '#':
			$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
			$transient_prefix = 'h';
			break;

		default:
			$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
			$transient_prefix = 'u';
			break;
	}
	
	$instagram_transient_key = 'instagram-032k18-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username );
	
	if ( WP_DEBUG || false === ( $instagram = get_transient( $instagram_transient_key ) ) ) {
		
		$remote = wp_remote_get( $url );
		
		if ( is_wp_error( $remote ) ) {
			return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'ciyashop' ) );
		}
		
		if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
			return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'ciyashop' ) );
		}
		
		$shards      = explode( 'window._sharedData = ', $remote['body'] );
		$insta_json  = explode( ';</script>', $shards[1] );
		$insta_array = json_decode( $insta_json[0], true );
		
		if ( ! $insta_array ) {
			return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'ciyashop' ) );
		}
		
		if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
		} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
			$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
		} else {
			return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'ciyashop' ) );
		}
		
		if ( ! is_array( $images ) ) {
			return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'ciyashop' ) );
		}
		
		$instagram = array();
		
		foreach ( $images as $image ) {
			if ( true === $image['node']['is_video'] ) {
				$type = 'video';
			} else {
				$type = 'image';
			}
			
			$caption = esc_html__( 'Instagram Image', 'ciyashop' );
			if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
				$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
			}
			
			$instagram[] = array(
				'description'=> $caption,
				'link'       => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
				'time'       => $image['node']['taken_at_timestamp'],
				'comments'   => $image['node']['edge_media_to_comment']['count'],
				'likes'      => $image['node']['edge_liked_by']['count'],
				'thumbnail'  => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
				'thumbnail_w'=> $image['node']['thumbnail_resources'][0]['config_width'],
				'thumbnail_h'=> $image['node']['thumbnail_resources'][0]['config_height'],
				
				'small'      => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
				'small_w'    => $image['node']['thumbnail_resources'][2]['config_width'],
				'small_h'    => $image['node']['thumbnail_resources'][2]['config_height'],
				
				'large'      => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
				'large_w'    => $image['node']['thumbnail_resources'][4]['config_width'],
				'large_h'    => $image['node']['thumbnail_resources'][4]['config_height'],
				
				'original'   => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
				'original_w' => $image['node']['dimensions']['width'],
				'original_h' => $image['node']['dimensions']['height'],
				'type'       => $type,
			);
		} // End foreach().
		
		// do not set an empty transient - should help catch private or empty accounts.
		if ( ! empty( $instagram ) ) {
			set_transient( $instagram_transient_key, $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
		}
	}

	if ( ! empty( $instagram ) ) {
		
		return array_slice( $instagram, 0, $count );

	} else {

		return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'ciyashop' ) );

	}
}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */
function ciyashop_get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}
	
	// Add full for fallback.
	$sizes['full'] = array();
	
	return $sizes;
}

function ciyashop_dynamic_image( $thumb_size = '', $thumb_size_w = '', $thumb_size_h = '', $color = '' ){
	
	// bail early if any data missing.
	if( $thumb_size == '' || $thumb_size_w == '' || $thumb_size_h == '' ) return false;
	
	if( is_array($thumb_size) ) $thumb_size = implode('-', $thumb_size);
	
	$img_key = trim( strtolower( "{$thumb_size}-{$thumb_size_w}-{$thumb_size_h}-{$color}" ) );
	$img_key = 'ciyashop-dynamic-img-' . sanitize_title_with_dashes($img_key);
	
	if ( WP_DEBUG || false === ( $image = get_transient($img_key) ) ) {
	
		// Create an image
		$im = imagecreate($thumb_size_w, $thumb_size_h);
		
		// White background and blue text
		$default_color = array(
			'r' => 254,
			'g' => 254,
			'b' => 254,
		);
		
		if( $color != '' && is_string($color) ){
			$color_hex2rgb = ciyashop_hex2rgb($color);
			if( $color_hex2rgb ){
				$color = $color_hex2rgb;
			}
		}else{
			$color = $default_color;
		}
		
		$bg = imagecolorallocate($im, $color['r'], $color['g'], $color['b']);
		
		ob_start();
		imagepng($im);
		$image = ob_get_clean();
		
		imagedestroy($im);
		
		// Include IXR_Base64 class
		if( !class_exists('IXR_Base64') ){
			require_once( ABSPATH . WPINC . '/IXR/class-IXR-base64.php' );
		}
		
		// prepare base64
		$image_base64 = new IXR_Base64($image);
		$image_xml = $image_base64->getXml();
		$image = str_replace( array('<base64>', '</base64>'), array('',''), $image_xml );
		$image = 'data:image/png;base64,'.$image;
		
		set_transient( $img_key, $image, apply_filters( 'ciyashop_dynamic_image_cache_time', HOUR_IN_SECONDS * 24 ) );
	}
	
	// return image
	return $image;
}

function ciyashop_layout_content( $field = '', $context = '' ){
	if( empty($field) ){
		return;
	}
	ob_start();
	get_template_part( 'template-parts/header/topbar-elements/'.$field, $context );
	return ob_get_clean();
}

function ciyashop_show_search(){
	
	global $ciyashop_options;
	
	$show_search = isset($ciyashop_options['show_search']) ? $ciyashop_options['show_search'] : true;
	
	$show_search = apply_filters( 'ciyashop_show_search', $show_search, $ciyashop_options );
	
	return $show_search;
	
}