<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Popup publicitaire (Ads Manager)
    |--------------------------------------------------------------------------
    |
    | Le front interroge l'API publique du module Ads Manager (hébergé côté
    | admin) pour afficher un popup rotatif d'annonces en bas à droite.
    |
    | admin_url : base publique de l'admin qui sert le JSON des zones et les
    |             endpoints de tracking (CORS déjà ouvert côté admin).
    | popup_zone: code de la zone publicitaire à afficher dans le popup.
    | enabled   : coupe global du popup.
    */

    'admin_url' => rtrim(env('ADS_ADMIN_URL', 'https://admin.goexploriabusiness.com'), '/'),

    'popup_zone' => env('ADS_POPUP_ZONE', 'popup_bottom_right'),

    'popup_enabled' => (bool) env('ADS_POPUP_ENABLED', true),

    // Durée (heures) de mémorisation de la fermeture du popup par le visiteur.
    'popup_dismiss_hours' => (int) env('ADS_POPUP_DISMISS_HOURS', 12),

    // Durée par défaut d'une annonce (secondes) si non définie côté admin.
    'popup_default_duration' => (int) env('ADS_POPUP_DEFAULT_DURATION', 5),
];
