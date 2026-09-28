<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCharsetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Set proper charset header for UTF-8
        $response->header('Content-Type', 'text/html; charset=utf-8');
        $response->header('Content-Language', 'bn');

        return $response;
    }
}
