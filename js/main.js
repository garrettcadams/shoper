/*================================================
[  Table of contents  ]
================================================
Window -> Load
:: Preloader
:: Owl Carousel
:: WooCommerce Promo Popup

Document -> Ready
:: One Page Menu
:: Auto complate Search
:: Magnific Popup
:: Sticky Menu
:: Select 2
:: SlickNav
:: Mobile Buttons
:: Inline Hover
:: WooCommerce
	:: Cookies info
	:: WooCommerce Quick View
	:: WooCommerce - Woo Tools - Cart (Header)
	:: WooCommerce - Woo Tools - Compare (Header)
	:: Single Page Sticky Content
	:: WooCommerce Gallery
	:: Product Type - Sticky Gallery
	:: WooCommerce - Quantity Input
	:: WooCommerce Product Details - Related Products
	:: WooCommerce Product Details - Up Sell Products
	:: WooCommerce Product Grid/List Switch
	:: WooCommerce Shop Filters
	:: WooCommerce Video Popup
:: Blog
	:: Blog Gallery Slick Slider
	:: Blog - Masonry
	:: Blog Load More
:: Tabs
:: Accordion
:: Back to top
:: Commingsoon countdown
:: Social Sharing option for blog
:: Call youtube and vimeo video function
:: Shortcodes
	:: Slick-slider for testimonials shortcode
	:: Hot Deal / Banner (Deal)
	:: Newsletter Mailchimp
	:: PGSCore : Banner
	:: Multi Tab Product Listing - Carousel
	:: Image Slider : Popup
	:: Vertical Menu : SlickNav Menu
======================================
[ End table content ]
======================================*/
(function($){
	"use strict";

	jQuery( window ).load(function() {

		/*************************
		:: Preloader
		*************************/

		jQuery("#load").fadeOut();
		jQuery('#preloader').delay(200).fadeOut('slow');

		/*************************
		:: Owl Carousel
		*************************/

		$(".owl-carousel.owl-carousel-options").each(function () {
			var $carousel = $(this),
				$carousel_option = ( $carousel.attr('data-owl_options')) ? $carousel.data('owl_options') : {};
				$carousel_option.navElement = 'div';
				$carousel_option.rtl = (jQuery( "body" ).hasClass( "rtl" )) ? true : false;

			$(this).owlCarousel($carousel_option);
		});
		
	});

	jQuery( document ).ready(function() {
		
		/* ---------------------------------------------
		 :: WooCommerce Promo Popup
		 --------------------------------------------- */

		setTimeout(function() {
			ciyashop_promopopup();
		},1000);

		function ciyashop_promopopup(){
			if( Cookies.get('woocommerce_popup') == 'shown' ) {
				return;
			}

			if( $(window).width() >= 768 && ciyashop_l10n.main_promopopup == 0 ) { // Check desktop
				return;
			}else if( $(window).width() < 768 && ciyashop_l10n.promopopup_hide_mobile == 1 ){ // Check mobile
				return;
			}
			
			$.magnificPopup.open({
				items: {
					src: '.ciyashop-promo-popup',
					type: 'inline',
				},
				removalDelay: 400, //delay removal by X to allow out-animation
				callbacks: {
					beforeOpen: function() {
						this.st.mainClass = 'ciyashop-popup-effect';
					},
					open: function() {
					},
					close: function() {
						
						var promo_popup_checked= $( "input[id='hide_promo_popup']:checked" ).length;
						var hide_promo_popup= $('#hide_promo_popup').length;
						
						if( hide_promo_popup ){
							if( promo_popup_checked ){
								Cookies.set('woocommerce_popup', 'shown', { expires: 7, path: '/' } );
							}
						}else{
							Cookies.set('woocommerce_popup', 'shown', { expires: 7, path: '/' } );
						}
					}
				}
			});
		}

		/*************************
		:: One page Menu
		*************************/

		var primary_menu = $('#primary-menu');
		if(primary_menu.length > 0){

			var current_url = window.location.href;
			var firstanurl = $('#primary-menu').find('a').first().attr('href');
			var anurl = firstanurl.split('#');
			var curl =  current_url.split('#')

			if(curl[1]){
				if(document.querySelector('#'+curl[1]) != null){
					document.querySelector('#'+curl[1]).scrollIntoView();
				}
			}

			$('ul#primary-menu li a').each(function(){
				this.addEventListener('click', one_navigation);
			});

			//First anchor set as active for one page
			if( anurl[0]+'/' == curl[0] ){
				$('ul#primary-menu li').each(function(){
					$( this ).removeClass( "current-menu-item" );
				});
				$('#primary-menu').find('li').first().addClass('current-menu-item');
			}

			$(document).on("scroll", onScroll);
		}

		/*************************
		:: Auto complate Search
		*************************/

		$( "input.search-form" ).each(function() {
			jQuery( this ).autocomplete({
				search: function(event, ui) {
					jQuery('.ciyashop-auto-compalte-default ul').empty();
                                        jQuery('.ciyashop-auto-compalte-default').addClass('ciyashop-empty');
				},
				source: function( request, response ) {
					var search_category = this.element.parents('div.search_form-input-wrap').prev().children().val();
					var search_keyword = this.element.val();
					var search_loader = this.element.parents('div.search_form-search-field');
					jQuery.ajax({
						url: ciyashop_l10n.ajax_url,
						type: 'POST',
						dataType: "json",
						data: {'action': 'ciyashop_auto_complete_search' , 'search_keyword' : search_keyword, 'search_category' : search_category},
						beforeSend: function(){
							search_loader.addClass('ui-autocomplete-loader');
						},
						success: function( resp ) {
							response( jQuery.map( resp, function( result ) {
								var return_data = {
									image: result.post_img,
									title: result.post_title,
									link: result.post_link
								};
								return return_data;
							}));
						}
					}).done( function(){
						search_loader.removeClass('ui-autocomplete-loader');
					});
				},
				minLength: 2,
			}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                                ul.remove();
				var html = '';
				html += '<a href="'+item.link+'">';
				html += '<div class="search-item-container">';
				if(item.image){
					html += item.image;
				}
				html += item.title;
				html += '</div>';
				html += '</a>';
                                jQuery('.ciyashop-auto-compalte-default').removeClass('ciyashop-empty');
				return jQuery( "<li class='ui-menu-item'></li>" )
					.data( "ui-autocomplete-item", item )
					.append(html)
					.appendTo(jQuery('.ciyashop-auto-compalte-default ul'));
		   };
		});
                $('input.search-form').keyup(function () {
                    if (jQuery(this).val().length < 1) {
                        jQuery('.ciyashop-auto-compalte-default ul').empty();
                        jQuery('.ciyashop-auto-compalte-default').addClass('ciyashop-empty');
                    }
                });

		/*************************
		:: Magnific Popup
		*************************/

		$(".mfp-popup-link").each(function () {
			var $mfp_popup_link = $(this),
				$mfp_popup_option = ( $mfp_popup_link.attr('data-mfp_options')) ? $mfp_popup_link.data('mfp_options') : {};

			$($mfp_popup_link).magnificPopup($mfp_popup_option);
		});
		
		$('.pgs-qrcode-popup-link').magnificPopup({
			type: 'image',
			mainClass: 'mfp-pgs-qrcode',
			image: {
				markup: '<div class="mfp-figure">'+
							'<div class="mfp-close"></div>'+
							'<div class="mfp-pgs-qrcode-img">'+
								'<img class="mfp-img">'+
							'</div>'+
						'</div>', // Popup HTML markup. `.mfp-img` div will be replaced with img tag, `.mfp-close` by close button
			}
		});

		/*************************
		:: Sticky Menu
		*************************/

		var header_sticky_el = $("#header-sticky"),
			sticky_top = 0,
			header_sticky_adminbar = $('#wpadminbar');

		$(document).ready(function(){
			ciyashop_sticky_menu();
		});
		function ciyashop_sticky_menu(update){
			if(
				( ciyashop_l10n.device_type == 'desktop' && ciyashop_l10n.sticky_header == '1' )
				|| ( ciyashop_l10n.device_type == 'mobile' && ciyashop_l10n.sticky_header_mobile == '1' )
			){
				if( $('body').hasClass('admin-bar') && header_sticky_adminbar.length > 0 ){
					if( header_sticky_adminbar.css('position') == 'fixed' ){
						sticky_top = $('#wpadminbar').outerHeight();
					}else{
						sticky_top = 0;
					}
				}

				header_sticky_el.sticky({
					topSpacing:sticky_top
				});

			}
			if( typeof update == 'boolean' && update ){
				header_sticky_el.sticky('update');
			}
		}

		$(window).on('resize', function(event){
			var windowSize = $(window).width(); // Could've done $(this).width()

			if( ciyashop_l10n.sticky_header == '1' && ciyashop_l10n.device_type == 'desktop' && ciyashop_l10n.sticky_header_mobile == '0' ){
				if( windowSize <= 992 ){
					header_sticky_el.unstick();
				}else if( windowSize > 992 ){
					ciyashop_sticky_menu(true);
				}
			}else{
				ciyashop_sticky_menu(true);
			}
		});

		/*************************
		:: Select 2
		*************************/
		$('.woocommerce-ordering select.orderby, .variations select').each(function(){
			$(this).select2({
				minimumResultsForSearch: Infinity,
			});
		});

		$('select.ciyashop-select2').select2({
			containerCssClass: 'ciyashop-select2-container',
			dropdownCssClass: 'ciyashop-select2-dropdown',
			minimumResultsForSearch: Infinity,
		});

		$('.search_form-category').select2({
			containerCssClass: 'ciyashop-search_form_cat-container',
			dropdownCssClass: 'ciyashop-search_form_cat-dropdown',
			minimumResultsForSearch: Infinity,
		});

		/*************************
		:: Clone Primary Menu
		*************************/
		var primary_menu_to_be_cloned,
			site_navigation_sticky = $('#site-navigation-sticky');

		if( $('#mega-menu-wrap-primary').length > 0 ){
			primary_menu_to_be_cloned = $('#mega-menu-wrap-primary');
		}else{
			primary_menu_to_be_cloned = $('#primary-menu');
		}

		var primary_menu_cloned = $(primary_menu_to_be_cloned).clone();
		$(site_navigation_sticky).append(primary_menu_cloned);

		/*************************
		:: SlickNav
		*************************/

		$(site_navigation_sticky).slicknav({
			label : '',
			appendTo : '#site-navigation-sticky-mobile',
			allowParentLinks: true,
			'closedSymbol': '&#43;', // Character after collapsed parents.
			'openedSymbol': '&#45;', // Character after expanded parents.
			'init': function(){
				var init_trigger = $('#site-navigation-sticky-mobile').find('.slicknav_btn');
				if( $(init_trigger).hasClass('slicknav_collapsed') ){
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-closed');
				}else{
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-opened');
				}
			},
			afterOpen: function(trigger){
				if( $(trigger).hasClass('slicknav_collapsed') ){
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-closed');
				}else{
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-opened');
				}
			},
			afterClose: function(trigger){
				if( $(trigger).hasClass('slicknav_collapsed') ){
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-closed');
				}else{
					$('.mobile-menu-trigger').removeClass('mobile-menu-trigger-closed mobile-menu-trigger-opened').addClass('mobile-menu-trigger-opened');
				}
			}
		});
		$(document).on('click', '.mobile-menu-trigger', function (event) {
			event.stopPropagation();
			$(site_navigation_sticky).slicknav('toggle');
		});

		/*************************
		:: Mobile Buttons
		*************************/

		var mobile_search_open = false;

		$(document).on( "click", function(event) {
			event.stopPropagation();
			if( $(event.target).is(".mobile-search-trigger, .mobile-search-trigger > i") ){
				$('.mobile-search-wrap').toggleClass('active');
			}else if( $(event.target).is(".mobile-search-wrap, .mobile-search-wrap *") ){
			}else{
				if( $('.mobile-search-wrap').hasClass('active') ){
					$('.mobile-search-wrap').removeClass('active')
				}
			}
		});

		/* ---------------------------------------------
		 :: Inline Hover
		 --------------------------------------------- */
		$( '.inline_hover' ).on( "mouseenter", function() {
			var $this = $( this );
			var hover_styles = $this.data( 'hover_styles');

			$.each(hover_styles, function(index, value) {
				if( $this.css(index) != null )  {
					/*success*/
					$this.data( 'prehover_'+index, $this.css( index ) );
				}else {
					/*does not have*/
					$this.data( 'prehover_'+index, 'remove' );
				}

				$this.css( index, value );
			});
		});
		
		$( '.inline_hover' ).on( "mouseleave", function(){
			var $this = $( this );
			var hover_styles = $this.data( 'hover_styles');

			$.each(hover_styles, function(index, value) {
				if( $this.data( 'prehover_'+index ) != 'remove' ){
					$this.css( index, $this.data( 'prehover_'+index ) );
				}else{
					$this.css( index, '' );
				}
			});
		});

		/********************************************************************************
		 *
		 :: WooCommerce
		 *
		 ********************************************************************************/

		/* ---------------------------------------------
		 :: Cookies info
		 --------------------------------------------- */
		ciyashop_cookiesinfo();
		function ciyashop_cookiesinfo(){
			if( Cookies.get('ciyashop_cookies') == 'accepted' ){
				$('.ciyashop-cookies-info').hide();
				return;
			}

			$( '.ciyashop-cookies-info' ).on('click', '.cookies-info-accept-btn', function(e) {
				e.preventDefault();
				ciyashop_acceptCookies();
			});
			var ciyashop_acceptCookies = function() {
				$('.ciyashop-cookies-info').hide();
				Cookies.set('ciyashop_cookies', 'accepted', { expires: 60, path: '/' } );
			};
		}

		/* ---------------------------------------------
		 :: WooCommerce Quick View
		 --------------------------------------------- */
		$('.open-quick-view').on('click', function(e) {
			e.preventDefault();

			var productId = $(this).data('id'),btn = $(this);
			btn.addClass('loading');
			var data = {
					id: productId,
					action: "ciyashop_quick_view"
				};

			$.ajax({
				url: ciyashop_l10n.ajax_url,
				data: data,
				method: 'get',
				success: function(data) {
					// Open directly via API
					$.magnificPopup.open({
						items: {
							src: '<div class="mfp-with-anim ciyashop-popup ciyashop-popup-quick-view">' + data + '</div>', // can be a HTML string, jQuery object, or CSS selector
							type: 'inline'
						},
						removalDelay: 500, //delay removal by X to allow out-animation
						callbacks: {
							beforeOpen: function() {
							},
							open: function() {
								$( '.quantity' ).trigger( 'init' );
							}
						},
					});

				},
				complete: function() {
					ciyashop_WooCommerce_Quantity_Input();
					btn.removeClass('loading');
				},
				error: function() {
				},
			});

		});

		/* ---------------------------------------------
		:: WooCommerce - Woo Tools - Cart (Header)
		 --------------------------------------------- */

		 $(document.body).on("adding_to_cart", function() {
			if($('.woo-tools-action.woo-tools-cart').length != 0){
				$('body,html').animate({scrollTop:0},1000);
				$('.woo-tools-action.woo-tools-cart').addClass('woo-tools-cart-show');
			}
		 });

		 $(document.body).on("added_to_cart", function() {
			if($('.woo-tools-action.woo-tools-cart').length != 0){
				setTimeout(function() {
					$('.woo-tools-action.woo-tools-cart').removeClass('woo-tools-cart-show');
				}, 3500);
			}
		});

		/* ---------------------------------------------
		:: WooCommerce - Woo Tools - Compare (Header)
		 --------------------------------------------- */
		$(document).on('click', '.woo-tools-compare > a', function (e) {
			e.preventDefault();

			var table_url = this.href;

			if (typeof table_url == 'undefined')
				return;

			$('body').trigger('yith_woocompare_open_popup', {response: table_url, button: $(this)});
		});

		/****************************
		:: Single Page Sticky Content
		*****************************/

		if($('.product_title.entry-title').length != 0 ){

			var header_sticky_adminbar = $('#wpadminbar');
			var windows_height = $(window).height();
			var element_height = $('.product_title.entry-title').offset().top
			var position = 10;

			if($("#header-sticky").is(":visible")){
				position =  position + $("#header-sticky").outerHeight();
			}

			if( $('body').hasClass('admin-bar') && header_sticky_adminbar.length > 0 ){
				if( header_sticky_adminbar.css('position') == 'fixed' ){
					position = position + $('#wpadminbar').outerHeight();
				}
			}

			$(document).scroll(function () {
				var current_position = $(this).scrollTop();

				if(current_position > element_height){
					$(".woo-product-sticky-content").sticky({topSpacing:position});
				}else if((current_position < element_height)){
					 $(".woo-product-sticky-content").unstick();
				}
			});
		}

		/* ---------------------------------------------
		 :: WooCommerce Gallery
		 --------------------------------------------- */
		if ( $(".ciyashop-product-images-wrapper").length > 0 ) {

			if ( $(".ciyashop-product-images-wrapper").hasClass("ciyashop-gallery-style-wide_gallery") ) {
				var $single_product_gallery__wide = $(".ciyashop-product-gallery__wrapper");

				$single_product_gallery__wide.slick({
					arrows: true,
					centerMode: false,
					dots: false,
					draggable: true,
					focusOnSelect: true,
					infinite: false,
					respondTo: 'slider',
					slidesToShow: 3,
					slidesToScroll: 1,
					swipeToSlide: true,
					touchMove: true
				});

			}else{
				var $single_product_gallery__default = $(".ciyashop-product-gallery__wrapper");
				var $single_product_thumbnails__default = $(".ciyashop-product-thumbnails__wrapper");
				$single_product_gallery__default.slick({
					arrows: false,
					asNavFor: '.ciyashop-product-thumbnails__wrapper',
					centerMode: false,
					dots: false,
					draggable: true,
					focusOnSelect: true,
					infinite: false,
					respondTo: 'slider',
					slidesToShow: 1,
					slidesToScroll: 1,
					swipeToSlide: true,
					touchMove: true
				});
				$single_product_thumbnails__default.slick({
					arrows: true,
					asNavFor: '.ciyashop-product-gallery__wrapper',
					centerMode: false,
					dots: false,
					draggable: true,
					focusOnSelect: true,
					infinite: false,
					respondTo: 'slider',
					slidesToShow: 5,
					slidesToScroll: 1,
					swipeToSlide: true,
					touchMove: true,
					vertical: $('.ciyashop-gallery-style-default').hasClass('ciyashop-gallery-thumb_vh-vertical') ? true : false,
				});
			}
		}

		/* ---------------------------------------------
		 :: Product Type - Sticky Gallery
		 --------------------------------------------- */
		if ( $("body.single-product .product.type-product").length > 0 && $("body.single-product .product.type-product").hasClass('product_page_style-sticky_gallery') ) {

			var page_style_sticky_header_sticky_visible = false;

			jQuery(window).on( 'scroll', function(){
				var page_style_sticky_header_sticky_visible_new = jQuery('#header-sticky-sticky-wrapper.is-sticky').is(":visible");
				if( page_style_sticky_header_sticky_visible != page_style_sticky_header_sticky_visible_new ){
					page_style_sticky_header_sticky_visible = page_style_sticky_header_sticky_visible_new;

					if( jQuery('#header-sticky-sticky-wrapper.is-sticky').is(":visible") ){
						var product_style_sticky__sticky_header_height = jQuery('#header-sticky-sticky-wrapper.is-sticky').outerHeight();
						var product_style_sticky__adminbar_height = 0;
						if( $('body').hasClass('admin-bar') && $('#wpadminbar').length > 0 ){
							product_style_sticky__adminbar_height = $('#wpadminbar').outerHeight();
						}

						var product_sticky_top = product_style_sticky__sticky_header_height + product_style_sticky__adminbar_height + 15;

						$('.product-top-left-inner.sticky-top').addClass('product-top-left-sticky').css('top', product_sticky_top);

					}else{
						$('.product-top-left-inner.sticky-top').removeClass('product-top-left-sticky').css('top', '');
					}
				}
			});
		}

		/* ---------------------------------------------
		:: WooCommerce - Quantity Input
		 --------------------------------------------- */

		ciyashop_WooCommerce_Quantity_Input();

		// On update the cart
		$( document.body ).on( 'updated_cart_totals', function(){
			ciyashop_WooCommerce_Quantity_Input();
		});

		/* ---------------------------------------------
		 :: WooCommerce Product Details - Related Products
		 --------------------------------------------- */
		if( $('.related.products').length != 0 ) {
			$('.related.products > .products-loop').owlCarousel({
				items:4,
				loop:false,
				margin:15,
				autoplay:true,
				autoplayTimeout:3000,
				autoplayHoverPause:true,
				dots:false,
				nav:true,
				smartSpeed:1000,
				navText:[
					"<i class='fa fa-angle-left fa-2x'></i>",
					"<i class='fa fa-angle-right fa-2x'></i>"
				],
				responsive:{
					0:{
						items:1
					},
					767:{
						items:2
					},
					992:{
						items:4
					}
				},
				rtl: (jQuery( "body" ).hasClass( "rtl" )) ? true : false
			});
		}

		/* ---------------------------------------------
		 :: WooCommerce Product Details - Up Sell Products
		 --------------------------------------------- */
		if( $('.up-sells.upsells.products').length != 0 ) {
			$('.up-sells.upsells.products > .products-loop').owlCarousel({
				items:4,
				loop:false,
				margin:15,
				autoplay:true,
				autoplayTimeout:3000,
				autoplayHoverPause:true,
				dots:false,
				nav:true,
				smartSpeed:1000,
				navText:[
					"<i class='fa fa-angle-left fa-2x'></i>",
					"<i class='fa fa-angle-right fa-2x'></i>"
				],
				responsive:{
					0:{
						items:1
					},
					767:{
						items:2
					},
					992:{
						items:4
					}
				},
				rtl: (jQuery( "body" ).hasClass( "rtl" )) ? true : false
			});
		}

		/* ---------------------------------------------
		 :: WooCommerce Product Grid/List Switch
		 --------------------------------------------- */

		jQuery('#gridlist-toggle-grid').on('click', function(event) {
			event.preventDefault();
			jQuery(this).addClass('active');
			jQuery('#gridlist-toggle-list').removeClass('active');
			Cookies.set('gridlist_view','grid', { path: '/' });
			jQuery('ul.products').fadeOut(300, function() {
				jQuery(this).addClass('grid').removeClass('list').fadeIn(300);
			});
			return false;
		});

		jQuery('#gridlist-toggle-list').on('click', function(event) {
			event.preventDefault();
			jQuery(this).addClass('active');
			jQuery('#gridlist-toggle-grid').removeClass('active');
			Cookies.set('gridlist_view','list', { path: '/' });
			jQuery('ul.products').fadeOut(300, function() {
				jQuery(this).removeClass('grid').addClass('list').fadeIn(300);
			});
			return false;
		});

		if (Cookies.get('gridlist_view')) {
			jQuery('.woocommerce-products-header').next('ul.products').addClass(Cookies.get('gridlist_view'));

			if (Cookies.get('gridlist_view') == 'grid') {
				jQuery('.gridlist-toggle #gridlist-toggle-grid').addClass('active');
				jQuery('.gridlist-toggle #gridlist-toggle-list').removeClass('active');
			}

			if (Cookies.get('gridlist_view') == 'list') {
				jQuery('.gridlist-toggle #gridlist-toggle-list').addClass('active');
				jQuery('.gridlist-toggle #gridlist-toggle-grid').removeClass('active');
			}
		}

		/* ---------------------------------------------
		 :: WooCommerce Shop Filters
		 --------------------------------------------- */

		$('.shop-filter').each(function() {
			var $filter = $(this),
				$placeholder = $(this).data('placeholder'),
				$select = $filter.find('select');

			$select.select2({
				placeholder: $placeholder,
				allowClear: true,
			})
		});

		/* ---------------------------------------------
		 :: WooCommerce Video Popup
		 --------------------------------------------- */
		if( $(".product-video-popup-link-html5_old").length > 0 ) {
			$(".product-video-popup-link-html5_old").each(function () {
				var $mfp_popup_link_html5_old = $(this);

				$($mfp_popup_link_html5_old).magnificPopup({
					type:'inline',
					midClick:true,
				});
			});
		}

		var $html5_vids = $('.product-video-popup-link-html5');
		if( $html5_vids.length > 0 ) {
			$html5_vids.each(function () {
				var $mfp_popup_link_html5 = $(this);

				$($mfp_popup_link_html5).magnificPopup({
					type: 'iframe',
					mainClass: 'mfp-fade product-video-popup',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false,
					iframe: {
						markup: '<div class="mfp-iframe-scaler">'+
								'<div class="mfp-close"></div>'+
								'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
								'</div>',

						srcAction: 'iframe_src',
					}
				});
			});
		}

		var $ombed_vids = $(".product-video-popup-link-oembed");
		if( $ombed_vids.length > 0 ) {
			$ombed_vids.each(function () {
				var $mfp_popup_link_non_html5 = $(this);

				$($mfp_popup_link_non_html5).magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade product-video-popup',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false,
					iframe: {
						patterns: {
							youtube: {
								index: 'youtube.com/',
								id: function(url) {
									var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
									if ( !m || !m[1] ) return null;
									return m[1];
								},
								src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0'
							},
							youtu: {
								index: 'youtu.be',
								id: '/',
								src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0'
							},
							vimeo: {
								index: 'vimeo.com/',
								id: function(url) {
									var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
									if ( !m || !m[5] ) return null;
									return m[5];
								},
								src: '//player.vimeo.com/video/%id%?autoplay=1'
							},
						}
					}
				});
			});
		}

		/* ---------------------------------------------
		 :: WooCommerce - Delete Cart Item Ajax
		 --------------------------------------------- */
		/**
		 * CiyaShop_RemoveFromCartHandler class.
		 */
		var CiyaShop_RemoveFromCartHandler = function() {
			$( document ).on( 'click', '.woocommerce-mini-cart-item .remove', this.onRemoveFromCart );
		};

		/**
		 * Handle the remove from cart event.
		 */
		CiyaShop_RemoveFromCartHandler.prototype.onRemoveFromCart = function( e ) {
			var $thisbutton = $( this );
			var $this_item = $( $thisbutton ).closest( ".woocommerce-mini-cart-item" );
			var $this_url = $( $thisbutton ).attr('href');

			if ( $thisbutton.is( '.woocommerce-mini-cart-item .remove' ) ) {
				if ( ! $thisbutton.attr( 'data-product_id' ) ) {
					return true;
				}

				e.preventDefault();

				// add "removing-cart-item" class
				$this_item.addClass( 'removing-cart-item' );

				var data = {
					action:'ciyashop_remove_cart_item'
				};

				var url_params = ciyashop_parse_url_parameters($this_url);

				var data = jQuery.extend({}, data, url_params);

				$.each( $thisbutton.data(), function( key, value ) {
					data[ key ] = value;
				});

				// Ajax action.
				$.post( wc_add_to_cart_params.ajax_url, data, function( response ) {
					if ( ! response ) {

						// remove "removing-cart-item" class
						$this_item.removeClass( 'removing-cart-item' );
						return;
					}

					if ( response.fragments ) {

						jQuery.each(response.fragments, function(key, value) {
							jQuery(key).replaceWith(value);
						});
					}
				});
			}
		};

		/**
		 * Init CiyaShop_RemoveFromCartHandler.
		 */
		new CiyaShop_RemoveFromCartHandler();

		/********************************************************************************
		 *
		 :: Blog
		 *
		 ********************************************************************************/

		/*************************
		:: Blog Gallery Slick Slider
		*************************/

		$('.blog-gallery-slick').slick({
		infinite: true,
		autoplay: true,
		adaptiveHeight: true,
		autoplaySpeed: 2000,
		autoplayHoverPause: true,
		});

		/*************************
		:: Blog - Masonry
		*************************/
		var container = document.querySelector('.masonry-main .masonry');
		if(container != null){
			var msnry = new Masonry( container, {
				itemSelector: '.masonry-item',
				columnWidth: '.masonry-item',
				isOriginLeft: (jQuery( "body" ).hasClass( "rtl" )) ? false :true,
			});
		}

		/*************************
		:: Blog Load More
		*************************/
		jQuery(".entry-date-bottom a").on('click', function(e) {
			e.preventDefault();

			var more_btn    = this;
			var next_link   = $(this).data('next_link');
			var max_pages   = $(this).data('max_pages');
			var current_page= $(this).data('current_page');
			var next_page   = $(this).data('next_page');

			// Disable button click if loaded all pages and added disabled class
			if( $(more_btn).hasClass('disabled' ) ){
				return;
			}

			// Call ajax to fetch data
			$.ajax({
				url: next_link,
				beforeSend: function( xhr ) {

					// Set "Loading..." while ajax in process
					$(more_btn).html('Loading....');
				}
			})
			.done(function( data ) {

				// Load data in temp
				var temp = $(data);

				// Get button from ajax data
				var next_btn = temp.find('.entry-date-bottom').html();

				// Remove unwanted content from data before appending
				temp.find('.entry-date').remove();
				temp.find('.entry-date-bottom').remove();
				temp.find('.clearfix.timeline-inverted').remove();

				// Extract timeline content for appening
				var new_timeline_items = temp.find('ul.timeline').html();

				// Get button data from button in returned data
				var next_btn_link        = $(next_btn).data('next_link');
				var next_btn_max_pages   = $(next_btn).data('max_pages');
				var next_btn_next_page   = $(next_btn).data('next_page');
				var next_btn_current_page= $(next_btn).data('current_page');

				// Check if current page count is less than max page count
				if( next_btn_current_page < next_btn_max_pages ){

					// Set "Load more..." back after ajax completed
					$(more_btn).html('Load more...');

					// Set returned button data to button
					$(more_btn).data('next_link', next_btn_link);
					$(more_btn).data('max_pages', next_btn_max_pages);
					$(more_btn).data('next_page', next_btn_next_page);
					$(more_btn).data('current_page', next_btn_current_page);
				}else{
					$(more_btn).html('No more posts to load').addClass("disabled");
				}

				// appent extracted timeline data
				$( "ul.timeline .timeline-item" ).last().after(new_timeline_items);
				// reinitialize the slick slider after ajax call
				$(".blog-gallery-slick").not('.slick-initialized').slick({
					infinite: true,
					autoplay: true,
					adaptiveHeight: true,
					autoplaySpeed: 2000,
					autoplayHoverPause: true,
				});

			})
			.fail(function() {
			})
			.always(function() {
			});
		});

		/*************************
		:: Tabs
		*************************/
		jQuery( ".tabs_wrapper" ).each(function( index ) {
			var tabs_wrapper = jQuery(this);
			tabs_wrapper.find('li[data-tabs]').on('click', function () {
				var tab = jQuery(this).data('tabs');
				tabs_wrapper.find('li[data-tabs]').removeClass('active');
				jQuery(this).addClass('active');

				tabs_wrapper.find('.tabcontent.active').fadeOut().hide().removeClass('active').removeClass("pulse");
				jQuery('#' + tab).addClass('active').show().fadeIn('slow').addClass("pulse");
			});
		});

		/*************************
		:: Accordion
		*************************/
		var allPanels = $(".accordion > .accordion-content").hide();

		allPanels.first().slideDown("easeOutExpo");
		$(".accordion > .accordion-title > a").first().addClass("active");
		$(".accordion > .accordion-title > a").on("click",function(){
			var current = $(this).parent().next(".accordion-content");

			$(".accordion > .accordion-title > a").removeClass("active");
			$(this).addClass("active");
			allPanels.not(current).slideUp("easeInExpo");
			$(this).parent().next().slideDown("easeOutExpo");
			return false;
		});

		/*************************
		:: Back to top
		*************************/
		$("#back-to-top").hide();
		$(window).scroll(function(){
			if ($(window).scrollTop()>100){
				$("#back-to-top").fadeIn(1500);
			}else{
				$("#back-to-top").fadeOut(1500);
			}
		});

		//back to top
		$("#back-to-top").on( "click", function(){
			$('body,html').animate({scrollTop:0},1000);
			return false;
		});

		/****************************
		:: Commingsoon countdown
		******************************/
		if( $(".commingsoon_countdown").length != 0 ) {
			var cs_countdown      = $('.commingsoon_countdown'),
				cs_countdown_date = $(cs_countdown).data('countdown_date'),
				cs_counter_data   = $(cs_countdown).data('counter_data');

			$(cs_countdown).countdown( cs_countdown_date )
				.on('update.countdown', function(event) {
					var format = '';

					var display_weeks = false;

					if( display_weeks ){
						if(event.offset.weeks > 0) {
							format = format + '<li><span class="days">%-w</span><p class="days_ref">'+cs_counter_data.weeks+'</p></li>';
						}
						if(event.offset.totalDays > 0) {
							format = format + '<li><span class="days">%-d</span><p class="days_ref">'+cs_counter_data.days+'</p></li>';
						}
					}else{
						if(event.offset.totalDays > 0) {
							format = format + '<li><span class="days">%-D</span><p class="days_ref">'+cs_counter_data.days+'</p></li>';
						}
					}

					format = format + '<li><span class="hours">%H</span><p class="hours_ref">'+cs_counter_data.hours+'</p></li>';
					format = format + '<li><span class="minutes">%M</span><p class="minutes_ref">'+cs_counter_data.minutes+'</p></li>';
					format = format + '<li><span class="seconds">%S</span><p class="seconds_ref">'+cs_counter_data.seconds+'</p></li>';

					cs_countdown.html(event.strftime(format));
				});
		}

		/* ---------------------------------------------
		 :: Social Sharing option for blog
		 --------------------------------------------- */
		/* facebook share */
		jQuery('.facebook-share').on('click', function() {
			var $url = jQuery(this).attr('data-url');
			window.open('https://www.facebook.com/sharer/sharer.php?u=' + $url, "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
			return false;
		});

		/* twitter share */
		jQuery('.twitter-share').on('click', function() {
			var $this = jQuery(this),
				$url = $this.attr('data-url'),
				$title = $this.attr('data-title');
				window.open('http://twitter.com/intent/tweet?text=' + $title + ' ' + $url, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
			return false;
		});

		/* google plus share */
		jQuery('.googleplus-share').on('click', function() {
			var $url = jQuery(this).attr('data-url');
			window.open('https://plus.google.com/share?url=' + $url, "googlePlusWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
			return false;
		});

		/* linkedin share */
		jQuery('.linkedin-share').on('click', function() {
			var $this = jQuery(this),
				$url = $this.attr('data-url'),
				$title = $this.attr('data-title'),
				$desc = $this.attr('data-desc');

			window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + $url + '&title=' + $title + '&summary=' + $desc, "linkedInWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
			return false;
		});

		/* pinterest share */
		jQuery('.pinterest-share').on('click', function() {
			var $this = jQuery(this),
				$url = $this.attr('data-url'),
				$title = $this.attr('data-title'),
				$image = $this.attr('data-image');

			window.open('http://pinterest.com/pin/create/button/?url=' + $url + '&media=' + $image + '&description=' + $title, "twitterWindow", "height=320,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
			return false;
		});

		/*******************************************
		:: Call youtube and vimeo video function
		********************************************/

		ciyashop_initVimeoVideoBackgrounds();

		/********************************************************************************
		 *
		 :: Shortcodes
		 *
		 ********************************************************************************/

		/*******************************************
		:: Slick-slider for testimonials shortcode
		********************************************/
		if(jQuery( '.testimonials.slick-carousel' ).length){
			jQuery('.testimonials.slick-carousel').each(function(idx, item) {
				var carouselId = "carousel" + idx,
					carousel_main = $(this).find('.slick-carousel-main'),
					carousel_nav = $(this).find('.slick-carousel-nav');

				var $slidesToShow = $(carousel_main).data('show');
				$(carousel_main).slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					asNavFor: carousel_nav
				});
				$(carousel_nav).slick({
					slidesToShow: $slidesToShow,
					slidesToScroll: 1,
					asNavFor: carousel_main,
					arrows: true,
					dots: false,
					centerMode: true,
					focusOnSelect: true
				});
			});
		}
		/*******************************************
		:: Hot Deal / Banner (Deal)
		********************************************/
		if(jQuery( '.deal-counter-wrapper' ).length){
			jQuery('.deal-counter-wrapper').each(function() {
				var $deal_wrapper   = jQuery(this),
					$deal_counter   = $deal_wrapper.find('.deal-counter'),
					$countdown_date = $deal_counter.data('countdown-date'),
					counter_data    = $deal_counter.data('counter_data'),
					on_expire_btn,
					$deal_wrapper_grand,
					$deal_button;

					if( typeof counter_data.on_expire_btn != 'undefined' ){
						on_expire_btn = counter_data.on_expire_btn;
					}else{
						on_expire_btn = 'remove';
					}

					if( $deal_wrapper.parent().hasClass('pgscore_banner-content-inner-wrapper') ){
						$deal_wrapper_grand = $deal_wrapper.closest('.pgscore_banner-content-inner-wrapper');
						$deal_button    = $deal_wrapper_grand.find('.pgscore_banner-btn');
					}else{
						$deal_wrapper_grand = $deal_wrapper.closest('.deal-banner');
						$deal_button    = $deal_wrapper.find('.deal-button');
					}


				$deal_counter.countdown( $countdown_date )
					.on('update.countdown', function(event) {

						var format = '<ul class="countdown">';

							var display_weeks = false;

							if( display_weeks ){
								if(event.offset.weeks > 0) {
									format = format + '<li><span class="days">%-w</span><p class="days_ref smalltxt">'+counter_data.weeks+'</p></li>';
								}
								if(event.offset.totalDays > 0) {
									format = format + '<li><span class="days">%-d</span><p class="days_ref smalltxt">'+counter_data.days+'</p></li>';
								}
							}else{
								if(event.offset.totalDays > 0) {
									format = format + '<li><span class="days">%-D</span><p class="days_ref smalltxt">'+counter_data.days+'</p></li>';
								}
							}

							format = format + '<li><span class="hours">%H</span><p class="hours_ref smalltxt">'+counter_data.hours+'</p></li>';
							format = format + '<li><span class="minutes">%M</span><p class="minutes_ref smalltxt">'+counter_data.minutes+'</p></li>';
							format = format + '<li><span class="seconds">%S</span><p class="seconds_ref smalltxt">'+counter_data.seconds+'</p></li>';

							format = format + '</ul>';

						$deal_counter.html(event.strftime(format));
					})
					.on('finish.countdown', function(event) {
						$deal_wrapper.addClass('deal-expired');
						$deal_counter.html('<span class="deal-expire-message">'+counter_data.expiremsg+'</span>').addClass('deal-counter-expired').removeAttr('data-counter_data').removeAttr('data-countdown-date');

						if( on_expire_btn == 'remove' ){
							$deal_button.remove();
						}else{
							$deal_button.addClass('disabled').attr('disabled', true);
							$deal_button.on('click', function(e){
								e.preventDefault();
							});
						}
					});
			});
		}

		/*******************************************
		:: Newsletter Mailchimp
		********************************************/
		if( $(".widget_pgs_newsletter_widget, .pgscore_newsletter_wrapper").length > 0 ) {
			jQuery('.widget_pgs_newsletter_widget, .pgscore_newsletter_wrapper').each(function(index, item) {
				var form = $(this).find('form'),
					newsletter_msg      = $(this).find('.newsletter-msg'),
					newsletter_btn      = $(this).find('.newsletter-mailchimp'),
					newsletter_spinner  = $(this).find('.newsletter-spinner'),
					newsletter_email    = $(this).find('.newsletter-email'),
					form_id             = $(this).attr('data-form-id'),
					newsletter_email_val= '';
					
				jQuery(newsletter_btn).on( "click", function(){	
					
					newsletter_email_val = $(newsletter_email).val();
					
					jQuery.ajax({
						url: ciyashop_l10n.ajax_url,
						type:'post',
						data:'action=mailchimp_singup&newsletter_email='+newsletter_email_val,
						beforeSend: function() {
							jQuery(newsletter_spinner).html('<i class="fa fa-refresh fa-spin"></i>');
							jQuery(newsletter_msg).hide().removeClass('error_msg').html('');
						},
						success: function(msg){
							jQuery(newsletter_msg).show().removeClass('error_msg').html(msg)
							$(newsletter_email).val('');
							jQuery(newsletter_spinner).html('');
						},
						error: function(msg){
							jQuery(newsletter_spinner).html('');
							jQuery(newsletter_msg).addClass('error_msg').html(msg).show();
						}
					});
					return false;
				});
				
			});
		}

		/*************************
		:: PGSCore : Banner
		*************************/
		if( $(".pgscore_banner_wrapper").length != 0 ) {
			var banner_class;
			$(window).on("load resize", function(e){
				var viewportWidth = $(window).width();
				
				$('.pgscore_banner').each( function( i, ele ) {
					var banner        	= this,						
						banner_options  = $(banner).data('banner_options'),
						banner_padding  = $(banner).children('.pgscore_banner-content'),
						banner_padding_options  = $(banner_padding).data('banner_padding_options'),
						font_size       = banner_options.font_size_xl;
						
					if( banner_options.font_size_responsive ){
						
						if ( viewportWidth >= 1200 ) {
							font_size = banner_options.font_size_xl;
						}else if ( viewportWidth >= 992 ) {
							font_size = banner_options.font_size_lg;
						}else if ( viewportWidth >= 768 ) {
							font_size = banner_options.font_size_md;
						}else if ( viewportWidth >= 576 ) {
							font_size = banner_options.font_size_sm;
						}else if ( viewportWidth < 576 ) {
							font_size = banner_options.font_size_xs;
						}
						$(banner).css("font-size", parseInt(font_size) );
					}
					
					if( banner_class != null){
						if($(banner_padding).hasClass(banner_class)){
							$(banner_padding).removeClass(banner_class);
						}
					}
					
					if( banner_padding_options.banner_padding_responsive ){
						
						if ( viewportWidth >= 1200 ) {
							banner_class = banner_padding_options.banner_padding_xl;
						}else if ( viewportWidth >= 992 ) {
							banner_class = banner_padding_options.banner_padding_lg;
						}else if ( viewportWidth >= 768 ) {
							banner_class = banner_padding_options.banner_padding_md;
						}else if ( viewportWidth >= 576 ) {
							banner_class = banner_padding_options.banner_padding_sm;
						}else if ( viewportWidth < 576 ) {
							banner_class = banner_padding_options.banner_padding_xs;
						}
						$(banner_padding).addClass(banner_class);
					}
				});
			});
		}

		/*************************
		:: Multi Tab Product Listing - Carousel
		*************************/
		if( $(".mtpl-tab-link").length > 0 ) {
			$('.mtpl-tab-link').on('shown.bs.tab', function (e) {
				var hide_arrow = $(e.relatedTarget).data('arrow_target');
				var show_arrow = $(e.target).data('arrow_target');
				$('#'+hide_arrow).removeClass('active');
				$('#'+show_arrow).addClass('active');

				if( $(e.target).hasClass('mtpl-intro-tab-link') ){
					$(e.target).css( "color", $(e.target).data('active_link_color') );
					$(e.relatedTarget).css( "color", $(e.relatedTarget).data('link_color') );
				}
			})

			//Initialise carousel on showing the tab
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				$($(e.target).attr('href'))
					.find('.owl-carousel')
					.owlCarousel('invalidate', 'width')
					.owlCarousel('update')
			})
		}

		// add loader while tab change
		if( $(".mtpl-tab-link").length > 0 ) {
			$('.mtpl-tab-link').on('click', function (e) {
				if(!$(this).hasClass('active')){
					$(this).parents('.pgs-mtpl-wrapper').addClass('multi-tab-product-loader');
				}
				$('.mtpl-tab-link').on('shown.bs.tab', function (e) {
					$(this).parents('.pgs-mtpl-wrapper').removeClass('multi-tab-product-loader');
				})
			});
		}

		/*************************
		:: Image Slider : Popup
		*************************/
		$('.slider-popup').magnificPopup({
			type: 'image',
		});

		/*************************
		:: Vertical Menu : SlickNav Menu
		*************************/
		if( $('.pgscore_v_menu__menu_wrap').length > 0 ){
			$('.pgscore_v_menu__menu_wrap').each(function(idx, item) {
				var v_menu_wrap   = this,
					v_menu        = $(v_menu_wrap).find('.pgscore_v_menu__nav'),
					v_menu_parent = $(v_menu_wrap).parent(),
					v_menu_branding = '';
					if( $(v_menu_parent).data('menu_title') !== undefined && $(v_menu_parent).data('menu_title') !== '' ){
						v_menu_branding = $(v_menu_parent).data('menu_title');
					}

				v_menu.slicknav({
					label : '<i class="fa fa-bars"></i>',
					brand : '<span class="slicknav_brand_icon"><i class="fa fa-bars"></i></span>'+v_menu_branding,
					appendTo : v_menu_parent,
					allowParentLinks: true,
					'closedSymbol': '&rsaquo;', // Character after collapsed parents.
					'openedSymbol': '&rsaquo;', // Character after expanded parents.
					'init': function(){
						$(v_menu_parent).find('.slicknav_menu').addClass('slicknav_menu-wrap').removeClass('slicknav_menu');
						$(v_menu_parent).find('.slicknav_nav').addClass('menu');
					},
					afterOpen: function(trigger){
						$(trigger).find('.fa').removeClass('fa-bars').addClass('fa-times');

					},
					afterClose: function(trigger){
						$(trigger).find('.fa').removeClass('fa-times').addClass('fa-bars');
					}
				});
			});
		}
	});

	function ciyashop_initVimeoVideoBackgrounds(){
		jQuery(".intro_header_video-bg").each(function() {
			var $video_bg_wrap  = $(this),
				$current_iframe = $video_bg_wrap.find('iframe'),
				$element        = $video_bg_wrap.parent(),
				video_type      = $video_bg_wrap.data("video_type"),
				video_link      = $video_bg_wrap.data("video_link"),
				iframe_src      = $current_iframe.attr('src'),
				iframe_src_new  = iframe_src,
				video_params    = {},
				query_string    = '';

			if( video_type == 'vimeo' ){
				video_params = {
					background: 1,
					autoplay: 1,
					muted: 1,
					loop: 1,
					quality: '540p',
				};
			}else if( video_type == 'youtube' ){
				video_params = {
					playlist: csExtractYoutubeId(video_link),
					iv_load_policy: 3,
					enablejsapi: 1,
					disablekb: 1,
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					rel: 0,
					loop: 1,
					wmode: 'transparent',
					mute: 1,
					modestbranding: 1,
				};
			}

			query_string = getQueryString(video_params);

			if( iframe_src.indexOf('?') !== -1 ){
				iframe_src_new  = iframe_src+"&"+query_string;
			}else{
				iframe_src_new  = iframe_src+"?"+query_string;
			}

			jQuery($current_iframe).attr('src', iframe_src_new );

			jQuery($video_bg_wrap).css('opacity','1');

			ResizeVideoBackground($element);
			jQuery(window).on("resize", function() {
				ResizeVideoBackground($element)
			})
		})
	}

	function getQueryString(obj) {
		var url = '';
		Object.keys(obj).forEach(function (key) {
			url += key + '=' + obj[key] + '&';
		});
		return url.substr(0, url.length - 1);
    }

	function ResizeVideoBackground($element) {
		var iframeW, iframeH, marginLeft, marginTop, containerW = $element.innerWidth(),
			containerH = $element.innerHeight(),
			ratio1 = 16,
			ratio2 = 9;
		containerW / containerH < ratio1 / ratio2 ? (iframeW = containerH * (ratio1 / ratio2), iframeH = containerH, marginLeft = -Math.round((iframeW - containerW) / 2) + "px", marginTop = -Math.round((iframeH - containerH) / 2) + "px", iframeW += "px", iframeH += "px") : (iframeW = containerW, iframeH = containerW * (ratio2 / ratio1), marginTop = -Math.round((iframeH - containerH) / 2) + "px", marginLeft = -Math.round((iframeW - containerW) / 2) + "px", iframeW += "px", iframeH += "px"), $element.find(".intro_header_video-bg iframe").css({
			maxWidth: "1000%",
			marginLeft: marginLeft,
			marginTop: marginTop,
			width: iframeW,
			height: iframeH
		})
	}

	function csExtractYoutubeId(url) {
		if ("undefined" == typeof url) return !1;
		var id = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
		return null !== id && id[1]
	}

	function csExtractVimeoId(url) {
		if ("undefined" == typeof url) return !1;
		var id = url.match(/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?/i);
		return null !== id && id[1]
	}

	function ciyashop_parse_url_parameters( url ){
		var result = {};

		if( url != '' ){
			var queryString = url.substring( url.indexOf('?') + 1 );

			if( queryString != url ){

				queryString.split("&").forEach(function(part) {
					var item = part.split("=");
					if( item[0] != '' ){
						if( typeof item[1] == 'undefined' ){
							result[item[0]] = '';
						}else{
							result[item[0]] = decodeURIComponent(item[1]);
						}
					}
				});
			}
		}
		return result;
	}

	/**************************************************
		Fix for Visual Composer RTL Resize Issue
		TODO: Attach this function to jQuery/Window	to make it available globally
		Check this : http://stackoverflow.com/questions/2223305/how-can-i-make-a-function-defined-in-jquery-ready-available-globally
	**************************************************/

	if( jQuery('html').attr('dir') == 'rtl' ){

		jQuery(window).load(function() {
			ciyashop_vc_rtl_fullwidthrow();
		});

		$( window ).resize(function() {
			ciyashop_vc_rtl_fullwidthrow();
		});

	}

	/* Hide Default menu toggle when mega menu activate */
	if(document.getElementById('mega-menu-wrap-primary')){
		jQuery('.site-header .main-navigation button.menu-toggle').hide();
	}

})(jQuery);

// Fix for form without action
var topbar_currency_switcher_form = document.querySelector(".topbar_item.topbar_item_type-currency .woocommerce-currency-switcher-form");
if(topbar_currency_switcher_form != null){
	topbar_currency_switcher_form.setAttribute("action", "");
}

function ciyashop_vc_rtl_fullwidthrow() {
	if( jQuery('html').attr('dir') == 'rtl' ){

		var $elements = jQuery('[data-vc-full-width="true"]');
		jQuery.each($elements, function(key, item) {
			var $el = jQuery(this);
			$el.addClass("vc_hidden");
			var $el_full = $el.next(".vc_row-full-width");
			if ($el_full.length || ($el_full = $el.parent().next(".vc_row-full-width")), $el_full.length) {

				var el_margin_left = parseInt($el.css("margin-left"), 10);
				var el_margin_right = parseInt($el.css("margin-right"), 10);
				var offset = 0 - $el_full.offset().left - el_margin_left;
				var width = jQuery(window).width();

				$el.css({
					left: 'auto',
					right: offset,
					width: width,
				});
			}
			$el.attr("data-vc-full-width-init", "true"), $el.removeClass("vc_hidden");
		});
	}
}

function ciyashop_WooCommerce_Quantity_Input() {
	jQuery('.quantity').each(function() {
		var spinner = jQuery(this),
			input = spinner.find('input[type="number"]');

		jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter(input);

		var btnUp = spinner.find('.quantity-up'),
			btnDown = spinner.find('.quantity-down'),
			min = input.attr('min'),
			max = input.attr('max');

			if( !max ) max = 999999;

		btnUp.on( "click", function() {
			var oldValue = parseFloat(input.val());
			if (oldValue >= max) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue + 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});

		btnDown.on( "click", function() {
			var oldValue = parseFloat(input.val());
			if (oldValue <= min) {
				var newVal = oldValue;
			} else {
				var newVal = oldValue - 1;
			}
			spinner.find("input").val(newVal);
			spinner.find("input").trigger("change");
		});
	});
}

function one_navigation(e) {

	var anch_hash_url = jQuery(this).attr('href');
	var current_url = window.location.href;

	anch_url = anch_hash_url.substr(0, anch_hash_url.lastIndexOf("#"));

	if(window.location.href.indexOf("#") > -1) {
		current_url = current_url.substr(0, current_url.lastIndexOf("#"));
	}

	var urlString = this.getAttribute('href');
	var urlArray = urlString.split('#');

	if(anch_url+'/' == current_url){

		e.preventDefault();
		document.querySelector('#'+urlArray[1]).scrollIntoView({
			behavior: 'smooth'
		});

	}else if(anch_hash_url){
		if (anch_hash_url.indexOf('#') > -1 && anch_hash_url != '#') {
			anch_hash_urlarray = anch_hash_url.split('#');
			if(!anch_hash_urlarray[0]){
				if(document.querySelector(anch_hash_url) != null){
					e.preventDefault();
					document.querySelector(anch_hash_url).scrollIntoView({
						behavior: 'smooth'
					});
				}
			}
		}
	}
}

//Change the Active class on scroll
function onScroll(event){
	var scrollPos = jQuery(document).scrollTop();

	jQuery('#primary-menu a').each(function () {

		var currLink = jQuery(this);
		var urlString = currLink.attr("href");
		var currurl = urlString.split('#');
		var refElement = jQuery('#'+currurl[1]);

		var refElement_position;
		var refElement_height;

		// add click event
		this.addEventListener('click', one_navigation);

		if(refElement.position()){
			var refElement_position = refElement.position().top;
			var refElement_height = refElement.height();
		}

		if ( ( refElement_position < scrollPos || refElement_position == scrollPos) && ( refElement_position + refElement_height > scrollPos) ) {
			currLink.parent().addClass( "current-menu-item" );
		}else{
			if (urlString.indexOf('#') > -1) {
				currLink.parent().removeClass( "current-menu-item" );
			}
		}
	});
}