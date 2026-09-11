<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEO / Meta
    |--------------------------------------------------------------------------
    */
    'meta' => [
        'title'       => 'Go Exploria — Explorez le monde, activités, hébergements & destinations',
        'description' => 'Go Exploria : la plateforme premium pour explorer destinations, activités, restaurants, hébergements et forfaits touristiques partout dans le monde.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Établissement qui porte les sections sous la carte (/ et /welcome-test)
    |--------------------------------------------------------------------------
    | La page d'accueil de cet établissement fournit tout ce qui suit la carte.
    | L'en-tête, le héro et la carte restent rendus par le front : ils dépendent
    | de la base (mégamenus, encarts sponsorisés, points d'intérêt) et aucun
    | HTML figé ne peut les remplacer.
    |
    | `id` d'abord, `slug` en repli — désigner l'établissement par son
    | identifiant permet d'en essayer un autre sans toucher au code ni renommer
    | quoi que ce soit. Mettez `id` à null pour revenir au slug.
    */
    'accueil' => [
        'etablissement_id'   => env('WELCOME_ACCUEIL_ETABLISSEMENT_ID', 10502),
        'etablissement_slug' => env('WELCOME_ACCUEIL_ETABLISSEMENT_SLUG', 'accueil-goexploria'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Endpoints AJAX réutilisés (compatibilité données Home V2)
    |--------------------------------------------------------------------------
    | Le package Welcome ne duplique aucune logique métier : il consomme les
    | mêmes API publiques que le reste de la plateforme.
    */
    'api' => [
        'menus'        => '/api/v1/menus',
        'destinations' => '/api/v1/destinations',
        'map_points'   => '/api/v1/map-points',
    ],

    /*
    |--------------------------------------------------------------------------
    | Carte Amérique du Nord (above the fold)
    |--------------------------------------------------------------------------
    */
    'map' => [
        'continent_slug' => 'amerique-du-nord',
        'center'         => [54.5, -105.0],
        'zoom'           => 3,
    ],
];
