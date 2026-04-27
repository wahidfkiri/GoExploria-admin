<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['fr', 'en', 'es', 'de', 'it'];

        $locale = (string) $request->session()->get('locale', 'fr');

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = 'fr';
        }

        App::setLocale($locale);

        return $next($request);
    }
}

