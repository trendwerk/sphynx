module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Compile Coffee
		 */	
		coffee: {
			compile: {
				options: {
					sourceMap: true
				},
				files: [
					{
						expand: true,
						cwd: 'assets/scripts',
						src: [ '*.coffee' ],
						dest: 'assets/scripts/output/',
						ext: '.js'
					}
				]
			}
		},

		/**
		 * Lint Coffee
		 */
	    coffeelint: {
			lint: [ 'assets/scripts/*.coffee' ],
			options: {
				'max_line_length': {
					'level': 'ignore'
				}
			}
	    },

		/**
		 * Compile SASS to CSS 
		 */	
		sass: {
			compile: {
				files: {
					'assets/styles/output/editor.css': 'assets/styles/editor.scss',
					'assets/styles/output/style.css': 'assets/styles/style.scss'
				}
			}
		},

		/**
		 * Lint PHP
		 */
		phplint: {
			lint: [
				'*.php',
				'assets/**/*.php',
				'partials/**/*.php'
			]
		},

		/**
		 * Watch things
		 */
		watch: {
			coffee: {
				files: [ 'assets/scripts/*.coffee' ],
				tasks: [ 'coffee', 'coffeelint' ],
				options: {
					livereload: true
				},
			},
			sass: {
				files: [ 'assets/styles/*' ],
				tasks: [ 'sass' ],
				options: {
					livereload: true
				},
			},
			phplint: {
				files: [
					'*.php',
					'assets/**/*.php',
					'partials/**/*.php'
				],
				tasks: [ 'phplint' ]
			}
		}

	} );

	/**
	 * Load tasks
	 */
	grunt.loadNpmTasks( 'grunt-contrib-coffee' );
	grunt.loadNpmTasks( 'grunt-coffeelint' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	/**
	 * Run tasks
	 */
	grunt.registerTask( 'default', [ 'coffee', 'coffeelint', 'sass', 'phplint', 'watch' ] );

};
