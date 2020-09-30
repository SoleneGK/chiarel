const { src, dest } = require('gulp');

const sass = require('gulp-sass');
sass.compiler = require('node-sass');

const purgeCss = require('gulp-purgecss');

const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');

const cleanCss = require('gulp-clean-css');

const scss_file_to_compile_path = './node_modules/bootstrap/scss/bootstrap.scss';
const css_dest_file_path = '../public/css/';

function compileScss(cb) {
	return src(scss_file_to_compile_path)
		.pipe(sass())
		.pipe(purgeCss({
			content: ['../templates/**/*.html.twig']
		}))
		.pipe(postcss([ autoprefixer() ]))
		.pipe(cleanCss())
		.pipe(dest(css_dest_file_path));
}

exports.css = compileScss;