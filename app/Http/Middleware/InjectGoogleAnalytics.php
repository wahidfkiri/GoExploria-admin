<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pose la balise Google Analytics 4 sur toutes les pages HTML du site public.
 *
 * Le site est rendu par de nombreuses mises en page indépendantes (accueil,
 * destinations, activités, landing, sites des établissements générés par le
 * CMS…) : une injection unique dans la réponse évite d'oublier l'une d'elles.
 *
 * Chaque page porte deux paramètres lus par le module « Statistiques du site »
 * de l'administration :
 *   - page_type        : destinations | activites | etablissements | landing | accueil | autres
 *   - etablissement_id : identifiant de l'établissement pour /company/{id}/…
 * Pour que GA4 les expose, les déclarer en dimensions personnalisées
 * (portée Événement) dans Administration > Définitions personnalisées.
 *
 * Déclaré en middleware GLOBAL : les routes du package activités ne passent
 * pas par le groupe « web ».
 */
class InjectGoogleAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $id = $this->measurementId();

        if ($id === '' || !$this->shouldInject($request, $response, $id)) {
            return $response;
        }

        $content = $response->getContent();

        // Au plus tôt dans <head>. `<head\b` ne correspond pas à <header>.
        if (preg_match('~<head\b[^>]*>~i', $content, $m, PREG_OFFSET_CAPTURE)) {
            $pos = $m[0][1] + strlen($m[0][0]);
        } elseif (($pos = stripos($content, '</head>')) === false) {
            return $response;
        }

        $response->setContent(substr($content, 0, $pos) . $this->snippet($request, $id) . substr($content, $pos));

        return $response;
    }

    /**
     * ID saisi dans l'admin (Statistiques › Configuration, table partagée
     * `site_settings`), sinon celui du .env. Lecture en cache 10 min via
     * SiteSetting ; la base injoignable ne doit jamais casser une page.
     */
    private function measurementId(): string
    {
        $fallback = (string) config('services.google_analytics.measurement_id');

        try {
            $id = (string) SiteSetting::get('analytics_measurement_id', $fallback);
        } catch (\Throwable) {
            $id = $fallback;
        }

        $id = strtoupper(trim($id));

        return preg_match('/^G-[A-Z0-9]{4,20}$/', $id) ? $id : '';
    }

    private function shouldInject(Request $request, Response $response, string $id): bool
    {
        if (!$request->isMethod('GET') || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($response->getStatusCode() !== 200
            || $response instanceof \Symfony\Component\HttpFoundation\StreamedResponse
            || $response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            return false;
        }

        if (!str_contains((string) $response->headers->get('Content-Type', 'text/html'), 'text/html')) {
            return false;
        }

        // Aperçus d'édition : jamais comptés comme des visites.
        if ($request->has('preview_theme') || $request->has('preview')) {
            return false;
        }

        $path = '/' . ltrim($request->path(), '/');
        foreach ((array) config('services.google_analytics.excluded_paths', []) as $pattern) {
            if (preg_match('~' . $pattern . '~', $path)) {
                return false;
            }
        }

        $content = $response->getContent();

        return is_string($content)
            && $content !== ''
            // Balise déjà présente (posée à la main dans un gabarit).
            && !str_contains($content, 'googletagmanager.com/gtag/js?id=' . $id);
    }

    private function snippet(Request $request, string $id): string
    {
        $path = '/' . ltrim($request->path(), '/');
        $params = ['page_type' => $this->pageType($path)];

        if (preg_match('~^/company/(\d+)~', $path, $m)) {
            $params['etablissement_id'] = $m[1];
        }

        $config = ['content_group' => $params['page_type']];

        // L'iframe /company/{id}/embed affiche le site dans la coquille
        // /company/{id}/site, qui compte déjà la page vue : l'iframe ne mesure
        // que les interactions (défilement, clics, formulaires).
        if (preg_match('~^/company/\d+/embed~', $path)) {
            $config['send_page_view'] = false;
        }

        $consent = config('services.google_analytics.consent_default', 'granted') === 'denied' ? 'denied' : 'granted';
        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
        $idJs = json_encode($id, $flags);
        $idUrl = rawurlencode($id);

        return "\n<!-- Google Analytics 4 -->\n"
            . "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$idUrl}\"></script>\n"
            . "<script>\n"
            . "window.dataLayer = window.dataLayer || [];\n"
            . "function gtag(){dataLayer.push(arguments);}\n"
            . "gtag('consent', 'default', {analytics_storage: '{$consent}', ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied'});\n"
            . "gtag('js', new Date());\n"
            . 'gtag(\'set\', ' . json_encode($params, $flags) . ");\n"
            . "gtag('config', {$idJs}, " . json_encode($config, $flags) . ");\n"
            . "</script>\n";
    }

    private function pageType(string $path): string
    {
        // Mêmes familles que config('analytics.sections') dans l'admin : les
        // deux listes doivent rester alignées, sinon une page changerait de
        // section entre la mesure et le rapport.
        return match (true) {
            $path === '/' => 'accueil',
            // Les fiches de destination sont servies par le paquet
            // travel_destination ; /destinations n'en est que l'index.
            (bool) preg_match('~^/(destinations|travel-destination)(/|$)~', $path) => 'destinations',
            (bool) preg_match('~^/activity(/|$)~', $path) => 'activites',
            (bool) preg_match('~^/company/\d+(/|$)~', $path) => 'etablissements',
            (bool) preg_match('~^/landing(/|$)~', $path) => 'landing',
            (bool) preg_match('~^/achat(/|$)~', $path) => 'boutique',
            (bool) preg_match('~^/chaine-videos(/|$)~', $path) => 'videos',
            default => 'autres',
        };
    }
}
