<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\PageModel;
use Illuminate\Support\Facades\View;

class PagesMiddleware
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
        $pages = PageModel::all();
        View::share('pages', $pages);
        return $next($request);
    }
}
