<?php

use Illuminate\Support\Facades\Route;
use Vendor\TravelDestination\Controllers\TravelDestinationController;

/* INDEX DES DESTINATIONS.

   L'adresse `/destination` était déjà écrite dans le fil d'Ariane et le pied
   de page de chaque destination, mais aucune route ne la servait : elle
   rendait 404. `/destinations` accepte le pluriel, par tolérance. */
Route::get('/destination', [TravelDestinationController::class, 'index'])
    ->name('travel-destination.index');
Route::get('/destinations', fn () => redirect()->route('travel-destination.index', request()->query(), 301));

Route::prefix('travel-destination')->group(function () {
    // Contenu du méga-menu « Activités » de l'en-tête (chargé à l'ouverture).
    // « menu » n'est pas un {type} autorisé : aucun conflit avec les routes
    // de destination ci-dessous.
    Route::get('/menu/activites', [TravelDestinationController::class, 'activitiesMenu'])
        ->name('travel-destination.activities-menu');

    // Contenu du méga-menu « Destinations » de la barre latérale.
    Route::get('/menu/destinations', [TravelDestinationController::class, 'destinationsMenu'])
        ->name('travel-destination.destinations-menu');

    // `all` : la carte de l'index `/destination`, qui montre TOUS les points.
    Route::get('/{type}/{slug}/map-points', [TravelDestinationController::class, 'mapPoints'])
        ->name('travel-destination.map-points')
        ->whereIn('type', ['all', 'continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);

    // Enfants directs d'une destination : alimente la cascade de filtres posée
    // au-dessus de la carte, un niveau à la fois.
    // ⚠ Doit rester AVANT la route générique /{type}/{slug}/{slug2?}, sinon
    //   « children » serait lu comme un second segment de slug.
    Route::get('/{type}/{slug}/children', [TravelDestinationController::class, 'children'])
        ->name('travel-destination.children')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);

    Route::get('/{type}/{slug}/{slug2?}', [TravelDestinationController::class, 'show'])
        ->name('travel-destination.show')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);
});
