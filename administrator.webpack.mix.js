const mix = require('laravel-mix');
const webpack = require('webpack');

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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: require.resolve('tinymce/tinymce'),
                use: [
                    'imports-loader?this=>window',
                    'exports-loader?window.tinymce'
                ]
            },
            {
                test: require.resolve('moment'),
                use: [{
                    loader: 'imports-loader?this=>window',
                    options: 'exports-loader?global.moment'
                }]
            },
            {
                test: /tinymce[\\/](themes|plugins)[\\/]/,
                loader: 'imports-loader?this=>window'
            },
            {
                test: /[\/\\]module\.js$/,
                loader: "imports-loader?this=>window"
            }
        ]
    },
    resolve: {
        alias: {
            'jquery-ui/ui/widget': 'blueimp-file-upload/js/vendor/jquery.ui.widget.js'
        }
    },
    plugins: [
        new webpack.IgnorePlugin( /\.\/locale$/ ),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',

        }),
    ],
});

// Build TeknozaCMS Modules
mix.combine('app/Extensions/*/assets/scripts/*', 'resources/assets/modules.js');
mix.combine('app/Extensions/*/assets/styles/*', 'resources/assets/modules.css');

// Compile LESS
mix.less('resources/assets/administrator/less/default.less', 'public/assets/administrator/css/default.less.css').options({ processCssUrls: false });

mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'resources/assets/administrator/css/lumen_bootstrap.min.css',
    'node_modules/bootstrap-sweetalert/dist/sweetalert.css',
    'node_modules/@fortawesome/fontawesome-free/css/all.css',
    'node_modules/blueimp-file-upload/css/jquery.fileupload.css',
    'node_modules/bootstrap-select/dist/css/bootstrap-select.css',
    'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css',
    'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
    'node_modules/morris-js-module/morris.css',
    'public/assets/administrator/css/default.less.css',
    'resources/assets/modules.css'
], 'public/assets/administrator/css/build.css');

mix.js([
    'node_modules/jquery/dist/jquery.js',
    'node_modules/jquery-ui-sortable-npm/jquery-ui-sortable.js',
    'node_modules/popper.js/dist/popper.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'node_modules/bootstrap-sweetalert/dist/sweetalert.js',
    'node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
    'node_modules/blueimp-file-upload/js/jquery.iframe-transport.js',
    'node_modules/blueimp-file-upload/js/jquery.fileupload.js',
    'node_modules/bootstrap-select/dist/js/bootstrap-select.js',
    'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.js',
    'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js',
    'node_modules/raphael/raphael.js',
    'node_modules/morris-js-module/morris.js',
    'resources/assets/administrator/js/default.js',
    'resources/assets/modules.js'
], 'public/assets/administrator/js/build.js');

// Copy TinyMCE skins
mix.copyDirectory('node_modules/tinymce/skins', 'public/assets/administrator/js/skins');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/assets/administrator/js/plugins');

// Copy FontAwesome fonts
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/assets/administrator/webfonts');
