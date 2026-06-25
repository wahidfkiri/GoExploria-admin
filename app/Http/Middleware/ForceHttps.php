<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect all requests to canonical HTTPS non-www URL
     * when FORCE_HTTPS is enabled in .env.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('app.force_https')) {
            return $next($request);
        }

        $forwardedProto = strtolower(trim((string) explode(',', (string) $request->header('x-forwarded-proto'))[0]));
        $isHttps = $request->secure() || $forwardedProto === 'https';

        $currentHost = $request->getHost();
        $canonicalHost = preg_replace('/^www\./i', '', $currentHost);

        $canonicalUrl = 'https://' . $canonicalHost . $request->getRequestUri();
        $currentScheme = $isHttps ? 'https' : 'http';
        $currentUrl = $currentScheme . '://' . $currentHost . $request->getRequestUri();

        if ($currentUrl !== $canonicalUrl) {
            return redirect()->to($canonicalUrl, 301);
        }

        return $next($request);
    }
}
