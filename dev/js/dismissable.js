/**
 * File to handle dismissable notices and ads.
 */

( function() {
	var notice, noticeId, storedNoticeId, dismissButton, site, siteHeader, adminHeader,
			siteFooter, siteFooterDismiss, dismissFooterButton, footerId, storedFooterId;

	// Prepare for Site Notice functionality.
	adminHeader = document.querySelector( '.admin-bar' );
	notice = document.querySelector( '.site-notice' );
	site = document.querySelector( '.site' );
	siteHeader = document.querySelector( '.site-header' );

	// Prepare for Fixed Footer functionality.
	siteFooter = document.querySelector( '.fixed-footer' );

	// If there's no Notice OR no Footer, leave.
	if ( ! notice || ! siteFooter ) {
		return;
	}

	/**
	 * Functionality for Site Notice.
	 */
	if ( notice ) {
		dismissButton = document.querySelector( '.site-notice-dismiss' );
		noticeId = notice.getAttribute( 'data-id' );
		storedNoticeId = localStorage.getItem( 'wprigSiteNotice' );

		// This means that the user hasn't already dismissed this specific notice. So, display it.
		if ( noticeId !== storedNoticeId ) {
			notice.style.display = 'block';
			site.style.marginTop = '60px';

			window.onscroll = function() {
				if ( 'site-header fixed' === siteHeader.className && 'none' !== notice.style.display ) {
					if ( ! adminHeader ) {
						siteHeader.style.top = '60px';
					} else {
						siteHeader.style.top = '92px';
					}
				} else {
					if ( ! adminHeader ) {
						siteHeader.style.top = '0px';
					} else {
						siteHeader.style.top = '32px';
					}
				}
			};

		}

		dismissButton.addEventListener( 'click', function() {

			// Hide the notice.
			notice.style.display = 'none';
			site.style.marginTop = '0px';
			siteHeader.style.top = '0px';

			// Add the current ID to localStorage.
			localStorage.setItem( 'wprigSiteNotice', noticeId );

		});
	}

	/**
	 * Functionality for Site (fixed) Footer.
	 */
	if ( siteFooter ) {

		dismissFooterButton = document.querySelector( '#dismiss-footer' );
		footerId = siteFooter.getAttribute( 'data-id' );
		storedFooterId = localStorage.getItem( 'wprigFixedFooter' );

		// This means that the user hasn't already dismissed this footer notice. So, display it.
		if ( footerId !== storedFooterId ) {
			siteFooter.style.display = 'block';
		}

		dismissFooterButton.addEventListener( 'click', function() {

			// Hide the footer.
			siteFooter.style.display = 'none';

			// Add the current ID to localStorage.
			localStorage.setItem( 'wprigFixedFooter', footerId );

		});
	}

} () );
