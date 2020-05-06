// Find overflowing elements.
var docWidth = document.documentElement.offsetWidth;

[].forEach.call(
	document.querySelectorAll( '*' ),
	function( el ) {
		if ( el.offsetWidth > docWidth ) {
			console.log( el );
		}
	}
);
