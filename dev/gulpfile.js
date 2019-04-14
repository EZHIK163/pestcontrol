'use strict';

var gulp = require('gulp');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var plumber = require('gulp-plumber');
var babel = require('gulp-babel');
var env = require('babel-preset-env');
var concat = require('gulp-concat');

var paths = {
  inner: [
      './my_js.js',
  ],
  html: []
};

gulp.task('default', ['dist_js']);

gulp.task('build', ['dist_js']);

gulp.task('dist_js', function(done) {
    gulp.src(paths.inner)
      .pipe(plumber())
      .pipe(babel({
          presets: ["env"],
          plugins: [
              'syntax-async-functions',
              'transform-async-to-generator',
              'transform-regenerator',
          ]
      }))
      .pipe(concat('new_my.js'))
      .pipe(uglify())
      .pipe(gulp.dest('../assets/ui/js'))
      .on('end', done);
});


gulp.task('watch', function() {
    gulp.watch(paths.inner, ['dist_js']);
});