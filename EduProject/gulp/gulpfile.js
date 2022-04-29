/* Import dependencies */
const { src, dest, series, parallel } = require('gulp');
const useref = require('gulp-useref'),
    gulpIf = require('gulp-if'),
    terser = require('gulp-terser'),
    cssnano = require('gulp-cssnano'),
    imagemin = require('gulp-imagemin'),
    cache = require('gulp-cache');


/* Build the source files (minify and bundle CSS and JavaScript files) */
function build_sources(cb) {
    src('src/public/*.html')
        .pipe(useref())
        .pipe(gulpIf('*.js', terser()))
        .pipe(gulpIf('*.css', cssnano()))
        .pipe(dest('dist/public/'));
    return cb();
}


/* Skip certain files (PHP) */
function passthrough_files(cb) {
    src('src/public/*.php')
        .pipe(dest('dist/public/'));
    return cb();
};


/* Optimise images */
function optimise_images(cb) {
    src('src/public/images/*.+(png|jpg|gif|svg)')
        .pipe(cache(imagemin()))
        .pipe(dest('dist/public/images/'));
    return cb();
}


/* Optimise CSS background images, if need be. */
function optimise_css_images(cb) {
    src('src/public/css/images/*.+(png|jpg|gif|svg)')
        .pipe(cache(imagemin()))
        .pipe(dest('dist/public/css/images/'));
    return cb();
}


/* Clear the cache */
function clear_cache(cb) {
    return cache.clearAll(cb);
}


/* Export two tasks: a task to build the project and a task to clear the cache. */
exports.build = parallel(
    build_sources,
    passthrough_files,
    optimise_images,
    optimise_css_images
);
exports.clear_cache = clear_cache;