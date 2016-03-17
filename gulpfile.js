'use strict';

/**
 * Require dependencies
 */
var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    colors = require('colors'),
    plumber = require('gulp-plumber'),
    livereload = require('gulp-livereload'),

    // Sass
    scssLint = require('gulp-scss-lint'),
    sass = require('gulp-sass'),
    cssnano = require('gulp-cssnano'),
    cssBase64 = require('gulp-css-base64'),

    // JavaScript
    jslint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    addSrc = require('gulp-add-src'),
    uglify = require('gulp-uglify'),

    // PHP
    phpcs = require('gulp-phpcs');

/**
 * Setup files to watch
 *
 * Concat contains extra files to concat
 */
var files = {
  sass: ['assets/styles/**/*.scss'],
  js: ['assets/scripts/**/*.js'],
  php: [
    '**/*.php',
    '!vendor/**/*.*',
    '!node_modules/**/*.*'
  ],
  twig: ['templates/**/*.twig'],
  concat: {
    js: [
      'bower_components/jquery/dist/jquery.js',
      'bower_components/fancybox/source/jquery.fancybox.js',
      'bower_components/toggle-navigation/src/toggle-navigation.js'
    ]
  }
};

/**
 * Error handling
 */
var gulp_src = gulp.src;

gulp.src = function() {
  return gulp_src.apply(gulp, arguments)

  .pipe(plumber(function(error) {
    beep();
  }));
};

/**
 * Lint Sass
 */
gulp.task('scsslint', function() {
  return gulp.src(files.sass)

  // Lint
  .pipe(scssLint({
    'config': 'config/lint/scss.yml'
  }))

  // Make the reporter fail task on error
  .pipe(scssLint.failReporter());
});

/**
 * Base64 Fancybox images
 */
gulp.task('base64', ['scsslint'], function() {
  return gulp.src('bower_components/fancybox/source/*.css')

  // Base64 images
  .pipe(cssBase64())

  // Write output
  .pipe(gulp.dest('bower_components/fancybox/source/'));
});

/**
 * Compile Sass
 */
gulp.task('sass', ['scsslint', 'base64'], function() {
  return gulp.src(files.sass)

  // Don't stop watch on error (just log it)
  .pipe(sass().on('error', sass.logError))

  // Minify, prefix
  .pipe(cssnano({
    autoprefixer: {
      add: true,
      browsers: ['> 1%']
    },
  }))

  // Write output
  .pipe(gulp.dest('assets/styles/output/'))

  // Reload
  .pipe(livereload());
});

/**
 * Lint CoffeeScript
 */
gulp.task('jslint', function() {
  return gulp.src(files.js)

  // Lint
  .pipe(jslint())

  // Report errors
  .pipe(jslint.reporter())

  // Make reporter fail task on error
  .pipe(jslint.reporter('fail'));
});

/**
 * Compile CoffeeScript
 */
gulp.task('js', ['jslint'], function() {
  return gulp.src(files.js)

  // Concat
  .pipe(addSrc.prepend(files.concat.js))
  .pipe(concat('all.js'))

  // Uglify
  .pipe(uglify())

  // Write output
  .pipe(gulp.dest('assets/scripts/output/'))

  // Reload
  .pipe(livereload());
});

/**
 * PHP CodeSniffer (PSR)
 */
gulp.task('phpcs', function() {
  return gulp.src(files.php)

  // Use cache to filter out unmodified files
  .pipe(cache('phpcs'))

  // Sniff code
  .pipe(phpcs({
    bin: 'vendor/bin/phpcs',
    standard: 'PSR2',
    warningSeverity: 0
  }))

  // Log errors and fail afterwards
  .pipe(phpcs.reporter('log'))
  .pipe(phpcs.reporter('fail'))

  // Reload
  .pipe(livereload());
});

/**
 * Twig: Livereload
 */
gulp.task('twig', function() {
  return gulp.src(files.twig)

  // Use cache to filter out unmodified files
  .pipe(cache('twig'))

  // Reload
  .pipe(livereload());
});

/**
 * Welcome message
 */
var welcomeMessage = [
  '',
  '',
  '                     ________',
  '                    //   |\\ \\\\',
  '                   //    | \\ \\\\',
  '             |\\\\  //     |  \\ \\\\  //|',
  '             ||\\\\//       —-—  \\\\//||',
  '             || \\/______________\\/ ||',
  '             ||                    ||',
  '             ||                    ||',
  '             ||    ( )      ( )    ||',
  '             ||        ____        ||',
  '             ||        \\  /        ||',
  '             ||         ||         ||',
  '             ||     \\__/  \\__/     ||',
  '             ||                    ||',
  '             ||                    ||',
  '',
  '',
  ' $$\\   $$\\  $$$$$$\\  $$\\       $$\\       $$$$$$\\',
  ' $$ |  $$ |$$  __$$\\ $$ |      $$ |     $$  __$$\\',
  ' $$ |  $$ |$$ /  $$ |$$ |      $$ |     $$ /  $$ |',
  ' $$$$$$$$ |$$$$$$$$ |$$ |      $$ |     $$ |  $$ |',
  ' $$  __$$ |$$  __$$ |$$ |      $$ |     $$ |  $$ |',
  ' $$ |  $$ |$$ |  $$ |$$ |      $$ |     $$ |  $$ |',
  ' $$ |  $$ |$$ |  $$ |$$$$$$$$\\ $$$$$$$$\\ $$$$$$  |',
  ' \\__|  \\__|\\__|  \\__|\\________|\\________|\\______/',
  '',
  ''
].join('\n');

/**
 * Watch
 */
gulp.task('default', function() {
  console.log(welcomeMessage.cyan);

  gulp.watch(files.sass, ['base64', 'scsslint', 'sass']);
  gulp.watch(files.js, ['jslint', 'js']);
  gulp.watch(files.php, ['phpcs']);
  gulp.watch(files.twig, ['twig']);

  livereload.listen();
});
