'use strict';

/**
 * Require dependencies
 */
var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var coffee = require('gulp-coffee');
var gutil = require('gulp-util');

/**
 * Compile Sass
 */
gulp.task('sass', function() {
  gulp.src('assets/styles/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write('assets/styles/output/'))
    .pipe(gulp.dest('assets/styles/output/'));
});

/**
 * Compile CoffeeScript
 */
gulp.task('coffee', function() {
  gulp.src('assets/scripts/**/*.coffee')
    .pipe(coffee({bare: true}).on('error', gutil.log))
    .pipe(gulp.dest('assets/scripts/output/'))
});

/**
 * Watch things
 */
gulp.task('default',function() {
  gulp.watch('assets/styles/**/*.scss',['sass']);
  gulp.watch('assets/scripts/**/*.coffee',['coffee']);
});
