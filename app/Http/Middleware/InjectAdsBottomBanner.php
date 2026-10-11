<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pose la bannière publicitaire pleine largeur (zone « banner_bottom_full »)
 * en bas de toutes les pages HTML du site public.
 *
 * Même raison d'être que InjectGoogleAnalytics : le site est rendu par de
 * nombreuses mises en page indépendantes (accueil, destinations, activités,
 * sites d'établissements du CMS, boutique…). Les inclure une à une
 * garantissait d'en oublier ; une seule injection dans la réponse les couvre
 * toutes, y compris les pages à venir.
 *
 * La bannière est insérée juste AVANT </body> — donc après le pied de page,
 * tout en bas du document.
 *
 * Déclaré en middleware GLOBAL : les routes de certains paquets (activités)
 * ne passent pas par le groupe « web ».
 */
class InjectAdsBottomBanner
{
    /** La vue qui dessine la bannière (rendue côté serveur). */
    private const VUE = 'components.ads-bottom-banner';

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldInject($request, $response)) {
            return $response;
        }

        $content = $response->getContent();
        $position = strripos($content, '</body>');

        if ($position === false) {
            return $response;
        }

        try {
            $banniere = View::make(self::VUE, [
                'gxbbLocation' => $this->location($request),
                'gxbbEtab' => $this->etablissement($request),
            ])->render();
        } catch (\Throwable $e) {
            // Une annonce ne vaut pas une page cassée.
            Log::warning('Bannière publicitaire de bas de page : ' . $e->getMessage());

            return $response;
        }

        if (trim($banniere) === '') {
            return $response;
        }

        $response->setContent(substr($content, 0, $position) . $banniere . substr($content, $position));

        return $response;
    }

    private function shouldInject(Request $request, Response $response): bool
    {
        if (! config('ads.bottom_banner_enabled', true)) {
            return false;
        }

        if (! $request->isMethod('GET') || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($response->getStatusCode() !== 200
            || $response instanceof \Symfony\Component\HttpFoundation\StreamedResponse
            || $response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            return false;
        }

        if (! str_contains((string) $response->headers->get('Content-Type', 'text/html'), 'text/html')) {
            return false;
        }

        // Aperçus d'édition : la bannière gênerait la relecture du gabarit.
        if ($request->has('preview_theme') || $request->has('preview')) {
            return false;
        }

        $chemin = '/' . ltrim($request->path(), '/');

        foreach ((array) config('ads.bottom_banner_excluded_paths', []) as $motif) {
            if (preg_match('~' . $motif . '~', $chemin)) {
                return false;
            }
        }

        $content = $response->getContent();

        // Déjà posée (page incluant le partiel elle-même) : pas de doublon.
        return is_string($content) && $content !== '' && ! str_contains($content, 'data-gxbb');
    }

    /**
     * Contexte de la page, au vocabulaire des cases « Pages d'affichage » de
     * l'annonce (Ad::DISPLAY_LOCATIONS côté admin). null quand la page
     * n'appartient à aucune famille : seules les annonces sans restriction
     * paraissent alors.
     *
     * Les chemins hiérarchiques de destination (/amerique-du-nord/canada/…)
     * ne disent pas leur niveau : il est relevé au rendu de la vue par le
     * composeur déclaré dans AppServiceProvider.
     */
    private function location(Request $request): ?string
    {
        $chemin = '/' . ltrim($request->path(), '/');

        if ($chemin === '/') {
            return 'home';
        }

        if (preg_match('~^/activity(/|$)~', $chemin) || preg_match('~^/activites(/|$)~', $chemin)) {
            return 'activities';
        }

        if (preg_match('~^/company/\d+(/|$)~', $chemin)) {
            return 'etablissements';
        }

        // /travel-destination/{type}/{slug} dit son niveau dans l'URL.
        if (preg_match('~^/travel-destination/([a-z]+)(/|$)~', $chemin, $m)) {
            return $this->niveauDestination($m[1]);
        }

        // Pages hiérarchiques (/amerique-du-nord/canada/quebec…) : le niveau
        // n'est pas dans l'URL. Il est rangé sur la requête par le composeur
        // de vue déclaré dans AppServiceProvider, au rendu de la page.
        $type = $request->attributes->get('gx_destination_context');

        return $type ? $this->niveauDestination((string) $type) : null;
    }

    /** « ville » côté données, « city » dans les cases de l'annonce. */
    private function niveauDestination(string $type): ?string
    {
        $type = strtolower(trim($type));
        $type = $type === 'ville' ? 'city' : $type;

        $connus = ['continent', 'country', 'province', 'region', 'secteur', 'city', 'arrondissement', 'quartier'];

        return in_array($type, $connus, true) ? $type : null;
    }

    /** Identifiant de l'établissement pour /company/{id}/… (ciblage de l'annonce). */
    private function etablissement(Request $request): ?int
    {
        $chemin = '/' . ltrim($request->path(), '/');

        return preg_match('~^/company/(\d+)(/|$)~', $chemin, $m) ? (int) $m[1] : null;
    }
}
