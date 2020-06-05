let mix = require('laravel-mix');

require('laravel-mix-tailwind');
let atImport = require('postcss-import');


mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .tailwind();
