var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var concatCss = require('gulp-concat-css');

gulp.task('sass', function () {
    gulp.src('./src/**/*.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concatCss("./web/assets/custom/css/main.css"))
        .pipe(gulp.dest('./'));
});

gulp.task('default', ['sass']);