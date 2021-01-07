jQuery( function( $ ) {

	// load more button click event
	$( '.gaya-comments-loadmore' ).click( function () {
		var button = $(this);

		alert( cpage );

		// decrease the current comment page value
		cpage++;

		$.ajax({
			url: ajaxurl, // AJAX handler, declared before
			data: {
				'action': 'comments_loadmore', // wp_ajax_comments_loadmore
				'post_id': parent_post_id, // the current post
				'cpage': cpage, // current comment page
			},
			type: 'POST',
			beforeSend: function( xhr ) {
				button.text( 'Loading...' ); // preloader here
			},
			success: function( data ) {
				if ( data ) {
					$( 'ol.comment-list' ).append( data );
					button.text( 'Load more' );

					// if the last page, remove the button
					if ( cpage === 1 ) {
						button.remove();
					}
				} else {
					button.remove();
				}
			},
			error: function( error ) {
				console.log( 'Comment Page Number: ', cpage );
				console.info( error );
				button.remove();
			}
		});
		return false;
	});
});