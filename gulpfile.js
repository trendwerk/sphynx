'use strict';

const gulp = require('gulp'),
      cache = require('gulp-cached'),
      beep = require('beepbeep'),
      colors = require('colors'),
      plumber = require('gulp-plumber'),
      liveReload = require('gulp-livereload'),
      sass = require('gulp-sass'),
      sassGlob = require('gulp-sass-glob'),
      cssNano = require('gulp-cssnano'),
      cssBase64 = require('gulp-css-base64'),
      webpack = require('webpack-stream');

const files = {
  sass: ['assets/styles/**/*.scss'],
  js: [
    'assets/scripts/**/*.js',
    '!assets/scripts/dist/*.js'
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
    .pipe(gulp.dest('assets/styles/dist/'))
    .pipe(liveReload());
});

gulp.task('js', () => {
  return gulp.src('assets/scripts/main.js')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('assets/scripts/dist/'))
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

const welcomeMessage = [
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

gulp.task('default', () => {
  gulp.watch(files.sass, ['base64', 'sass']);
  gulp.watch(files.js, ['js']);
  gulp.watch(files.php, ['php']);
  gulp.watch(files.twig, ['twig']);

  liveReload.listen();

  console.log(welcomeMessage.cyan);
});
