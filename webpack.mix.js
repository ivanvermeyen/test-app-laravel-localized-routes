const mix = require('laravel-mix');

require('mix-tailwindcss');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js');
mix.extract(['vue']);

mix.sass('resources/sass/app.scss', 'public/css');
mix.tailwind();
mix.purgeCss();

mix.version();
