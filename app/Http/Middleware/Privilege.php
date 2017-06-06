<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Privilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $accesses)
    {
        $accessesArray = explode('&', $accesses);
        foreach ($accessesArray as $access) {
            if (Auth::user()->hasAccess($access))
                return $next($request);
        }
        return ('<h1>Sorry : unauthenticated from middleware</h1>');
    }
}
