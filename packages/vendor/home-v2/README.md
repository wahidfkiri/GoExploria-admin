# GoExploria — Package Home V2

Package local Laravel regroupant tous les blocs de la page d'accueil GoExploria V2.

## Structure

```
packages/vendor/home-v2/
├── composer.json
├── README.md
└── src/
    ├── HomeV2ServiceProvider.php
    └── resources/
        ├── views/
        │   └── home-v2/
        │       ├── index.blade.php          ← page principale
        │       ├── components/              ← tous les blocs
        │       │   ├── EventsVedette.blade.php
        │       │   ├── DestinationsVedette.blade.php
        │       │   ├── TravelPackages.blade.php
        │       │   ├── VideoPlayer.blade.php
        │       │   ├── MediaSlideshow.blade.php
        │       │   ├── RestaurantHeader.blade.php
        │       │   ├── RestaurantsVedette.blade.php
        │       │   ├── MenuAccordMetsVins.blade.php
        │       │   ├── TravelInfos.blade.php
        │       │   ├── TourismSection.blade.php
        │       │   ├── PartnersMaster.blade.php
        │       │   ├── AgencySection.blade.php
        │       │   ├── RealEstateSection.blade.php
        │       │   ├── MultilingualGrid.blade.php
        │       │   ├── NewsSection.blade.php
        │       │   ├── WebServices.blade.php
        │       │   ├── Hero.blade.php
        │       │   ├── InteractiveMap.blade.php
        │       │   ├── Header.blade.php
        │       │   ├── Footer.blade.php
        │       │   └── ... (autres composants)
        │       └── pages/
        │           ├── video-player.blade.php
        │           └── accord-mets-vins.blade.php
        └── css/
            └── (CSS publiables — voir public/css/home-v2/)
```

## Compatibilité

Les vues sont accessibles de **deux façons** :

```blade
{{-- Notation existante (dot) — aucun changement requis --}}
@include('home-v2.components.EventsVedette')

{{-- Notation namespace (pour migration future) --}}
@include('home-v2::components.EventsVedette')
```

Le dossier `resources/views/home-v2/` de l'application reste **prioritaire** :
placer un fichier à cet endroit écrase la vue du package (override local).

## Ajouter un nouveau bloc

1. Créer `src/resources/views/home-v2/components/NouveauBloc.blade.php`
2. Créer `src/resources/css/nouveau-bloc.css` (à publier via `vendor:publish`)
3. Inclure dans `src/resources/views/home-v2/index.blade.php` :
   ```blade
   @include('home-v2.components.NouveauBloc')
   ```
4. Ajouter le lien CSS dans le `<head>` de `index.blade.php` :
   ```blade
   <link rel="stylesheet" href="{{ asset('css/home-v2/nouveau-bloc.css') }}">
   ```

## Publier les assets CSS

```bash
php artisan vendor:publish --tag=home-v2-assets
```

## Enregistrement

Le package est auto-découvert via `composer.json` (`extra.laravel.providers`).
Il est également listé dans `bootstrap/providers.php` :

```php
Vendor\HomeV2\HomeV2ServiceProvider::class,
```
