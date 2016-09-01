'use strict';

var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    colors = require('colors'),
    plumber = require('gulp-plumber'),
    liveReload = require('gulp-livereload'),

    scssLint = require('gulp-scss-lint'),
    sass = require('gulp-sass'),
    sassGlob = require('gulp-sass-glob'),
    cssNano = require('gulp-cssnano'),
    cssBase64 = require('gulp-css-base64'),

    webpack = require('webpack-stream'),

    phpcs = require('gulp-phpcs');

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
  twig: ['templates/**/*.twig']
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
 * Tasks
 */
gulp.task('scssLint', function() {
  return gulp.src(files.sass)
    .pipe(cache('scssLint'))
    .pipe(scssLint({
      'config': 'config/lint/scss.yml'
    }))
    .pipe(scssLint.failReporter());
});

gulp.task('base64', ['scssLint'], function() {
  return gulp.src('bower_components/fancybox/source/*.css')
    .pipe(cssBase64())
    .pipe(gulp.dest('bower_components/fancybox/source/'));
});

gulp.task('sass', ['scssLint', 'base64'], function() {
  return gulp.src(files.sass)
    .pipe(sassGlob())
    .pipe(sass().on('error', sass.logError))
    .pipe(cssNano({
      autoprefixer: {
        add: true,
        browsers: ['> 1%']
      },
    }))
    .pipe(gulp.dest('assets/styles/output/'))
    .pipe(liveReload());
});

gulp.task('js', function() {
  return gulp.src('assets/scripts/main.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('assets/scripts/output/'))
    .pipe(liveReload());
});

gulp.task('phpcs', function() {
  return gulp.src(files.php)
    .pipe(cache('phpcs'))
    .pipe(phpcs({
      bin: 'vendor/bin/phpcs',
      standard: 'PSR2'
    }))
    .pipe(phpcs.reporter('log'))
    .pipe(phpcs.reporter('fail'))
    .pipe(liveReload());
});

gulp.task('twig', function() {
  return gulp.src(files.twig)
    .pipe(cache('twig'))
    .pipe(liveReload());
});

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

gulp.task('default', function() {
  console.log(welcomeMessage.cyan);

  gulp.watch(files.sass, ['base64', 'scssLint', 'sass']);
  gulp.watch(files.js, ['js']);
  gulp.watch(files.php, ['phpcs']);
  gulp.watch(files.twig, ['twig']);

  liveReload.listen();
});
