<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\PageModel;
use Illuminate\Support\Facades\View;

/* My uses */
use Illuminate\Support\Facades\Auth;

class AuthAdministratorMiddleware
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
        if (Auth::user()->role != 'admin') {
        	return redirect(route('page'));
        }
        return $next($request);
    }
}
