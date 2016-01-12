<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/* My uses */
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(Config::get('app.locale'));

        app('view')->composer('admin', function($view)
        {
            $action = app('request')->route()->getAction();
            $controller = class_basename($action['controller']);
            list($controllerName, $action) = explode('@', $controller);
            $controllerName = strtolower(str_replace('Component', '', $controllerName));
            $view->with(compact('controllerName', 'action'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Load services according environment
        if ($this->app->environment('local')) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }
}
