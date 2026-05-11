<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect HTTP requests to HTTPS in production.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isForwardedHttps = strtolower((string) $request->header('x-forwarded-proto')) === 'https';

        if (app()->environment('production') && ! $request->secure() && ! $isForwardedHttps) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}

