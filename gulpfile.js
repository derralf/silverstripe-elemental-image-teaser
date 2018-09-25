/*
* If you don't have node.js installed, INSTALL NODE.JS
*
* If you don't have gulp installed:
* sudo npm install --global gulp
* sudo npm install --save-dev gulp
*
* Make sure gulpfile.js and package.json are in the same directory.
* Navigate to directory of gulpfile.js and package.json file and type `npm install`.
*
* In the gulp file, update all paths to location of current theme directory.
* Also update the browserSync proxy to the current project local URL
*
* RECOMMENDED: run `gulp build for initial setup and first time builds. run `gulp watch every time after that.
*
* Run `gulp build` if you want to just run necessary tasks for building the theme
* Run `gulp watch` to watch for any file changes while in development
* Run `gulp` streamlined to run sass, lint and watch tasks
*
* Run `gulp styles`: to build styles only, without watch
* Run `gulp scripts` to build js only, without watch
* Run `gulp images` to build images only, without watch
*
* Add --production parameter to minify CSS and JS. For example:
* - `gulp --production`
* - `gulp build --production`
* - `gulp watch --production`
*
*
* NOTE: Browser Sync will run when running any task associated with the 'watch' task (including the default task). This will open a new tab at
* http://localhost:3000. In the command line you can find the links for local and external. There are also links for the UI to adjust options.
*
*/



var gulp            =   require('gulp'),
    pump            =   require('pump'),
    sass            =   require('gulp-sass'),
    path            =   require('path'),
    include         =   require('gulp-include'),
    autoprefixer    =   require('gulp-autoprefixer'),
    minify          =   require('gulp-cssnano'),
    uglify          =   require('gulp-uglify'),
    notify          =   require('gulp-notify'),
    sourcemaps      =   require('gulp-sourcemaps'),
    imagemin        =   require('gulp-imagemin'),
    svgtopng        =   require('gulp-svg2png'),
    util            =   require('gulp-util'),
    gulpif          =   require('gulp-if');


var config = {
    // Production-Mode / Sourcemaps ?
    production: !!util.env.production,
    sourceMaps: !!util.env.sourcemaps,
    // Source Config
    src_images          :    './client/src/images/',                                   // Source Images Directory
    src_javascripts     :    './client/src/js/',                               // Source Javascripts Directory
    src_stylesheets     :    './client/src/styles/',                                     // Source Styles Sheets Directory
    // Destination Config
    dist_images         :    './client/dist/images/',                                       // Destination Images Directory
    dist_javascripts    :    './client/dist/js/',                                   // Destination Javascripts Directory
    dist_stylesheets    :    './client/dist/styles/',                                          // Destination Styles Sheets Directory
    // Auto Prefixer
    autoprefix          :    ['last 3 versions', 'ie >= 9', 'and_chr >= 2.3']  // Browser Versions for Auto Prefixer to use
};


// Styles
gulp.task('styles', function () {
    return gulp.src(path.join(config.src_stylesheets, '/**/*.scss'))
        .pipe(gulpif(config.sourceMaps, sourcemaps.init()))

        .pipe(sass({
            includePaths: config.src_includePaths,
            errLogToConsole: true,
        }).on("error", notify.onError(function (error) {
            return "Error: " + error.message;
        })))
        .pipe(autoprefixer(config.autoprefix))
        .pipe(config.production ? minify({zindex: false}) : util.noop())
        .pipe(gulpif(config.sourceMaps, sourcemaps.write('./')))
        .pipe(gulp.dest(config.dist_stylesheets))
        .pipe(notify("sass complete"));
});


// Scripts
gulp.task('scripts', function (cb) {
    pump([
            gulp.src(path.join(config.src_javascripts, '/[^_]*.js')),
            include(),
            config.production ? uglify({preserveComments:false}) : util.noop(),
            gulp.dest(config.dist_javascripts),
        ],
        cb
    );
});


// SVG to PNG
gulp.task('svgtopng', function () {
    gulp.src(path.join(config.src_images, '/**/*.svg'))
        .pipe(svgtopng())
        .pipe(gulp.dest(config.src_images));
});


// Image Optimization (all files but *.psd)
gulp.task('images',['svgtopng'], function() {
    return gulp.src(path.join(config.src_images, '/**/!(*.psd|*.ai)'))
        .pipe(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true }))
        .pipe(gulp.dest(config.dist_images));
});

// Watch
gulp.task('watch', function() {
    gulp.watch(path.join(config.src_stylesheets, '/**/*.scss'), ['styles']);
    gulp.watch(path.join(config.src_javascripts, '/**/*.js'), ['scripts']);
});

// Prep
gulp.task('build', ['styles', 'scripts','images']);

// Default
gulp.task('default', ['build'], function() {
    gulp.watch(path.join(config.src_stylesheets, '/**/*.scss'), ['styles']);
    gulp.watch(path.join(config.src_javascripts, '/**/*.js'), ['scripts']);
});

