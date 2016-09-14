var gulp = require('gulp'),
    configLocal = require('./gulp-config.json'),
    merge = require('merge'),
    sass = require('gulp-sass'),
    bless = require('gulp-bless'),
    rename = require('gulp-rename'),
    scsslint = require('gulp-scss-lint'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    browserSync = require('browser-sync').create();

var configDefault = {
    scssPath: './src/scss',
    cssPath: './static/css'
  },
  config = merge(configDefault, configLocal);


// Lint all scss files
gulp.task('scss-lint', function() {
  gulp.src(config.scssPath + '/*.scss')
    .pipe(scsslint());
});

// Compile + bless primary scss files
gulp.task('css-main', function() {
  gulp.src(config.scssPath + '/ucf-events.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9'],
      cascade: false
    }))
    .pipe(cleanCSS({compatibility: 'ie9'}))
    .pipe(rename('ucf-events.min.css'))
    .pipe(bless())
    .pipe(gulp.dest(config.cssPath))
    .pipe(browserSync.stream());
});


// All css-related tasks
gulp.task('css', ['scss-lint', 'css-main']);

// Rerun tasks when files change
gulp.task('watch', function() {
  if (config.sync) {
    browserSync.init({
        proxy: {
          target: config.target
        }
    });
  }

  gulp.watch(config.scssPath + '/**/*.scss', ['css']).on('change', browserSync.reload);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
});

// Default task
gulp.task('default', ['css']);
