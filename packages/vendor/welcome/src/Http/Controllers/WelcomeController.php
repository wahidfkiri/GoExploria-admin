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
     * Repli historique, utilisé quand aucun identifiant n'est configuré. Même
     * valeur que `CmsAccueilGoExploriaSeeder::ETABLISSEMENT_SLUG` côté admin :
     * c'est le seul lien entre les deux projets.
     *
     * @see config('welcome.accueil') pour désigner un autre établissement
     */
    public const ACCUEIL_SLUG = 'accueil-goexploria';


    /**
     * Page d'essai : même page, mais tout ce qui suit la carte vient du CMS.
     *
     * En-tête, héro et carte restent rendus par le front — ils dépendent de la
     * base (mégamenus, encarts sponsorisés, points d'intérêt) et aucun HTML
     * figé ne peut les remplacer. Le reste est servi par la page d'accueil de
     * l'établissement désigné par `welcome.accueil.etablissement_id`,
     * modifiable dans VvvebJS. Si ce contenu emporte encore l'en-tête ou le
     * pied du gabarit, `ContenuCmsIntegre` les retire : la page garde les siens.
     *
     * Route séparée volontairement : `/` n'est pas touchée tant que le rendu
     * n'a pas été validé ici. Basculer se fera en passant `$cmsAccueil` depuis
     * index() — la vue gère déjà les deux cas.
     */
    public function test()
    {
        $donnees = $this->donneesAccueil();

        [$contenu, $motif] = $this->contenuAccueilCms();
        $donnees['cmsAccueil'] = $contenu;

        if ($contenu === null) {
            // Mieux vaut le dire que d'afficher silencieusement l'ancien rendu :
            // la page paraîtrait normale et l'essai n'aurait rien prouvé. Le
            // motif exact évite d'avoir à deviner lequel des quatre écueils
            // (établissement, page, publication, contenu) a été rencontré.
            $donnees['cmsAccueilAbsent'] = $motif;
        }

        return view('welcome-home.index', $donnees);
    }

    /**
     * Contenu de page du CMS pour l'accueil du site public.
     *
     * Renvoie [null, motif] si l'établissement ou sa page manquent — la vue
     * retombe alors sur le rendu d'origine, en annonçant pourquoi.
     *
     * @return array{0:?string,1:string}
     *
     * @see \Database\Seeders\CmsAccueilGoExploriaSeeder (projet admin)
     */
    protected function contenuAccueilCms(): array
    {
        $motif = 'Contenu CMS indisponible : la base n\'a pas répondu.';

        $contenu = $this->safe(function () use (&$motif) {
            $etablissement = $this->etablissementAccueil();

            if (! $etablissement) {
                $motif = 'Établissement introuvable (' . $this->designationAccueil() . ').';

                return null;
            }

            $page = \Vendor\Cms\Models\Page::where('etablissement_id', $etablissement->id)
                ->where('is_home', true)
                ->first();

            if (! $page) {
                $motif = 'L\'établissement #' . $etablissement->id
                    . ' n\'a pas de page marquée comme accueil (is_home).';

                return null;
            }

            if ($page->status !== 'published') {
                $motif = 'La page d\'accueil de l\'établissement #' . $etablissement->id
                    . ' est en « ' . $page->status . ' » : publiez-la pour la voir ici.';

                return null;
            }

            $brut = trim((string) $page->content);

            if ($brut === '') {
                $motif = 'La page d\'accueil de l\'établissement #' . $etablissement->id
                    . ' est vide : installez-y un template.';

                return null;
            }

            // Le cloisonnement parcourt 400 Ko de CSS : une fois par version de
            // la page, pas à chaque visite. La date de modification suffit comme
            // clé — éditer la page dans VvvebJS la fait changer.
            return \Illuminate\Support\Facades\Cache::remember(
                'welcome:accueil-cms:' . $page->id . ':' . $page->updated_at?->timestamp,
                now()->addDay(),
                fn () => \Vendor\Welcome\Support\ContenuCmsIntegre::preparer($brut)
            );
        }, null);

        return [$contenu, $motif];
    }

    /**
     * L'établissement configuré.
     *
     * L'identifiant l'emporte, et sans repli : si `welcome.accueil
     * .etablissement_id` désigne un établissement qui n'existe pas, mieux vaut
     * l'annoncer que servir le contenu d'un autre — on croirait le bon branché.
     * Le slug ne sert que lorsqu'aucun identifiant n'est configuré.
     */
    protected function etablissementAccueil(): mixed
    {
        $id = config('welcome.accueil.etablissement_id');

        if (filled($id)) {
            return \App\Models\Etablissement::find($id);
        }

        return \App\Models\Etablissement::where('slug', $this->slugAccueil())->first();
    }

    /** Comment l'établissement est désigné, pour les messages de diagnostic. */
    protected function designationAccueil(): string
    {
        $id = config('welcome.accueil.etablissement_id');

        return filled($id)
            ? 'identifiant ' . $id . ', défini par welcome.accueil.etablissement_id'
            : 'slug « ' . $this->slugAccueil() . ' »';
    }

    protected function slugAccueil(): string
    {
        return (string) config('welcome.accueil.etablissement_slug', self::ACCUEIL_SLUG);
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
