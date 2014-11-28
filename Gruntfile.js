module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		coffee: {
			compile: {
				options: {
					bare: true
				},
				files: {
					'assets/coffee/output/admin.js': 'assets/coffee/admin.coffee',
					'assets/coffee/output/functions.js': 'assets/coffee/functions.coffee',
					'assets/coffee/output/responsive.js': 'assets/coffee/responsive.coffee'
				}
			}

		},

		/**
		 * Compile SASS to CSS 
		 */	
		sass: {
			options: {
				style: 'nested'
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
					'assets/sass/lib/*'
				],
				tasks: [ 'sass' ],
				options: {
					livereload: 35729
				},
			},
			coffee: {
				files: [
					'assets/js/*'
				],
				tasks: [ 'coffee' ],
				options: {
					livereload: 35729
				},
			}
		}

	} );

	/**
	 * Load tasks
	 */
	grunt.loadNpmTasks( 'grunt-contrib-coffee' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	/**
	 * Run tasks
	 */
	grunt.registerTask( 'default', [ 'coffee', 'sass', 'watch' ] );

};