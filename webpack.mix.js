const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').js('resources/js/sample.js',
'public/js').js('resources/js/sb-admin-2.js',
'public/js').js('resources/js/sb-admin-2.min.js',
'public/js').autoload({
    "jquery": ['$', 'window.jQuery'],
}).postCss( 'resources/css/app.css', 'public/css', [
    require( 'postcss-import' ),
    require( 'tailwindcss' ),
    require( 'autoprefixer'),
]).sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
