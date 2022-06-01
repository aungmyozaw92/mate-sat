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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// mix.js([
//     'resources/backend/plugins/jquery/jquery.min.js',
//     'resources/backend/plugins/bootstrap/js/bootstrap.bundle.min.js',
//     'resources/backend/dist/js/adminlte.min.js'
//     ], 'public/js')
// .styles([
//         'resources/backend/plugins/fontawesome-free/css/all.min.css',
//         'resources/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
//         'resources/backend/dist/css/adminlte.min.css'
//     ], 'public/css/all.css')
// .sass('resources/sass/app.scss', 'public/css');
