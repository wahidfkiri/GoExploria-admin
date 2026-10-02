<?php

namespace Vendor\HomeV2\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Plan;

class HomeV2Controller extends Controller
{
    /**
     * Afficher la page d'accueil v2 avec les sliders
     */
    public function index()
    {
        $sliders = Slider::active()
            ->ordered()
            ->get();

        $plans = Plan::active()
            ->ordered()
            ->with([
                'activeDestinations',
                'plugins' => function ($query) {
                    $query->orderBy('name');
                }
            ])
            ->get();

        // Carte "Amérique du Nord" (même principe/design que travel-destination/continent/amerique-du-nord).
        // Les points sont chargés en AJAX côté client → aucun impact sur le temps de chargement initial.
        $naMap = $this->northAmericaMapData();

        return view('home-v2.index', compact('sliders', 'plans', 'naMap'));
    }

    /**
     * Données légères pour la carte Amérique du Nord de la page d'accueil.
     * Ne précharge pas les points (récupérés en AJAX via travel-destination.map-points).
     * Retourne null si le continent est introuvable → repli sur l'ancienne carte.
     */
    protected function northAmericaMapData(): ?array
    {
        try {
            $continent = \App\Helpers\DestinationHelper::continent('amerique-du-nord')
                ?? app(\App\Services\DestinationService::class)->getContinentBySlug('amerique-du-nord');

            if (!$continent) {
                return null;
            }

            return [
                'entity'         => $continent,
                'slug'           => $continent->slug ?? 'amerique-du-nord',
                'normalizedType' => 'continent',
                'childEntities'  => $continent->countries()->active()->get(),
                'mapCategories'  => \App\Models\MapCategory::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get(['slug', 'name', 'icon_class', 'color', 'image']),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Liste de toutes les catégories actives
     */
    public function categoriesIndex()
    {
        $categories = Category::with(['activities' => function ($q) {
            $q->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        return view('home-v2.pages.categories', compact('categories'));
    }

    /**
     * Page d'une catégorie avec ses activités
     */
    public function showCategory($slug, \Illuminate\Http\Request $request = null)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOr(function () use ($slug) {
                return Category::where('id', $slug)->where('is_active', true)->firstOrFail();
            });

        // Si la catégorie a une page composée dans l'éditeur, c'est ELLE le
        // site : on la rend telle quelle. `?template=classic` ramène la liste
        // des activités — utile pour comparer, et pour ne pas enfermer une
        // catégorie dont la page serait ratée. Même dispositif que la page
        // d'une activité (Vendor\Activities\Controllers\LandingPageController).
        //
        // ⚠ La page vit dans `page_contents` sous les colonnes POLYMORPHIQUES
        // (pageable_type + pageable_id) : le type réservé « page » est le même
        // que celui des activités, c'est le propriétaire qui les distingue.
        $pageSite = \App\Models\PageContent::where('pageable_type', Category::class)
            ->where('pageable_id', $category->id)
            ->where('type', 'page')
            ->where('is_active', true)
            ->orderBy('id')
            ->first();

        $classique = $request && $request->query('template') === 'classic';

        if ($pageSite && trim((string) $pageSite->content) !== '' && ! $classique) {
            // Chaîne de rendu, dans cet ordre :
            //   1. les règles d'édition que l'éditeur aurait enregistrées par
            //      erreur sont retirées ;
            //   2. le bandeau ne montre que des vidéos (image de fond, bouton
            //      « Voir la vidéo » et flèche de défilement retirés) ;
            //   3. la section d'attente `data-gx-map` devient la vraie carte ;
            //   4. « Quoi faire » reçoit les activités de la catégorie ;
            //   5. « Où aller » reçoit les villes et régions où elles se
            //      pratiquent ;
            //   6. « Où en profiter » reçoit les établissements qui les
            //      proposent — la grille d'ensemble comme les sous-grilles
            //      par type de prestation (dormir / manger / pratiquer) —, et
            //      ses filtres les catégories réellement là.
            // Sans donnée, chaque grille garde sa démonstration plutôt que
            // d'afficher un trou.
            $contenu = \Vendor\Activities\Support\ReglesEdition::retirer($pageSite->content);
            $contenu = \Vendor\Activities\Support\HerosVideo::nettoyer($contenu);
            $contenu = \Vendor\Activities\Support\CarteMonde::injecter($contenu);
            $contenu = \Vendor\Cms\Support\TemplateActivities::hydrateCategorie($contenu, (int) $category->id);
            $contenu = \Vendor\Cms\Support\TemplateDestinations::hydrateCategorie($contenu, (int) $category->id);
            $contenu = \Vendor\Cms\Support\TemplateEtablissements::hydrateCategorie($contenu, (int) $category->id);

            return view('home-v2.pages.category-page', [
                'category' => $category,
                'page'     => $pageSite,
                'contenu'  => $contenu,
            ]);
        }

        $activities = $category->activities()->where('is_active', true)->orderBy('name')->get();

        return view('home-v2.pages.category', compact('category', 'activities'));
    }

    /**
     * Page d'une activité
     */
    public function showActivity($slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOr(function () use ($slug) {
                return Activity::where('id', $slug)->where('is_active', true)->firstOrFail();
            });

        $category = $activity->categoryRelation;

        return view('home-v2.pages.activity', compact('activity', 'category'));
    }
}
