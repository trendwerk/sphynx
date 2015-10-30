"use strict"

/**
 * Require dependencies
 */
var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    colors = require('colors'),
    plumber = require('gulp-plumber'),
    sourcemaps = require('gulp-sourcemaps'),
    livereload = require('gulp-livereload'),

    // Sass
    scsslint = require('gulp-scss-lint'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    minify = require('gulp-minify-css'),
    cssBase64 = require('gulp-css-base64'),

    // Coffee
    coffeelint = require('gulp-coffeelint'),
    coffee = require('gulp-coffee'),
    concat = require('gulp-concat'),
    addsrc = require('gulp-add-src'),
    uglify = require('gulp-uglify'),

    // PHP
    phpcs = require('gulp-phpcs');

/**
 * Setup files to watch
 *
 * Concat contains extra files to concat
 */
var files = {
  sass: 'assets/styles/**/*.scss',
  coffee: ['assets/scripts/**/*.coffee', '!assets/scripts/defer.coffee'],
  defer: 'assets/scripts/defer.coffee',
  php: ['**/*.php', '!vendor/**/*.*', '!node_modules/**/*.*'],
  twig: ['templates/**/*.twig'],
  concat: {
    coffee: [
      'bower_components/fancybox/source/jquery.fancybox.js'
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
}

/**
 * Lint Sass
 */
gulp.task('scsslint', function(cb) {
  return gulp.src(files.sass)
  // Lint
  .pipe(scsslint({
    'config': 'config/lint/scss.yml'
  }))

  // Make the reporter fail task on error
  .pipe(scsslint.failReporter())
});

/**
 * Base64 Fancybox images
 */
gulp.task('base64', ['scsslint'], function() {
  return gulp.src('bower_components/fancybox/source/*.css')
  // Base64 images
  .pipe(cssBase64())

  // Write output
  .pipe(gulp.dest('bower_components/fancybox/source/'))
});

/**
 * Compile Sass
 */
gulp.task('sass', ['scsslint', 'base64'], function() {
  return gulp.src(files.sass)

  // Init sourcemaps
  .pipe(sourcemaps.init())

  // Don't stop watch on error (just log it)
  .pipe(sass().on('error', sass.logError))

  // Autoprefixer
  .pipe(autoprefixer())

  // Minify
  .pipe(rename({suffix: '.min'}))
  .pipe(minify())

  // Write sourcemaps
  .pipe(sourcemaps.write('.'))

  // Write output
  .pipe(gulp.dest('assets/styles/output/'))

  // Reload
  .pipe(livereload())
});

/**
 * Lint CoffeeScript
 */
gulp.task('coffeelint', function() {
  return gulp.src(files.coffee)

  // Lint
  .pipe(coffeelint())

  // Report errors
  .pipe(coffeelint.reporter())

  // Make reporter fail task on error
  .pipe(coffeelint.reporter('fail'))
});

/**
 * Compile CoffeeScript
 */
gulp.task('coffee', ['coffeelint'], function() {
  gulp.src(files.coffee)

  // Init sourcemaps
  .pipe(sourcemaps.init())

  // Compile
  .pipe(coffee({bare: true}))

  .pipe(addsrc.prepend(files.concat.coffee))

  // Concat
  .pipe(concat('all.js'))

  // Uglify
  .pipe(uglify())

  // Write sourcemaps
  .pipe(sourcemaps.write('.'))

  // Write output
  .pipe(gulp.dest('assets/scripts/output/'))

  // Reload
  .pipe(livereload())
});

// Compile defer
gulp.task('defer', ['coffeelint'], function() {
  gulp.src('assets/scripts/defer.coffee')

  // Init sourcemaps
  .pipe(sourcemaps.init())

  // Compile
  .pipe(coffee({bare: true}))

  // Uglify
  .pipe(uglify())

  // Write sourcemaps
  .pipe(sourcemaps.write('.'))

  // Write output
  .pipe(gulp.dest('assets/scripts/output/'))

  // Reload
  .pipe(livereload())
});

/**
 * PHP CodeSniffer (PSR)
 */
gulp.task('phpcs', function() {
  gulp.src(files.php)

  // Use cache to filter out unmodified files
  .pipe(cache('phpcs'))

  // Sniff code
  .pipe(phpcs({
    bin: '~/.composer/vendor/bin/phpcs',
    standard: 'PSR2',
    warningSeverity: 0
  }))

  // Log errors and fail afterwards
  .pipe(phpcs.reporter('log'))
  .pipe(phpcs.reporter('fail'))

  // Reload
  .pipe(livereload())
});

/**
 * Twig: Livereload
 */
gulp.task('twig', function() {
  gulp.src(files.twig)

  // Use cache to filter out unmodified files
  .pipe(cache('twig'))

  // Reload
  .pipe(livereload())
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
].join("\n");

/**
 * Watch
 */
gulp.task('default', function() {
  console.log(welcomeMessage.cyan);
  gulp.watch(files.sass, ['base64', 'scsslint', 'sass']);
  gulp.watch(files.coffee, ['coffeelint', 'coffee']);
  gulp.watch(files.defer, ['defer']);
  gulp.watch(files.php, ['phpcs']);
  gulp.watch(files.twig, ['twig']);
  livereload.listen();
});
