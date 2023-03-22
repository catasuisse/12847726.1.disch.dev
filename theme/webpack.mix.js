let mix = require('laravel-mix');

require('laravel-mix-polyfill');

mix
.sass('resources/old/scss/main.scss', '/public/assets/frontend/old/css/frontend.css')
.js('resources/old/js/main.js', '/public/assets/frontend/old/js/frontend.js')
.sass('resources/new/scss/main.scss', '/public/assets/frontend/new/css/frontend.css')
.js('resources/new/js/main.js', '/public/assets/frontend/new/js/frontend.js')
.polyfill({
    enabled: true,
    targets: 'Firefox 50, IE 11',
    useBuiltIns: 'usage',
});
