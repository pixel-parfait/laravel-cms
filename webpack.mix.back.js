const mix = require('laravel-mix');

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

mix.setPublicPath('public/back')
    .js('resources/js/admin/main.js', 'public/back/js').vue()
    .copy('node_modules/tinymce/skins', 'public/back/js/skins')
    .sass('resources/sass/admin.scss', 'public/back/css')
    .sass('resources/sass/editor.scss', 'public/back/css');

mix.extract();

if (mix.inProduction()) {
    mix.version();
}
