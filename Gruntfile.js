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
		},

		/**
		 * Uglify files
		 */

		uglify: {
			build: {
				src: 'assets/js/all.js',
				dest: 'assets/js/all.min.js'
			}
		},

		/**
		 * Uglify files
		 */		

		sass: {
			dist: {
				options: {
					style: 'expanded'
				},
				files: {
					'sass.css': 'style.scss',
				}
			}
		},

		/**
		 * Optimize images
		 */

		imageoptim: {
			myTask: {
				src: ['assets/img']
			}
		},

	} );

	/**
	 * Load tasks
	 */

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-imageoptim');

	/**
	 * Run tasks
	 */

	grunt.registerTask( 'default', ['concat', 'uglify', 'sass', 'imageoptim'] );

};