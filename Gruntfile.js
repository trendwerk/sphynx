module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		/**
		 * Optimize images
		 */

		imageoptim: {
			options: {
				quitAfter: true
			},
			myTask: {
				src: ['assets/img']
			}
		},

		/**
		 * Combine files with concatenate
		 */

		concat: {
			dist: {
				src: [
					'assets/js/lib/*.js',
					'assets/js/functions.js',
					'assets/js/responsive.js'
				],
			dest: 'assets/js/all.js',
			},
		},

		concat: {
			dist: {
				src: [
					'assets/plugins/*.scss',
					'assets/plugins/**/*.scss'],
			dest: 'assets/sass/output/_plugins.scss',
			},
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
					'assets/sass/output/style.css': 'assets/sass/style.scss',
					'assets/sass/output/editor.css': 'assets/sass/editor.scss',
					'assets/sass/output/admin.css': 'assets/sass/admin.scss'
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

	grunt.loadNpmTasks('grunt-imageoptim');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');

	/**
	 * Run tasks
	 */

	grunt.registerTask( 'default', ['concat', 'uglify', 'sass', 'imageoptim', 'watch'] );

};