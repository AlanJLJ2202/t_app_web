const mix = require('laravel-mix');
mix.disableNotifications();
mix.browserSync({
   proxy: 't_app.test',
    port: 22051
});

mix.stylus('resources/stylus/global.styl', 'public/css').version().options({ processCssUrls: false });
mix.stylus('resources/stylus/dashboard.styl', 'public/css').version().options({ processCssUrls: false });
mix.stylus('resources/stylus/dashboard_cargos.styl', 'public/css').version().options({ processCssUrls: false });
mix.stylus('resources/stylus/listas.styl', 'public/css').version().options({ processCssUrls: false });



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

mix.js(['resources/js/transaccion.js'], 'public/js/transaccion.js').vue(2).version();
mix.js(['resources/js/listas_compras.js'], 'public/js/listas_compras.js').vue(2).version();

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
