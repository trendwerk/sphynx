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
		 * Compile SASS to CSS 
		 */		

		sass: {
			options: {
				style: 'compressed'
			},
			dist: {
				files: {
					'assets/sass/output/style.compiled.css': 'assets/sass/style.scss',
					'assets/sass/output/editor-style.css': 'assets/sass/editor.scss'
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

		/**
		 * Watch things
		 */

        watch: {
            sass: {
                files: [
                		'assets/sass/*',
                		'assets/sass/inc/*',
                		'assets/sass/inc/lib/*',
                		'asset/sass/output/*'],
                tasks: ['sass'],
                options: {
					livereload: 35729
				}
            },
            js: {
                files: ['assets/js/lib/*.js',
						'assets/js/functions.js'],
                tasks: ['concat', 'uglify']
            },
            images: {
                files: ['assets/img/*'],
                tasks: ['imageoptim']
            }
        }

	} );

	/**
	 * Load tasks
	 */

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-imageoptim');

	/**
	 * Run tasks
	 */

	grunt.registerTask( 'default', ['concat', 'uglify', 'sass', 'imageoptim', 'watch'] );

};