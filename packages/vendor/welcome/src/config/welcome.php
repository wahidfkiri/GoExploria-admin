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
