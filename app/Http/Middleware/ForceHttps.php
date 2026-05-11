<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect requests to canonical HTTPS URL in production.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        $forwardedProto = strtolower(trim((string) explode(',', (string) $request->header('x-forwarded-proto'))[0]));
        $isForwardedHttps = $forwardedProto === 'https';
        $isHttps = $request->secure() || $isForwardedHttps;

        $currentHost = $request->getHost();
        $canonicalHost = preg_replace('/^www\./i', '', $currentHost);

        $needsHostRedirect = ! empty($canonicalHost) && strcasecmp($currentHost, $canonicalHost) !== 0;

        if (! $isHttps || $needsHostRedirect) {
            $targetUrl = 'https://' . ($canonicalHost ?: $currentHost) . $request->getRequestUri();
            return redirect()->to($targetUrl, 301);
        }

        return $next($request);
    }
}
