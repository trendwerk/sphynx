module.exports = function( grunt ) {

	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Compile Coffee
		 */	
		coffee: {
			compile: {
				options: {
					sourceMap: true,
					bare: true
				},
				files: {
					'assets/coffee/output/functions.js': 'assets/coffee/functions.coffee',
					'assets/coffee/output/responsive.js': 'assets/coffee/responsive.coffee'
				}
			}
		},

		/**
		 * Lint Coffee
		 */
	    coffeelint: {
			app: [ 
				'assets/coffee/functions.coffee', 
				'assets/coffee/responsive.coffee'
			],
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
			options: {
				style: 'nested'
			},
			dist: {
				files: {
					'assets/sass/output/editor.css': 'assets/sass/editor.scss',
					'assets/sass/output/style.css': 'assets/sass/style.scss'
				}
			}
		},

		/**
		 * Lint PHP
		 */
		phplint: {
			files: [
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
				files: [ 'assets/coffee/*' ],
				tasks: [ 'coffee', 'coffeelint' ],
				options: {
					livereload: true
				},
			},
			sass: {
				files: [ 'assets/sass/*' ],
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
