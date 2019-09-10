/**
 * Fetch up to 4 related posts based on current post categories
 * via the WP REST API. Posts are only fetched if and when the
 * user scrolls the viewport to the container.
 */

// Variables passed from the PHP Component.
const postID = postdata.post_ID;
const catIDs = postdata.cat_ids;
const restURL = postdata.rest_url;
const count = postdata.count;

// Create query URL for the REST API. Note &_embed=true at the end which brings in the featured image...
const queryURL = `${restURL}posts?per_page=${count}&categories=${catIDs}&exclude=${postID}&embed=true`;

// Get the Featured Image if there is one.
function getFeaturedImage( postObject ) {

	// If there is no Featured Image, exit the function returning nothing.
	if ( 0 === postObject.featured_media ) {
		return '';
	} else {
		let featuredObject = postObject._embedded['wp:featuredmedia'][0];
		console.log( featuredObject );
		let imgWidth = featuredObject.media_details.sizes.wpRigRelated.width;
		let imgHeight = featuredObject.media_details.sizes.wpRigRelated.height;

		return `
  <figure class="related-post__image">
    <img src="${featuredObject.media_details.sizes.wpRigRelated.source}"
        'width="${imgWidth}"
        'height="${imgHeight}"
        'alt="" ' +
    >
  </figure>`;
	}
}

/* Generate HTML for individual related post. */
function thePost( postObject ) {

	// Create a div with class "related-post" to populate.
	let postElement = document.createElement( 'div' );
	postElement.className = 'related-post';

	// Turn the date into something meaningful.
	let date = new Date( postObject.date );

	// HTML template for the post.
	let postContent = `
<a href="${postObject.link}">
  ${getFeaturedImage( postObject )}
  <h3 class="related-post__title">
    ${postObject.title.rendered}
  </h3>
  <div class="related-post__meta">
    Published <time class="entry-date published" datetime="${date}">${date}</time>
  </div>
  <p class="related-post__excerpt">
    ${postObject.excerpt.rendered}
  </p>
</a>`;

	// Put the HTML template into the postElement div.
	postElement.innerHTML = postContent;

	return postContent;
}

// Find the .related-posts container and loop through the data to populate the container.
function displayRelatedPosts( data ) {
	const relatedContainer = document.querySelector( '.related-posts' );

	data.forEach( function( postObject ) {
		relatedContainer.append( thePost( postObject ) );
	});
}

// Fetch the query results from the WP REST API.
function sendRESTquery() {
	fetch( queryURL )
		.then( response => response.json() )
		.then( data => displayRelatedPosts( data ) )
		.then( document.querySelector( '.related-spinner' ).remove() );
}

// Trigger event only when Related Posts area comes into view.
window.addEventListener(
	'load',
	function( event ) {
		const observer = new IntersectionObserver( function( entries, self ) {
			entries.forEach( entry => {
				if ( entry.isIntersecting ) {
					sendRESTquery();

					// Disconnect IntersectionObserver after first reveal.
					self.disconnect();
				}
			});
		});
		observer.observe( document.querySelector( '.related-posts' ) );
	},
	false
);
