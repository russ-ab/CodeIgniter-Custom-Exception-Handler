var gulp = require('gulp');
var plumber = require('gulp-plumber');

// Paths
var path_src = 'src/';
var path_dist = 'dist/';

var files = [
    path_src + 'application/config/custom_exception.php',
    path_src + 'application/config/hooks.php',
    path_src + 'application/controllers/Exception_tests.php',
    path_src + 'application/core/MY_Exceptions.php',
    path_src + 'application/hooks/ExceptionHook.php',
    path_src + 'application/libraries/Custom_exception.php',
    path_src + 'application/views/exception_tests_view.php',
    path_src + 'sql/custom_exception.sql'
];

// Move files from src to dist
gulp.task('build', function () {
    return gulp.src(files, {base: './src/'})
        .pipe(plumber())
        .pipe(gulp.dest(path_dist));
});

// Gulp Run
gulp.task('default', ['build']);