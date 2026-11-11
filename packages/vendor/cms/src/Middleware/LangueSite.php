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
 * - langue non publiée par l'établissement → 302 vers la langue principale ;
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

        $cible = LanguesSite::sansLangue('/' . ltrim($request->path(), '/'));
        $query = $request->getQueryString();

        if ($langue === $config['principale']) {
            return redirect()->to($cible . ($query ? '?' . $query : ''), 301);
        }

        // Langue non publiée par l'établissement (non cochée « Publiée » dans
        // Configuration → Langues du site) : la page dans la langue
        // principale plutôt qu'une erreur 404. Temporaire (302) : la langue
        // peut être publiée demain.
        if (! LanguesSite::estVisible($config, $langue)) {
            return redirect()->to($cible . ($query ? '?' . $query : ''), 302)
                ->header('X-Langue-Site', 'non-publiee');
        }

        App::setLocale($langue);
        $request->attributes->set('gx_langue', $langue);
        $route->forgetParameter('langue');

        return $next($request);
    }
}
