/*global ciyashop_single_product_params, PhotoSwipe, PhotoSwipeUI_Default */
jQuery( function( $ ) {
	
	var ciyashop_single_product_params = {
		"photoswipe_enabled":"1",
		"photoswipe_options":{
			"shareEl":false,
			"closeOnScroll":false,
			"history":false,
			"hideAnimationDuration":0,
			"showAnimationDuration":0
		},
	};
	
	/**
	 * Product gallery class.
	 */
	var CiyaShop_ProductGallery = function( $target, args ) {
		this.$target = $target;
		this.$images = $( '.ciyashop-product-gallery__image', $target );

		// No images? Abort.
		if ( 0 === this.$images.length ) {
			this.$target.css( 'opacity', 1 );
			return;
		}

		// Make this object available.
		$target.data( 'product_gallery', this );

		// Pick functionality to initialize...
		this.photoswipe_enabled = true;

		// ...also taking args into account.
		if ( args ) {
			this.photoswipe_enabled = false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
		}

		// Bind functions to this.
		this.initPhotoswipe       = this.initPhotoswipe.bind( this );
		this.getGalleryItems      = this.getGalleryItems.bind( this );
		this.openPhotoswipe       = this.openPhotoswipe.bind( this );
		this.onResetSlidePosition = this.onResetSlidePosition.bind( this );

		if ( this.photoswipe_enabled ) {
			this.initPhotoswipe();
			$target.on( 'cs_woocommerce_gallery_reset_slide_position', this.onResetSlidePosition );
		}
	};

	/**
	 * Init PhotoSwipe.
	 */
	CiyaShop_ProductGallery.prototype.initPhotoswipe = function() {
		if ( this.$images.length > 0 ) {
			this.$target.on( 'click', '.ciyashop-product-gallery_button-link-zoom', this.openPhotoswipe );
		}
		this.$target.on( 'click', '.ciyashop-product-gallery__image a', this.openPhotoswipe );
	};
	
	/**
	 * Reset slide position to 0.
	 */
	CiyaShop_ProductGallery.prototype.onResetSlidePosition = function() {
		// this.$target.flexslider( 0 );
		$(".ciyashop-product-gallery__wrapper").slick( "slickGoTo", 0);
	};

	/**
	 * Get product gallery image items.
	 */
	CiyaShop_ProductGallery.prototype.getGalleryItems = function() {
		var $slides = this.$images,
			items   = [];

		if ( $slides.length > 0 ) {
			$slides.each( function( i, el ) {
				var img = $( el ).find( 'img' ),
					large_image_src = img.attr( 'data-large_image' ),
					large_image_w   = img.attr( 'data-large_image_width' ),
					large_image_h   = img.attr( 'data-large_image_height' ),
					item            = {
						src  : large_image_src,
						w    : large_image_w,
						h    : large_image_h,
						title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
					};
				items.push( item );
			} );
		}
		
		return items;
	};

	/**
	 * Open photoswipe modal.
	 */
	CiyaShop_ProductGallery.prototype.openPhotoswipe = function( e ) {
		e.preventDefault();

		var pswpElement = $( '.pswp' )[0],
			items       = this.getGalleryItems(),
			eventTarget = $( e.target ),
			clicked;

		if ( ! eventTarget.is( '.ciyashop-product-gallery_button-link-zoom' ) ) {
			clicked = this.$target.find( '.slick-current' );
		} else {
			clicked = this.$target.find( '.slick-current' );
		}
		
		var options = $.extend( {
			index: $( clicked ).index()
		}, ciyashop_single_product_params.photoswipe_options );

		// Initializes and opens PhotoSwipe.
		var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
		photoswipe.init();
		
		var psIndex = photoswipe.getCurrentIndex();
        var psIndexSlick = psIndex;
		photoswipe.listen('afterChange', function() {
			var psIndex = photoswipe.getCurrentIndex();
			var psIndexSlick = psIndex;
			$(".ciyashop-product-gallery__wrapper").slick( "slickGoTo", psIndexSlick);
		});
	};

	/**
	 * Function to call ciyashop_product_gallery on jquery selector.
	 */
	$.fn.ciyashop_product_gallery = function( args ) {
		new CiyaShop_ProductGallery( this, args );
		return this;
	};

	/*
	 * Initialize all galleries on page.
	 */
	$( '.ciyashop-product-gallery' ).each( function() {
		$( this ).ciyashop_product_gallery();
	} );
} );