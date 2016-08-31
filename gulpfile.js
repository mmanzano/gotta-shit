var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
 mix.sass('gottashit.scss', 'public/css/gottashit.css')
     .scripts(['jquery.min.js', 'analytics.js', 'nearest.js', 'hover.js', 'place_experience.js', 'menu_experience.js', 'rate.js', 'helpers.js'], 'public/js/gottashit.js')
     .scripts(['place_field.js'], 'public/js/gottashit_place_field.js')
     .scripts(['place.js'], 'public/js/gottashit_place.js');
});
