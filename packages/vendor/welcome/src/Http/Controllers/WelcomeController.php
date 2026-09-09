<?php

namespace Vendor\Welcome\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Slider;

/**
 * Contrôleur de la page /welcome.
 *
 * Rend un clone indépendant de la page d'accueil (design identique à « / »).
 * Réutilise uniquement les MODÈLES de l'application (couche données partagée),
 * jamais le code du package Home V2. Les vues clonées vivent sous `welcome-home`.
 */
class WelcomeController extends Controller
{
    /**
     * L'établissement qui porte le contenu du site public.
     *
     * Même valeur que `CmsAccueilGoExploriaSeeder::ETABLISSEMENT_SLUG` côté
     * admin : c'est le seul lien entre les deux projets.
     */
    public const ACCUEIL_SLUG = 'accueil-goexploria';


    /**
     * Page d'essai : même page, mais tout ce qui suit la carte vient du CMS.
     *
     * En-tête, héro et carte restent rendus par le front — ils dépendent de la
     * base (mégamenus, encarts sponsorisés, points d'intérêt) et aucun HTML
     * figé ne peut les remplacer. Le reste est servi par la page d'accueil de
     * l'établissement « accueil-goexploria », modifiable dans VvvebJS.
     *
     * Route séparée volontairement : `/` n'est pas touchée tant que le rendu
     * n'a pas été validé ici. Basculer se fera en passant `$cmsAccueil` depuis
     * index() — la vue gère déjà les deux cas.
     */
    public function test()
    {
        $donnees = $this->donneesAccueil();
        $donnees['cmsAccueil'] = $this->contenuAccueilCms();

        if ($donnees['cmsAccueil'] === null) {
            // Mieux vaut le dire que d'afficher silencieusement l'ancien rendu :
            // la page paraîtrait normale et l'essai n'aurait rien prouvé.
            $donnees['cmsAccueilAbsent'] = true;
        }

        return view('welcome-home.index', $donnees);
    }

    /**
     * Contenu de page du CMS pour l'accueil du site public.
     *
     * Renvoie null si l'établissement ou sa page n'existent pas — la vue
     * retombe alors sur le rendu d'origine.
     *
     * @see \Database\Seeders\CmsAccueilGoExploriaSeeder (projet admin)
     */
    protected function contenuAccueilCms(): ?string
    {
        return $this->safe(function () {
            $etablissement = \App\Models\Etablissement::where('slug', self::ACCUEIL_SLUG)->first();

            if (! $etablissement) {
                return null;
            }

            $page = \Vendor\Cms\Models\Page::where('etablissement_id', $etablissement->id)
                ->where('is_home', true)
                ->where('status', 'published')
                ->first();

            $contenu = trim((string) ($page->content ?? ''));

            if ($contenu === '') {
                return null;
            }

            // Le cloisonnement parcourt 400 Ko de CSS : une fois par version de
            // la page, pas à chaque visite. La date de modification suffit comme
            // clé — éditer la page dans VvvebJS la fait changer.
            return \Illuminate\Support\Facades\Cache::remember(
                'welcome:accueil-cms:' . $page->id . ':' . $page->updated_at?->timestamp,
                now()->addDay(),
                fn () => \Vendor\Welcome\Support\ContenuCmsIntegre::preparer($contenu)
            );
        }, null);
    }

    public function index()
    {
        return view('welcome-home.index', $this->donneesAccueil());
    }

    /** Les données communes à l'accueil et à sa page d'essai. */
    protected function donneesAccueil(): array
    {
        $sliders = $this->safe(fn () => Slider::active()->ordered()->get(), collect());

        $plans = $this->safe(fn () => Plan::active()
            ->ordered()
            ->with([
                'activeDestinations',
                'plugins' => fn ($q) => $q->orderBy('name'),
            ])
            ->get(), collect());

        $naMap = $this->safe(fn () => $this->northAmericaMapData(), null);

        return compact('sliders', 'plans', 'naMap');
    }

    /**
     * Données légères pour la carte Amérique du Nord (points chargés en AJAX).
     */
    protected function northAmericaMapData(): ?array
    {
        $slug = config('welcome.map.continent_slug', 'amerique-du-nord');

        $continent = \App\Helpers\DestinationHelper::continent($slug)
            ?? app(\App\Services\DestinationService::class)->getContinentBySlug($slug);

        if (! $continent) {
            return null;
        }

        return [
            'entity'         => $continent,
            'slug'           => $continent->slug ?? $slug,
            'normalizedType' => 'continent',
            'childEntities'  => $continent->countries()->active()->get(),
            'mapCategories'  => \App\Models\MapCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(['slug', 'name', 'icon_class', 'color', 'image']),
        ];
    }

    protected function safe(callable $callback, mixed $fallback): mixed
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            return $fallback;
        }
    }
}
