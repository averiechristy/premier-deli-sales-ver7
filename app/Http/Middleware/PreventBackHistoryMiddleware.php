<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackHistoryMiddleware
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
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        return $response;
    }
}
