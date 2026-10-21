<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    |
    | Specify the database connection to use for CMS tables.
    | If null, will use the default database connection.
    |
    */
    'database_connection' => env('CMS_DB_CONNECTION', 'cms'),

    /*
    |--------------------------------------------------------------------------
    | Themes Storage Path
    |--------------------------------------------------------------------------
    |
    | Path where themes will be stored relative to storage path.
    |
    */
    'themes_path' => env('CMS_THEMES_PATH', 'app/cms/themes'),

    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | Default theme name to use if no theme is activated.
    |
    */
    'default_theme' => env('CMS_DEFAULT_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Cache Pages
    |--------------------------------------------------------------------------
    |
    | Enable page caching for better performance.
    |
    */
    'cache_pages' => env('CMS_CACHE_PAGES', false),

    /*
    |--------------------------------------------------------------------------
    | Page Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Number of minutes to cache pages.
    |
    */
    'page_cache_lifetime' => env('CMS_PAGE_CACHE_LIFETIME', 60),

    /*
    |--------------------------------------------------------------------------
    | Allowed File Extensions for Themes
    |--------------------------------------------------------------------------
    |
    | File extensions allowed in theme uploads.
    |
    */
    'allowed_theme_extensions' => ['blade.php', 'css', 'js', 'json', 'png', 'jpg', 'jpeg', 'svg', 'woff', 'woff2', 'ttf'],

    /*
    |--------------------------------------------------------------------------
    | Stockage des contenus en fichiers (pilote)
    |--------------------------------------------------------------------------
    |
    | Même dépôt que l'admin (CONTENUS_RACINE identique dans les deux .env).
    | Le front LIT seulement : c'est l'admin qui choisit le mode d'un
    | établissement et qui écrit. Cf. docs/CONCEPTION-STOCKAGE-CONTENUS.md
    | du projet admin.
    |
    */
    'contenus' => [
        // « CONTENUS_RACINE= » vide : repli sur storage/, jamais la racine du disque.
        'racine' => env('CONTENUS_RACINE') ?: storage_path('app/contenus'),
        'ecriture' => env('CONTENUS_ECRITURE', false),
        'taille_max' => (int) env('CONTENUS_TAILLE_MAX', 8 * 1024 * 1024),
        'revisions' => (int) env('CONTENUS_REVISIONS', 20),
    ],
];