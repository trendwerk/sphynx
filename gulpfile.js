'use strict';

const beep = require('beepbeep'),
      cache = require('gulp-cached'),
      cssBase64 = require('gulp-css-base64'),
      cssNano = require('gulp-cssnano'),
      gulp = require('gulp'),
      liveReload = require('gulp-livereload'),
      plumber = require('gulp-plumber'),
      sass = require('gulp-sass'),
      sassGlob = require('gulp-sass-glob'),
      webpack = require('webpack-stream');

const files = {
  sass: ['styles/**/*.scss'],
  js: [
    'scripts/**/*.js',
    '!scripts/dist/*.js'
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
const gulp_src = gulp.src;

gulp.src = function() {
  return gulp_src.apply(gulp, arguments)
    .pipe(plumber(() => {
      beep();
    }));
};

gulp.task('base64', () => {
  return gulp.src('node_modules/fancybox/dist/css/*.css')
    .pipe(cssBase64())
    .pipe(gulp.dest('node_modules/fancybox/dist/css/'));
});

gulp.task('sass', ['base64'], () => {
  return gulp.src(files.sass)
    .pipe(sassGlob())
    .pipe(sass().on('error', sass.logError))
    .pipe(cssNano({
      autoprefixer: {
        add: true,
        browsers: ['> 0.1%']
      },
      discardComments: {
        removeAll: true
      }
    }))
    .pipe(gulp.dest('styles/dist/'))
    .pipe(liveReload());
});

gulp.task('js', () => {
  return gulp.src('scripts/main.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('scripts/dist/'))
    .pipe(liveReload());
});

gulp.task('php', () => {
  return gulp.src(files.php)
    .pipe(cache('php'))
    .pipe(liveReload());
});

gulp.task('twig', () => {
  return gulp.src(files.twig)
    .pipe(cache('twig'))
    .pipe(liveReload());
});

gulp.task('default', () => {
  gulp.watch(files.sass, ['base64', 'sass']);
  gulp.watch(files.js, ['js']);
  gulp.watch(files.php, ['php']);
  gulp.watch(files.twig, ['twig']);

  liveReload.listen();
});
