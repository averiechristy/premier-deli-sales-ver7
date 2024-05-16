<?php

namespace App\Http\Middleware;

use Closure;

class RefreshBackButton
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

        // Menambahkan header untuk menandai halaman yang tidak bisa disimpan di cache
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

        return $response;
    }
}
