const mix = require('laravel-mix');
require('laravel-mix-purgecss');
require('laravel-mix-tailwind');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig(require('./webpack.config'))
    .tailwind()
    .purgeCss()
;

if (mix.inProduction()) {
    mix.version();
}
