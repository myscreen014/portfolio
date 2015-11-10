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
	
	mix.sass([
        'bootstrap-theme.min.css',
        'bootstrap.min.css',
        'font-awesome.min.css',
        'admin.scss',
        'app.scss'
    ], "public/css/admin.all.css");

    mix.scripts([
    	'jquery-1.11.3.min.js',
        'bootstrap.min.js',
        'jquery-ui.min.js',
    	'dropzone.js',
        'admin.js',
        'admin.modal.js'
    ], "public/js/admin.all.js" );
   
   mix.version(["public/css/admin.all.css", "public/js/admin.all.js"]);

});
