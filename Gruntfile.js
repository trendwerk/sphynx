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
		 * Lint SASS
		 */
		scsslint: {
			allFiles: [
				'assets/sass/*.scss',
			],
			options: {
				colorizeOutput: true,
				config: 'assets/sass/lint/scss-lint.yml',
				force: true,
				reporterOutput: 'assets/sass/lint/scss-lint-report.xml'
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
		 * Watch things
		 */
		watch: {
			coffee: {
				files: [ 'assets/coffee/*' ],
				tasks: [ 'coffee' ],
				options: {
					livereload: true
				},
			},
			coffeelint: {
				files: [ 'assets/coffee/*' ],
				tasks: [ 'coffeelint' ],
				options: {
					livereload: true
				},				
			},
			scsslint: {
				files: [ 'assets/sass/*' ],
				tasks: [ 'scsslint' ],
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
			}
		}

	} );

	/**
	 * Load tasks
	 */
	grunt.loadNpmTasks( 'grunt-contrib-coffee' );
	grunt.loadNpmTasks( 'grunt-coffeelint' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-scss-lint' );

	/**
	 * Run tasks
	 */
	grunt.registerTask( 'default', [ 'coffee', 'coffeelint', 'sass', 'watch', 'scsslint' ] );

};