const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/js/app.js', 'js/marketplace.js')
    .sass(__dirname + '/resources/sass/app.scss', 'css/marketplace.css');

if (mix.inProduction()) {
    mix.version();
}