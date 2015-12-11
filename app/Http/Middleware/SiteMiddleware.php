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
        $pages = $page->orderBy('ordering','ASC')->get();
        $site['pages'] = $pages;


        // Load controllers pages
        $controllerPages = array();
        foreach ($pages as $page) {
            if ($page->controller != 'pages') {
                $controllerPages[$page->controller] = $page;
            }
        }
        $site['controllersPages'] = $controllerPages;
        
        View::share('site', $site);
        return $next($request);
    }
}
