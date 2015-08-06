module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Lint PHP
		 */
		phplint: {
			lint: [
				'*.php',
				'assets/**/*.php'
			]
		},

		/**
		 * PHP Code Sniffer
		 */
		phpcs: {
			lint: {
				src: [
					'*.php',
					'assets/**/*.php'
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
					'assets/styles/output/style.css': 'assets/styles/main.scss'
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
				files: [ 'assets/styles/**/*.scss' ],
				tasks: [ 'sass' ],
				options: {
					livereload: true
				},
			},
			php: {
				files: [
					'*.php',
					'assets/**/*.php'
				],
				tasks: [ 'phplint', 'phpcs' ]
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
