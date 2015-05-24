var gulp        = require('gulp'),
    minifycss   = require('gulp-minify-css'),
    uglify      = require('gulp-uglify'),
    concat      = require('gulp-concat'),
    del         = require('del'),
    replace     = require('gulp-html-replace'),
    minifyhtml  = require('gulp-minify-html'),
    ngannotate  = require('gulp-ng-annotate'),
    templateCache = require('gulp-angular-templatecache'),
    gulpif = require('gulp-if');

gulp.task('clean', function(cb) {
    del(['build/*'], cb);
});

gulp.task('scripts', function() {

  gulp.src([
    'app/components/jquery/dist/jquery.min.js',
    'app/components/angular.js/angular.min.js',
    'app/components/bootstrap/dist/js/bootstrap.min.js',
    'app/components/angular.js/angular-route.min.js',
    'app/components/qrcode-generator/js/qrcode.js',
    'app/components/angular-qrcode/qrcode.js',
    'app/app.js',
    'app/scripts/**/*.js',
    'app/**/*.html'
  ])

  .pipe(gulpif(/^((?!(\.min\.js|\.html|qrcode.js)).)*$/, ngannotate()))
  .pipe(gulpif(/^((?!(\.min\.js|\.html)).)*$/, uglify()))
  .pipe(gulpif(/html$/,minifyhtml()))
  .pipe(gulpif(/html$/,templateCache({standalone: true})))
  .pipe(concat('main.js'))
  .pipe(gulp.dest('build/'));
});

gulp.task('images', function() {
  gulp.src('app/images/*')
  .pipe(gulp.dest('build/images/'));
});

gulp.task('styles', function() {
    gulp.src(['app/components/bootstrap/dist/css/bootstrap.min.css','app/components/bootstrap/dist/css/bootstrap-theme.min.css'])
    .pipe(concat('main.css'))
    .pipe(minifycss({}))
    .pipe(gulp.dest('build/styles/'));

    gulp.src("app/components/bootstrap/dist/fonts/*")
    .pipe(gulp.dest('build/fonts/'));
});

gulp.task('index', function() {
    gulp.src('app/index.html')
    .pipe(replace({
        js: ['main.js'],
        css: 'styles/main.css'
    }))
    .pipe(minifyhtml())
    .pipe(gulp.dest('build/'));
});

gulp.task('api', function() {
    gulp.src('app/api/**/*.php')
    .pipe(gulp.dest('build/api/'));
});

gulp.task('default', ['clean'], function() {
    gulp.start('api', 'styles', 'scripts', 'index', 'images');
});
