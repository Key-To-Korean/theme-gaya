/*
 * File functions.js
 *
 * Containing various JS functions for the theme.
 *
 * 1. Centered images full bleed
 */
jQuery( document ).ready( function( $ ) {

	/* Find overflowing element */
	var docWidth = document.documentElement.offsetWidth;

	[].forEach.call(
		document.querySelectorAll( '*' ),
		function( el ) {
			if ( el.offsetWidth > docWidth ) {
				console.log( el );
			}
		}
	);

	/**
	 * Back to Top button
	 * @TODO needs fix
	 */
	var offset = 500;
	var speed = 500;
	var duration = 500;
	$( window ).scroll( function() {
		if ( $( this ).scrollTop() < offset ) {
			$( '.topbutton' ).fadeOut( duration );
			$( '.post-navigation-container' ).removeClass( 'active' );
		} else if ( $( this ).scrollTop() > $( this ).height - 200 ) {
			$( '.post-navigation-container' ).removeClass( 'active' );
		} else if ( ( window.innerHeight + window.scrollY ) > document.body.offsetHeight ) {

			// If this is the very bottom of the page.
			$( '.post-navigation-container' ).removeClass( 'active' );
		} else {
			$( '.topbutton' ).fadeIn( duration );
			$( '.post-navigation-container' ).addClass( 'active' );
		}
	});

	$( '.topbutton' ).on( 'click', function() {
		$( 'html, body' ).animate({
			scrollTop: 0
		}, speed );
		return false;
	});

	// Slick Slider
	$( document ).ready( function() {
		$( '#featured-slider' ).slick({

			// All the defaults
			//       accessibility: true,
			//       adaptiveHeight: false,
			//autoplay: true,
			//       autoplaySpeed: 3000,
			//       arrows: true,
			//       asNavFor: null,
			//       appendArrows: $(element),
			prevArrow: '<button type="button" class="slick-prev">Previous</button>',
			nextArrow: '<button type="button" class="slick-next">Next</button>',

			//       centerMode: false,
			//       centerPadding: '50px',
			//       cssEase: 'ease',
			//       customPaging: '',
			dots: true

			//       draggable: true,
			//       fade: false,
			//       focusOnSelect: false,
			//       easing: 'linear',
			//       edgeFriction: 0.15,
			//       infinite: true,
			//       initialSlide: 0,
			//       lazyLoad: 'ondemand',
			//       mobileFirst: false,
			//       pauseOnHover: true,
			//       pauseOnDotsHover: false,
			//       respondTo: 'window',
			//       responsive: none,
			//       slide: '',
			//       slidesToShow: 1,
			//       slidesToScroll: 1,
			//       speed: 300,
			//       swipe: true,
			//       swipeToSlide: false,
			//       touchMove: true,
			//       touchThreshold: 5,
			//       useCSS: true,
			//       variableWidth: false,
			//       vertical: false,
			//       rtl: false,
		});
	});

	/*
	 * Center Aligned Images - full bleed on smaller screens
	 */
	$( 'figure.wp-caption.aligncenter' ).removeAttr( 'style' );
	$( 'img.aligncenter' ).wrap( '<figure class="centered-image" />' );

	/*
	 * Wrap blockquote images with a figure tag
	 */
	if ( $( 'blockquote.has-image img' ).parent().is( 'figure' ) ) {
		$( 'blockquote.has-image img' ).unwrap();
	}
	$( 'blockquote.has-image' ).wrap( '<figure class="blockquote-image" />' );

	/*
	 * Turn on site search
	 */
	$( '#site-search-button, .search-toggle' ).click( function() {
		if ( $( '#secondary' ).hasClass( 'active' ) ) {
			$( '#secondary' ).removeClass( 'active' );

			//            $( '.site' ).removeClass( 'blur' );
		} else {
			$( '#secondary' ).removeClass( 'active' );

			//            $( '.site' ).removeClass( 'blur' );
		}

		// @TODO: Needs some work to turn OFF search when button is clicked again
		if ( $( '.site-search-overlay' ).hasClass( 'active' ) ) {
			$( '.site-search-overlay' ).removeClass( 'active' );

			//            $( '.site' ).removeClass( 'blur' );
		} else {
			$( '.site-search-overlay' ).addClass( 'active' );

			// $( '.site' ).addClass( 'blur' );.
			$( '.site-search-overlay .search-field' ).focus();
		}

	});

	// Turn off site search when it's not in focus
	$( '.site-search-overlay .search-field' ).focusout( function() {
		$( '.site-search-overlay' ).removeClass( 'active' );

		//    $( '.site' ).removeClass( 'blur' );
	});
	$( '.close-search' ).click( function() {
		$( '.site-search-overlay' ).removeClass( 'active' );
	});

	/* Open Drawer (Sidebar) */
	$( '.dismiss-drawer, .drawer-box' ).click( function() {
		$( '.drawer' ).toggleClass( 'active' );

		// $( '.site-main' ).toggleClass( 'drawer-open' ); .
		$( '.drawer-box' ).toggleClass( 'active' );
	});

	/*
	 * Show / Hide Comments
	 */
	$( '.view-comments' ).click( function() {
		$( '.view-the-comments' ).toggleClass( 'active' );
	});

	/*
	 * Toggle Author box
	 */
	$( '.show-hide-author' ).click( function() {
		$( '.author_bio_section' ).toggle( 600, 'swing' );
		if ( '<i class="fa fa-plus-circle"></i> Show' === $( this ).html() ) {
			$( this ).html( '<i class="fa fa-minus-circle"></i> Hide' );
		} else {
			$( this ).html( '<i class="fa fa-plus-circle"></i> Show' );
		}
	});


	/**
	 * Test if inline SVGs are supported.
	 * @link https://github.com/Mocernizr/Modernizr/
	 */
	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
	}
	if ( true === supportsInlineSVG() ) {
		document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
	}

	/**
	 * Better Categories Widgets
	 */
	$( '.widget_categories ul.children' ).parent().addClass( 'category-item-has-children' );

	/**
	 * Fixed Top Menu
	 */
	let topMenuStart = $( '.site-header' ).offset().top;
	$( window ).scroll( function() {
		if ( $( this ).scrollTop() < topMenuStart ) {
			$( '.site' ).removeClass( 'fixed-header' );
			$( '.site-header' ).removeClass( 'fixed' );
			$( '.site-header .logo' ).addClass( 'screen-reader-text' );
		} else {
			$( '.site' ).addClass( 'fixed-header' );
			$( '.site-header' ).addClass( 'fixed' );
			$( '.site-header .logo' ).removeClass( 'screen-reader-text' ).delay( 800 );
		}
	});

	/* Dismiss Adsense footer */
	$( '#dismiss-footer' ).click( function() {
		$( '.adsense.fixed-footer' ).addClass( 'dismissed' );
	});


	$( '.menu-toggle' ).click( function() {
		$( '.main-navigation' ).toggleClass( 'toggled-on' );
	});
	$( '#dismiss-menu' ).click( function() {
		$( '.main-navigation' ).removeClass( 'toggled-on' );
	});

});
