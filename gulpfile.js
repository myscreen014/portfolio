var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    /*
    |--------------------------------------------------------------------------
    | Admin
    */
    
    /* COPY CSS files */
    mix.copy('resources/assets/css/bootstrap.min.css', 'public/css/bootstrap.min.css');
    mix.copy('resources/assets/css/font-awesome.min.css', 'public/css/font-awesome.min.css');
    mix.copy('resources/assets/fonts', 'public/fonts');
    mix.copy('resources/assets/plugins', 'public/plugins');
    mix.copy('resources/assets/img', 'public/img');

    /* SASS */
    mix.sass([
        'mixins.scss',
        'admin.scss',
        'sb-admin-2.scss',
    ], "public/css/admin.all.css");
    mix.sass([
        'wysiwyg.scss'
    ], "public/css/wysiwyg.css");

    mix.scripts([
        'jquery-1.11.3.min.js',
        'jquery-ui.min.js',
        'bootstrap.min.js',
        'dropzone.js',
        'admin.js',
        'admin.modal.js'
    ], "public/js/admin.all.js" );
   
    

     /*
    |--------------------------------------------------------------------------
    | Site
    */
    mix.sass([
        'mixins.scss',
        'site.grid.scss',
        'site.scss',
    ], "public/css/site.all.css");

    mix.scripts([
        'jquery-1.11.3.min.js',
        'site.js',
    ], "public/js/site.all.js" );

    

    mix.version([
        "public/css/bootstrap.min.css",
        "public/css/font-awesome.min.css",
        "public/css/admin.all.css",
        "public/js/admin.all.js",
        "public/js/site.all.js",
        "public/css/site.all.css",
    ]);
});
