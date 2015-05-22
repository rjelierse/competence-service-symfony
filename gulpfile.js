var browserify = require('browserify');
var watchify = require('watchify');
var stringify = require('stringify');
var gulp = require('gulp');
var gutil = require('gulp-util');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');

var bundler = browserify()
  .transform(stringify(['.html']))
  .add('app/index.js');

gulp.task('css', function () {
  return gulp
    .src([
      'node_modules/angular/angular-csp.css',
      'node_modules/angular-material/angular-material.css'
    ])
    .pipe(gulp.dest('web/styles'));
});

gulp.task('js', bundleProcessor);

gulp.task('default', ['css'], function () {
  var watcher = watchify(bundler);
  
  watcher.on('update', bundleProcessor);
  watcher.on('log', gutil.log);
  
  return bundleProcessor();
});

function bundleProcessor () {
  return bundler.bundle()
    .on('error', gutil.log.bind(gutil, 'Error in Browserify'))
    .pipe(source('app.js'))
    .pipe(buffer())
    .pipe(gulp.dest('web/scripts'));
}
