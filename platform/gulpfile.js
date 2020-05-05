const gulp = require("gulp");
const scss = require("gulp-scss");
const autoprefixer = require("gulp-autoprefixer");
const sourcemaps = require("gulp-sourcemaps");
const browserSync = require("browser-sync").create();
const minify = require("gulp-minify");
const concat = require("gulp-concat");
const cleanCss = require("gulp-clean-css");
const php = require("gulp-connect-php");

var paths = {
  HERE: "./",
  DIST: "./dist/",
  CSS: "./css/",
  SCSS_WATCH: "./scss/**/**/*",
  SCSS_SRC: "./scss/demo.scss",
  SCSS_DIST: "demo.css",
  JS_SRC: ["./js/graph.js", "./js/site.js", "./js/app.js"],
  JS_WATCH: ["./js/*.js"],
  JS_DIST: "demo.js"
};

/**
 * Used for error handling.
 * @param {string} error 
 */
var errorHandler = function(error) {
  notify.onError({
    title: "Task Failed [" + error.plugin + "]",
    message: "Oops, something went wrong!",
    sound: true
  })(error);

  // Prevent gulp watch from stopping
  this.emit("end");
};

/**
 * Compiling SCSS, minifying, creating sourcemaps.
 */
gulp.task(
  "compile:scss",
  gulp.series(function(done) {
    gulp
      .src(paths.SCSS_SRC, { allowEmpty: true })
      .pipe(sourcemaps.init())
      .pipe(scss())
      .pipe(concat(paths.SCSS_DIST))
      .pipe(autoprefixer())
      .pipe(cleanCss())
      .on("error", errorHandler)
      .pipe(sourcemaps.write(paths.HERE))
      .pipe(gulp.dest(paths.DIST + "css/"));
    done();
  })
);

/**
 * Compiling Javascript, minifying (in order).
 */
gulp.task(
  "compile:js",
  gulp.series(function(done) {
    gulp
      .src(paths.JS_SRC)
      .pipe(concat(paths.JS_DIST))
      .pipe(
        minify({
          ext: {
            min: ".js"
          },
          noSource: true
        })
      )
      .pipe(gulp.dest(paths.DIST + "/js"));
    done();
  })
);

/**
 * Build task for compiling SCSS and Javascript.
 */
gulp.task(
  "build",
  gulp.parallel("compile:scss", "compile:js", function(done) {
    done();
  })
);

/**
 * Watch task for live development.
 */
gulp.task(
  "watch",
  gulp.series("build", function(done) {
    gulp.watch(paths.SCSS_WATCH, gulp.series("compile:scss"));
    gulp.watch(paths.JS_WATCH, gulp.series("compile:js"));
    done();
  })
);

/**
 * Task for running PHP server, mimicking a live Pantheon server.
 */
gulp.task('php', gulp.series(function(done){
  php.server({base:'./', port:8011, keepalive:true});
  done();
}));

/**
 * Task for serving site with Browsersync, proxying requests to PHP server.
 */
gulp.task(
  "serve",
  gulp.series("php", function(done) {
    browserSync.init({
      server: {
        proxy:"localhost:8011",
        baseDir: "./",
        port: "3011",
        open: true,
        notify: false,
        serveStaticOptions: {
          extensions: ["php, html"]
        }
      }
    });
    // Reloads page when some of the already built files changed:
    gulp.watch(["./dist/**/*", "./*.php", "./*.html"]).on("all", browserSync.reload);
  })
);

/**
 * Default gulp task
 * Starts server, watches code for recompiling, refreshes local server.
 */
gulp.task(
  "default",
  gulp.series("watch", "serve", function(done) {
    done();
  })
);
