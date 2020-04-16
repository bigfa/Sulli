"use strict";

const gulp = require("gulp");
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const concat = require("gulp-concat");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const less = require("gulp-less");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const browserify = require("browserify");
//const webpack = require("webpack");
//const webpackconfig = require("./webpack.config.js");
//const webpackstream = require("webpack-stream");
const sass = require("gulp-sass");
const rename = require("gulp-rename");
const eslint = require("gulp-eslint");

// Lint scripts
function scriptsLint() {
  return gulp
    .src(["./assets/js/**/*"])
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

function css() {
  return gulp
    .src("./sass/app.scss")
    .pipe(plumber())
    .pipe(
      sass({
        outputStyle: "expanded"
        // includePaths: require('node-normalize-scss').includePaths
      })
    )
    .pipe(gulp.dest("./build/css/"))
    .pipe(rename({ suffix: ".min" }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest("./build/css/"));
}

/*
function css() {
  return gulp
    .src("./less2020/app.less")
    .pipe(plumber())
    .pipe(less().on('error', function (e){
            console.error(e.message);
            this.emit('end');
        }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest("./vendor/css/"))
}
*/

// Transpile, concatenate and minify scripts
function scripts() {
  return (
    gulp
      .src(["./js/app.js", "./js/modules/*.js"])
      .pipe(plumber())
      //.pipe(webpackstream(webpackconfig, webpack))
      .pipe(concat("app.js"))
      .pipe(
        babel({
          presets: ["@babel/preset-env"]
        })
      )
      .pipe(uglify())
      //.pipe(plumber())
      //.pipe(webpackstream(webpackconfig, webpack))
      //.pipe(concat('all.js'))
      //.pipe(babel({
      //presets: ['@babel/preset-env']
      // }))
      // .pipe(uglify())
      .pipe(gulp.dest("./build/js/"))
  );
}

// Watch files
function watchFiles() {
  gulp.watch(["./js/app.js"], gulp.series(scriptsLint, scripts));
  gulp.watch(["./sass/*"], gulp.series(css));
}

// define complex tasks
const js = gulp.series(scriptsLint, scripts);
const watch = gulp.parallel(watchFiles);
const build = gulp.parallel(watch, gulp.parallel(css, js));

exports.css = css;
exports.js = js;
exports.build = build;
exports.watch = watch;
exports.default = build;
