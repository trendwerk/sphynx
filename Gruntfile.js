module.exports = function(grunt) {

	grunt.initConfig({

		/**
		 * Combine files with concatenate 
		 */

		pkg: grunt.file.readJSON( 'package.json' ),

		concat: {
			dist: {
				src: [
					'assets/js/lib/*.js',
					'assets/js/functions.js'
				],
			dest: 'assets/js/all.js',
			}
		}

		/**
		 * Uglify 
		 */
		
		// uglify: {
		// 	build: {
		// 		src: 'js/build/all.js',
		// 		dest: 'js/build/all.min.js'
		// 	}
		// }

	} );

	/**
	 * Load tasks
	 */

	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	// grunt.loadNpmTasks( 'grunt-contrib-uglify' );

	/**
	 * Run tasks
	 */

	grunt.registerTask( 'default', ['concat'] );

};