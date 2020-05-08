'use strict';

module.exports = {
	theme: {
		slug: 'gaya',
		name: 'Gaya',
		author: 'Aaron Snowberger'
	},
	dev: {
		browserSync: {
			live: true,
			proxyURL: 'keytokorean.test',
			bypassPort: '8181'
		},
		browserslist: [ // See https://github.com/browserslist/browserslist
			'> 1%',
			'last 2 versions'
		],
		debug: {
			styles: false, // Render verbose CSS for debugging. true to help find rules
			scripts: false // Render verbose JS for debugging.
		}
	},
	export: {
		compress: true
	}
};
