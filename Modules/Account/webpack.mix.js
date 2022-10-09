const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/js/app.js', 'js/account.js')
    .sass(__dirname + '/resources/sass/app.scss', 'css/account.css');

if (mix.inProduction()) {
    mix.version();
}