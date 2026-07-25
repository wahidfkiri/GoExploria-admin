<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force le SCHÉMA https pour les URLs générées + envoie l'en-tête HSTS.
 *
 * ⚠ Aucune redirection d'hôte/scheme n'est faite ici : les redirections
 * canoniques (retrait du www + http→https) sont gérées EXCLUSIVEMENT par
 * public/.htaccess (niveau Apache, avant Laravel). Avoir les deux couches qui
 * redirigent provoquait une boucle « trop de redirections » (le .htaccess
 * retirait le www, un ancien canonical_host=www le rajoutait). On garde donc
 * une seule autorité de redirection : le .htaccess.
 */
class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        $forceHttps = (bool) config('app.force_https', false);

        if ($forceHttps) {
            URL::forceScheme('https');
        }

        $response = $next($request);

        if ($forceHttps && $request->isSecure()) {
            $seconds = max(0, (int) config('app.https_hsts_seconds', 31536000));
            if ($seconds > 0) {
                $response->headers->set('Strict-Transport-Security', 'max-age=' . $seconds . '; includeSubDomains; preload');
            }
        }

        return $response;
    }
}
