const mix = require('laravel-mix');
require('laravel-mix-polyfill');
require('dotenv').config();
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

mix .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/img', 'public/img')
    .js('resources/js/app.js', 'public/js')
    .polyfill({ // will keep compat to old navigators
        enabled: true,
        useBuiltIns: "usage",
        targets: {
            "firefox": 68,
            "safari": 12,
            "ie": 11,
            "chrome": 70,
            "edge": 15
        }
    })
    .postCss('resources/css/app.css', 'public/css', [
        //all the plugins used to make tailwind work
        require("postcss-import"),
        require('tailwindcss'),
        require("autoprefixer"),
    ])
mix.browserSync({
    proxy: 'http://nginx',
    files: ['tailwind.config.js', 'src/js/*.js', 'src/css/*.css', 'templates/**/*.twig']
});
