var gulp = require('gulp'),
    configLocal = require('./gulp-config.json'),
    merge = require('merge'),
    sass = require('gulp-sass'),
    rename = require('gulp-rename'),
    scsslint = require('gulp-scss-lint'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    readme = require('gulp-readme-to-markdown'),
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

// Compile primary scss files
gulp.task('css-main', function() {
  gulp.src(config.scssPath + '/ucf-events.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9'],
      cascade: false
    }))
    .pipe(cleanCSS({compatibility: 'ie9'}))
    .pipe(rename('ucf-events.min.css'))
    .pipe(gulp.dest(config.cssPath))
    .pipe(browserSync.stream());
});


// Create a Github-flavored markdown file from the plugin readme.txt
gulp.task('readme', function() {
  gulp.src(['readme.txt'])
    .pipe(readme({
      details: false,
      screenshot_ext: [],
    }))
    .pipe(gulp.dest('.'));
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

  gulp.watch(config.scssPath + '/**/*.scss', ['css']);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
  gulp.watch('readme.txt', ['readme']);
});

// Default task
gulp.task('default', ['css', 'readme']);
