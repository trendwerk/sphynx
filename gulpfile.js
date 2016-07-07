'use strict';

/**
 * Require dependencies
 */
var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    colors = require('colors'),
    plumber = require('gulp-plumber'),
    liveReload = require('gulp-livereload'),

    // Sass
    scssLint = require('gulp-scss-lint'),
    sass = require('gulp-sass'),
    sassGlob = require('gulp-sass-glob'),
    cssNano = require('gulp-cssnano'),
    cssBase64 = require('gulp-css-base64'),

    // JavaScript
    babel = require('gulp-babel'),
    jsLint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    addSrc = require('gulp-add-src'),
    uglify = require('gulp-uglify'),
    webpack = require('gulp-webpack'),

    // PHP
    phpcs = require('gulp-phpcs');

/**
 * Setup files to watch
 *
 * Concat contains extra files to concat
 */
var files = {
  sass: ['assets/styles/**/*.scss'],
  js: [
    'assets/scripts/**/*.js',
    '!assets/scripts/output/*.js'
  ],
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
gulp.task('scssLint', function() {
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
gulp.task('base64', ['scssLint'], function() {
  return gulp.src('bower_components/fancybox/source/*.css')

  // Base64 images
  .pipe(cssBase64())

  // Write output
  .pipe(gulp.dest('bower_components/fancybox/source/'));
});

/**
 * Compile Sass
 */
gulp.task('sass', ['scssLint', 'base64'], function() {
  return gulp.src(files.sass)

  //Glob
  .pipe(sassGlob())

  // Don't stop watch on error (just log it)
  .pipe(sass().on('error', sass.logError))

  // Minify, prefix
  .pipe(cssNano({
    autoprefixer: {
      add: true,
      browsers: ['> 1%']
    },
  }))

  // Write output
  .pipe(gulp.dest('assets/styles/output/'))

  // Reload
  .pipe(liveReload());
});

/**
 * Lint CoffeeScript
 */
gulp.task('jsLint', function() {
  return gulp.src(files.js)

  // Lint
  .pipe(jsLint({
    esversion: 6
  }))

  // Report errors
  .pipe(jsLint.reporter())

  // Make reporter fail task on error
  .pipe(jsLint.reporter('fail'));
});

/**
 * Compile CoffeeScript
 */
gulp.task('js', function() {
  return gulp.src(files.js)

  // Webpack
  .pipe(webpack(require('./webpack.config.js')))

  // Write output
  .pipe(gulp.dest('assets/scripts/output/'))

  // Reload
  .pipe(liveReload());
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
    standard: 'PSR2'
  }))

  // Log errors and fail afterwards
  .pipe(phpcs.reporter('log'))
  .pipe(phpcs.reporter('fail'))

  // Reload
  .pipe(liveReload());
});

/**
 * Twig: Livereload
 */
gulp.task('twig', function() {
  return gulp.src(files.twig)

  // Use cache to filter out unmodified files
  .pipe(cache('twig'))

  // Reload
  .pipe(liveReload());
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

  gulp.watch(files.sass, ['base64', 'scssLint', 'sass']);
  gulp.watch(files.js, ['js']);
  gulp.watch(files.php, ['phpcs']);
  gulp.watch(files.twig, ['twig']);

  liveReload.listen();
});
