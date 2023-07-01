let mix = require('laravel-mix');

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

mix.sass('resources/assets/sass/gottashit.scss', 'public/css/gottashit.css')
    .scripts([
        'node_modules/leaflet/dist/leaflet.js',
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/analytics.js',
        'resources/assets/js/nearest.js',
        'resources/assets/js/hover.js',
        'resources/assets/js/place_experience.js',
        'resources/assets/js/menu_experience.js',
        'resources/assets/js/rate.js',
        'resources/assets/js/helpers.js'
    ], 'public/js/gottashit.js')
    .copy('node_modules/leaflet/dist/images/*', 'public')
    .scripts(['resources/assets/js/place_field.js'], 'public/js/gottashit_place_field.js')
    .scripts(['resources/assets/js/place.js'], 'public/js/gottashit_place.js')
    .js('resources/assets/js/app.js', 'public/js/app.js')
    .sourceMaps()
    .version();
