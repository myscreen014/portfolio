<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\PageModel;
use Illuminate\Support\Facades\View;

class SiteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $site = array();

        // Load pages
        $page = new PageModel;
        $site['pages'] = array(
            'primary'   => $page->where('menu', 'primary')->orderBy('ordering','ASC')->get(),
            'secondary' => $page->where('menu', 'secondary')->orderBy('ordering','ASC')->get(),
        );


        // Load controllers pages
        /* 
       $controllerPages = array();
        foreach ($pages as $page) {
            if ($page->controller != 'pages') {
                $controllerPages[$page->controller] = $page;
            }
        }
        $site['controllersPages'] = $controllerPages;
        */
        
        View::share('site', $site);
        return $next($request);
    }
}
