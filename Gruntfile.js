module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Compile SASS to CSS 
		 */	
		sass: {
			options: {
				style: 'compressed'
			},
			dist: {
				files: {
					'assets/sass/output/admin.css': 'assets/sass/admin.scss',
					'assets/sass/output/editor.css': 'assets/sass/editor.scss',
					'assets/sass/output/style.css': 'assets/sass/style.scss'
				}
			}
		},

		/**
		 * Watch things
		 */
		watch: {
			sass: {
				files: [
					'assets/plugins/*',
					'assets/sass/*',
					'assets/sass/inc/*',
					'assets/sass/inc/lib/*',
					'assets/sass/output/*'
				],
				tasks: [ 'sass' ],
				options: {
					livereload: 35729
				}
			}
		}

	} );

	/**
	 * Load tasks
	 */
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	/**
	 * Run tasks
	 */
	grunt.registerTask( 'default', [ 'sass', 'watch' ] );

};
