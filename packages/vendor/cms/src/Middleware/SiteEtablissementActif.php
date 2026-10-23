<?php

namespace Vendor\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

/**
 * Site web d'un établissement désactivé depuis l'admin (onglet Tableau de
 * bord → « Site web ») : toutes les pages /company/{id}/… affichent « site
 * momentanément indisponible » (HTTP 503, temporaire : les moteurs de
 * recherche gardent l'adresse).
 *
 * Lit la colonne `etablissements.site_actif`, posée par une migration de
 * l'admin (base partagée). Colonne absente, établissement inconnu ou base en
 * panne : on laisse passer — la page fera son propre 404 au besoin, et un
 * incident de lecture ne doit jamais éteindre tous les sites.
 *
 * Distinct de `is_active` (présence dans la recherche, repris du legacy).
 */
class SiteEtablissementActif
{
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('etablissementId');

        if (! is_numeric($id) || ! self::colonnePresente()) {
            return $next($request);
        }

        try {
            $etab = DB::table('etablissements')
                ->where('id', (int) $id)
                ->first(['id', 'name', 'site_actif']);
        } catch (\Throwable $e) {
            Log::warning('SiteEtablissementActif : lecture impossible', ['id' => $id, 'error' => $e->getMessage()]);

            return $next($request);
        }

        if (! $etab || (bool) $etab->site_actif) {
            return $next($request);
        }

        // Appels JSON (API pages, recherche ajax, panier…) : réponse JSON.
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce site est momentanément indisponible.',
            ], 503);
        }

        return response()
            ->view('cms::web.site-desactive', ['nomEtablissement' => (string) $etab->name], 503)
            ->header('Retry-After', '86400')
            ->header('Cache-Control', 'no-store, max-age=0');
    }

    private static function colonnePresente(): bool
    {
        static $present = null;

        try {
            return $present ??= Schema::hasColumn('etablissements', 'site_actif');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
