module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

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
		 * PHP Code Sniffer
		 */
		phpcs: {
			application: {
				src: [
					'*.php',
					'assets/**/*.php',
					'partials/**/*.php'
				]
			},
			options: {
				standard: 'PSR2'
			}
		},

		/**
		 * Lint CoffeeScript
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
		 * Compile CoffeeScript to JavaScript
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
		 * Watch things
		 */
		watch: {
			coffee: {
				files: [ 'assets/scripts/*.coffee' ],
				tasks: [ 'coffeelint', 'coffee' ],
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
	grunt.loadNpmTasks( 'grunt-phplint' );
	grunt.loadNpmTasks( 'grunt-coffeelint' );
	grunt.loadNpmTasks( 'grunt-contrib-coffee' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-phpcs' );

	/**
	 * Run tasks
	 */
	grunt.registerTask( 'default', [ 'phplint', 'phpcs', 'coffeelint', 'coffee', 'sass', 'watch' ] );

};
