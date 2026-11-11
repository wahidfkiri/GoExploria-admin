<?php

namespace Vendor\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Vendor\Cms\Support\LanguesSite;

/**
 * Segment de langue des sites d'établissement : /company/{id}/{langue}/...
 * (sites multilingues, étape 1 — docs/CONCEPTION-MULTILINGUE.md côté admin).
 *
 * - langue principale demandée avec préfixe → 301 vers l'adresse sans préfixe
 *   (une seule adresse par contenu) ;
 * - langue non publiée par l'établissement → 404 ;
 * - sinon : locale de l'application, attribut `gx_langue` de la requête, et
 *   le paramètre `langue` est RETIRÉ de la route, pour que les actions du
 *   contrôleur gardent leur signature (etablissementId, slug…).
 */
class LangueSite
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $langue = (string) $route->parameter('langue');
        $config = LanguesSite::pour((int) $route->parameter('etablissementId'));

        if ($langue === $config['principale']) {
            $cible = LanguesSite::sansLangue('/' . ltrim($request->path(), '/'));
            $query = $request->getQueryString();

            return redirect()->to($cible . ($query ? '?' . $query : ''), 301);
        }

        if (! LanguesSite::estVisible($config, $langue)) {
            abort(404);
        }

        App::setLocale($langue);
        $request->attributes->set('gx_langue', $langue);
        $route->forgetParameter('langue');

        return $next($request);
    }
}
